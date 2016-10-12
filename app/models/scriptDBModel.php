<?php

class scriptDB extends Model {
	
	/* ------------------------ FW ------------------------- */
	
	/**
	* Usado para consultar script por id.
	* @param $idScript
	* @author Bruna Leiras
	* @return array de objetos script
	*/
	public function consultaScriptsPorId( $idScript ) {
	
		$sql 	= "select * from scripts where id = {$idScript}";
		
		//echo $sql; exit;
		$rs 	= $this->db->query ( $sql );
	
		return ( !empty( $rs ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
	}
	
	/**
	* Adaptado do original (consultaScriptSoxSDW) para consultar script por campos(novo) e tabela_referencia.
	* @param $codigo
	* @author Bruna Leiras
	* @return array de objetos script
	*/
	public function consultaScriptSoxSDWNovo ( $codigo ) {
		
		$query 	= "select * from scripts where codigo = '{$codigo}'";
		$script = $this->db->query( $query );

		$objTabela = ( !empty( $script ) ? $script->fetchAll(PDO::FETCH_OBJ) : False );
		//Coloco o * para nao dar erro pois a coluna campos e nova.
		$campos = "*";
		
		if(!empty($objTabela[0]->campos)){
			
			$campos = $objTabela[0]->campos;
			
		}
		
		$tabela = "";
		
		if(!empty($objTabela[0]->tabela_referencia)){
			
			$tabela = $objTabela[0]->tabela_referencia;
			
		}
		
		$sql 	= "select {$campos} from {$tabela}";
		
		$rs 	= $this->db->query( $sql );
                //echo $sql;exit();
		return ( !empty( $rs ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
	}
	
        /**
	* Usado contar os itens da tabela_referencia.
	* @param $tabela - valor da coluna tabela_referencia  da tabela scripts
	* @author Bruna Leiras
	* @return int
	*/
	public function countPorTabelaReferencia( $tabela ) {
		
		$sql 	= "select count(*) from {$tabela}";

		$rs 	= $this->db->query( $sql );

		return ( !empty( $rs ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
	}
        
        
	public function verificaTabelaCodigoScript ( $codigo ) {
        
	            try {
        
	                $sql    = "select * from scripts where codigo = '".$codigo."'";
	                $rs     = $this->db->query ( $sql );
        
	            }  catch (Exception $ex){
                
	                echo $ex->getMessage() . ' Codigo: '. $codigo .'<br />';
	            }
                
	            return ( !empty ( $rs ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
	    }
	
            
	public function consultaScriptId ( $idScript ) {
	
		$sql = "select s.*,
		m.link,
		m.controller,
		m.action
		from scripts s
		inner join modules m on m.id = s.module where s.id = {$idScript}";
	
		$rs = $this->db->query( $sql );
	
		return ( !empty( $rs ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
	}
	
	
	public function consultaScriptsTipo ( $idTipo ) {
	
	
		$sql = "select * from scripts where id_tipo = {$idTipo}";
	
		$rs = $this->db->query ( $sql );
	
		return ( !empty( $rs ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
	}
	
	
	public function consultaScriptsTipoSituacao ( $idTipo = null, $idSituacao = null ) {

		if ( !empty ( $idTipo ) && !empty ( $idSituacao ) ) {
	
			$where = "where id_tipo = {$idTipo} and situacao = '{$idSituacao}'";
				
		} elseif ( !empty ( $idTipo ) && empty ( $idSituacao ) ) {
	
			$where = "where id_tipo = {$idTipo}";
				
		} elseif ( empty ( $idTipo ) && !empty ( $idSituacao ) ) {
				
			$where = "where situacao = '{$idSituacao}'";
				
		} else {
				
			$where = '';
		}
	
		$sql 	= "select * from scripts $where";
		$rs 	= $this->db->query ( $sql );
	
		return ( !empty( $rs ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
	}
		

	public function consultaScript ( $controller, $action ) {
	

		$sql = "SELECT s.id as id,
		s.nome as nome_script,
		s.id_tipo,
		m.id as id_module,
		m.name as nome_modulo,
		m.link,
		m.controller,
		m.action
		FROM scripts s
		INNER JOIN modules m ON m.id = s.module
		WHERE controller ='{$controller}'
		AND action = '{$action}'";
	
		$rs = $this->db->query( $sql );

                return ( !empty( $rs ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
	}
	
	
	public function listaScripts () {
	
		$sql = "select
					   s.id,
					   s.nome,
					   s.tabela_referencia,
					   s.situacao,
					   s.module,
					   m.link
				  from scripts s
		     left join modules m on m.id = s.module";
	
		$rs  = $this->db->query( $sql );
	
		return ( !empty ($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False);

	}	
	
	/* ------------------------ SDW ------------------------- */
        
        
	public function listaProblemas () {
	
	
		$sql = "SELECT DISTINCT(COD_SOX) as cod_sox,
						MAX(hora) as hora,
						horario_envio,
						max(qtd_reg) as qtd_reg,
						descricao,
						max(erro_num) as erro_num
				  FROM (
						SELECT 	DISTINCT(A.COD_ALERTA) as cod_sox,
								MAX(B.INSERT_TIMESTAMP)::TEXT AS HORA,
						        A.HORARIO_ENVIO as horario_envio,
						        max(B.ERRO_NUM) as erro_num,
						        B.BLOCO as bloco,
						        --B.ERRO_DESCRICAO as erro_descricao,
						        max(B.QTD_REG) as qtd_reg,
						        A.DESCRICAO as descricao
						   FROM sox.\"ALERTAS_SOX\" A
					  LEFT JOIN log.\"ALERTAS_SOX\" B ON B.COD_SOX = A.COD_ALERTA
						  WHERE B.INSERT_TIMESTAMP::DATE = NOW()::DATE
							AND (B.COD_SOX , B.INSERT_TIMESTAMP) IN (
																		SELECT B.COD_SOX,
																			   MAX(B.INSERT_TIMESTAMP) AS HORA
																		  FROM log.\"ALERTAS_SOX\" B
																		 WHERE B.INSERT_TIMESTAMP::DATE = NOW()::DATE
																	  GROUP BY B.COD_SOX
																	  ORDER BY HORA DESC
																	)
					   GROUP BY A.COD_ALERTA, A.HORARIO_ENVIO, B.BLOCO, B.ERRO_DESCRICAO, A.DESCRICAO
					   UNION
					   SELECT DISTINCT(A.COD_ALERTA) as cod_sox,
							  max(NULL) as hora,
							  A.HORARIO_ENVIO as horario_envio,
						      NULL as erro_num,
						      NULL as bloco,
							--NULL as erro_descricao,
							  NULL as qtd_reg,
						      A.DESCRICAO as descricao
						 FROM sox.\"ALERTAS_SOX\" A
				  	 GROUP BY A.COD_ALERTA, HORARIO_ENVIO, ERRO_NUM, QTD_REG, DESCRICAO
					 ORDER BY HORA, HORARIO_ENVIO
					) AS Z
			 GROUP BY COD_SOX, horario_envio, descricao
			 ORDER BY 3";
	
		$rs = $this->db->query( $sql );
	
		return ( !empty($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : false );

	}
	
	
	public function listaAlertasSox () {
	
		$sql = "SELECT DISTINCT(COD_SOX) as cod_sox, MAX(hora) as hora, horario_envio, funcao, max(qtd_reg) as qtd_reg, descricao, max(erro_num) as erro_num, max(email_envio) as email_envio, horario_envio_email
					FROM (
					SELECT 	DISTINCT(A.COD_ALERTA) as cod_sox,
						MAX(B.INSERT_TIMESTAMP)::TEXT AS HORA,
							A.HORARIO_ENVIO as horario_envio,
							A.HORARIO_ENVIO_EMAIL as horario_envio_email,
							max(B.ERRO_NUM) as erro_num,
							B.BLOCO as bloco,
							A.function as funcao,
							max(B.QTD_REG) as qtd_reg,
							A.DESCRICAO as descricao,
							L.check_sox as email_envio
					FROM 	sox.\"ALERTAS_SOX\" A
					LEFT 	JOIN log.\"ALERTAS_SOX\" B ON B.COD_SOX = A.COD_ALERTA
					LEFT 	JOIN log.\"CONFIRM_ENVIO_EMAIL_LOGWATCH\" L ON L.COD_SOX = A.COD_ALERTA AND L.INSERT_TIMESTAMP::DATE = NOW()::DATE
					WHERE 	B.INSERT_TIMESTAMP::DATE = NOW()::DATE
					AND		A.ativo = '1'
					AND 	(B.COD_SOX , B.INSERT_TIMESTAMP) IN
							(SELECT 	B.COD_SOX,
									MAX(B.INSERT_TIMESTAMP) AS HORA
							FROM 		log.\"ALERTAS_SOX\" B
							WHERE 		B.INSERT_TIMESTAMP::DATE = NOW()::DATE
							GROUP BY 	B.COD_SOX
							ORDER BY 	HORA DESC)
					GROUP 	BY A.COD_ALERTA, A.HORARIO_ENVIO, A.HORARIO_ENVIO_EMAIL, A.function, B.BLOCO, B.ERRO_DESCRICAO, A.DESCRICAO, L.check_sox
					UNION
					SELECT 	DISTINCT(A.COD_ALERTA) as cod_sox,
						max(NULL) as hora,
						A.HORARIO_ENVIO as horario_envio,
						A.HORARIO_ENVIO_EMAIL as horario_envio_email,
							NULL as erro_num,
							NULL as bloco,
							A.function as funcao,
						NULL as qtd_reg,
							A.DESCRICAO as descricao,
							NULL as email_envio
					FROM 	sox.\"ALERTAS_SOX\" A
					WHERE 	A.ativo = '1'
					GROUP BY A.COD_ALERTA, HORARIO_ENVIO, HORARIO_ENVIO_EMAIL, funcao, ERRO_NUM, QTD_REG, DESCRICAO, email_envio
					ORDER BY HORA, HORARIO_ENVIO
					) AS Z
					GROUP BY COD_SOX, horario_envio,horario_envio_email, descricao, funcao
					ORDER BY 7 DESC, 3";
	
		$rs = $this->db->query( $sql );
	
		return ( !empty($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : false );
	}

	
	public function consultaScriptSoxSDW ( $codigo ) {
		
		$query 	= "select * from scripts where codigo = '{$codigo}'";
		$script = $this->db->query( $query );

		$objTabela = ( !empty( $script ) ? $script->fetchAll(PDO::FETCH_OBJ) : False );
		
		$sql 	= "select * from {$objTabela[0]->tabela_referencia}";
		$rs 	= $this->db->query( $sql );

		return ( !empty( $rs ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
	}

	
	public function consultaTabelaCodigoScript ( $codigo ) {
		
            try {
		
                $sql    = "select * from sox.\"ALERTAS_SOX\" where cod_alerta = '".$codigo."'";
                $rs     = $this->db->query ( $sql );
		
            }  catch (Exception $ex){
                
                echo $ex->getMessage() . ' Codigo: '. $codigo .'<br />';
            }
                
            return ( !empty ( $rs ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
	}
	

	public function consultaInconsistenciasTabela ( $campos, $table, $inicio = null, $fim = null) {
		
		// TODO: Periodo para ser implementado
		
		$data 		= new Data();
		
		$where 		= "WHERE ";
		$orderBy	= "ORDER BY insert_timestamp DESC";		
		
		if ( !empty ( $inicio ) && empty ( $fim ) ) {
			
			$where .= "insert_timestamp >= '{$data->formatoBD($inicio)}' AND insert_timestamp <= '" . Date("Y-m-d") . "'";
			
		} elseif ( !empty ( $inicio ) && !empty ( $fim ) ) {
			
			$where .= "insert_timestamp >= '{$data->formatoBD($inicio)}' AND insert_timestamp <= '{$data->formatoBD($fim)}'";
		
		} elseif ( empty ( $inicio ) && empty ( $fim ) ) {

			$where .= "to_char(insert_timestamp, 'YYYY-MM-DD') = to_char(CURRENT_DATE, 'YYYY-MM-DD')";
			
		} elseif ( empty ( $inicio ) && !empty ( $fim ) ) {

			die('Periodo inicial n�o foi definido!');
		}
		
		$sql 	= "SELECT " . trim($campos) . " FROM $table $where $orderBy";
		
		$rs 	= $this->db->query( $sql );
		 
		return ( !empty($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
	}
}