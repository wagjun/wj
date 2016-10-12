<?php


class Curl {
	
	/**
	 *
	 * @const WSTIMEOUT
	 */
	const WSTIMEOUT = 60;
	
	/**
	 * 
	 * @const RESQUESTPOST
	 */
	const RESQUESTPOST 	 = 'POST';
	
	/**
	 *
	 * @const RESQUESTGET
	 */
	const RESQUESTGET  	 = 'GET';
	
	/**
	 *
	 * @const RESQUESTPUT
	 */
	const RESQUESTPUT  	 = 'PUT';
	
	/**
	 *
	 * @const RESQUESTDELETE
	 */
	const RESQUESTDELETE = 'DELETE';
	
	/**
	 * 
	 * @var Curl
	 * */
	private   $ch;

	/**
	 * URL onde será feita a requisição
	 * @var string
	 */
	private   $url;
	
	/**
	 * Parâmetros de envio
	 * @var array
	 */
	private   $requestParams;
	
	/**
	 * Tamanho da URL
	 * @var integer
	 */
	private   $contentLength;
	
	/**
	 * Resposta da requisição
	 * @var string
	 */
	protected $responseBody;
	
	/**
	 * Informações da resposta
	 * @var string
	 */
	protected $responseInfo;
	
	/**
	 * Content-Type da requisição (application/json, application/xml, text/plain, application/x-www-form-urlencoded,...)
	 * @var string
	 */
	private   $contentType;
	
	/**
	 * Classe para requisições WebService com cUrl.
	 * */
	public function __construct ( $url ) {
		
		// Checa se o curl está instalado
		if (!function_exists('curl_init')) {
			
			throw new Exception(__CLASS__ . '->' . __METHOD__ . ': cUrl extension not find');
		}
			
		// Inicia uma sessão curl.
		$this->ch = curl_init();
		
		// Define URL
		$this->url = $url;
		
		// Define o tamanho da string
		$this->contentLength = strlen( $this->getUrl() );
	}
	
	/**
	 *  Retorna url onde será realizada a requisição
	 * */
	private function getUrl () {
	
		return $this->url;
	}	
	
	/**
	 * Informações do retorno da requisição 
	 * */
	public function getResponseInfo () {
		
		return $this->responseInfo;
	}
	
	/**
	 * Retorno da requisição
	 * */
	public function getResponseBody () {
	
		return $this->responseBody;
	}
	
	/**
	 *  Configura a requisição
	 * */
	private function configureRequest ( $tipoRequisicao, $aParams = null ) {
		
		// Serializa dados na URL
 		if ( !empty ( $aParams ) ) {

 			$this->requestParams = http_build_query($aParams);
 		}
		
		// Inicia configuração para o request.
 		curl_setopt($this->ch, CURLOPT_TIMEOUT, self::WSTIMEOUT);
 		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		
		// Desabilita a verificação de SSL na requisição
 		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
		
 		switch ( $tipoRequisicao ) {
		
 			case self::RESQUESTGET:
		
				if (strlen($this->requestParams) > 0) {
					
					// sobrescreve o content type.
					$this->contentType = "Content-type: application/json";
				}
		
				break;
		
			case self::RESQUESTPOST:
		
				curl_setopt($this->ch, CURLOPT_POST, TRUE);
				curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->requestParams);
		
				break;
		
			case self::RESQUESTPUT:
		
				curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, self::RESQUESTPUT);
				curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->requestParams);
		
				break;
		
			case self::RESQUESTDELETE:
		
				curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, self::RESQUESTDELETE);
		
				break;
		}
		
		// Definindo Cabeçalho da Requisição.
		//curl_setopt($this->ch, CURLOPT_HTTPHEADER, array (
		//													//"Accept: application/json",
		//													"{$this->contentType}",
		//													"Content-Length: " . $this->contentLength
		//											)
		//);
 		
		// define a URL (pode ser alterada se requisição for GET
 		curl_setopt($this->ch, CURLOPT_URL, $this->getUrl());
	}

	/**
	 *  Realiza a requisição e armazena resposta
	 * */
	public function request ($tipoRequisicao, $aParams = null) {
		
		$this->configureRequest($tipoRequisicao, $aParams);

		// Realiza requisição
		$this->responseBody = curl_exec($this->ch);
		$this->responseInfo = curl_getinfo($this->ch);
		
		curl_close($this->ch);
	}
}

?>