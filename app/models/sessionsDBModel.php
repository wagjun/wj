<?php

class sessionsDB extends Model {
    
    
    public function salvaSessao ( $objSession ) {
        
        $sql = "INSERT INTO sessions (\"user\", 
                                      \"status\", 
                                      \"s_ip\", 
                                      \"s_port\", 
                                      \"start_timestamp\", 
                                      \"insert_timestamp\")
                              VALUES ('{$objSession->user}', 
                                      '{$objSession->status}',
                                      '{$objSession->s_ip}',
                                      {$objSession->s_port},
                                      CURRENT_TIMESTAMP,
                                      CURRENT_TIMESTAMP) RETURNING id";
                                 
        $rs = $this->db->query( $sql );
        
        
        
        return (!empty ( $rs ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False);
    } 
    
    
    public function consultaSessao () {
        
        
    }
    
    
    public function quantidadeSessoesIntervaloUsuario ( $objSessions ) {
        
        $sql = "SELECT count(*) as qtd_erros
                  FROM sessions 
                 WHERE s_ip = '$objSessions->s_ip'
                   AND status = 'Failure'  
                   AND insert_timestamp > '" . Date("Y-m-d H:i:s", strtotime('-180 seconds')) . "'";
        
        $rs = $this->db->query( $sql );
        
        return (!empty ($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False);
    }
    
}