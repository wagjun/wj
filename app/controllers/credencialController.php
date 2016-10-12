<?php

class credencial extends Controller {
    
	
    public function index () {
        
    	global $objMenu;
    	
    	if ( $this->executionMode == MODE_WEB ) {
    		
    		if ( !$this->authenticate() ) {
    		
	    		$this->login();
	    		
    		} else {
    			
    			$this->view('telaInicial');
    		}
	    		
    	} else {
    	
    		echo 'Bash rolando!!!' . PHP_EOL;
    	}
    }


    public function expiracaoContaServico () {
    	
    	$aObjCredencial = $this->consultaPrazoExpiracaoContaServico();
    	
    	if ( !empty ( $aObjCredencial ) ) {
    		
    		$this->alertaContaServicoExpirada();
    		
    		if ( $this->executionMode == MODE_WEB ) {
    		
    			header("Location: http://localhost/fw/");
    			
    		} else {
    			
				echo 'Execução finalizada!!!';    			
    		}
    	}
    }
    
    
    private function consultaPrazoExpiracaoContaServico () {
    	
    	$objCredenciais = $this->model('credenciais');
    	
    	$objCredenciais->connect('SDW');
    	
    	$aObjCredencial = $objCredenciais->consultaContaServicoExpiradaPorTempo('CC059143', 120);
    	
    	return $aObjCredencial;
    }
    
    
    private function alertaContaServicoExpirada ( $dados = array() ) {
    	
    	/*
    	$this->mailer->sendEmail(
	    						array(array('email'=>'wagner.junior.proofsec@contratada.oi.net.br')), 
	    						'teste html', 
	    						$this->content('email', 'emailExpiracaoContaServico', $dados, True) 
		);
    	*/
    }
    
    
    
    
    
}