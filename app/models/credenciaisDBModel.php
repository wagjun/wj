<?php

class credenciaisDB extends Model {
	
	
	public function consultaContaServicoExpiradaPorTempo ( $contaServico, $tempo, $intervalo = 'days' ) {
	
		try {
	
	    	$sql = "SELECT pwdchangedtime 
	    			  FROM nds_cache 
	    			 WHERE cn='{$contaServico}' 
	    			   AND  to_timestamp(pwdchangedtime, 'YYYYMMDD') > (NOW() - INTERVAL '{$tempo} {$intervalo}')";
				
			$rs = $this->db->query( $sql );
		
			return ( !empty($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False ); 
			
		} catch (Exception $e) {
				
			echo 'Erro ocorrido!';
		}
	}
		
}