<?php

class SystemExceptions extends Exception {
    
    
    public function __construct( $message, $code = null, $previous = null ) {
    
        echo 'System Exceptions: ';
        parent::__construct( $message, $code, $previous );
    }
    
    
    public function register ($message) {

        echo "{$message}<br />";
        $this->saveLog();
    }
    
    
    private function saveLog () {
        
        $this->banco();
        $this->log();
    }
    
    
    private function banco () {
        
        echo 'Registro em Banco de dados' . '<br />';
    }
    
    
    private function log () {
        
        echo 'Registro em arquivo' . '<br />';
    }
}