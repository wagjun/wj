<?php


class cronDB extends Model {
    
    
    public function salvaExecucao ( $aParams ) {
        
        
        if ( empty($aParams['id']) ) {
            
            $sql = "INSERT INTO cron_executions (inicio_execucao, parametros) VALUES ('" . Date("Y-m-d H:i:s") . "','" . json_encode($aParams) . "') RETURNING id";
            
        } else {
            
            $objExecucao = $this->consultaExecucao( $aParams['id'] );
            
            $inicioExecucao = $objExecucao[0]->inicio_execucao;
            $fimExecucao    = Date("Y-m-d H:i:s");
            $tempoExecucao  = $fimExecucao - $inicioExecucao;
            
            $sql = "UPDATE cron_executions SET fim_execucao = '{$fimExecucao}', tempo_execucao = '{$tempoExecucao}' WHERE id = {$aParams['id']}";
        }
        
        $rs = $this->db->query( $sql );
        
        return ( !empty ( $rs ) ? $rs->fetchAll(PDO::FETCH_ASSOC) : False );
    }
    
    
    public function verificaScriptsCron () {
            
        $where = "minuto = '*' AND hora = '*' AND dia_da_semana = '*' AND dia_do_mes = '*' AND mes = '*'";

        $sql = "SELECT c.id, 
                       s.*,
                       m.*
                  FROM cron c
            INNER JOIN scripts s on s.id = c.id_script
            INNER JOIN modules m on m.id = s.module
                 WHERE {$where}";

        $rs = $this->db->query( $sql );

        return ( !empty ( $rs ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
    }
 
    
    public function consultaExecucao ( $idExecucao ) {
        
        $sql    = "SELECT * FROM cron_executions WHERE id = {$idExecucao}";
        
        $rs     = $this->db->query( $sql );
        
        return ( !empty ( $rs ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
    }
}
                     
