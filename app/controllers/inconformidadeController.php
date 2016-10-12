<?php

class inconformidade extends Controller {

    public function excel( $nomeExcel = 'inconformidades' ) {
        
        $objListaCpf = $this->model('inconformidades');

        $objListaCpf->connect('FW');

        $dados['nomeDoExcel']   = $nomeExcel;
        $dados['dados']         = $objListaCpf->listaNdsCpfDuplicado();

        $this->html('excelInconformidades', $dados);
    }

    /**
     * Muda os dados filtrados da tabela de coleta do NDS para a tabela fw.inconformidades.nds_cpf_duplicado.
     * @author Bruna Leiras 
     */
    public function nds_cpf_duplicado () {

        $objInconformidades = $this->model('');
        $objInconformidades->connect('SDW');

        $arrayCpfDuplic = $objInconformidades->getNdsCpfDuplicado();

        $objInconformidades->connect('FW');
        
        if ( !empty ( $arrayCpfDuplic ) ) {
        
            foreach ($arrayCpfDuplic as $cpfDuplic) {
            
                $objInconformidades->saveNdsCpfDuplicado($cpfDuplic);
            }
        }
    }

    
    public function cpf_duplicado () {

        $objListaCpf = $this->model();
        $objListaCpf->connect('FW');

        $dados['cpfs'] = $objListaCpf->listaNdsCpfDuplicado();

        $this->view('listaInconformidades', $dados);
    }
}
