<?php

namespace Generics;

final class Configuration {
    private $IsDevelopmentMode;
    private $RootPath;
    private $CachePath;
    
    public function __construct($IsDevelopmentMode = null, $RootPath = null, $CachePath = null) {
        $this->IsDevelopmentMode = $IsDevelopmentMode;
        $this->RootPath = $RootPath;
        $this->CachePath = $CachePath;
    }
        
    public function IsDevelopmentMode() {
        return $this->IsDevelopmentMode;
    }

    public function GetRootPath() {
        return $this->RootPath;
    }
    
    public function GetCachePath() {
        return $this->CachePath;
    }
    
    public function HasDevelopmentMode() {
        return $this->IsDevelopmentMode !== null;
    }

    public function HasRootPath() {
        return $this->RootPath !== null;
    }
    
    public function HasCachePath() {
        return $this->CachePath !== null;
    }
    
    public function SetIsDevelopmentMode($IsDevelopmentMode) {
        if(!is_bool($IsDevelopmentMode)) {
            throw new \InvalidArgumentException('$IsDevelopmentMode must be boolean');
        }
        $this->IsDevelopmentMode = $IsDevelopmentMode;
    }

    public function SetRootPath($RootPath) {
        if(!is_string($RootPath) || !is_dir($RootPath)) {
            throw new \InvalidArgumentException('$RootPath must be a valid directory');
        }
        $this->RootPath = $RootPath;
    }

    public function SetCachePath($CachePath) {
        if(!is_string($CachePath)) {
            throw new \InvalidArgumentException('$CachePath must be a valid string');
        }
        $this->CachePath = $CachePath;
    }
}