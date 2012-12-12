<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 


class Loader extends MyFrameWork
{
	private $singletons = array();
	
	public function __construct()
	{
		parent::__construct(); 
	}
	
	
	protected function Helper($helper)
	{
		$this->Execute($helper, 'SHelper');
	}
	
	protected function Model($model)
	{
		if ( $this->Singleton($model) == TRUE ) :
			$this->Execute($model, 'AModel');
			
		$this->singletons = array_merge( $this->singletons, array($model) );
		endif;
	}
	
	protected function View($view, $string = NULL)
	{
		$this->Execute($view, 'AView', $string);
	}
	
	protected function Library($library)
	{
		if ( $this->Singleton($library) == TRUE ) :
			$this->Execute($library, 'ALibrary');
			$this->Execute($library, 'SLibrary');
			
			if ( $library != 'DataBase' )
				$this->singletons = array_merge( $this->singletons, array($library) );
		endif;
	}
	
	# singleton
	private function Singleton( $class )
	{
		for ( $i=0; $i<count($this->singletons); $i++ ) :
			if ( isset( $this->singletons[$i] ) and $this->singletons[$i] == $class )
				return FALSE;
		endfor;
		
		return TRUE;
	}
	
	protected function Execute($file, $mode, $string = NULL)
	{
		if (is_array($file)) :
			
			for ($f=0; $f<count($file); $f++) :
				if ($this->Exists($file[$f], $mode) == TRUE)
					$this->Call($file[$f], $mode, $string);
				
			endfor;
			
		else :
			
			if ($this->Exists($file, $mode) == TRUE)
				$this->Call($file, $mode, $string);
			
		endif;
	}
	
	private function Exists($file, $mode)
	{
		if (file_exists($this->location[$mode].$file.EXT))
			return TRUE;
	}
	
	private function Call($file, $mode, $string = NULL)
	{
		if (isset($string))
			extract($string);
		
		$file = ucfirst($file);
		require_once($this->location[$mode].$file.EXT);
		
		$folder = strpos($file, "/");
		
		if ($folder !== FALSE) :
			$fileName	= preg_split("/[\/]+/", $file);
			$file 		= $fileName[count($fileName)-1];
		endif;
		
		
		if ($mode == 'AModel') :
			$className		= $file.'_Model';
			$this->$file	= new $className;
		endif;
		
		if ($mode == 'ALibrary' or $mode == 'SLibrary') :
			$className		= $file;
			
			if ($mode == 'SLibrary') :
				
				if ($file == 'DataBase')
					$file 		= 'DB';
			
				if ($file == 'FormValidation')
					$file 		= 'FV';
			
			endif;
			
			$this->$file	= new $className;
		endif;
		
	}
	
}

  
?>