<?php

class soxDB extends Model {

    /**
     * Usado para consulta usuarios registrados na base de dados NDS
     * e não registrados na base de dados SRT      
     * @author Bruna Leiras
     * @return array de objetos script
     */
    public function getNdsSrtInexistentes() {

        $sql = "SELECT nds.cn 
                  FROM nds_cache nds 
             LEFT JOIN dados_cache.srt_cache srt on nds.cn = srt.matricula 
                 WHERE (nds.cn ilike 'tr%' OR nds.cn ilike 'tc%')
                   AND nds.cn NOT IN(select matricula FROM dados_cache.srt_cache)";
        
        $rs = $this->db->query($sql);

        return (!empty($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
    }    

    /**
     * Insere os dados na tabela sox.nds_srt_inexistentes
     * @param type $itemSrtNds
     * @author Bruna Leiras
     */
    public function saveNdsSrtInexistentes( $itemSrtNds ) {

        $sql = "INSERT INTO sox.nds_srt_inexistentes(nome, cpf, matricula) VALUES ('{$itemSrtNds->nome}', '{$itemSrtNds->cpf}', '{$itemSrtNds->matricula}');";

        $this->db->query($sql);
    }
     
    /**
     * Consulta os dados na tabela sox.nds_srt_inexistentes
     * @return array de objetos scripts
     * @author Bruna Leiras
     */
    public function consultaNdsSrtInexistentes() {

        $sql = "select * from sox.nds_srt_inexistentes";
        $rs = $this->db->query($sql);

        return (!empty($rs) ? $rs->fetchAll(PDO::FETCH_OBJ) : False );
    }    

}
