<?php
/**
* @author Ramon
* @access public
*/
class Fileutils {
    
    
    const CSV   = 'csv';
    
    
    const EXCEL = 'xls';
    
	
	private $ponteiroArquivo;
	
	
    private $sourceFile;
    
	
    private $targetFile;
	
    
    function  __construct ( $sourceFile = null, $destinationFile = null) {
		
		$this->sourceFile 		= $sourceFile;
		$this->destinationFile 	= $destinationFile;
	}

    
    function  __destruct() {}    
    
    
    public static function createSheet( $name, $str_csv, $formato = self::CSV ) {
        
        $pathfile   = $name . "." . $formato;
        $file       = fopen($pathfile, 'wb');
        
        fwrite( $file, $str_csv );
        fclose( $file );
        
        return $pathfile;
    }
    
    
    function CompressFile($pathfile) {
        
        $this->log->log_writer("compactando arquivo $pathfile");
        exec("gzip ".$pathfile);
        $this->log->log_writer("Arquivo compactado");
        
        return $pathfile.'.gz';
    }
    
	
    
    function GetStrInToFile($pathfile) {
        
        $this->log->log_writer("Carregando arquivo $pathfile para string");
        
        $in_str = "";
        $array  = "";
        $handle = fopen($pathfile, "r");
        
        if ($handle) {
            
            while (($buffer = fgets($handle, 4096)) !== false) {
                
                $array[] = $buffer;
            }
            
            if(!feof($handle)) {
                
                $this->log->log_writer("Erro ao abrir arquivo");
            }
            
            fclose($handle);

            if (is_array($array)){
                
                foreach($array as $v){
                    
                    if(rtrim($v) != "")
                        $in_str.="'".rtrim($v)."',";
                }
                
                $in_str = substr($in_str,0,strlen($in_str)-1);
            }
        }
        
        return $in_str;
    }

    
    function GetArrayToFile($pathfile) {
        
        $this->log->log_writer("Carregando arquivo $pathfile para array");
        
        $array = "";
        $array = file($pathfile);
        
        return $array;
    }

    
    function GetLastExecutionToFile($pathfile) {
        
        $this->log->log_writer("Carregando arquivo $pathfile para string");
        
        $str = file_get_contents($pathfile);
        
        return $str;
    }

    
    function CsvBkp() {
        
        $diretorio=dir(csv_filepath);
        
        while ($arquivo = $diretorio->read()) {
            
            if ( $arquivo != "." && $arquivo != "..") {
                
                if(substr($arquivo, -3) != '.gz')
                    $this->CompressFile(csv_filepath."/".$arquivo);
            }
        }
        
        $diretorio->close();
    }

    
    function CsvBkpClear($limit=csv_limit) {
        
        $diretorio=dir(csv_filepath."/");
        
        while ($arquivo = $diretorio->read()) {
            
            if ($arquivo != "." && $arquivo != "..") {
                
                if(substr($arquivo, -3) == '.gz'){
                    
                    $date_file = substr($arquivo, -21, 8);
                    $date_now = date("Ymd");
                    
                    if ((strtotime($date_now) - strtotime($date_file)) >= ($limit*86400))
                        exec("rm ".csv_filepath."/".$arquivo);
                }
            }
        }
        
        $diretorio->close();
    }

    
    function GetFileFromSmb($server,$comp,$dom,$user,$pass,$fromdir,$file,$todir,$tofile) {
        
        $resp = exec("sh ".path_classes."/getfilefromsmb.sh '".$server."' '".$comp."' '".$fromdir."' '".$pass."' '".$user."' '".$dom."' '".$file."' '".$todir."' '".$tofile."'");
        
        if(filesize($todir.'/'.$tofile)>0){
            
            return true;
            
        }else{
            
            return false;
        }
    }

    
    function GetFileFromWget($url,$todirfile,$user='',$password=''){
        
        if ($user != '' && $password != ''){
            
            if (stristr($url, 'http://') != ''){
                
                $user = '--http-user='.$user;
                $password = '--http-password='.$password;
            
            } else if (stristr($url, 'ftp://') != ''){
                
                $user = '--ftp-user='.$user;
                $password = '--ftp-password='.$password;
            }
            
            $resp = exec("wget $user $password $url -O $todirfile -o /dev/null");
        
        }else{
            
            $resp = exec("wget $url -O $todirfile -o /dev/null");
        }

        if(is_file($todirfile) && filesize($todirfile)>0){
            
            return true;
            
        } else {
            
            exec("rm -if $todirfile");
            
            return false;
        }
    }

    
    function GetFileFromSSH($server,$user,$pass,$fromdirfile,$todirfile){
        
        $connection = ssh2_connect($server, 22);
        
        ssh2_auth_password($connection, $user, $pass);
        ssh2_scp_recv($connection, $fromdirfile, $todirfile);
        
        if(is_file($todirfile) && filesize($todirfile)>0){
            
            return true;
        
        } else {
            
            return false;
        }
    }


	/**
	Métodos acrescentados por Wagner
	**/
	public function CompactaGzip ($sourceFile = null) {
        
		if ( !empty ( $sourceFile )  ) {
			
			$this->sourceFile		= $sourceFile;
		}
		
        exec("gzip -r {$this->sourceFile}");
    }

	
	public function CompactaTarGz ($sourceFile = null, $destinationFile = null) {
        
		if ( !empty ( $sourceFile )  && !empty ( $destinationFile ) ) {
			
			$this->sourceFile		= $sourceFile;
			$this->destinationFile	= $destinationFile;
		}
		
        exec("tar -cvzf {$this->destinationFile} {$this->sourceFile}");
    }
	
	
	public function unificaArquivos ($aFileOrigem, $destinationFile) {
		
		if ( !empty ( $aFileOrigem ) && !empty ( $destinationFile )  ) {
		
			// Define arquivo destino
			$this->destinationFile = $destinationFile;
			
			if ( is_array ( $aFileOrigem ) ) {
			
				foreach ( $aFileOrigem as $arquivo ) {

					echo 'Origem: ' . $arquivo . ' Destino: ' . $this->destinationFile . PHP_EOL; 
					$this->sourceFile = $arquivo;
					$this->readFile();
				}
				
			} else {
					
				$this->sourceFile = $aFileOrigem;
				$this->readFile();
			}	
		}
		
		return $destinationFile;
	}
	
	
	public function excluiArquivos ( $aArquivos ) {
		
		if ( is_array ( $aArquivos ) ) {
			
			foreach ( $aArquivos as $arquivo ) {

				unlink( $arquivo );
			}
			
		} else {
			
			unlink( $aArquivos );	
		}
	}
	
	
	public function readFile () {
        
        $this->ponteiroArquivo = fopen ( $this->sourceFile, 'r' );
        
        while ( !feof( $this->ponteiroArquivo ) ) {
            
            $this->persist ( $this->readLine() );
        }
        
        fclose ( $this->ponteiroArquivo );
    }
    
	
    private function readLine () {
        
        return fgets( $this->ponteiroArquivo, 4096 );
    }
    
	
    private function persist ( $line ) {
	
		$file = fopen ( $this->destinationFile, 'a' );
        
        fwrite ( $file, $line );
        fclose ( $file );
    }
}
?>