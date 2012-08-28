<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 

 
class Model extends Loader
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_au_library();
	}
	
	private function _au_library()
	{
		if ( 
			isset($this->configuration['au_library']) 
			 and 
			( 
			 $this->configuration['au_library'] != NULL
			  or
			 count($this->configuration['au_library']) > 0
			) 
		   )
			$this->Library($this->configuration['au_library']);
	}
	
}




?>