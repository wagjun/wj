<?php

class cidadesDB extends Model {
	
	
	public function listaCidades () {
		

		
	}
	
	
	public function coletaCidadesMy () {
		
		
		$sql = "SELECT * FROM cidade";
		$rs  = $this->MY_LOCAL->query( $sql );
		
		return ( !empty ( $rs ) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
	}
	
	
	public function salvaCidadesPostgres ( $aObjCidades ) {
		
		
		foreach ( $aObjCidades as $objCidade ) {
			
			$sql = "INSERT INTO coletas.cidades VALUES ({$objCidade->id}, '{$objCidade->nome}', {$objCidade->estado})";
			
			$this->POSTGRE_LOCAL->query ( $sql );			
		}
	}
	
	
	public function limpaCidadesPostgres () {
		
		$sql = "TRUNCATE coletas.cidades";
			
		$this->POSTGRE_LOCAL->query ( $sql );
	}
	

	
}