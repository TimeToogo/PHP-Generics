<?php

namespace Generics;

final class Loader {
    const GenericFileSuffix = '.generic.php';
    
    private $Parser;
    private $Configuration;
    
    private  function __construct(Configuration $Configuration) {
        $this->Parser = new Parser();
        $this->Configuration = $Configuration;
    }
    
    public static function Register(Configuration $Configuration) {
        if(!$Configuration->HasDevelopmentMode()) {
            throw new \BadMethodCallException('Configuration is missing the development mode');
        }
        if(!$Configuration->HasRootPath()) {
            throw new \BadMethodCallException('Configuration is missing the root path');
        }
        if(!$Configuration->HasCachePath()) {
            throw new \BadMethodCallException('Configuration is missing the cache path');
        }
        $Loader = new self($Configuration);
        spl_autoload_register([$Loader, 'Load']);
        return $Loader;
    }
    
    public function Load($ConcreteClassName) {
        $ConcreteFileName = $this->MakeConcreteFileName($ConcreteClassName);
        if(!$this->Configuration->IsDevelopmentMode()) {
            if($this->LoadConcreteFile($ConcreteFileName)) {
                return;
            }
        }
        
        $BackslashAmount = substr_count($ConcreteClassName, '\\');
        if($BackslashAmount === 0 || ($BackslashAmount === 1 && strpos($ConcreteClassName, '\\') === 0)) {
            return;
        }
        
        $OrginalClassName = $ConcreteClassName;
        $RootPath = $this->Configuration->GetRootPath();
        while(strlen($ConcreteClassName) > 0) {
            $GenericPath = $RootPath . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $ConcreteClassName) . self::GenericFileSuffix;
            
            $GenericCode = $this->LoadGenericFile($GenericPath);
            if($GenericCode !== false) {
                $GenericTypeString = substr($OrginalClassName, strlen($ConcreteClassName));
                
                $ConcreteCode = $this->Parser->Parse($GenericCode, $ConcreteClassName, $GenericTypeString);
                $this->SaveConcreteFile($ConcreteCode, $ConcreteFileName);
                return $this->LoadConcreteFile($ConcreteFileName);
            }
            
            $ConcreteClassName = substr($ConcreteClassName, 0, strrpos($ConcreteClassName, '\\'));
        }
    }
    
    private function LoadGenericFile($FileName) {
        if(file_exists($FileName) && is_readable($FileName)) {
             return file_get_contents($FileName);
        }
        
        return false;
    }
    
    private function LoadConcreteFile($FileName) {
        if(file_exists($FileName) && is_readable($FileName)) {
            require $FileName;
            return true;
        }
        
        return false;
    }
    
    private function MakeConcreteFileName($ClassName) {
        $StorageClassName = str_replace('\\', '_', $ClassName);
        return $this->Configuration->GetCachePath() . '/' . $StorageClassName . '.php';
    }
    
    private function SaveConcreteFile($ConcreteCode, $FileName) {
        $Directory = dirname($FileName);
        if(!file_exists($Directory)) {
            mkdir($Directory);
        }
        file_put_contents($FileName, $ConcreteCode);
    }
}