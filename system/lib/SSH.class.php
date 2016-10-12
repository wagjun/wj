<?php

/**
 * Classe de conexão via protocolo ssh
 * */
class SSH {

    /**
     * Variável da conexão
     * 
     * @var resource
     * */
    private $connection;
    
	
	private $dataConnection;
	
    /**
     * Construtor
     * 
     * @param string $server Servidor
     * @param integer $port Porta
     * @param string $user Usuário
     * @param string $password Senha
     * 
     * @throws FrameworkException
     * */
    function __construct( $aConnection ) {

		$this->dataConnection = $aConnection;
		
		/*
        $this->connect( $this->dataConnection->host, $this->dataConnection->port );

        if (!$this->connection) {
            
            throw new FrameworkException("Unable to connect at SSH server: {$this->dataConnection->host}:{$this->dataConnection->port}");
        }

        if ( !$this->authenticate( $this->dataConnection->user, $this->dataConnection->password ) ) {
			
		
            
            throw new FrameworkException("Invalid username ({$this->dataConnection->user}) or password at SSH server: {$this->dataConnection->host}:{$this->dataConnection->port}");
        }
		*/
    }
    
    /**
     * Efetua a conexão com o host e porta
     * 
     * @param string $host Host a se conectar
     * @param integer $port Porta a se conectar
     * */
    private function connect() {

        //$this->connection = ssh2_connect( $this->dataConnection->host, $this->dataConnection->port );
    }
    
    /**
     * Efetua a autenticação do usuário e senha
     * 
     * @param string $user Usuário a ser utilizado
     * @param string $password Senha a ser utilizada
     * */
    private function authenticate() {
		/*
		$objCrypt = new Encryption( $this->dataConnection->key );
		
        return ssh2_auth_password ( 
									$this->connection, 
									$this->dataConnection->user, 
									$objCrypt->decrypt( $this->dataConnection->password ) 
		);
		*/
	}
    
    /**
     * Copia um arquivo via SCP do servidor para o sistema de arquivos local
     * 
     * @param string $remotePath Caminho remoto do arquivo
     * @param string $localPath Caminho no sistema de arquivos local onde o arquivo será copiado
     * @throws FrameworkException
     * */
    public function downloadFromServer() {
        /*
        try {
            
            $return = ssh2_scp_recv($this->connection, $this->dataConnection->source_path, $this->dataConnection->target_path);
            
        } catch (Exception $e) {
            
            throw new FrameworkException("SSH:scpFromServer - Unable to copy remote file $this->dataConnection->source_path to $this->dataConnection->target_path");
        }
        
        return $return;
		*/
    }
    
    /**
     * Copia um arquivo via SCP para o servidor do sistema de arquivos local
     * 
     * @param string $remotePath Caminho remoto do arquivo
     * @param string $localPath Caminho no sistema de arquivos local onde o arquivo será copiado
     * @throws FrameworkException
     * */
    public function uploadToServer() {
		/*
        try {
            
            $return = ssh2_scp_send($this->connection, $localPath, $remotePath );
            
        } catch (Exception $e) {
            
            throw new FrameworkException("SSH:scpToServer - Unable to copy local file $localPath to $remotePath");
        }
        
        return $return;
		*/
    }
    
    
    public function scpFromServer () {
		
		$scpFile = "scp -i {$this->dataConnection->key_ssh_path} {$this->dataConnection->user}@{$this->dataConnection->host}:{$this->dataConnection->source_path} {$this->dataConnection->target_path}";
		
		$this->executeCommandShell ( $scpFile );
	}
    
    
    public function scpToServer () {
		
		$scpFile = "scp -i {$this->dataConnection->key_ssh_path} {$this->dataConnection->source_path} {$this->dataConnection->user}@{$this->dataConnection->host}:{$this->dataConnection->target_path}";
		
		$this->executeCommandShell ( $scpFile );
	}


	public function executeCommandShell ( $command ) {
		
		exec( $command );
	}
	
}