<?php


class Ldap {

	
    private $connection;
    
    
    private $connectionData;
    
    
    public function __construct( $connectionData ) {
        
        $this->connectionData = $connectionData;
        
        $this->connect();
    }

    
    private function connect() {
        

        try {
            
            $this->connection = ldap_connect($this->connectionData['address'], $this->connectionData['port']);
            
            ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($this->connection, LDAP_OPT_REFERRALS, 0);
            
        } catch (Exception $e) {

            throw new Exception("LDAP Connection Error. Host: {$this->connectionData['address']} Port: {$this->connectionData['port']} Message: {$e->getMessage()}");
        }

        try {

            ldap_bind($this->connection, $this->connectionData['user'], $this->connectionData['password']);
            
        } catch (Exception $e) {

            throw new FrameworkException("LDAP Authentication Error. Message: {$e->getMessage()}");
        }

    }
    
    
    public function query( $aQuery ) {

        $nullFields = array(
                            'base_dn'       => null,
                            'filter'        => null,
                            'attributes'    => array(),
                            'attrsonly'     => null,
                            'sizelimit'     => null,
                            'timelimit'     => null,
                            'deref'         => null
        );

        $arguments = array_merge($nullFields, $aQuery);
        
        $this->result  = ldap_search($this->connection, $arguments['base_dn'], $arguments['filter'], $arguments['attributes'], $arguments['attrsonly'], $arguments['sizelimit'], $arguments['timelimit'], $arguments['deref']);
        $this->numRows = ldap_count_entries($this->connection, $this->result);

        $this->affectedRows = null; //TODO Estudar como fazer isso

        return true;
    }
    
    
    public function data() {

        $this->data = array();

        if ($this->numRows > 0) {

            $this->data = ldap_get_entries($this->connection, $this->result);

            return $this->data;
            
        } else {
            
            return false;
        }
    }

}
