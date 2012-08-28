<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 

/*
 *	MyFrameWork dapat melakukan koneksi ke lebih dari satu basisdata. konfigurasi default yang akan digunakan
 * 	oleh sistem adalah konfigurasi basisdata dengan nama 'mfw'.
 * 	
 */

 $database['mfw']['host']			= 'localhost';					# host basis-data
 $database['mfw']['user']			= 'mysharet_proto';						# nama pengguna database
 $database['mfw']['password']			= 'prototype';			# password basis-data
 $database['mfw']['database']			= 'mysharet_proto_sistem';						# basis-data yang dipilih
 $database['mfw']['port']				= null;							# kosongkan (NULL) atau isi 3306 jika menggunakan port default

/*
 $database['regional']['host']		= 'localhost';					# host basis-data
 $database['regional']['user']		= 'mysharet_proto';						# nama pengguna database
 $database['regional']['password']		= 'prototype';			# password basis-data
 $database['regional']['database']	= 'mysharet_proto_regional';				# basis-data yang dipilih
 $database['regional']['port']			= null;							# kosongkan jika tidak menggunakan port
  */

?>
