<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 
 
/*
 *	String sistem digunakan untuk melakukan konfigurasi pada sistem
 * 
 * 		$this->sistem['Nama']
 *  
 */

 
 
/*
 *	String array au_pustaka digunakan melakukan pemuatan otomatis pustaka melalui sistem
 * 
 * 		$this->sistem['au_pustaka'] = array('pustaka1', 'pustaka2');
 *  
 */

 $configuration['au_library'] = array(
		 							  'Route',
		 							  'Variable',
		 							  'Session',
		 							 );
  
 
/*
 *	String rewrite digunakan untuk menentukan penggunaan permalink pada alamat url dari pustaka Rute yang dicetak
 * 	Isi value dengan true jika ingin menghilangkan penggunaan 'index.php' pada url,
 * 	Dan isi value dengan false jika ingin menampilkan penggunaan 'index.php' pada url
 * 
 * 	cth 'true',
 * 		http://alamatdomain/namaClass
 * 	cth 'false',
 * 		http://alamatdomain/index.php/namaClass
 * 
 */

 $configuration['Rewrite']								= TRUE;								# value pengatur permalink


/*
 *	Bahasa dapat ditambahkan lebih dari satu, setiap penambahan bahasa pastikan untuk menambahkan berkas 
 *	dengan nama yang sesuai dengan kode bahasa dibawah ke folder :
 * 		
 * 		/aplikasi/konfigurasi/Bahasa/KODEBAHASA.php
 * 
 * 		* KODEBAHASA, cth EN (dalam huruf kapital)
 * 	
 * 	Pastikan untuk tidak menghapus konfigurasi bahasa dibawah, karena string ini akan dikaitkan dengan sistem
 * 
 */
 
 $configuration['Language'][0]							= 'en';										# bahasa default
 #$sistem['Bahasa'][1]		= 'id';										# bahasa tambahan
 
 $configuration['session']['cache_exp'] 				= 20;									# in minute(s)
 
 # nama session
 $configuration['session']['Language']					= 'language';
 $configuration['session']['Token']						= 'token';
 $configuration['session']['ID']						= 'id';
 $configuration['session']['Name']						= 'name';
 $configuration['session']['Timeout']					= 'timeout';
  
 
?>