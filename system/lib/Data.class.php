<?php

class Data {
	
		
	public function formatoBD ( $data ) {
		
		$date = new DateTime( $data );
		
		return $date->format("Y-m-d");
	}
	
	
}