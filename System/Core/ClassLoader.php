<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 


/*----------------------------------------------------------------------------------------------------
 *	Class Pemuat
 *----------------------------------------------------------------------------------------------------
 *
 *	Sistem ini digunakan untuk menentukan Class, Function dan Variable yang akan dipanggil.
 *	Sistem akan mengambil semua URL, Folder, File, dan Variable dari alamat yang diminta
 *	lalu secara otomatis akan memisahkan dan mengelompokkan menjadi
 *		Folder Class jika ada
 *		Class
 *		Function jika ada (default Index function dalam Class)
 *		Variable jika ada
 *
 *	cth,akan memanggil class 'Class', function 'Function', dan memiliki Variable
 *		Class/Function/Variable1/IsiVariable1/Variable2/IsiVariable2/Variable3
 *
 *	cth, jika memanggil class tersebut dalam folder 'Folder'
 *		Folder/Class/Function/Variable1/IsiVariable1/Variable2/IsiVariable2/Variable3
 *
 */


/*----------------------------------------------------------------------------------------------------
 *	Mempersiapkan Variable yang akan digunakan untuk konfigurasi Folder, Class dan Variable
 *
 */

	$URI				= str_replace('index.php/', '', $_SERVER['REQUEST_URI']); 			# Request_uri -> /folderjikaada/index.php/FolderClassjikaada/Class/Function/Variable -> -(index.php/)
	$URIScript			= str_replace('index.php/', '', $_SERVER['SCRIPT_NAME']);			# Script_name -> /folderjikaada/index.php -> -(index.php)
	$URI				= str_replace($URIScript, '', $URI);								# /folderjikaada/FolderClassjikaada/Class/Function/Variable -> -(/folderjikada/)
	$URIExplode			= explode('/', $URI);												# [0]->FolderClassjikaada [1]->Class [2]->Function [3]->Variable
	$ClassLocation		= NULL;
	$ClassName			= NULL;
	$ClassLoader		= NULL;
	$FunctionName		= NULL;
	$FunctionLoader		= NULL;
	$Variable			= array();
	$VariableCount		= 0;
	$VariableTemp		= 0;
	$Temp				= 0;
	$NotFound			= false;
	
	for ($p=0; $p<count($URIExplode); $p++)
	{
		$Address = $URIExplode[$p];

		if ($Address!='')
		{
			if (is_dir($LocationLoader->Location('AController').$ClassLocation.$Address))
			{
				$ClassLocation .= $Address.'/';
				$VariableTemp	= $p;
			}
			elseif ($ClassLoader == NULL and file_exists($LocationLoader->Location('AController').$ClassLocation.$Address.EXT) and strtolower($Address) != 'index')
			{
				$ClassName	  	= $Address;
				require_once($LocationLoader->Location('AController').$ClassLocation.$ClassName.EXT);
				
				if (class_exists($ClassName))
				{
					#$ClassLoader = new $ClassName;
					$ClassLoader = $ClassName;
				}
				
				$FunctionLoader	= true;
				$VariableTemp	= $p;
				$Temp = $p;
			}
			elseif ($FunctionName == NULL and isset($FunctionLoader) and is_callable(array($ClassLoader, $Address)) and $p == ($Temp+1))
			{
				$FunctionName	= $Address;
				$FunctionLoader	= false;
				$VariableTemp	= $p;
			}
			elseif ($VariableTemp != 0 and $p > $VariableTemp)
			{
				$Address = ucfirst($Address);
				
				if ($VariableCount % 2 == 0)
				{
					if (isset($URIExplode[$p+1]))
					{
						$Variable[$Address] = $URIExplode[$p+1];
					}
					else
					{
						$Variable[$Address] = NULL;
					}
				}
					
				$VariableCount++;	
			}
		}
	}
	
	if ( ! isset($ClassName) )
	{
		$ClassName		= 'Welcome';
		
		if ( file_exists($LocationLoader->Location('AController').$ClassLocation.$ClassName.EXT) ) :
			require_once($LocationLoader->Location('AController').$ClassLocation.$ClassName.EXT);
			$ClassLoader = new $ClassName;
		else :
			require_once($LocationLoader->Location('AVS404'));
			$NotFound = true;
		endif;
		
		
	}
	
	if ( isset($ClassLoader) and $ClassLoader != NULL )
	{
		$ClassLoader = new $ClassLoader;
	}
	else 
	{
		require_once($LocationLoader->Location('AVS404'));
	}
	
	if ( ! isset($FunctionName) and $NotFound == false )
	{
		$FunctionName = 'Index';
	}
	
	if ( isset($Variable) )
	{
		$ClassLoader->Variable = $Variable;
	}
	
	if ( $NotFound == false ) :
		$ClassLoader->$FunctionName();
	endif;
	
?>
