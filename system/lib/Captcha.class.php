<?php

class Captcha {
	
	
	private $qtdeCaracteres = 5;
	
	
	private $code;
	
	
	private $bg;
	
	
	private $font;
	
	
	private $dirBackgrounds;
	
	
	private $dirFonts;
	
	
	public function __construct( $qtdeCaracteres = null ) {
		
		$this->qtdeCaracteres = ( !empty ( $qtdeCaracteres ) ? $qtdeCaracteres : $this->qtdeCaracteres );
	}
	
	
	public function generateCode () {
		
		$this->code = substr ( md5( microtime() ) , 0, $this->qtdeCaracteres );
		
		return $this->code;
	}

	
	public function getBackground () {
		
		$this->bg	= array_slice ( scandir( $this->dirBackgrounds ) , 2 );
		$keyImage 	= array_rand( $this->bg );

		return $this->bg[$keyImage];
	}

	
	public function getFont () {
	
	
		$this->font	= array_slice ( scandir( $this->dirFonts ) , 2 );
		$keyImage 	= array_rand ( $this->font );
                
		return $this->font[$keyImage];
	}	
	
	
	public function createImage ( $code = null ) {
		
		$code = ( !empty( $code ) ? $code : $this->generateCode() );
		
		$background 	= $this->dirBackgrounds . DIRECTORY_SEPARATOR . $this->getBackground();
		$font		= $this->dirFonts . DIRECTORY_SEPARATOR . $this->getFont();

                header ( "Content-type: image/jpeg" );
                
		$imagemCaptcha 	= imagecreatefromjpeg ( $background );
		$fonteCaptcha 	= imageloadfont( $font );
		$corCaptcha 	= imagecolorallocate( $imagemCaptcha, 255, 0, 0 );
		
		imagestring ( $imagemCaptcha, $fonteCaptcha, 15, 5, $code, $corCaptcha );
		imagejpeg ( $imagemCaptcha );
		imagedestroy( $imagemCaptcha );
	}
	
        
        public function definePaths ( $bgs, $fonts ) {
            
            $this->dirBackgrounds   = $bgs;
            $this->dirFonts         = $fonts;
        }		
}
?>