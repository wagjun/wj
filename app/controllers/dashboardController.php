<?php

class dashboard extends Controller {
	
	
	public function index () {
	
		if ( $this->executionMode == MODE_WEB ) {
			
			
			$this->view('teste');
			
		} else {
			
			echo 'Linha de comando';
		}
		
	}
	
	
	
	
	
}