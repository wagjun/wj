<?php

class usuario extends Controller {
    

	
    public function index () {
        
    	global $mode;
    	
    	if ( $this->executionMode == MODE_WEB ) {
    	
    		$this->view( 'usuarioIndex' );
    	
    	} else {
    	
    		$this->executaTerminal();
    	}
    }
    
    
    protected function executaTerminal () {
    	
    	echo 'Rodou usuario' . PHP_EOL;
    }
    
    
    public function lista () {
    	
    	$objUsers = $this->model('users');
    	$objUsers->connect('FW');
    	
    	$dados['usuarios'] = $objUsers->listaUsuarios();
    	
    	$this->view('listaUsuarios', $dados);
    	
    }
    
    
    public function cadastro () {
    	
    	$objProfiles = $this->model('profiles');
    	$objProfiles->connect('FW');
    	
        $objTipoUsuario = $this->model('userTypes');
    	$objTipoUsuario->connect('FW');
        
        $objAutenticacao = $this->model('userAuth');
        $objAutenticacao->connect('FW');
        
    	$dados['profiles']  = $objProfiles->listaProfiles();
    	$dados['types']     = $objTipoUsuario->listaTipoUsuarios();
    	$dados['auths']     = $objAutenticacao->listaAutenticacaoUsuario();
        
    	$this->html('cadastroUsuario', $dados);
    }
    
    
    public function salva () {

    	$aUsuario = $_POST;
    	
    	$objUsers = $this->model('users');
    	$objUsers->connect('FW');
    	
    	$objUsers->salvaUsuario( $aUsuario );
    	
    	header('Location:'.BASE_URL.'usuario/lista/');
    }
    
    
    public function edita ( $usuario ) {
    	
    	$objUsers = $this->model('users');
    	$objUsers->connect('FW');
		
    	$objProfiles = $this->model('profiles');
    	$objProfiles->connect('FW');
        
        $objTipoUsuario = $this->model('userTypes');
    	$objTipoUsuario->connect('FW');
        
        $objAutenticacao = $this->model('userAuth');
        $objAutenticacao->connect('FW');

        $dados['usuarios']  = $objUsers->consultaUsuarioId( $usuario[0] );
        $dados['profiles']  = $objProfiles->listaProfiles();
    	$dados['types']     = $objTipoUsuario->listaTipoUsuarios();
    	$dados['auths']     = $objAutenticacao->listaAutenticacaoUsuario();
        
    	$this->html('editaUsuario', $dados);
    	
    }
    
    
    public function exclui ( $usuario ) {
    	
    	$objUsers = $this->model('users');
    	$objUsers->connect('FW');
    	
    	
    	$objUsers->excluiUsuario( $usuario[0] );
    }
    
    
    public function senha () {
    	
    	$objUsuario = $this->model('users');
    	$objUsuario->connect('FW');
    	
    	$objProfiles = $this->model('profiles');
    	$objProfiles->connect('FW');
    	
    	$dados['usuarios'] = $objUsuario->consultaUsuarioId( self::$session->getFromSession('id') );
    	$dados['profiles'] = $objProfiles->listaProfiles();
    	
    	$this->view ('alterarSenhaUsuario', $dados);
    	
    }
    
}