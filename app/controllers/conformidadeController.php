<?php

class conformidade extends Controller {
	
	
	public function index () {}
	
	
	public function nmo () {
		
		$objConformidade = $this->model('conformidade');
		$objConformidade->connect('SDW');
		
		$objEvents = $this->model('conformidade');
		//$objEvents->connect('NMO');
		
		var_dump($objEvents);die;
		
		foreach ( $objConformidade->getWhiteListNmo() as $user ) {
		
			//echo ($user->login_nds) . PHP_EOL;
			
			
			$objEvents->getEventsNmoByUser( $user->login_nds );
		}
	}
	
	
	
	
}