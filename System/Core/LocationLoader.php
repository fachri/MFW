<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 


/*----------------------------------------------------------------------------------------------------
 *	LOKASI FOLDER DAN FILE
 *----------------------------------------------------------------------------------------------------
 *
 *	Halaman ini akan memasukkan semua lokasi terkait dengan sistem dan aplikasi, berikut adalah
 *	daftar file dan folder terkair dengan sistem.
 *
 *	aplikasi/
 *		konfigurasi/
 *
 *
 *
 *	sistem/
 *		inti/
 *			Inti.php
 */
 
 
 # 	aplikasi/
 #		konfigurasi/

 #	sistem/
 #		pustaka/
 #		inti/
 #			Pemuat.php
 	require($LocationLoader->Location('SCLoader'));
 #			PenangananError.php
 	require($LocationLoader->Location('SCErrorHandling'));
 #			Kontroler.php
 	require($LocationLoader->Location('SCController'));
 #			Model.php
 	require($LocationLoader->Location('SCModel'));
 #			ClassPemuat.php
 	require($LocationLoader->Location('SCClassLoader'));

?>