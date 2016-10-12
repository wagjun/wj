<?php

class tipoUsuario extends Controller {
    
    
    public function index () {
        
    }
    
    
    public function lista () {
        
        
        
    }
    
    public function consulta () {
        
        $objTipoUsuario = $this->model('userTypes');
        $objTipoUsuario->connect('FW');
        
        $dados['tipos'] = $objTipoUsuario->listaTipoUsuarios();
        
        return $dados;
    }
    
    
}