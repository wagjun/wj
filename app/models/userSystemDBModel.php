<?php

class userSystemDB extends Model {
    
    
    public function consultaCredencial ( $conexao ) {
        
        $sql    = "SELECT us.*,
                          u.login as user,
                          u.password,
                          u.email,
                          u.status
                     FROM user_system us
               INNER JOIN users u on u.id = us.user_id
                    WHERE nome_conexao ='" . $conexao . "'";

        $rs     = $this->db->query( $sql );
        
        return (!empty($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False);
    }
    
    
    
}