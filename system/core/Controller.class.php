<?php


abstract class Controller extends Fw {

	
    private $startExecution = null;


    private $endExecution = null;


    private $timeExecution = null;


    private $idExecucao = null;


    private $action = null;


    private $script = null;


    private $url;


    protected $appLog;


    protected $dirView;


    public function __construct( $action = null ) {


        $this->startExecution 	= date("Y-m-d H:i:s");
        $this->dirView          = get_class( $this );
        $this->action		= $action;
        $this->url		= $this->dirView . '/' . $this->action;
        self::$session          = ( ( !self::$session ) ? new Session() : self::$session );
        
        parent::__construct();

        //  TODO: VALIDACAO DE PERMISSÂO A URL
                
        $objPermissions = $this->model('permissions');
        $objPermissions->connect('FW');

        $objUrl = $objPermissions->consultaPermissaoUrl( self::$session->getFromSession('profile'), $this->url );
        
        /*
        if ( !empty ( $objUrl ) ) {

            $this->scriptExecucao();

        } else {
           
            var_dump(self::$session);
            die('Sem permissão para execução.');
        }
        */       
        
        $this->appLog	= new Logger( LOGS_DIR . DIRECTORY_SEPARATOR . $this->dirView . DIRECTORY_SEPARATOR . "{$this->dirView}-{$this->action}.log" );
    }

    
    private function carregaPermissoes ( $idPerfil ) {
    	
    	$objPermissoes = $this->model('permissions');
    	
    	$objPermissoes->connect('FW');
    	
    	$rs = $objPermissoes->permissaoPerfil( $idPerfil );
    	
    	return $rs;
    }
    
    
    private function montaArvoreMenu ( $permissoes ) {
    	
    	$menuArvore = array();
    	
    	foreach ($permissoes as $valor) {
    	
    		$menuArvore[$valor->id_main][$valor->id_menu] = array('link' => $valor->link, 'name' => $valor->name);
    	}
    	
    	return $menuArvore;
    }
    
    
    private function urlsPermitidas ( $permissoes ) {
    	
    	$urlPermitidas = array();
    	 
    	foreach ($permissoes as $valor) {
    		 
    		$urlPermitidas[] = $valor->link;
    	}
    	 
    	return $urlPermitidas;
    	
    }

    
    protected function validaLogin ( $aUsuario ) {
    	
    	$objUsuario = $this->model('users');
        $objUsuario->connect('FW');    	
		
    	$objUsuarios = $objUsuario->consultaUsuario( $aUsuario );
        
    	if ( !empty ( $objUsuarios ) ) {
    	
    		if ( $objUsuarios[0]->driver == 'LDAP') {
    		
                    $this->validaLoginLdap($objUsuario);
    		
    		} elseif ( ( !empty ($aUsuario['token']) ) && ( $aUsuario['token'] == $objUsuarios[0]->token ) ) { // Autenticacao por Token
                
                    return $objUsuarios;
                    
                } else {
    		
                    return ( $objUsuarios[0]->password == $aUsuario['senha'] ? $objUsuarios : False );
    		}
    		
    	} else {
    		
    		return False;
    	}
    }
    
    
    protected function tentativasLogin ( $objSessao ) {
        
        $objSession = $this->model('sessions');
        $objSession->connect('FW');
        
        $objSession->salvaSessao( $objSessao );
        
        return $objSession->quantidadeSessoesIntervaloUsuario( $objSessao );
    }

    
    protected function carregaSessaoUsuario ( $aUsuario ) {


        $aSession = array (
                            'id' 	=> $aUsuario[0]->id,
                            'login' 	=> $aUsuario[0]->login,
                            'full_name'	=> $aUsuario[0]->full_name,
                            'profile'	=> $aUsuario[0]->profile,
                            'status'	=> $aUsuario[0]->status,

        );

        self::$session->addSession( $aSession );

        $permissoes = $this->carregaPermissoes( self::$session->getFromSession('profile') );
        
        $arvore     = $this->montaArvoreMenu( $permissoes );
        $urls       = $this->urlsPermitidas( $permissoes );

        self::$session->addSession('menu', $arvore);
        self::$session->addSession('permissoes', $urls);


    }

    
    protected function validaLoginLdap ( $objUsuario ) {
    	
        /*
    	$objCrypt = new Encryption($objUsuario->paramsConn['NDS']['key']);
    	
    	$dataConnection['address']  = $objUsuario->db['NDS']['host'];
    	$dataConnection['port']     = $objUsuario->db['NDS']['port'];
    	$dataConnection['base_dn']  = $objUsuario->db['NDS']['database'];
    	$dataConnection['user']     = $objUsuario->db['NDS']['user'];
    	$dataConnection['password'] = $objCrypt->decrypt($objUsuario->db['NDS']['password']);
    	
    	$objLdap = new Ldap($dataConnection);
    	*/
    	
        $objNds = $this->model('nds');
        $objNds->connect('NDS');
    	echo '<pre>';
        var_dump($objNds->teste());
        echo '</pre>';die;
    	
    	
    }
    

    private function scriptExecucao () {

        $objScriptDB = $this->model('script');
        $objScriptDB->connect('FW');

        $objScript      = $objScriptDB->consultaScript( $this->dirView, $this->action );
        $this->script   = ( !empty( $objScript ) ? $objScript[0] : null );

        if ( !empty($this->script->id) ) {

            $this->execution( $this->script->id );
        }
    }


    protected function execution ( $idScript ) {


        $objExecution = $this->model('execution');

        $objExecution->connect('FW');

        // Código necessário para registrar o início e o fim da execução de um script.
        if ( !empty ( $this->idExecucao ) ) {

                $aExecution = array (
                                    'id_execution'      => $this->idExecucao,
                                    'fim_execucao'	=> $this->endExecution,
                                    'tempo_execucao'    => $this->timeExecution
                );

        } else {

                $aExecution = array (
                                    'id_script'  	=> $idScript,
                                    'id_usuario' 	=> self::$session->getFromSession('id'),
                                    'inicio_execucao' 	=> $this->startExecution,
                                    'modo_execucao'	=> $this->executionMode,
                                    'parametros'	=> null
                );

        }

        $lastId             = $objExecution->saveExecution( $aExecution );
        $this->idExecucao   = ( !empty ( $lastId ) ? $lastId[0]->id : null );
    }


    public function endExecution () {

        $this->endExecution 	= date("Y-m-d H:i:s");
        $this->timeExecution 	= strtotime($this->endExecution) - strtotime($this->startExecution);

        $this->scriptExecucao();

        if ( !empty ( $this->script ) ) {

                $this->fwLog->write( "Execução do Script: " . $this->script->nome_script . " Início: " . $this->startExecution . " Fim: " . $this->endExecution . " Usuário: " . self::$session->getFromSession('login') );
        }

    }
	
	
    protected function view ( $view, $dados = array(), $return = false ) {
        
        //Tranformando os indices em variáveis nas views e templates
        extract($dados, EXTR_OVERWRITE);
        
        // Template
        ob_start();
        
        if ( $this->template == TEMPLATE_LOGIN ) {
        	
        	include ( TEMPLATE_DIR . DIRECTORY_SEPARATOR . $this->template . DIRECTORY_SEPARATOR .  TEMPLATE_LOGIN .'.phtml' );
        	
        } else {
        	
        	include ( TEMPLATE_DIR . DIRECTORY_SEPARATOR . $this->template . DIRECTORY_SEPARATOR .  $this->template.'.phtml' );
        }
        
        $template = ob_get_clean();

    	// View
    	ob_start();
    	
    	include ( VIEWS_DIR . DIRECTORY_SEPARATOR . $this->dirView . DIRECTORY_SEPARATOR  . $view . 'View.phtml' );
    	
    	$viewContents = ob_get_clean();
        $contents 	  = str_replace('{contents}', $viewContents, $template);
        
        if ( $return ) {
        	
        	return $contents;
        	
        } else {
        	
        	echo $contents;
        }
    }
    
    
    protected function content ( $layout, $view, $dados = array(), $return = false ) {

    	//Tranformando os indices em variáveis nas views e templates
        extract( $dados, EXTR_OVERWRITE );
        
        // Template
        ob_start();
        
        include ( TEMPLATE_DIR . DIRECTORY_SEPARATOR . $this->template . DIRECTORY_SEPARATOR .  $layout.'.phtml' );
        
        $template = ob_get_clean();

    	// View
    	ob_start();
    	
    	include ( VIEWS_DIR . DIRECTORY_SEPARATOR . $this->dirView . DIRECTORY_SEPARATOR  . $view . 'View.phtml' );
    	
    	$viewContents = ob_get_clean();
        $contents 	  = str_replace('{contents}', $viewContents, $template);
        
        if ( $return ) {
        	
        	return $contents;
        	
        } else {
        	
        	echo $contents;
        }
    }
    
    
    protected function html ($view, $dados = array(), $return = false) {
    	
    	//Tranformando os indices em variáveis nas views e templates
    	extract($dados, EXTR_OVERWRITE);

    	
    	$path = VIEWS_DIR . DIRECTORY_SEPARATOR . $this->dirView . DIRECTORY_SEPARATOR  . $view . 'View.phtml';

    	
    	if ( file_exists( $path ) ) {
    		
    		include ( $path );

    		
    	} else {
    		
    		echo "Nao existe view ({$path})";
    	}
    }
    
    
    protected function model ( $model = null) {

    	$model = ( !empty ( $model ) ? $model . 'DB' : $this->dirView . 'DB');
    	
        return new $model();
    }
    
    
    protected function authenticate () {
    	
    	return (boolean) ( self::$session->isActiveSession() ); 
    }
     
}