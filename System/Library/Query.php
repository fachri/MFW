<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 

class Query
{
	public function __construct()
	{
		#parent::__construct();
	}
	
	/*
	 * array(
	 * 		 table	=> "namaTable",
	 * 		 query 	=> array(
	 * 						 "namaFieldSatu"	=> "valueDariFieldSatu",
	 * 						 "namaFieldDua" 	=> "@!TanggalSekarang",
	 * 						),
	 * 		)
	 * 
	 * return :
	 * 		INSERT INTO namaTable 
	 * 		(
	 * 		 namaFieldSatu, 
	 *   	 namaFieldDua
	 * 		) 
	 * 		VALUES 
	 * 		(
	 * 		 'valueDariFieldDua', 
	 * 		 NOW()
	 *		)
	 */
	public function Insert( $params )
	{
		$result  = "INSERT INTO ".$params['table']." (";
		$result .= $this->_insert_field($params['query']);
		$result .= ") VALUES (";
		$result .= $this->_insert_value($params['query']);
		$result .= ")";
		
		return $result;
	}
	
	
	private function _insert_field( $params )
	{
		$step	= 1;
		$total	= count($params);
		$output = NULL;
		
		while ( list($key) = each($params) ) :
			$output .= $key;
			
			if ( $step < $total ) 
				$output .= ",";
			
			$output .= " ";
			$step++;
		endwhile;
		
		return $output;
	}

	private function _insert_value( $params )
	{
		$step	= 1;
		$total	= count($params);
		$output 	= NULL;
		
		while ( list($key) = each($params) ) :
			if ( $params[$key] == NULL )
				$output .= "NULL";
			else 
				$output .= $this->_value_type($params[$key]);

			if ( $step < $total ) 
				$output .= ",";
			
			$output .= " ";
			$step++;
		endwhile;
		
		return $output;
	}

	private function _value_type($value)
	{
		if ( is_numeric($value) or is_int($value) )
		 	return $value;
		
		switch ( $value ) :
			case '@!DATENOW'			: return 'NOW()';
									 	  break;
			
			default : return "'".$value."'";
		   			  break;
		endswitch;
	}
}


?>