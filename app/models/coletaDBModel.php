<?php

class coletaDB extends Model {
	
	
	public function salvaColetaNds ( $objUsuarioNds, $campos ) {
	
		try {
	
			$sql = "INSERT INTO coletas.nds (" . join(", ", $campos) . ") VALUES ('" . join("', '", $objUsuarioNds) ."')";
				
			$this->db->query( $sql );
				
		} catch (Exception $e) {
				
			echo 'Erro ocorrido!';
		}
	}
	
	
	public function salvaColetaNdsLote ( $aObjUsuarioNds, $campos ) {

		$count 	= 0;
		$total 	= 0; 
		$indice	= 0;
		$aInsrt	= array();
		
		$sql 	= "INSERT INTO coletas.nds (" . join(", ", $campos) . ") VALUES ";
		$csv	= join("; ", $campos) . "\n";
		
		// Monta o insert com o teto de 1000 registros 
		foreach ( $aObjUsuarioNds as $objUsuarioNds ) {

			if ( $count > 0 ) {
				
				$sql .= ", ";
			} 
			
			$sql .= "('" . join("', '", $objUsuarioNds) ."')";
			$csv .= join("'; '", $objUsuarioNds) . "\n";
			
			$count++;
			$total++;
			
			if ( $count % 1000 == 0 ) {
			
				$aInsrt[$indice]	= $sql;
				$sql 				= "INSERT INTO coletas.nds (" . join(", ", $campos) . ") VALUES ";
			
				$count = 0;
				$indice++;
			} 
		}

		// Adicionando os ultimos registros
		$aInsrt[$indice] = $sql;

		foreach ( $aInsrt as $ind => $insert ) {
	
			try {

				$objCsv = new Fileutils();
				$objCsv->createSheet('nds_cache', $csv);
				
				if ( !$this->db->query( $insert ) ) {
					
					throw new Exception("Query: " . $sql);
				}
				
			} catch (Exception $e) {
			
				echo $e->getMessage();
			}
		}
	}
}