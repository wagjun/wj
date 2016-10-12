<?php

class BTSG5505 {

    
    protected $credencial;

	
    protected $sshCon;
	

    public function __construct( $objCredencial ) {
        
        $this->credencial 	= $objCredencial;
        $this->sshCon		= new SSH ( $this->credencial );
    }
    
    
    public function downloadArquivos($scp = True) {

        if ( $scp ) {
        
            return $this->sshCon->scpFromServer ();
			
        } else {
            
            return copy ( $this->credencial->source_path, SYSTEM_FOLDER . $this->credencial->target_path . "file.txt" );
        }
    }

    
    public function uploadArquivos($scp = True) {

        if ( $scp ) {
        
            return $this->sshCon->scpToServer ();
			
        } else {
            
            return copy ( $this->credencial->source_path, SYSTEM_FOLDER . $this->credencial->target_path . "file.txt" );
        }
    }

    
    public function processaArquivos () {
        
        $data   = gmdate( "Y-m-d", time() - (3600 * 27) );
        
        $this->credencial->source_path 	= str_replace( 'DATE', $data, $this->credencial->source_path );

        $this->downloadArquivos();
    }
	
}
