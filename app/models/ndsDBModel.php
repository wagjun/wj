<?php

class ndsDB extends Model {
    
    public function teste () {
        
        $query = array (
                        'base_dn' 		=> 'ou=usuarios,ou=brt,o=btp',
                        'filter'                => '(CN=tr551543)'
                        //'attributes' 	=> array('cn','dn','brtnomecompleto','brtemail')
    	);
        
        $this->db->query($query);
        
        return $this->db->data();
    }
    
    
}
