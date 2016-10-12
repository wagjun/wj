<?php 

global $argc, $argv, $mode, $obj;

try {
	
	require_once 'bootstrap.php';
	
	// Identifica se a requisição veio pela web ou linha de comando
	if ( !empty( $argc ) && !empty($argv) ) {
	
		$mode = MODE_CLIENT;
		
		// Retira o nome do script (index.php)
		array_shift($argv);
		
		$PATH = $argv;
		
                if ( MAINTENANCE_SYSTEM || MAINTENANCE_CLIENT ) {
                    
                    die('Sistema em manutencao. Por favor, tente novamente mais tarde.');
                }
	} else {
                
		$mode = MODE_WEB;
		
		// A posição key vem do .htaccess
		$key    = ( !empty ( $_GET['key'] ) ? $_GET['key'] : '' );
		$PATH   = explode('/', $key); 
                
                if ( MAINTENANCE_SYSTEM || MAINTENANCE_WEB ) {
                    
                    die('Sistema em manutencao. Por favor, tente novamente mais tarde.');
                }
	}

	
	$controller     = ( !empty( $PATH[0] ) ? $PATH[0] : MAIN_CONTROLLER );
	$action         = ( !empty( $PATH[1] ) ? $PATH[1] : MAIN_ACTION );
	
	// Verificando se foram passados paramentros para os metodos
	if ( count( $PATH ) > 2 ) {
		
		$aParams = array();
	
		// $i = 2, pois, 0 = controller e 1 = metodo 
		for ( $i = 2; $i < count( $PATH ); $i++ ) {
			
			$aParams[] = $PATH[$i];
		}
		
	} else {
		
		$aParams = null;
	}
	
	$obj = new $controller( $action );
	
	$obj->$action( $aParams );
	$obj->endExecution();
        
} catch ( Exception $e ) {
        
	echo $e->getMessage();
        $obj->mailer->sendEmail(
                                'wagner.junior.proofsec@contratada.oi.net.br', 
                                "Framework Error {$e->getCode()}", 
                                utf8_encode( $e->getMessage() ),
                                null,
                                null
        );
}