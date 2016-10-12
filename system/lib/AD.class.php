<?php

class AD extends Ldap {
	
	
	private $attributes;

	
	private $arvore;
	
	
	protected $ldap; 
	
	
	public function __construct( $aConnectionData ) {
		
		$this->ldap = parent::__construct( $aConnectionData );
	}
	

	public function conectaAD () {
		
		return $this->ldap;
	}

	
	public function buscaUsuariosPorGrupo ($aGrupos, $dc) {
		

		foreach ( $aGrupos as $grupo ) {

			$aUsuarios = array();
			
			echo $grupo.PHP_EOL;
			echo "========== {$dc} ===========".PHP_EOL;
		
			$data = $this->consultaUsuariosAD ($grupo, $dc);

			if ( !empty( $data ) ) {

				if ( !empty( $data[0]['member'] ) ) {
				
					foreach ( $data[0]['member'] as $ind => $valor ) {
							
						if ( is_string( $valor ) ) {
				
							$rs				= explode(",", $valor);
							$cn				= explode("=", $rs[0]);
				
							$aUsuarios[] 	= $cn[1];
						}
					}
				
				} else {
				
					echo 'Nao tinha membros' . PHP_EOL;
				}
				
			} else {
				
				echo 'Nao retornou dados' . PHP_EOL;
			}
		}
		
		return $aUsuarios;
	}
	
	
	private function consultaUsuariosAD ($grupo, $dc) {
	
		$query	 = array (
							'base_dn'	=> "dc={$dc},dc=corp,dc=net",
							'filter'  	=> "(CN={$grupo})"
		);
	
		$this->query( $query );
	
		return $this->data();
	}

}