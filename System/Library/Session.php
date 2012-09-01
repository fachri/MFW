<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 


/*----------------------------------------------------------------------------------------------------
 *	Sesi
 *----------------------------------------------------------------------------------------------------
 *
 *	Class ini digunakan untuk proses/eksekusi berhubung dengan Session. 
 *
 */
 
class Session extends MyFrameWork
{

/*----------------------------------------------------------------------------------------------------
 *	Construct
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini akan memulai inisialisasi session.
 *
 *	cth, inisialisasi pemanggilan sesi
 *		$this->Pustaka('Sesi');
 *
 */
 
	public function __construct()
	{
		parent::__construct();
		
		if ( isset($this->configuration['Session']['CacheExp']) and is_int($this->configuration['Session']['CacheExp']) )
			session_cache_expire($this->configuration['Session']['CacheExp']);
		
		if (!session_id())
			session_start();
	}

/*----------------------------------------------------------------------------------------------------
 *	Daftar
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini akan melakukan proses pendaftaran session, secara satu-persatu ataupun langsung 
 *	beberapa session dengan menggunakan array.
 *
 *	cth, contoh pendaftaran session
 *		$this->Sesi->Daftar('NamaSesi', 'IsiSesi');
 *	atau, langsung beberapa
 *		$sesi = array(
 *					  'NamaSesiSatu'	=>	'IsiSesiSatu',
 *					  'NamaSesiDua'		=>	'IsiSesiDua'
 *					 );
 *
 *		$this->Sesi->Daftar($sesi);
 *
 */
 
	public function Add($session, $value = NULL)
	{
		if (is_array($session)) :
			
			while (list($key) = each($session)) :
				$this->Add($key, $session[$key]);
			endwhile;
			
			return NULL;
		endif;
		
		$_SESSION[$session] = $value;
	}
	
	

/*----------------------------------------------------------------------------------------------------
 *	Cetak
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini akan melakukan proses pengambilan value session, secara satu-persatu ataupun langsung 
 *	beberapa session dengan menggunakan array.
 *
 *	cth, contoh pendaftaran session
 *		$this->Sesi->Cetak('NamaSesi');
 *	atau, langsung beberapa
 *		$sesi = array(
 *					  'NamaSesiSatu',
 *					  'NamaSesiDua'
 *					 );
 *
 *		$this->Sesi->Cetak($sesi);
 *
 */
 
	public function Get($session)
	{
		if (is_array($session)) :
			$return = array();
			
			for ($s=0; $s<count($session); $s++) :
				$array 	= array($session[$s] => $_SESSION[$session[$s]]);
				$return	= array_merge($return, $array);
			endfor;
			
			return $return;
		endif;
		
		if (isset($_SESSION[$session]))
			return $_SESSION[$session];
			
		return NULL;
	}
	

/*----------------------------------------------------------------------------------------------------
 *	Hapus
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini akan melakukan proses pengahapusan session, secara satu-persatu ataupun langsung 
 *	beberapa session dengan menggunakan array.
 *
 *	cth, contoh penghapusan session
 *		$this->Sesi->Hapus('NamaSesi');
 *	atau, langsung beberapa
 *		$sesi = array(
 *					  'NamaSesiSatu',
 *					  'NamaSesiDua'
 *					 );
 *
 *		$this->Sesi->Hapus($sesi);
 *
 */
 
	public function Delete($session)
	{
		if (is_array($session)) :
			
			while (list($key) = each($session)) :
				$this->Delete($key);
			endwhile;
			
			return NULL;
			
		endif;
		
		if ( isset($_SESSION[$session]) )
			unset($_SESSION[$session]);
	}
	

/*----------------------------------------------------------------------------------------------------
 *	HapusSemua
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini akan melakukan proses pengahapusan seluruh session.
 *
 *	cth, contoh penghapusan seluruh session
 *		$this->Sesi->HapusSemua();
 *
 */
 
	public function DeleteAll()
	{
		if (isset($_SESSION))
			$this->Delete($_SESSION);
		
		session_destroy();
	}
	
/*----------------------------------------------------------------------------------------------------
 *	Periksa
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini akan memeriksa jika ada sesi yang aktif.
 *
 *	cth, pemeriksaan sesi
 *		$this->Sesi->Periksa();
 *
 */
 
	public function Check($session = NULL)
	{
		if ( ! isset($_SESSION) )
			return FALSE;
		
		if ( $session != NULL ) :
			
			# jika sesi berupa array 21/03/2012
			if ( is_array($session) ) :
				
				while (list($key) = each($session)) :
					
					if ( ! isset($_SESSION[$session[$key]]) )
						return FALSE;
					
				endwhile;
				
				return TRUE;
			else :

				if ( isset($_SESSION[$session]) )
					return TRUE;
			
			endif;
			
			return FALSE;
		endif;
		
		return FALSE;
	}
	

}




?>