<?php if (! defined('SYSTEM')) exit('No direct script access allowed');

class Utility
{
	public function __construct()
	{
	}
	
	public function isInvalidInt($int) 
	{
		if ($int == NULL or $int == "" or empty($int))
			return TRUE;
		
		if (!is_numeric($int))
			return TRUE;
		
		return FALSE;
	}
	
	public function isInvalidString($string) 
	{
		if ($string == NULL or $string == "" or empty($string))
			return TRUE;
		
		return FALSE;
	}
	
	public function isInvalidEmail($email)
	{
		if (! filter_var($email, FILTER_VALIDATE_EMAIL))
			return TRUE;
		
		return FALSE;
	}
}


?>