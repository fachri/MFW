<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 


/*----------------------------------------------------------------------------------------------------
 *	Gambar
 *----------------------------------------------------------------------------------------------------
 *
 *	Pustaka Class Gambar, digunakan untuk proses eksekusi sistem perubahan ukuran gambar.
 *
 *	Class ini dapat digunakan di Model & Kontroler
 *
 */
 
class Image 
{
	private $picture;
	private $type;
	
	public $width;
	public $height;
	
	private $biggerSide;
	private $widthCrop;
	private $heightCrop;
	
	
/*----------------------------------------------------------------------------------------------------
 *	Construct
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini ...
 *
 *	Fungsi ini sudah dikonfigurasi untuk dipanggil oleh Model / Kontroler, Variable yang digunakan
 *	untuk memanggil class ini:
 *		$this->DB->NAMAFUNCTION()/VARIABLE
 * 
 *	Cara pakai Load($berkasGambar)
 * 	Lalu panggil perintah Ubah / SetHeight / SetWidth / Skala
 *  Lalu Simpan($NamaYangAkanDisimpan)
 *
 */
	
	
	public function __construct()
	{
	}
	
	public function Load( $file )
	{
		$info		= getimagesize( $file );
		$this->type = $info[2];
		
		switch ( $this->type ) :
			case IMAGETYPE_JPEG		:	$this->picture = imagecreatefromjpeg( $file );
										break;
			
			case IMAGETYPE_GIF		:	$this->picture = imagecreatefromgif( $file );
										break;
			
			case IMAGETYPE_PNG		:	$this->picture = imagecreatefrompng( $file );
										break;
		endswitch;
		
		$this->width	= self::Width();
		$this->height	= self::Height();
	}
	
	public function Save( $file, $permission = NULL, $compression = 75 )
	{
		switch ( $this->type ) :
			case IMAGETYPE_JPEG		:	imagejpeg( $this->picture, $file, $compression );
										break;
			
			case IMAGETYPE_GIF		:	imagegif( $this->picture, $file );
										break;
			
			case IMAGETYPE_PNG		:	imagepng( $this->picture, $file );
										break;
		endswitch;
		
		if ( $permission != NULL ) :
			chmod( $file, $permission );
		endif;
		
		self::Delete();
	}
	
	public function Delete()
	{
		imagedestroy( $this->picture );
	}
	
	# prototype 
	public function Display()
	{
		switch ( $this->type ) :
			case IMAGETYPE_JPEG		:	#header('Content-Type: image/jpeg');
										imagejpeg( $this->picture );
										break;
			
			case IMAGETYPE_GIF		:	#header('Content-Type: image/gif');
										imagegif( $this->picture );
										break;
			
			case IMAGETYPE_PNG		:	#header('Content-Type: image/png');
										imagepng( $this->picture );
										break;
		endswitch;
	}
	
	public function Width()
	{
		return imagesx( $this->picture );
	}
	
	public function Height()
	{
		return imagesy( $this->picture );
	}
	
	public function SetHeight( $height )
	{
		$ratio	= $height / $this->height;
		$width	= $this->width * $ratio;
		
		self::Set( $width, $height );
	}
	
	public function SetWidth( $width )
	{
		$ratio 	= $width / $this->width;
		$height	= $this->height * $ratio;
		
		self::Set( $width, $height );
	}
	
	public function Scale( $scale )
	{
		$width	= $this->width * $scale/100;
		$height	= $this->height * $scale/100;
		
		self::Set( $width, $height );
	}
	
	/*
	 * 
	 * 		$this->Gambar->Load('aplikasi/tampilan/_Komponen/images/01.jpg');
		$this->Gambar->Thumb(.5, $this->website['Lebar_Thumb'], $this->website['Tinggi_Thumb']);
		$this->Gambar->Save('aplikasi/tampilan/_Komponen/images/01test.jpg');
		
	 * 
	 * 
	 */
	public function Thumb( $percent, $width, $height )
	{
		self::BiggerSide();
		
		$this->widthCrop = $this->biggerSide*$percent;
		$this->widthHeight = $this->biggerSide*$percent;
		
		$x = ($this->width-$this->widthCrop)/2;
		$y = ($this->height-$this->widthHeight)/2;
		
		$this->width = $this->widthCrop;
		$this->height = $this->widthHeight;
		
		self::Set( $width, $height, $x, $y );
	}
	
	private function BiggerSide()
	{
		if ( $this->width > $this->height ) :
			$this->biggerSide = $this->width;
		else :
			$this->biggerSide = $this->height;
		endif; 
	}
	
	public function Set( $width, $height, $x = 0, $y = 0 )
	{
		$picture			= imagecreatetruecolor($width, $height);
		imagecopyresampled($picture, $this->picture, 0, 0, $x, $y, $width, $height, $this->width, $this->height);
		$this->picture 		= $picture;
	}
}


?>