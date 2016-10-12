<?php

class ws extends Controller {
	

	public function __construct () {
		
		
		
	}
	
	
	public function hello () {
		
		header('Cache-Control: no-cache, must-revalidate');
		header('Content-Type: application/json; charset=utf-8');
		
		echo json_encode ( array("resposta" =>"resposta a requisicao") );
	}
	

	public function csv ( ) {
		
		
		$excel = new Excel('C:\Program Files (x86)\Zend\Apache2\htdocs\wj\alertas_sox.xls');
		
		//echo "<table border=1>";

		$sql = "insert into scripts (nome, id_tipo, module, tabela_referencia, situacao, codigo ) values ";
		
        for( $i = 1; $i <= $excel->rowcount(); $i++ ){

        	if ( $i != 1 ) {
        		$sql .= ',';
        	}
        	
        	$sql .= "('{$excel->val($i, 4)}', 2, null, '{$excel->val($i, 11)}', 'A', '{$excel->val($i, 3)}')";
        	
            //echo "<tr>";
			/*
            for ($j = 1; $j <= $excel->colcount(); $j++) {
            	//2,3,4,6,11
                
            	if (in_array($j, array(2,3,4,6,11))) {
                
            		//echo "<td>" . $excel->val($i, $j) . "</td>";
                }
            	
            }
			*/
            //echo "</td>";
        }
    	
        echo $sql;
	    //echo "</table>";
	    //echo "Total: " . $excel->rowcount() . " Registros.";
			
		//var_dump($dados);
	}
	
	
}