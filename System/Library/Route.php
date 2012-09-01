<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 


/*----------------------------------------------------------------------------------------------------
 *	Rute
 *----------------------------------------------------------------------------------------------------
 *
 *	Class ini digunakan untuk proses/eksekusi berhubungan dengan rute/alamat
 *
 */
 
class Rute extends MyFrameWork
{
	private $URL;
	
	
/*----------------------------------------------------------------------------------------------------
 *	Construct
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini akan melakukan inisialisasi, lokasi url utama.
 *
 */
	
	public function __construct()
	{
		self::URL();
		parent::__construct(); 
	}
	
	
/*----------------------------------------------------------------------------------------------------
 *	Kontroler
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini dipanggil untuk mencetak lokasi Kontroler dapat juga ditambahkan dengan variable-nya.
 *
 *	cth, pemanggilan
 *		$this->Rute->Kontroler('Folder/Class')
 *		$this->Rute->Kontroler('Folder/Class/Variable/IsiVariable')
 *
 *	cth, output
 *		http://alamat:port/folderjikaada/index.php/Folder/Class
 *		http://alamat:port/folderjikaada/index.php/Folder/Class/Variable/IsiVariable
 *
 */
	
	public function Controller($location)
	{
		if ( isset($this->configuration['Rewrite']) and $this->configuration['Rewrite'] == TRUE ) :
			return str_replace('/index.php','',$this->URL.$location);
		endif;
			
		return $this->URL.$location;
	}
	
	public function ControllerOpen($location)
	{
		header('Location: '.$this->Controller($location));
	}
	
	
/*----------------------------------------------------------------------------------------------------
 *	URL
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini dipanggil untuk mencetak lokasi URL, fungsi ini tertutup hanya oleh sistem.
 *
 *	cth, output
 *		http://alamat:port/folderjikaada/index.php
 *
 */
	
	private function URL()
	{
		$this->URL = 'http';
		if (isset($_SERVER["HTTPS"]) and $_SERVER["HTTPS"] == "on")
		{
			$this->URL .= "s";
		}
		$this->URL .= '://';
		if ($_SERVER["SERVER_PORT"] != "80")
		{
			$this->URL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
		}
		else
		{
			$this->URL .= $_SERVER["SERVER_NAME"];
		}
		$this->URL .= $_SERVER['SCRIPT_NAME']."/";
	}
}




?>