<?php

class userTypesDB extends Model {
    
    
    public function listaTipoUsuarios () {
        
        $sql    = "select * from user_types";
        $rs     = $this->db->query( $sql );
        
        return ( !empty( $rs ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
    }
    
    
}