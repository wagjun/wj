<?php

class executionDB extends Model {
	
	
	public function saveExecution ( $aExecution ) {
	
		if ( !empty($aExecution['id_execution']) ) {

			$sql = "UPDATE executions SET fim_execucao = '{$aExecution['fim_execucao']}', 
										  tempo_execucao = '{$aExecution['tempo_execucao']}' 
			                        WHERE id = {$aExecution['id_execution']}";
			
		} else {
		
			$sql = "INSERT INTO executions (id_script, id_usuario, inicio_execucao, modo_execucao, parametros)
			VALUES ({$aExecution['id_script']}, {$aExecution['id_usuario']}, '{$aExecution['inicio_execucao']}', '{$aExecution['modo_execucao']}', '{$aExecution['parametros']}' ) RETURNING id";
			
                        
		}
		
		try {
		
			$rs = $this->db->query( $sql );
		
			return ( empty ( $aExecution['id_execution'] ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False ); 
			
		} catch (Exception $e) {
			
			die('Erro ao salvar Execucao!');
		}
	}
	
	
	public function getExecutions ( $idScript ) {
		
		$sql = "SELECT * 
		          FROM executions e
		    INNER JOIN users u on u.id = e.id_usuario
		         WHERE id_script = {$idScript[0]}";
		$rs  = $this->db->query( $sql );
		
		return ( !empty($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
	}
	
}