<?php

class permissions extends Controller {
	
	
	public function index () {
		
	}
	
	
	public function lista () {
		
		
		
	}
	
	
	public function getUrls () {
	
	
		$objControllers = new DirectoryIterator( CONTROLLERS_DIR );
	
		foreach ( $objControllers as $objController ) {
	
			// echo strstr( $objController->getFilename(), "Controller.php", True);
			// echo $objController->getFilename();
	
			if (!is_dir($objController->getFilename()) ) {
	
	
				var_dump(get_class_methods( strstr( $objController->getFilename(), 'Controller.php', TRUE) ) );
			}
		}
	
	}
	
}