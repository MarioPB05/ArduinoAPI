<?php 

class Config {
    
    private $urlConfig = "clases/config/config.json";
    private $urlTokenDataConfig = "clases/config/token-data.json";
    private $urlUserDataConfig = "clases/config/user-data.json";
    private $urlStreamDataConfing = "clases/config/stream-data.json";

    public function getUrlConfig() {
        return $this->urlConfig;
    }

    public function getUrlTokenDataConfig() {
        return $this->urlTokenDataConfig;
    }

    public function getUrlUserDataConfig(){
        return $this->urlUserDataConfig;
    }

    public function getUrlStreamDataConfig(){
        return $this->urlStreamDataConfing;
    }
}

?>