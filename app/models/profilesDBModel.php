<?php

class profilesDB extends Model {

    
    public function listaProfiles () {
        
        $sql = "select * from profiles";
        
        $rs = $this->db->query( $sql );
         
        return ( !empty ($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : false );
    }
    
    
    public function savePerfil ( $aProfile ) {
    	
    	if ( !empty( $aProfile['id'] ) ) {
    		
    		$sql = "update profiles set initials = '{$aProfile['sigla']}', name = '{$aProfile['nome']}' where id = {$aProfile['id']}";
    		
    	} else {
    	
    		$sql = "insert into profiles (initials, name) values ('{$aProfile['sigla']}', '{$aProfile['nome']}')";
    	}
    	
    	$this->db->query( $sql );
    }
    
    
    public function consultaPerfilId ( $idPerfil ) {
    	
    	$sql 	= "select * from profiles where id = {$idPerfil}";
    	$rs 	= $this->db->query( $sql );

    	return ( !empty ($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
    }
    
    
    public function excluiPerfil ( $idPerfil ) {
    	
    	$sql = "delete from profiles where id = {$idPerfil}";
    	$this->db->query( $sql );
    }
}