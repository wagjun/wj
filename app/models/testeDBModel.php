<?php

class testeDB extends Model {
	
	
	
	public function consultaNDS ( $idAutorizado ) {
		
		$sql = "select * from nds_cache where oiidautorizados = '{$idAutorizado}'";
		//echo $sql . PHP_EOL;
		
		$rs = $this->SDW->query ($sql);
		
		return  ( !empty ($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
	}
	

	public function consultaAutorizados ( $idAutorizado ) {
	
		$sql = "select * from autorizados_desligados_cache where identificacao = '{$idAutorizado}'";
		//echo $sql . PHP_EOL;
	
		$rs = $this->SDW->query ($sql);
	
		return  ( !empty ($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
	}
	
	
}