<?php

class autenticacaoUsuario extends Controller {
    
    
    public function index () {
        
        
    }
    
    
    public function lista () {
        
        $objAutenticacao = $this->model('userAuth');
        $objAutenticacao->connect('FW');
        
        $dados['auths'] = $objAutenticacao->listaAutenticacaoUsuario();
    }
    
    public function consulta () {
        
        $objAutenticacao = $this->model('userAuth');
        $objAutenticacao->connect('FW');
        
        $dados['auths'] = $objAutenticacao->listaAutenticacaoUsuario();

        return $dados;
    }
    
}