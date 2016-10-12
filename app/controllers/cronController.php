<?php

class cron extends Controller {

    
    private $idExecucao;

    
    public function index ( $aParams = 'null' ) {

    	global $mode;

        $this->idExecucao   = $this->registraExecucao( $aParams );
        
        $aUsuario           = $this->organizaParametros( $aParams );
        $aObjUsuario          = $this->validaLogin($aUsuario);
        
        $this->carregaSessaoUsuario($aObjUsuario);
        
        $objSessao = new stdClass();

        $objSessao->user    = $aObjUsuario[0]->login;  
        $objSessao->status  = 'Success';
        $objSessao->s_ip    = "127.0.0.1";;
        $objSessao->s_port  = 'null';
        $objSessao->tempo   = date("Y-m-d H:i:s");
        
        $this->tentativasLogin($objSessao);
        
        $this->executaScript();
    }

    
    private function organizaParametros ( $aParams ) {
        
        $usuario    = explode(':', $aParams[0]);
        $senha      = explode(':', $aParams[1]);
        
        if ( $usuario[0] != 'u' ) {
            
            echo "Parametro '{$usuario[0]}' desconhecido" . PHP_EOL;
            return False;
            
        } else {
            
            $aUsuario['usuario']   = $usuario[1];
        }
        
        if ( $senha[0] != 't') {
            
            echo "Parametro '{$senha[0]}' desconhecido" . PHP_EOL;
            return False;
            
        } else {
            
            $aUsuario['senha']  = null;
            $aUsuario['token']  = $senha[1];
        }
        
        return $aUsuario;
    }
            
    
    private function executaScript () {
        
        $objCron = $this->model();
        $objCron->connect('FW');
        
        $objScriptsCron = $objCron->verificaScriptsCron();

        foreach ( $objScriptsCron as $objScript ) {
        
            $controller     = $objScript->controller;
            $action         = $objScript->action;
            
            $app            = new $controller();
            
            $app->$action();
            $app->endExecution();
        }
        
    }

    
    public function registraExecucao ( $aParams ) {
        
        $objCron = $this->model();
        $objCron->connect('FW');
        
        return $objCron->salvaExecucao ( $aParams );
    }    
    
    
    public function __destruct() {

        $this->registraExecucao($this->idExecucao[0]);
    }
}