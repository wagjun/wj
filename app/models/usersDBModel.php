<?php

class usersDB extends Model {

    
    public function listaUsuarios () {
        
        $sql = "select u.id,
                        u.login,
                        u.full_name,
                        ut.description,
                        ut.abrev,
                        ut.id as user_type_id,
                        u.type_authentication,
                        u.status,
                        u.profile,
                        p.initials,
                        p.name as name_profile,
        		ua.driver
                   from users u 
         inner join profiles p on p.id = u.profile
         inner join user_auth ua on ua.id = u.type_authentication
         inner join user_types ut on ut.id = u.user_type_id";
        
        $rs = $this->db->query( $sql );
         
        return ( !empty ($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : false );
    }
    
    
    public function buscaUsuariosAtivos ($campos = ' * ') {
     
        $where = "estado = 'A'";
        
        return $this->select(self::tabela, $campos , $where);
    }

    
    public function consultaUsuario ( $aUsuario ) {
    	
    	$sql = "SELECT u.*, 
                        ut.description, 
                        ut.abrev,
                        ua.driver
                  FROM users u
    	    INNER JOIN user_types ut on ut.id = u.user_type_id
    	    INNER JOIN user_auth ua on ua.id = u.type_authentication
                 WHERE u.login 			= '{$aUsuario['usuario']}'
    		    -- A senha precisa se comentada, pois, pode vir de um diretorio 
                    -- AND u.password 		= '{$aUsuario['senha']}'
    		       AND ut.abrev 		= 'sys'  
    		       AND u.status 		= 'A'";
    	
    	$rs = $this->db->query($sql);
    	
    	return ( !empty ($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False ); 
    }

    
    public function consultaUsuarioToken ( $aUsuario ) {
     
        $sql = "SELECT u.*, 
                        ut.description, 
                        ut.abrev,
                        ua.driver
                  FROM users u
    	    INNER JOIN user_types ut on ut.id = u.user_type_id
    	    INNER JOIN user_auth ua on ua.id = u.type_authentication
                 WHERE u.login 			= '{$aUsuario['usuario']}'
                       AND u.token 		= '{$aUsuario['token']}'
    		       AND ut.abrev 		= 'sys'  
    		       AND u.status 		= 'A'";
    	
    	$rs = $this->db->query($sql);
    	
    	return ( !empty ($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
    }
    
    
    public function consultaUsuarioId ( $idUsuario ) {
    	 
    	$sql = "SELECT *
                  FROM users
                 WHERE id = {$idUsuario}";
    	 
    	$rs = $this->db->query($sql);
    	 
    	return ( !empty ($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
    }    
    
    
    public function excluiUsuario ( $idUsuario ) {
    	
    	$sql = "delete from users where id = {$idUsuario}";
    	
    	$this->db->query( $sql );
    }

    
    public function salvaUsuario ( $aUsuario ) {
    	
    	
    	if ( ( empty ($aUsuario['senhaantiga']) ) || ( !empty ($aUsuario['senhaantiga']) && ($aUsuario['senha'] != $aUsuario['senhaantiga']) ) ) {

    		$objCrypt = new Encryption( $this->paramsConn['FW']['key'] );
    		 
    		$aUsuario['senha'] = $objCrypt->encrypt( $aUsuario['senha'] );
    	}
    	
    	if ( !empty( $aUsuario['id'] ) ) {

    		$sql = "update users set login = '{$aUsuario['usuario']}', 
    								 password = '{$aUsuario['senha']}', 
    								 full_name = '{$aUsuario['nome']}', 
    								 status = '{$aUsuario['situacao']}', 
    								 profile = {$aUsuario['perfil']},
    								 user_type_id = {$aUsuario['tipo']},
    								 type_authentication = {$aUsuario['auth']},
    								 email = '{$aUsuario['email']}'
							where id = {$aUsuario['id']}";
    	} else {

    		$sql = "insert into users (login, password, full_name, status, profile, user_type_id, type_authentication, email)
    		values ('{$aUsuario['usuario']}','{$aUsuario['senha']}','{$aUsuario['nome']}', '{$aUsuario['situacao']}', {$aUsuario['perfil']},{$aUsuario['tipo']},{$aUsuario['auth']},'{$aUsuario['email']}')";
    	}
    	
    	$this->db->query ( $sql ); 
    }


}