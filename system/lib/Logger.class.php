<?php

/**
 * Classe de escrita de log do framework
 * */
Class Logger {

    const WARNING   = 4;
    const ERROR     = 3;
    const DEBUG     = 7;
    const INFO      = 6;

	
    private $logFilePath;
    
	
    public function __construct( $logFilePath ) {
        
        if ( !empty ( $logFilePath ) ) {
        
            $this->logFilePath 	= $logFilePath;
            
        } else {
            
            throw new Exception("Arquivo de Log não definido!");
        }
    }

	
    public function write( $message, $priority = null ) {
        
        switch ($priority) {

            case 4:
                $txPriority = 'warn';
            break;

            case 3:
                $txPriority = 'error';
            break;

            case 7:
                $txPriority = 'debug';
            break;

            case 6:
                $txPriority = 'info';
            break;

            default:
                $txPriority = 'info';
        }

        $line = "[" . Date ("Y-m-d H:i:s") . "][{$txPriority}] - $message" . PHP_EOL;

        file_put_contents( $this->logFilePath, $line, FILE_APPEND);
    }

}