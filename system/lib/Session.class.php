<?php

class Session {

	
	protected $session 		= array();
	
	
	private $activeSession 	= False;
	

	private $loginRequired	= True;
	
	
	public function __construct() {

		$this->sessionStart();		
	}
	
	
	public function sessionStart () {
		
		session_start();
		
		$this->session          = & $_SESSION;
		$this->activeSession 	= True;
		$this->loginRequired	= False;
	}
	
	
	public function isActiveSession () {
		
		return (boolean) ( $this->getFromSession('login') );
		
	}
	
	
	public function addSession ( $data, $content = null ) {
	
		if ( is_array( $data ) ) {
		
			foreach ( $data as $key => $value ) {
			
				$this->session[$key] = $value;
			}
			
		} else {
			
			$this->session[$data] = $content;
		}
	}
	
	
	public function remSession ( $data ) {
	
            if ( is_array( $data ) ) {
		
			foreach ( $data as $key ) {
			
				unset($this->session[$key]);
			}
			
		} else {
			
			unset($this->session[$data]);
		}
	}
	
	
	public function returnSession () {
		
		return $this->session;  		
	}
	
	
	public function sessionDestroy () {
		
		$this->activeSession = False;
		$this->loginRequired = True;
		
		session_destroy();
	}
	
	
	public function getFromSession ( $indice ) {
		
		return ( isset ( $this->session[$indice] ) ? $this->session[$indice] : False );
	}
	
        
        public function cleanSession () {
            
            $this->session = null;
        }
}