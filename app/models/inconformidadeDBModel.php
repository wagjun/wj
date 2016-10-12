<?php

class inconformidadeDB extends Model {
    
    /**
     * Usado para consulta usuarios registrados na base de dados NDS 
     * com CPF duplicado.
     * @author Bruna Leiras
     * @return array de objetos script
     */
    public function getNdsCpfDuplicado(){
        
        $sql = "SELECT brtnomecompleto,brtcpf,cn 
                  FROM nds_cache nc 
            INNER JOIN (
                        SELECT brtcpf AS cpf
                          FROM nds_cache
                         WHERE ( arvore = 'terceiros' or arvore = 'colaboradores' )
                           AND brtcpf != '' 
                      GROUP BY brtcpf
                        HAVING COUNT(*) > 1 
                        ) c ON c.cpf= nc.brtcpf
                 WHERE ( arvore = 'terceiros' or arvore = 'colaboradores' )
              ORDER BY c.cpf;";
        
        $rs = $this->db->query($sql);
    
        return ( !empty($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
    }

    /**
     * Insere os dados na tabela inconformidades.nds_cpf_duplicado
     * @param type $itemCpf
     * author Bruna Leiras
     */
    public function saveNdsCpfDuplicado( $itemCpf ){
        
        $sql = "INSERT INTO inconformidades.nds_cpf_duplicado(nome, cpf, cn) VALUES ('{$itemCpf->brtnomecompleto}', '{$itemCpf->brtcpf}', '{$itemCpf->cn}');";
    	
        $this->db->query($sql);
    } 
	
    /**
     * Consulta os dados na tabela inconformidades.nds_cpf_duplicado
     * @return array de objetos scripts
     * @author Bruna Leiras
     */
    public function listaNdsCpfDuplicado () {
        
        $sql = "SELECT * FROM inconformidades.nds_cpf_duplicado WHERE to_char(insert_timestamp, 'YYYY-MM-DD') = to_char(CURRENT_DATE, 'YYYY-MM-DD')";
        
        $rs = $this->db->query( $sql );
         
        return ( !empty ($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : false );
    }
}