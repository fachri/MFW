<?php if (! defined('SYSTEM')) exit('No direct script access allowed');

class Welcome extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->Model(
					 array(
					 	   "Startup",
						  )
					);
		
		$this->Language($this->Startup->languageCode);

	}
	
	public function index()
	{
		echo $this->language['halo'];
	}
	
}


?>