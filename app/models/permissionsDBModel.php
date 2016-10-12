<?php

class permissionsDB extends Model {
	

	public function permissaoPerfil ( $idProfile ) {
		
		$sql = "SELECT perm.id,
					   perm.profile,
			           perm.module,
					   men.name,
			           mdl.link,
			           men.id as id_menu,
			           men.id_main,
			           men.level,
			           men.sequence,
			           men.visible
				  FROM permissions perm
                            INNER JOIN modules mdl on mdl.id = perm.module
                            INNER JOIN menu men on men.module = mdl.id
				 WHERE perm.profile = {$idProfile}
				   AND men.visible = '1'
			  ORDER BY men.id_main, men.level, men.sequence";
		
		$rs = $this->db->query( $sql );
		
		return ( !empty($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False);
	}

	
	public function consultaPermissaoUrl ( $idPerfil, $url ) {
		
		$sql = "SELECT perm.id,
                                perm.profile,
                                perm.module,
                                mdl.link
                               FROM permissions perm
                     INNER JOIN modules mdl on mdl.id = perm.module
                              WHERE perm.profile = {$idPerfil}
                                AND mdl.link = '{$url}'";
		
		$rs = $this->db->query( $sql );
		
		return ( !empty($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False);
		
		
	}
}