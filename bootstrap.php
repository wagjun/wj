<?php

date_default_timezone_set('America/Sao_Paulo');

ini_set("error_reporting", E_ALL);
ini_set('display_errors', 'On');
ini_set("memory_limit", -1);
ini_set('max_execution_time', 0);

set_time_limit(0);

define('MAINTENANCE_SYSTEM', False);
define('MAINTENANCE_WEB', False);
define('MAINTENANCE_CLIENT', False);

define('MAIN_CONTROLLER','principal');															// CONTROLADOR PRINCIPAL
define('MAIN_ACTION','index');																	// MÉTODO PRINCIPAL

//define('DIRECTORY_ROOT', __DIR__ . DIRECTORY_SEPARATOR );
define('DIRECTORY_ROOT', './');
define('APPLICATION_FOLDER', DIRECTORY_ROOT. 'app');                                			// APLICAÇÃO 
define('SYSTEM_FOLDER', DIRECTORY_ROOT. 'system');                                  			// FRAMEWORK
define('MODULES_DIR', DIRECTORY_ROOT. 'modules');												// MODULES
define('CORE_FOLDER', SYSTEM_FOLDER . DIRECTORY_SEPARATOR . 'core');							// CORE
define('CONTROLLERS_DIR', APPLICATION_FOLDER . DIRECTORY_SEPARATOR. 'controllers'); 			// CONTROLLERS
define('VIEWS_DIR', APPLICATION_FOLDER . DIRECTORY_SEPARATOR . 'views'); 						// VIEWS
define('MODELS_DIR', APPLICATION_FOLDER . DIRECTORY_SEPARATOR . 'models');  					// MODELS
define('CONF_DIR', SYSTEM_FOLDER . DIRECTORY_SEPARATOR . 'conf');  								// CONFIGURATIONS
define('LIB_DIR', SYSTEM_FOLDER . DIRECTORY_SEPARATOR . 'lib');    								// LIBRARIES
define('LOGS_DIR', SYSTEM_FOLDER . DIRECTORY_SEPARATOR .'logs');							  	// LOGS

define('TEMPLATE_DIR', 'template');																// TEMPLATE DIR
define('TEMPLATE_NAME', 'azul');																// NOME DO TEMPLATE
define('TEMPLATE_LOGIN','login');																// TELA DE LOGIN DO TEMPLATE
define('BASE_URL', 'http://localhost/wj/');															// URL SISTEMA

define('MODE_WEB', 'WEB');																		// FRAMEWORK EM MODO WEB
define('MODE_CLIENT', 'CLIENT');																// FRAMEWORK EM MODO CLIENT APPLICATION


function __autoload ( $className ) {

	global $mode;
	
	$pathfile = null;
	
	// Terceiros
	require_once (MODULES_DIR . DIRECTORY_SEPARATOR .  'PHPMailer' . DIRECTORY_SEPARATOR . 'class.phpmailer.php');
	require_once (MODULES_DIR . DIRECTORY_SEPARATOR .  'PHPMailer' . DIRECTORY_SEPARATOR . 'class.smtp.php');

	if ( file_exists( CORE_FOLDER . DIRECTORY_SEPARATOR . $className . '.class.php' ) ) {
	
		$pathfile = CORE_FOLDER . DIRECTORY_SEPARATOR . $className . '.class.php';
		
	// Libraries
	} elseif ( file_exists( LIB_DIR . DIRECTORY_SEPARATOR . $className . '.class.php' ) ) {
        
    	$pathfile = LIB_DIR . DIRECTORY_SEPARATOR . $className . '.class.php';

    // Controllers        
    } elseif ( file_exists( CONTROLLERS_DIR . DIRECTORY_SEPARATOR . $className.'Controller.php' ) ) {
    	
    	$pathfile = CONTROLLERS_DIR . DIRECTORY_SEPARATOR . $className.'Controller.php';
    	
    // Models    	
    } elseif ( file_exists( MODELS_DIR . DIRECTORY_SEPARATOR . $className.'Model.php' ) ) {
        
    	$pathfile = MODELS_DIR . DIRECTORY_SEPARATOR . $className.'Model.php';

    // Modules	
    } elseif ( file_exists( MODULES_DIR . DIRECTORY_SEPARATOR . $className.'.class.php' ) ) {
        
    	$pathfile = MODULES_DIR . DIRECTORY_SEPARATOR .  $className.'.class.php';
    	
    } else {
    	
    	throw new Exception ("A classe {$className} não foi encontrada!");
    }
    
    if ( !empty ( $pathfile ) ) {
    
    	require_once ( $pathfile );
    }
}