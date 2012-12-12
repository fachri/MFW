<?php if (! defined('SYSTEM')) exit('No direct script access allowed');

class DataBaseGenerator extends Loader
{
	public function __construct()
	{
		parent::__construct();
		$this->limit = 10;
	}
	
	private function _valueParameter($value)
	{
		switch (strtolower($value)) :
			case "uuid()"	: return "UUID()";
			case "sha1()" 	: return "SHA1()";
			case "md5()" 	: return "MD5()";
			case "null" 	: return "NULL";
			case "now()" 	: return "NOW()";
			default : return "'".$value."'";
		endswitch;
	}
	
	/*
	 * @params['table']	
	 * @params['values'] = array(fieldsName => value)
	 */
	public function InsertIntoTable($params)
	{
		$return['status'] = FALSE;
		
		if (!isset($params['table']) or !isset($params['values']))
			return $return;
		
		$i = 1;
		$fields = TRUE;
		$sql = "INSERT INTO ".$params['table'];
		$sqlFields = " (";
		$fieldForCheck = NULL;
		$valueForCheck = NULL;
		
		while(list($key) = each($params['values'])) :
			if (is_int($key)) :
				$fields = FALSE;
				break;
			endif;
			
			$sqlFields .= $key;
			
			if ($i < count($params['values']))
				$sqlFields .= ", ";
			
			if ($i == 1)
				$fieldForCheck = $key;
			
			$i++;
		endwhile;
		
		$sqlFields .= ")";
		
		if ($fields == TRUE)
			$sql .= $sqlFields;
		
		$sql .= " VALUES (";
		$i = 1;
		
		foreach ($params['values'] as $value) :
			if ($i == 1)
				$valueForCheck = $value;
			
			$sql .= $this->_valueParameter($value);
						
			if ($i < count($params['values']))
				$sql .= ", ";
			
			$i++;
		endforeach;
			
		$sql .= ")";
		
		$this->Library("DataBase");
		$DB = $this->DB;
		$DB->Open();
		$DB->Query($sql);
		$DB->Close();
		
		if ($fieldForCheck == NULL) :
			$DB = NULL;
			$DB = $this->DB;
			$DB->Open();
			$DB->Query("SELECT * FROM ".$params['table']. " LIMIT 0,1");
			$fieldsName = $DB->Result('fields');
			$fieldForCheck = $fieldsName[0]['name'];
		endif;
		
		$result = $this->SearchBy(array("table"=>$params['table'], "field"=>$fieldForCheck, "value"=>$valueForCheck));
		
		if ($result['status'] == TRUE) :
			$return['status'] = TRUE;
			$return[$params['table']] = $result[$params['table']];
		endif;
		
		return $return;
	}
	
	/*
	 * @params['table']		= table name
	 * @params['order']		= fieldName for order by
	 * @params['orderType']	= order method asc / desc
	 * @params['limit']		= limit per page
	 * @params['condition'] = after where condition
	 */
	public function ListOfTable($params)
	{
		$return['status'] = FALSE;
		
		if (!isset($params['table']))
			return $return;
		
		$sql = sprintf("SELECT * FROM %s", $params['table']);
		
		if (isset($params['condition']))
			$sql .= " WHERE ".$params['condition'];
		
		if (isset($params['order']))
			$sql .= sprintf(" ORDER BY %s", $params['order']);
		
		if (isset($params['orderType'])) :
			switch(strtolower($params['orderType'])) :
				case 'asc'			: 
				case 'ascending'	: $sql .= " ASC";
									  break;
				
				case 'desc'			: 
				case 'descending'	: $sql .= " DESC";
									  break;
			endswitch;
		endif; 
		
		$this->Library("DataBase");
		$DB = $this->DB;
		
		if (isset($params['limit'])) 
			$DB->limit = $params['limit'];
		else
			$DB->limit = $this->limit;
		
		$DB->Open();
		$DB->Query($sql);
		
		if ($DB->Result('total') > 0) :
			$fieldInfo = $DB->Result('fields');
			$return['status'] = TRUE;
			$i = 0;
			
			while ($result = $DB->Result()) :
				foreach($fieldInfo as $info) :
					$field = $info->name; 
					$return[$params['table']][$i][$field] = $result->$field;
				endforeach;
				$i++;
			endwhile;
			
		endif;
			
		$return['pages'] = $DB->Page();
			
		return $return;
	}
	
	/*
	 * @params['table']		= table name
	 * @params['field']		= field
	 * @params['value']		= value
	 */
	public function SearchBy($params)
	{
		$return['status'] = FALSE;
		
		if (!isset($params['table']) or !isset($params['field']) or !isset($params['value']))
			return $return;
		
		$this->Library("DataBase");
		$DB = $this->DB;
		$DB->Open();
		$DB->Query("SELECT * FROM ".$params['table']." WHERE ".$params['field']." = '".$params['value']."'");
		
		if ($DB->Result('total') > 0) :
			$fieldInfo = $DB->Result('fields');
			$return['status'] = TRUE;
			
			if ($result = $DB->Result()) :
				foreach($fieldInfo as $info) :
					$field = $info->name; 
					$return[$params['table']][$field] = $result->$field;
				endforeach;
			endif;
			
		endif;
			
		return $return;
	}
	
	public function GetAllTables()
	{
		$return['status'] = FALSE;
		
		$this->Library("DataBase");
		$DB = $this->DB;
		$DB->Open();
		$DB->Query("SHOW TABLES FROM ".$DB->dbName);
		
		if ($DB->Result('total') > 0) :
			$fieldInfo = $DB->Result('fields');
			$return['status'] = TRUE;
			$i = 0;
			
			while ($result = $DB->Result()) :
				foreach($fieldInfo as $info) :
					$field = $info->name; 
					$return['tables'][$i] = $result->$field;
				endforeach;
				$i++;
			endwhile;
		endif;
		
		return $return;
	}
	
	/*
	 * @params['tables']		= list of tables in array
	 * @params['field']		= field for search uuid
	 */
	public function UUID($params = NULL)
	{
		$return['status'] = FALSE;
		
		$this->Library(array("DataBase", "UUID"));
		
		if (isset($params['tables'])) :
			$tables = $params['tables'];
		else :
			$tables = $this->GetAllTables();
			if ($tables['status'] == FALSE) :
				$return['message'] = "no tables found!";
				return $return;
			endif;
			$tables = $tables['tables'];
		endif;
		
		if (isset($params['field'])) 
			$field = $params['field'];
		else
			$field = "id";
		
		$uuid = $this->UUID->V4();
		$sql = "SELECT * FROM %s WHERE ".$field." = '".$uuid."'";
		$valid = TRUE;
		
		for($i=0; $i<count($tables); $i++) :
			$DB = NULL;
			$DB = $this->DB;
			$DB->Open();
			$DB->Query(sprintf($sql, $tables[$i]));
			
			if ($DB->Result('total') > 0)
				$valid = FALSE;
			
			$DB->Close();
		endfor;
		
		if ($valid == FALSE) 
			$return = $this->UUID;
		else 
			$return['uuid'] = $uuid;
		
		$return['status'] = TRUE;
		return $return;
	}
	
}


?>