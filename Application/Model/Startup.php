<?php if (! defined('SYSTEM')) exit('No direct script access allowed');

class Startup_Model extends Controller
{
	public $languageCode;
	
	public function __construct()
	{
		parent::__construct();
		
		if ( ! $this->Session->Get($this->configuration['Session']['Language']) ) :
			$this->Session->Add( $this->configuration['Session']['Language'], $this->configuration['Language'][0] );
		endif;
		
		$this->languageCode = $this->Session->Get($this->configuration['Session']['Language']);
		$this->Language( $this->languageCode );
	}
}


?>