<?php

/**
 * Classe de criptografia do Framework
 * */
class Encryption{
	
		
	const RIJNDAEL='MCRYPT_RIJNDAEL_256';
	
	
	/**
	 * Algoritmo utilizado na criptografia
	 * @var string
	 * */
	private $cypher;
	
	/**
	 * @var integer
	 * */
	private $ivSize;
	
	/**
	 * The encryption key
	 * */
	private $key;
	
	public function __construct ( $key = '', $algoritm = self::RIJNDAEL ) {

		#Algorithm
		$this->cypher 	= $algoritm;
		$this->key		= ( !empty ( $key ) ? $key : 'default_key' );
		
	}
	
	
	/**
	 * Dado uma string, retorna ela criptografada
	 *
	 * @param string $input Valor a ser criptografado
	 * */
	public function encrypt ($input) {
		
		$size 	= mcrypt_get_block_size ( constant( $this->cypher ), 'ecb' );
		$input	= $this->pkcs5_pad ( $input, $size );
		$td 	= mcrypt_module_open ( constant( $this->cypher ), '', 'ecb', '' );
		$iv 	= mcrypt_create_iv ( mcrypt_enc_get_iv_size( $td ), MCRYPT_RAND );
		
		mcrypt_generic_init ( $td, $this->key, $iv );
		
		$data 	= mcrypt_generic ( $td, $input );
		
		mcrypt_generic_deinit ( $td );
		mcrypt_module_close ( $td );
		
		$data = base64_encode ( $data );
		$data = urlencode ( $data ); //push it out so i can check it works
		
		return $data;
	}
	
	
	/**
	 * Retorna o valor descriptografado
	 *
	 * @param string $crypt Valor a ser descriptografado
	 * @return string
	 * */	
	public function decrypt ( $crypt ) {
	
		$crypt 			= urldecode ( $crypt );
		$crypt 			= base64_decode ( $crypt );
		$td 			= mcrypt_module_open ( constant ( $this->cypher ), '', 'ecb', '' );
		$iv 			= mcrypt_create_iv ( mcrypt_enc_get_iv_size ( $td ), MCRYPT_RAND );
		
		mcrypt_generic_init( $td, $this->key, $iv );
		
		$decrypted_data = mdecrypt_generic ( $td, $crypt );
		
		mcrypt_generic_deinit ( $td );
		mcrypt_module_close ( $td );
		
		$decrypted_data = $this->pkcs5_unpad ( $decrypted_data );
		$decrypted_data = rtrim ( $decrypted_data );
		
		return $decrypted_data;
	}	
	

	private function pkcs5_pad($text, $blocksize){
		
		$pad = $blocksize - ( strlen( $text ) % $blocksize );
		
		return $text . str_repeat( chr( $pad ), $pad );
	}
	
	
	private function pkcs5_unpad( $text ) {
		
		$pad = ord( $text { strlen( $text )-1 } );
		
		if ( $pad > strlen( $text ) ) {
			
			return false;
		}
		
		return substr($text, 0, -1 * $pad);
	}	
	
}