<?php

class principal extends Controller {
    
    
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
	
    
    private function login () {
    	
    	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    	
            $objCrypt 	= new Encryption( $this->confsFw['CRYPT']['key'] );

            $aUsuario   = $_POST;

                if ( !empty ( $aUsuario['usuario'] ) && !empty ( $aUsuario['senha'] ) ) {

                    $aUsuario['senha']	= $objCrypt->encrypt( $aUsuario['senha'] );

                    $dados['aObjUsers'] = $this->validaLogin( $aUsuario );

                    if ( !empty($dados['aObjUsers']) ) {

                        $this->carregaSessaoUsuario( $dados['aObjUsers'] );
                        
                        $objSessao = new stdClass();

                        $objSessao->user    = $dados['aObjUsers'][0]->login;  
                        $objSessao->status  = 'Success';
                        $objSessao->s_ip    = "{$_SERVER['REMOTE_ADDR']}";;
                        $objSessao->s_port  = $_SERVER['REMOTE_PORT'];
                        $objSessao->tempo   = date("Y-m-d H:i:s");

                        $captcha            = self::$session->getFromSession('captcha');
                        
                        if ( !empty( $captcha ) ) {
                            
                            if ( $aUsuario['captcha'] != $captcha ) {                            
                                
                                $objSessao->status  = 'Failure';
                                
                                $iErros             = $this->tentativasLogin($objSessao);
                                $bExibeCaptcha      = ( $iErros[0]->qtd_erros >= 3 ? True : False );
                                
                                self::$session->remSession( array('id','login','full_name','profile','status','menu','permissoes','captcha') );
                                
                                $this->telaLogin(array( 'msg'=>'Código Captcha não confere!', 'exibe_captcha' => $bExibeCaptcha ));
                                
                            } else {
                            
                                $this->tentativasLogin($objSessao);
                                $this->telaInicial( $dados );
                            }
                            
                        } else {
                            
                            $this->tentativasLogin($objSessao);
                            $this->telaInicial( $dados );
                        }

                    } else {
                        // TODO: Paramentrizar configurações para captcha
                        $objSessao = new stdClass();
                        
                        $objSessao->user    = $aUsuario['usuario'];  
                        $objSessao->status  = 'Failure';
                        $objSessao->s_ip    = "{$_SERVER['REMOTE_ADDR']}";
                        $objSessao->s_port  = $_SERVER['REMOTE_PORT'];
                        $objSessao->tempo   = date("Y-m-d H:i:s");
                        
                        $iErros             = $this->tentativasLogin($objSessao);
                        $bExibeCaptcha      = ( $iErros[0]->qtd_erros >= 3 ? True : False );
                        
                        self::$session->remSession('captcha');
                        
                        $this->telaLogin( array( 'msg'=>'Erro de autenticacao!', 'exibe_captcha' => $bExibeCaptcha ) );
                    }

                } else {

                    $this->telaLogin("Usuário e/ou senha não podem ser vazios!");
                }

    	} else {
    		 
            if ( self::$session->isActiveSession() ) {

                    $this->telaInicial( $dados );

            } else {
                    
                    self::$session->remSession('captcha');
                    $this->telaLogin();
            }
        }
    }
    
    
    protected function telaInicial ( $dados ) {
    
    	$this->view('telaInicial', $dados);
    }
    
    
    protected function telaLogin ( $dados = null) {

        if ( !is_array ( $dados ) ) {
            
            $dados = array('msg' => $dados);
            
        } 
        
    	$this->content('login','telaLogin', $dados);
    }    
    
    
    public function crypt ( $dados = null ) {
    	
    	$dados['senha_crypt'] = null;

        if ( $this->executionMode == MODE_WEB ) {

            if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

                $objCrypt = new Encryption($this->confsFw['CRYPT']['key']);

                $dados['senha_crypt']   = $objCrypt->encrypt($_POST['senha_crypt']);
            }

            $this->view('formCrypt', $dados);

        } else {

                var_dump($dados);
        }
    }

    
    public function captcha () {
    	
        $bgs    = TEMPLATE_DIR . DIRECTORY_SEPARATOR . 'azul' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'captcha';
        $fonts  = TEMPLATE_DIR . DIRECTORY_SEPARATOR . 'azul' . DIRECTORY_SEPARATOR . 'fonts' . DIRECTORY_SEPARATOR . 'captcha';
                
    	$objCaptcha = new Captcha();
        
        $objCaptcha->definePaths($bgs, $fonts);
        
    	$code       = $objCaptcha->generateCode();
    	 
    	self::$session->addSession( 'captcha', $code );

    	$objCaptcha->createImage( $code );
    }
    
    
    public function logout () {
    	
        self::$session->sessionDestroy();
    	
    	header("Location:".BASE_URL);
    }
}