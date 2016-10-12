<?php

class Config {
    
	
    // Configurações
    private $config;
    
    
    public function __construct() {
        
        $this->config = parse_ini_file ( CONF_DIR . DIRECTORY_SEPARATOR . 'fw.ini', TRUE );
    }
    
    
    public function __destruct() {}
    
    
    private function systemDefinitions () {
        
        ini_set("error_reporting", $this->errorReporting);
        ini_set('display_errors', $this->displayErrors);
        ini_set("memory_limit", "1024M");        
        
    }
    
    
    public function getConfigurationsSmtp () {
        
        return $this->config['SMTP'];
    }
}




