<?php

class script extends Controller {
	
    /* ---------------------- TODOS ----------------------- */

    public function index () {

    	
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


    public function lista () {

    	
        $dados['scripts'] = $this->consultaScripts();

        $this->view('coletaLista', $dados);

    }


    public function cadastro () {

    	
        $this->html('coletaCadastroAjax');
    }


    public function edita () {

    	 
        $this->html('coletaEditaAjax');
    }


    public function execucoes ( $idScript ) {
    	 
        $objExecutions = $this->model('execution');
        $objExecutions->connect('FW');

    	$execucoes = $objExecutions->getExecutions( $idScript ); 

        $this->html('infoExecutionsAlertaAjax', $execucoes);
    }


    private function consulta ( $idScript ) {

        $objScript 	= $this->model();
    	$rBd 		= $objScript->connect('FW');
    	
    	return ( $rBd instanceof Exception ) ? array($rBd) : $objScript->consultaScriptId( $idScript );
    }


    private function consultaScripts () {

    	$objScript 	= $this->model();
		$rBd 		= $objScript->connect('FW');
		
        return ( $rBd instanceof Exception ) ? array($rBd) : $objScript->listaScripts();
    }

    
    /* ---------------------- COLETAS ----------------------- */

    public function servcel () {

    	if ( $this->executionMode == MODE_WEB ) {

    		
            $this->consultaGruposServcel();
    		 
        } else {


            $this->consultaGruposServcel();
        }
    	
    }


    private function consultaGruposServcel () {

    	$aDc 			= array('oi');
    	$aUsuarios 		= array();

    	foreach ( $aDc as $dc ) {

    		$objAD = new AD ( $this->parametrosConexaoAD( $dc ) );
    		 
    		$aUsuarios = array_merge( $aUsuarios, $objAD->buscaUsuariosPorGrupo( $this->gruposAd( $dc ), $dc ) );
        }

        var_dump($aUsuarios);
    }


    private function parametrosConexaoAD ( $dc ) {

    	$objCrypt = new Encryption( $this->confsFw["CRYPT"]["key"] );

    	switch ( $dc ) {

            case 'telemar':
    			$aConnectionData = array (
		    			'address' 	=> '10.21.9.211',
		    			'port'    	=> '389',
		    			'user'    	=> 'cn=_cops01,OU=Contas de Servicos,OU=Suporte,OU=TELEMAR,DC=telemar,DC=corp,DC=net',
		    			'password' 	=> "{$objCrypt->decrypt('fSKdIBzxT%2BIZ3tKTdkznE8PjlGux%2BuDSbvGuNUP1yR4%3D')}"
                );
                break;

            case 'brt':
				$aConnectionData = array (
						'address' 	=> '10.61.177.136',
						'port'    	=> '389',
						'user'    	=> 'cn=sersocmtz22,OU=Servico,OU=Usuarios,OU=Cyber,OU=DF,DC=brasiltelecom,DC=intra,DC=corp',
						'password' 	=> "{$objCrypt->decrypt('fzCiSmcx2S7AnkuQh1GEandS3fXkVnQNlrc4BU5qzkg%3D')}"
                );
                break;

            case 'oi':
				$aConnectionData = array (
						'address' 	=> '10.21.9.107',
						'port'    	=> '389',
						'user'    	=> 'cn=sersocmtz22,ou=Servico,ou=Usuarios,ou=Cyber,ou=DF,ou=Oi,dc=oi,dc=corp,dc=net',
						'password' 	=> "{$objCrypt->decrypt('fzCiSmcx2S7AnkuQh1GEandS3fXkVnQNlrc4BU5qzkg%3D')}"
                );
                break;
    			
        }

        return $aConnectionData;
    }


    private function gruposAd ( $dc ) {

    	switch ( $dc ) {
    		
            case 'oi':
		    		$aGrupos = array (
                    '_g_Fabrica_Windows',
                    '_g_suporte',
                    '_g_suporte_backup',
                    '_g_suporte_gbl',
                    '_g_suporte_itoc',
                    '_g_suporte_storage',
                    '_g_suporteoracle_fabrica',
                    '_g_suportesql_fabrica',
                    '_g_suportestorage',
                    'bancodados - ch',
                    'domain admins',
                    'op_prepago',
                    'pc-service-adm_oi',
					    				'_g_fabrica_bd_oracle', 			//
					    				'_g_suportewinfabrica',	 			//
					    				'adm backup corp',					//
					    				'gg - servidores_mgfil',			//
					    				'gg - suporte nt_dfmtz',			//
					    				'p2v_dell_windows',					//
                        //'_ppggtwprdcl02',
                        //'_sqlexecutive',
                        //'addmmon',
                        //'brtmanagad',
                        // oi157438,
                        // oi173028,
                        // oi191182,
                        // oi269325,
                        // oi273683,
                        // oi305921,
                        // oi314121
                        // oi82980,
                        // seem6001,
                        // serbkpmtz21,
                        // sercelmtz01,
                        // serjobmtz21,
                        // tr072618,
                        // tr112192,
                );
                break;

            case 'telemar':
    				$aGrupos = array (
                    '_g_suporte',
                    '_g_suporte_itoc',
                    '_g_suporte_storage',
                    '_itoc',
                    '_sqlexecutive'
                );
                break;
        }

        return $aGrupos;
    }


    public function nds () {

        echo 'Funciona' . PHP_EOL;
        
        /*
    	if ( $this->executionMode == MODE_WEB ) {
    		 
            $this->coletaNds();

            $this->lista();
    		 
        } else {

            $this->coletaNds();

            echo 'Finalizado!!!' . PHP_EOL;
        }
        */
    }


    private function parametrosConexaoNds () {

    	$objCrypt = new Encryption( $this->confsFw["CRYPT"]["key"] );

    	$aConnectionData = array (
    			'address' 	=> '10.61.198.60',
    			'port'    	=> '389',
    			'user'    	=> 'cn=sersocmtz21,ou=contasservico,ou=usuarios,ou=brt,o=btp',
    			'password' 	=> "{$objCrypt->decrypt('Q8DMu%2BLywebMju0b7TFKebof1x2P7PjpZtW9O69Zvtk%3D')}"
        );

        return $aConnectionData;
    }


    private function coletaNds () {

    	//$aArvores = array ('contasservico','colaboradores','terceiros','inativos','clientes','conselheiros','domainadmins');
    	$aArvores = array ('contasservico');

    	$objNds = new NDS( $this->parametrosConexaoNds() );

    	foreach ( $aArvores as $arvore ) {
    	  
            echo 'Coletando da arvore: ' . $arvore . PHP_EOL;

    		$objNds->selecionaAtributos( $arvore );

    		$aObjUsuariosNds 	= $objNds->montaMatrizUsuariosNds();
    		$objColetaDB 		= $this->model();

            $objColetaDB->connect('POSTGRE_LOCAL');

    		foreach ( $aObjUsuariosNds as $indice => $objUsuarioNds ) {

    			// preenche atributos com null e ap�s isso faz o merge dos arrays
    			// Necess�rio fazer isso, pois, a consulta ao nds s� traz os campos que est�o preenchidos
    			$objUser 						= array_merge( array_fill_keys ( $objNds->getAtributos( $arvore ), null ), $objUsuarioNds );
    			$aObjUsuariosNdsNovo[$indice] 	= $objUser;
            }

    		$objColetaDB->salvaColetaNdsLote( $aObjUsuariosNdsNovo, $objNds->getAtributos( $arvore ) );
        }
    }


    public function oi_atende () {
    
        if ( $this->executionMode == MODE_WEB ) {
    
            //$this->appLog->write("Essa coleta deve ser executada por linha de comando.");
            echo 'Essa coleta deve ser executada por linha de comando.'. PHP_EOL;
    
        } else {
    
            //$this->appLog->write("Inicio da coleta de Logs dos servidores do Portal OI Atende.");
            echo 'Inicio da coleta de Logs dos servidores do Portal OI Atende.'. PHP_EOL;
            //$this->appLog->write("==============================================================");
            echo '==============================================================' . PHP_EOL;
            $aArquivos = $this->processaColetaPortais('LOGSOIATENDE');
    
            $this->armazenaStorage ( 'STORAGEOIATENDE', $aArquivos );
        }
    }
    
    
    public function oi_vende () {
		
        if ( $this->executionMode == MODE_WEB ) {
            
			//$this->appLog->write("Essa coleta deve ser executada por linha de comando.");
            echo 'Essa coleta deve ser executada por linha de comando.'. PHP_EOL;
            
        } else {
            
            //$this->appLog->write("Inicio da coleta de Logs dos servidores do Portal OI Atende.");
            echo 'Inicio da coleta de Logs dos servidores do Portal OI Vende.'. PHP_EOL;
            //$this->appLog->write("==============================================================");
            echo '==============================================================' . PHP_EOL;
            $aArquivos = $this->processaColetaPortais('LOGSOIVENDE');
			
            $this->armazenaStorage ( 'STORAGEOIVENDE', $aArquivos );
        }
    }
   
            
    private function processaColetaPortais ( $portal ) {
        
		$data		= gmdate( "Y-m-d", time() - (3600 * 27) );
		$mascara 	= ( $portal == 'LOGSOIATENDE' ? "OIATENDE-OIATENDE.extended.log.{$data}-00_00_00" : "OIVende-OIVende.extended.log.{$data}-00_00_00" );
		
		//$this->appLog->write("Consultando credenciais a serem utilizadas.");
		echo 'Consultando credenciais a serem utilizadas.'. PHP_EOL;
        $aObjCredenciais 	= $this->getCredentials( $portal );

		$numServidores		= count( $aObjCredenciais );
		
		//$this->appLog->write("Total de {$numServidores} servidores que serão coletados");
		echo "Total de {$numServidores} servidores que serão coletados". PHP_EOL;
		
		foreach ($aObjCredenciais as $objCredencial) {
			
			//$this->appLog->write("Coletando logs do servidor {$objCredencial->hostname}");
			echo " => Coletando logs do servidor {$objCredencial->hostname}" . PHP_EOL;
			
			$objPortal = new PortaisOi( $objCredencial );
			$objPortal->processaArquivos();
			
			$objCredencial->target_path = $objCredencial->target_path . $mascara;
			$aArquivos[] 				= $objCredencial->target_path;
			
			//$this->appLog->write("Fim da coleta do servidor {$objCredencial->hostname}");
			echo "Fim da coleta do servidor {$objCredencial->hostname}" . PHP_EOL;
			//$this->appLog->write("--------------------------------------------------------------");
			echo '--------------------------------------------------------------' . PHP_EOL;
		}
		
		return $aArquivos;
    }
            

    private function armazenaStorage ( $storage, $aArquivos = null ) {
		
        $data                               = gmdate( "Y-m-d", time() - (3600 * 27) );

		//$this->appLog->write("Consultando credenciais a serem utilizadas.");
        echo 'Consultando credenciais a serem utilizadas.'. PHP_EOL;
        $aObjCredenciais                    = $this->getCredentials( $storage );
        $aObjCredenciais[0]->source_path    = str_replace( 'DATE', $data, $aObjCredenciais[0]->source_path );

		$arquivoOrigem 						= strstr($aObjCredenciais[0]->source_path, '.gz', True);
		
        $objFile                            = new Fileutils ();
		
		//$this->appLog->write("Unificando arquivos...");
		echo 'Unificando arquivos...' . PHP_EOL;
		$objFile->unificaArquivos( $aArquivos, $arquivoOrigem );
        $objFile->excluiArquivos( $aArquivos );
		
		//$this->appLog->write("Compactando arquivo Bruto para realizar Upload.");
		echo 'Compactando arquivo Bruto para realizar Upload.' . PHP_EOL;
		$objFile->CompactaGzip ( $arquivoOrigem );

        $objBtsg5505                        = new BTSG5505( $aObjCredenciais[0] );

		//$this->appLog->write("Fazendo Upload dos arquivos.");
        echo 'Fazendo Upload dos arquivos.'. PHP_EOL;
        $objBtsg5505->uploadArquivos();

		echo 'Excluindo arquivo unificado localmente.' . PHP_EOL;
		$objFile->excluiArquivos( $aObjCredenciais[0]->source_path );
		
		//$this->appLog->write("Fim do Upload.");
        echo 'Fim do Upload.'. PHP_EOL;
    }
        
    /* ------------------------ SOX ------------------------- */
        
        
    public function problemas () {
    
    	$objSdw = $this->model();
    	$objSdw->connect('SDW');
    
    	$dados['problemas'] = $objSdw->listaProblemas();
    	 
    	$this->view('soxProblemas', $dados);
    }
    
    
    public function alertas () {
    	 
    	$this->view('soxAlertas', $this->todosAlertas());
    }
    
    
    private function todosAlertas () {
    	 
    	$dados['alertas'] = $this->listaAlertas(2);
    
    	return $dados;
    }
    
    
    public function inconsistencias () {
    
    	$this->alertasGa();
    }
    
    
    private function alertasGa () {
    	 
    	$dados['alertas'] = $this->listaAlertas ( 2, 'A' );
    	
		foreach ( $dados['alertas'] as $alerta ) {
			
			$dados['codigos'][$alerta->codigo] = $this->consultaRegistrosPorCodigo ( array($alerta->codigo) );
		}
    	
    	$this->view('indexAlertasSox', $dados);
    }
    
    
    private function listaAlertas ( $idTipo = null, $idSituacao = null ) {
    	 
    	$objSdw = $this->model();
    	$objSdw->connect('FW');
    	 
    	return $objSdw->consultaScriptsTipoSituacao ( $idTipo, $idSituacao );
    }
    
    
    private function consultaRegistrosPorCodigo ( $aParams ) {
    	
    	$objScript = $this->model();
    	$objScript->connect('SDW');
    	
    	$codigo = ( !empty ($aParams[0]) ? $aParams[0] : null );
    	$inicio = ( !empty ($aParams[1]) ? $aParams[1] : null );
    	$fim 	= ( !empty ($aParams[2]) ? $aParams[2] : null );
    	
    	$objTabelas = $this->consultaTabelaPorCodigoScript( $codigo );
    	$registros  = $objScript->consultaInconsistenciasTabela( $objTabelas[0]->tabela_colunas, $objTabelas[0]->tabela, $inicio, $fim );
    	
    	return $registros;
    }

    
    private function consultaTabelaPorCodigoScript ( $codigo ) {
    
    	$objScript = $this->model();
    	$objScript->connect('SDW');
    
    	$objTabelas = $objScript->consultaTabelaCodigoScript( $codigo );
    
    	return $objTabelas;
    }
    
    
    public function listaInconsistencia ( $aParams ) {
    	
    	$dados = $this->dadosScriptsCodigo( $aParams );
    	
    	$this->html('soxListaInconsistencias', $dados);
    }
    
    
    public function periodoInconsistencia ($codigo) {

    	$dados['codigo'] = $codigo[0];

    	$this->html('soxPeriodoInconsistencia', $dados);
    }
    
    
    public function modalPeriodoInconsistencia ($aParams) {
    	
    	$dados = $this->dadosScriptsCodigo( $aParams );
    	
    	$this->html('soxModalPeriodoInconsistencia', $dados);
    	
    }
    
    
    public function excel ( $aParams ) {
    	
    	$dados = $this->dadosScriptsCodigo( $aParams );
    	
    	$this->html('excelScript', $dados);	
    }
    
    
    private function dadosScriptsCodigo ( $aParams ) {
    	 
    	$codigo = ( !empty ($aParams[0]) ? $aParams[0] : null );
    	$inicio = ( !empty ($aParams[1]) ? $aParams[1] : null );
    	$fim 	= ( !empty ($aParams[2]) ? $aParams[2] : null );
    	
    	$dados['script']	= $this->consultaTabelaPorCodigoScript( $codigo );
    	$dados['registros'] = $this->consultaRegistrosPorCodigo( $aParams );
    	
    	$dados['codigo']	= $codigo;
    	$dados['inicio']	= $inicio;
    	$dados['fim']		= $fim;
    
    	return $dados;
    }
    
    /**
     * Método para ser descontinuado 
     * @param type $aParams
     * @return type
     */
    private function consultaInconsistenciasAlerta ( $aParams ) {
    	
    	$registros = $this->consultaRegistrosPorCodigo( $aParams ); 
    	
    	return $registros;
    }
    
    /**
     * Migra os dados das tabelas srt_cache e nds_cache para nds_srt_inexistentes e mostra os scripts.
     * @author Bruna Leiras.
     */
    public function nds_srt_inexistentes () {
    
        $objSox = $this->model('sox');
        $objSox->connect('SDW');
        
        $arrayStrInexist = $objSox->getNdsSrtInexistentes();
        $objSox->connect('FW');
    
        if ( !empty($arrayStrInexist) ) {
        
            foreach ($arrayStrInexist as $strInexist) {
            
                $objSox->saveNdsSrtInexistentes( $strInexist );
            }
        }
    }
    
    /**
     * URL para servicos de batimentos.
     * @author Bruna Leiras
     */
    public function batimentos() {
        
        $this->batimentosSox();
    }
    
    /**
     * Busca pelo nds_str_inexistentes e coloca na view.
     * @author Bruna Leiras
     */
    private function batimentosSox() {

        $dados['alertas']   = $this->listaAlertas(4, 'A');
        $objScript          = $this->model();
        
        $objScript->connect('FW');

        foreach ($dados['alertas'] as $alerta) {
            //Bruna Leiras - Implementado metodo para contar registros pela "tabela_referencia"
            $retornoCount = $objScript->countPorTabelaReferencia($alerta->tabela_referencia);
            //Bruna Leiras - Se retornar false coloco o count como 0
            if ($retornoCount == false) {

                $alerta->count = 0;
            } else {
                //Bruna se o count retorna pego a propriedade de retorno e seto no stdClass do alerta.
                $alerta->count = $retornoCount[0]->count;
            }
        }
        
        //Passando $dados para visao com count.
        $this->view('batimentosSox', $dados);
    }
    
    /**
     * Usado para carregar popup modal na tela batimentos.
     * @author Bruna Leiras
     */
    public function modalBatimentosInexistentes() {

        $arraySrtNdsInexistentes = $this->consultaScriptSox();
        
        if($arraySrtNdsInexistentes == false){
                
               $arraySrtNdsInexistentes = array();
                
            }
            
        $arrayDados = array();
        $arrayDados['inexistentes'] = $arraySrtNdsInexistentes;            
        
        $this->html('modalBatimentosInexistentes', $arrayDados);
    }    
    
    /**
     * Usado para consultar dinamicamente a tabela scripts, 
     * pegar as colunas 'campos' e 'tabela_referencia' e trazer o SOX
     * @acess private
     * @return resultado dos dados da tabela
     * @author Bruna Leiras
     */
    public function consultaScriptSox() {

        $objScript = $this->model();

        $objScript->connect('FW');
        
        $key = $_GET["key"];
        //Quebrando chave key do .htacesse para obter o codigo script
        $arrayKey = explode('/', $key);

        $codigoScript = $arrayKey[2];

        $objTabelas = $objScript->consultaScriptSoxSDWNovo($codigoScript);

        return $objTabelas;
    }
    
}
