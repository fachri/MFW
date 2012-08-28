<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 


/*
 *	pemanggilan SQL dapat dilakukan dengan cara :
 * 
 * 		printf($this->SQL['select'], $id);
 * 
 * 	ke dalam function Query dari Pustaka BasisData (BD)
 * 
 */

  include('SQL/Base'.EXT);

	$SQL['select']							= "SELECT
											   	*
											   FROM
											   	table
											   WHERE
											   	field_id = %d
											  ";
	
?>