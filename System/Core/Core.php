<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 



/**
 * MyFrameWork
 *
 * FrameWork open source untuk pengembangan aplikasi dengan PHP 5 keatas
 *
 * @package		MyFrameWork [Developer Edition-Source Code Documentation]
 * @author		Imam Fachri Chairudin
 * @copyright	Copyright (c) 2011 - 2012, MyShareTool, Inc.
 * @license		http://mysharetool.com
 * @link		http://jeruksquash.web.id
 * @since		Version 1.0
 * @version		Version 1.0
 * @filesource
 *
 */

// ------------------------------------------------------------------------

/*
 *----------------------------------------------------------------------------------------------------
 *	SIMPLE GUIDE
 *----------------------------------------------------------------------------------------------------
 *
 *	Jangan pernah mengubah ataupun nekat menghapus code php yang terdapat di halaman ini atauapun
 * 	yang terdapat di seluruh halaman dari folder 'sistem'!! kecuali tim developer MyShareTool 
 * 	ataupun kontributor-kontributor terkait.
 * 	Jika tetap nekat melakukannya... maka hancurlah kau..
 *
 */

// ------------------------------------------------------------------------

 
	#set_error_handler(array(&$this, "PenangananError"));

 	if (defined('ENVIRONMENT') and is_dir(APPLICATION.'Configuration/'.ENVIRONMENT))
	{
		define('AConfiguration', APPLICATION.'Configuration/'.ENVIRONMENT.'/');
	}
	else
	{
		define('AConfiguration', APPLICATION.'Configuration/');
	}
	
	
	require(SYSTEM.'Core/MyFrameWork'.EXT);
	
?>