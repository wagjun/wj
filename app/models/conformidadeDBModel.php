<?php

class conformidadeDB extends Model {
	
	
	public function getWhiteListNmo () {
		
		$sql 	= "SELECT login_nds FROM whitelist_nmo";

		$rs 	= $this->db->query( $sql );
		
		return ( !empty ($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : false );
	}
	
	
	public function getEventsNmoByUser ( $user ) {
		
		$sql = "SELECT
                            id,
                            datetime,
                            eventid,
                            eventtype,
                            eventcategory,
                            username
            FROM
                            logntsec
            WHERE
                            (datetime BETWEEN DATEADD(hour, -1, GETDATE()) AND GETDATE())
              AND 	eventcategory = 'Account Management'
              AND	(eventid='624' OR eventid='627' OR eventid='628' OR eventid='630' OR eventid='642' OR eventid='644' OR eventid='671')
              AND	UPPER (username) NOT LIKE '%{$user}%'";
		
	}
	
}