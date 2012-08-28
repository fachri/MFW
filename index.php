<?php 

/*----------------------------------------------------------------------------------------------------
 *	LINGKUP KONFIGURASI SISTEM
 *----------------------------------------------------------------------------------------------------
 *
 *	Variable berikut akan menentukan lingkup konfigurasi yang akan digunakan untuk mengoperasikan
 *	MyFrameWork ini. Konfigurasi ini juga akan berpengaruh pada penampilan Error System yang dari PHP.
 *
 *	Lingkup konfigurasi dapat menggunakan:
 *
 *		pengembangan
 *		produksi
 *		test
 *
 */
 
	define('ENVIRONMENT', 'developer');

/*----------------------------------------------------------------------------------------------------
 * ERROR
 *----------------------------------------------------------------------------------------------------
 *
 * Perbedaan lingkup konfigurasi akan mempengaruhi penampilan Error dari sistem.
 *
 */

if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'developer'	: 
							  error_reporting(E_ALL | E_STRICT);
							  ini_set('display_errors', '1');
							  break;
	
		case 'production'	:
		case 'test'			: 
							  error_reporting(0);
							  break;

		default :
				  exit('Environment Configurations is not set!');
	}
}

/*----------------------------------------------------------------------------------------------------
 *	NAMA FOLDER SISTEM
 *----------------------------------------------------------------------------------------------------
 *
 *	Folder yang digunakan untuk menyimpan aplikasi-aplikasi terkait dengan sistem pada FrameWork ini, 
 *	harus menggunakan value dari string 'folder_sistem' dibawah ini
 *
 */
 	$folder_system = 'System';
/*----------------------------------------------------------------------------------------------------
 *	NAMA FOLDER APLIKASI
 *----------------------------------------------------------------------------------------------------
 *
 *	Folder yang digunakan untuk menyimpan aplikasi-aplikasi pada FrameWork ini, harus menggunakan 
 *	value dari string 'folder_aplikasi' dibawah ini
 *
 */
 	$folder_application = 'Application';
//----------------------------------------------------------------------------------------------------
//	AKHIR DARI KONFIGURASI
//----------------------------------------------------------------------------------------------------


/*----------------------------------------------------------------------------------------------------
 *	Melakukan pemeriksaan folder, untuk memastikan eksistensi ataupun validasi penulisan folder
 */
 
 	# menambahkan '/' di akhir
	if(realpath($folder_system) !== false)
		$folder_system = rtrim($folder_system,"/")."/";
 
 	# menambahkan '/' di akhir
	if(realpath($folder_application) !== false)
		$folder_application = rtrim($folder_application,"/")."/";
 
 	# memeriksa eksistensi folder sistem
	if (! is_dir($folder_system))
		exit("'System' folder is not set!");
 
 	# memeriksa eksistensi folder sistem
	if (! is_dir($folder_application))
		exit("'Application' folder is not set!");
		
/*----------------------------------------------------------------------------------------------------
 *	Jika tidak ditemukan masalah, maka mulai menentukan variable-variable yang akan digunakan
 */
 
 	# Menentukan ekstensi file yang digunakan
	define('EXT', '.php');
	
	# Menentukan lokasi folder teratas
	#define('MFWPATH', str_replace("\\","/",dirname(__FILE__)));
	
	# Menentukan variable folder sistem yang digunakan, mengubah format '\' dengan '/'
	define('SYSTEM', str_replace("\\","/",$folder_system));

	# Menentukan variable folder aplikasi yang digunakan, mengubah format '\' dengan '/'
	define('APPLICATION', str_replace("\\","/",$folder_application));


/*----------------------------------------------------------------------------------------------------
 *	Path lokasi berdasarkan maping system
 */
 
 	# Mengambil lokasi file ini dalam format system, mengubahformat '\' dengan '/'
 	define('BASEPATH', str_replace('\\', '/', dirname(__FILE__).'/'));

/*----------------------------------------------------------------------------------------------------
 *	Mulai melakukan proses ke sistem utama
 */
 	require(SYSTEM.'Core/Core'.EXT);

?>