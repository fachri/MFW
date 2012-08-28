<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 


/*----------------------------------------------------------------------------------------------------
 *	MyFrameWork
 *----------------------------------------------------------------------------------------------------
 *
 *	Class ini adalah class paling utama/inti, dimana hampir seluruh proses sistem akan menggunakan 
 *	class ini
 *
 */
 
class MyFrameWork
{
/*
	protected $lokasi	= array();
	protected $website	= array();
	protected $sistem	= array();
	protected $SQL		= array();
	protected $bahasa	= array();
	protected $var 		= array();
*/

	protected $location			= array();
	protected $website			= array();
	protected $configuration	= array();
	protected $SQL				= array();
	protected $language			= array();
	protected $var 				= array();

/*----------------------------------------------------------------------------------------------------
 *	Construct
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini memuat konfigurasi lokasi file dan folder yang diguanakan oleh beberapa fungsi child  
 *	ataupun diakses langsung dari luar class. Akses langsung dari luar class, akan menggunakan fungsi
 *	Lokasi() ataupun pemanggilan variable lokasi untuk akses dari child class.
 *
 *	cth, pemanggilan variable lokasi dari child
 *		$this->lokasi['AKonfigurasi'];
 *
 */
	
	public function __construct()
	{
		# petakan halaman
		require(SYSTEM.'Core/Location'.EXT);
		$this->location	= $location;
		
		# konfigurasi website
		require($this->Location('ACWebsite'));
		$this->website = $website;
		
		# konfigurasi website
		require($this->Location('ACConfiguration'));
		$this->configuration 	= $configuration;
		
		# konfigurasi SQL
		require($this->Location('ACSQL'));
		$this->SQL = $SQL;
		
		
	}
	
	protected function Language($language = NULL)
	{
		$languageSelected = NULL;

		if ( $language == NULL ) :
			$languageSelected = $this->configuration['Language'][0];
		else :
			for ( $b=0 ; $b<count($this->configuration['Language']) ; $b++ ) :
				if ( strtolower($language) == strtolower($this->configuration['Language'][$b]) ) :
					$languageSelected = $language;
				endif;
			endfor;
		endif;
		
		if ( $languageSelected != NULL ) :
			require($this->Location('ACLanguage').strtoupper($languageSelected).EXT);
			$this->language = $language;
		endif;
	}
	
	
/*----------------------------------------------------------------------------------------------------
 *	Lokasi
 *----------------------------------------------------------------------------------------------------
 *
 *	Hasil pengumpulan konfigurasi lokasi oleh construct untuk dimasukkan kedalam variable lokasi,
 *	Setelah itu untuk pemanggilan melalui luar class menggunakan fungsi ini, tetapi untuk pemanggilan
 *	dari turunan atau child dapat menggunakan variable lokasi.
 *
 *	cth, pemanggilan variable lokasi dari luar class
 *		$MFW = new MyFrameWork;
 *		$MFW->Lokasi['AKonfigurasi'];
 *
 */
	
	public function Location($key)
	{
		if (isset($this->location[$key]))
		{
			return $this->location[$key];
		}
	}
	
	public function Configuration($key)
	{
		if (isset($this->configuration[$key]))
		{
			return $this->configuration[$key];
		}
	}
	
	public function Error($class, $description, $fileName = NULL, $fileLine = NULL)
	{
		
	}
	
}


	$LocationLoader = new MyFrameWork();
	require($LocationLoader->Location('SCLocationLoader'));

?>