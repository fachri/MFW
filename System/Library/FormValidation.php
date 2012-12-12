<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 

class FormValidation
{
	
	public $validation	= TRUE;
	public $info		= array();
	
	public function __construct()
	{
		if (isset($_POST))
			$this->post = $_POST;
		
		if (isset($_FILES)) :
			$this->files = $_FILES;
			$this->post = array_merge($this->post, $this->files);
		endif;
	}
	
	
	private function Capture( $formName, $labelName, $ruleName, $status = FALSE )
	{
		$flag = FALSE;
		
		for ( $i=0; $i<count($this->info); $i++ ) :
			
			if ( isset($this->info[$i]['name']) and $this->info[$i]['name'] == $formName ) :
				
				for ( $j=0; $j<count($this->info[$i]['rules']); $j++ ) :
					
					if ( $this->info[$i]['rules'][$j]['name'] == $ruleName ) :
						$this->info[$i]['rules'][$j]['status'] = $status;
						$flag = TRUE;
					else :
						$rules[]	= array(
										   	'name'		=> $ruleName,
										   	'status'	=> $status,
										   	'message'	=> NULL,
										   );
						
						$this->info[$i]['rules'] = array_merge($this->info[$i]['rules'], $rules);
						$flag = TRUE;
					endif;
					
				endfor;
				
			endif;
			
		endfor;
		
		if ( $flag == FALSE ) :

			$rules[]	  = array(
								  'name'	=> $ruleName,
								  'status'	=> $status,
								  'message'	=> NULL,
								 );
			
			$this->info[] = array(
								  'name'	=> $formName,
								  'label'	=> $labelName,
								  'rules'	=> $rules,
								 );
		endif;
		
	}
	

	public function Compare( $AFormName, $BFormName, $ALabelName = NULL, $ruleName = "compare" )
	{
		if ($this->post[$AFormName] != NULL and $this->post[$BFormName] != NULL) :
			
			$status = TRUE;
			
			if ( $this->post[$AFormName] != $this->post[$BFormName] )
				$status = FALSE;
			
			$this->Rules( $AFormName, $ALabelName, $ruleName, $status );
			
		endif;
	}
	
	# class = class name for css
	public function Error( $type = 'print', $class = 'error' )
	{
		$error = $this->Info_Get();
		
		switch ( $type ) :
			
			case 'print'	:	return $this->Info_Print($error, $class);
								break;
			
			case 'array'	:	return $error;
								break;
			
		endswitch;
	}
	
	
	private function Info_Print( $array, $class )
	{
		$return = NULL;
		
		$return = "	<div class=\"".$class."\">
		<ul>
";

		foreach ( $array as $message ) :
			
			$return .= "			<li>".$message."</li>
";
			
		endforeach;

		$return .= "		</ul>
	</div>
";
		
		return $return;
	}
	
	private function Info_Get( $status = FALSE )
	{
		$return = array();
		
		if ( isset($this->info) and is_array($this->info) ) :
			
			for ( $i=0; $i<count($this->info); $i++ ) :
				
				for ( $j=0; $j<count($this->info[$i]['rules']); $j++ ) :
					
					if ( $this->info[$i]['rules'][$j]['status'] == $status ) :
						$return[] = $this->info[$i]['rules'][$j]['message'];
					endif;
					
					if ( $status == 'all' ) :
						$return[] = $this->info[$i]['rules'][$j]['message'];
					endif;
					
				endfor;
				
			endfor;
			
		endif;
		
		return $return;
	}

	public function Message( $formName, $ruleName, $message, $status = FALSE )
	{
		if ( isset($this->info) and is_array($this->info) ) :
		
			$nameId = $this->Search($this->info, 'name', $formName);
			
			if ( isset( $this->info[$nameId] ) )
				$ruleId = $this->Search($this->info[$nameId]['rules'], 'name', $ruleName);
			else
				return FALSE;
			
			if ( isset( $this->info[$nameId]['rules'][$ruleId] ) ) :
				
				if ( $this->info[$nameId]['rules'][$ruleId]['status'] == $status )
					$this->info[$nameId]['rules'][$ruleId]['message'] = $message;
				
			endif;
				
		endif;
	}
	
	
	public function Rules( $formName, $labelName, $ruleName = NULL, $status = FALSE )
	{
		if ( isset($ruleName) ) :
			
			switch($ruleName) :
				
				case 'required'			:	$result = $this->_Rules_Required($formName);
											$this->Capture( $formName, $labelName, $ruleName, $result );
											break;
				
				default					:	$this->Capture( $formName, $labelName, $ruleName, $status );
											break;
				
			endswitch;
			
		endif;
	}
	
	
	private function _Rules_Required( $formName, $skip = FALSE )
	{
		if ( ! isset($this->post[$formName]) or $this->post[$formName] == NULL ) :
			
			if ( $skip == FALSE )
				$this->validation = FALSE;
			
			return FALSE;
			
		endif;
		
		return TRUE;
	}
	
	
	private function Search( $array, $field, $key )
	{
		for ( $i=0; $i<count($array); $i++ ) :
			
			if ( isset($array[$i][$field]) and $array[$i][$field] == $key )
				return $i;
			
		endfor;
		
		return FALSE;
	}
	
	
	
}


?>