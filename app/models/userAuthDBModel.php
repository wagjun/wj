<?php

class userAuthDB extends Model {
    
    
    public function listaAutenticacaoUsuario () {
        
        $sql    = "select * from user_auth";
        $rs     = $this->db->query( $sql );
        
        return ( !empty( $rs ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
    }
    
    
}