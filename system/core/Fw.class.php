<?php

abstract class Fw {
	
    
	protected static $conn = array();

        
	protected $paramsConn = array();
        
        
	protected $template = TEMPLATE_NAME;
	
	
	protected $confsFw;
	
	
	protected $executionMode;
	
	
	protected $fwLog;
	
	
	public $mailer;
	
        
        protected $destinatariosFw;


        protected static $session;
	
	
	public function __construct () {
		
            global $mode;

            $this->executionMode    = $mode;
            $this->confsFw          = parse_ini_file ( CONF_DIR . DIRECTORY_SEPARATOR . 'fw.ini', true );
            $this->paramsConn       = parse_ini_file ( CONF_DIR . DIRECTORY_SEPARATOR . 'db.ini', true );
            

            $this->log();

            $this->configureSmtp();

            $this->makeConnections();
                
	}
	
            
	protected function makeConnections () {

            if ( !self::$conn ) {
                
                foreach ( $this->paramsConn as $bd => $connection ) {

                    try {
                        
                        // Objeto criptografia
                        $objCrypt 	= new Encryption( $connection['key'] );
                        
                        if ( $connection['driver'] == 'ldap' ) {
                        
                            $dataConnection['address']  = $connection['host'];
                            $dataConnection['port']     = $connection['port'];
                            $dataConnection['base']     = $connection['database'];
                            $dataConnection['user']     = $connection['user'];
                            $dataConnection['password'] = $objCrypt->decrypt ( $connection['password'] ); 
                            
                            self::$conn[$bd] = new Ldap( $dataConnection );
                            
                        } else {
                        
                            // Objeto PDO
                            self::$conn[$bd] = new PDO( $connection['driver'] . ":dbname=" . $connection['database'] . ";host=" . $connection['host'], $connection['user'], $objCrypt->decrypt ( $connection['password'] ) );
                        }
                        
                    } catch ( Exception $e ) {

                        throw new Exception('Ocorreu um erro ao tentar fazer conexões com Banco de dados.');
                    }
                }
            
            } 
            
            /*
            if ( $return ) {

                return $objPdo;

            } else {

                $this->$connection = $objPdo;
            }
            */
        }
        
	
	private function log () {
		
		$pathLogFw		= ( !empty( $this->confsFw['LOGS']['path'] ) ? $this->confsFw['LOGS']['path'] : ( LOGS_DIR . DIRECTORY_SEPARATOR . 'fw' . DIRECTORY_SEPARATOR .  'fw.log') );
		
		$this->fwLog	= new Logger ( $pathLogFw );
	}
	
	
	private function configureSmtp () {
	
		
		if ( !empty( $this->confsFw['SMTP']['host'] ) ) {
	
			$this->mailer = new Email( $this->confsFw['SMTP'] );
                        $this->configuraDestinatarios();
		} else {
	
			$this->fwLog->write("Servidores de SMTP não configurados!");
		}
	}
        
        
        private function configuraDestinatarios () {

            $destinatarios = explode( ";", $this->confsFw['EMAILS']['destinatarios'] );

            foreach ( $destinatarios as $destinatario ) {

                if ( !empty ( $destinatario ) ) {

                    $dest                   = explode(",", $destinatario); 
                    $this->destinatariosFw[]  = array('name' => $dest[0], 'email' => $dest[1]);
                } 
            }
        }
        
        
        protected function getCredentials ( $connection ) {
        
            $objCredencial = $this->model('userSystem');
            $objCredencial->connect('FW');

            return $objCredencial->consultaCredencial( $connection );
        }
}