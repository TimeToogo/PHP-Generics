<?php

namespace Generics;

final class Configuration {
    private $IsDevelopmentMode;
    private $RootPath;
    private $CachePath;
    
    public function __construct($IsDevelopmentMode, $RootPath, $CachePath) {
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
}