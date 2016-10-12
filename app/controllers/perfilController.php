<?php

class perfil extends Controller {
    
	
    public function lista () {
    	
    	$objProfiles = $this->model('profiles');
    	$objProfiles->connect('FW');
    	
    	$dados['profiles'] = $objProfiles->listaProfiles();
    	
    	$this->view('listaPerfis', $dados);
    	
    }
    
    
    public function consulta ( $perfil ) {
    	
    	$objProfiles = $this->model('profiles');
    	$objProfiles->connect('FW');
    	
    	return $objProfiles->consultaPerfilId( $perfil );
    }
    
    
    public function cadastro () {
    	
    	$this->html('cadastroPerfil');
    }
    
    
    public function salva () {
    	
    	$aProfile 		= $_POST;
    	$objProfiles 	= $this->model('profiles');
		$objProfiles->connect('FW');
    	
		$objProfiles->savePerfil( $aProfile );
		
		header('Location: '. BASE_URL . 'perfil/lista/');
    }
    
    
    public function edita ( $aParams ) {
    	
    	$dados['profiles'] = $this->consulta( $aParams[0] );    	
    	$this->html('editaPerfil', $dados);
    }
	
	
    public function exclui ( $perfil ) {
    	
    	$objProfiles = $this->model('profiles');
    	$objProfiles->connect('FW');
    	
    	$objProfiles->excluiPerfil( $perfil[0] );
    	
    }
}