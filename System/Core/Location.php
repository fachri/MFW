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
	$location['AConfiguration']		= AConfiguration;
 #			BasisData.php
	$location['ACDatabase']			= $location['AConfiguration'].'DataBase'.EXT;
 #			Website.php
	$location['ACWebsite']			= $location['AConfiguration'].'Website'.EXT;
 #			Sistem.php
	$location['ACConfiguration']	= $location['AConfiguration'].'Configuration'.EXT;
 #			SQL.php
	$location['ACSQL']				= $location['AConfiguration'].'SQL'.EXT;
	
 #			Bahasa
	$location['ACLanguage']			= $location['AConfiguration'].'Language/';
		
 #		kontroler/
 	$location['AController']		= APPLICATION.'Controller/';
 #		model/
 	$location['AModel']				= APPLICATION.'Model/';
 #		tampilan/
 	$location['AView']				= APPLICATION.'View/';
	 #		Sistem/
	 	$location['AVSystem']		= $location['AView'].'_System/';
		 #		404.php
		 	$location['AVS404']		= $location['AVSystem'].'404'.EXT;
		
 #		pustaka/
 	$location['ALibrary']			= APPLICATION.'Library/';

 #	sistem/
 #		bantuan/
 	$location['SHelper']			= SYSTEM.'Helper/';
 #		pustaka/
 	$location['SLibrary']			= SYSTEM.'Library/';
 #		inti/
 	$location['SCore']				= SYSTEM.'Core/';
 #			PemuatLokasi.php
 	$location['SCLoader']			= $location['SCore'].'Loader'.EXT;
 #			PemuatLokasi.php
 	$location['SCLocationLoader']	= $location['SCore'].'LocationLoader'.EXT;
 #			PenangananError.php
 	$location['SCErrorHandling']	= $location['SCore'].'ErrorHandling'.EXT;
 #			Kontroler.php
 	$location['SCController']		= $location['SCore'].'Controller'.EXT;
 #			Model.php
 	$location['SCModel']			= $location['SCore'].'Model'.EXT;
 #			ClassPemuat.php
 	$location['SCClassLoader']		= $location['SCore'].'ClassLoader'.EXT;

?>