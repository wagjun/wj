<?php

class Model extends Fw {
    
	
    protected $db;

    public function connect ( $connection, $return = false ) {
    	
        return $this->db = self::$conn[$connection]; 
    }
    
}