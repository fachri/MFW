<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 


/*----------------------------------------------------------------------------------------------------
 *	Security
 *----------------------------------------------------------------------------------------------------
 *
 *	None
 *
 */
 
class Security
{

/*----------------------------------------------------------------------------------------------------
 *	Construct
 *----------------------------------------------------------------------------------------------------
 *
 *	None
 *
 *	cth, None
 *		None
 *
 */
  
	public function __construct()
	{
	}
 
	public function ConvertHash( $input, $type = 'sha1' )
	{
		switch($type) :
			
			case 'sha1'		:	return sha1($input);
			case 'md5'		: 	return md5($input);
			
		endswitch;
	}
	
	Public Function ConvertHtml( $input )
	{
		return htmlspecialchars(stripslashes($input));
	}
	
	public function ConvertHTML( $input )
	{
		return $this->ConvertHtml($input);
	}
 
	public function Login( $input )
	{
		$input = $this->ConvertHtml($input);
		$input = str_ireplace("script", "blocked", $input);
		$input = mysql_escape_string($input);
		return $input;
	}

	public function Image( $input )
	{
		$input = preg_replace("#<img\s+.*?src\s*=\s*[\"'](.+?)[\"'].*?\>#", "\\1", $input);
		$input = preg_replace("#<img\s+.*?src\s*=\s*(.+?).*?\>#", "\\1", $input);

		return $input;
	}
	
	
 # XSS Filter
	
	public function XSS( $input )
	{
		$input = $this->Image($input);
		$input = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $input); 
	
		$search  = 'abcdefghijklmnopqrstuvwxyz'; 
		$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
		$search .= '1234567890!@#$%^&*()'; 
		$search .= '~`";:?+/={}[]-_|\'\\'; 
		
		for ($i = 0; $i < strlen($search); $i++) 
		{ 
			$input = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $input); 
			$input = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $input); 
		} 
		
		$filter	= array_merge($this->_XSS_Event(), $this->_XSS_Tag()); 
		
		for ($i = 0; $i < count($filter); $i++) 
		{ 
			$pattern = '/';
			
			for ($j = 0; $j < strlen($filter[$i]); $j++) 
			{ 
				if ($j > 0) 
				{ 
					$pattern .= '(';
					$pattern .= '(&#[xX]0{0,8}([9ab]);)'; 
					$pattern .= '|'; 
					$pattern .= '|(&#0{0,8}([9|10|13]);)'; 
					$pattern .= ')*'; 
				}
				
				$pattern .= $filter[$i][$j]; 
			} 
		
			$pattern .= '/i'; 
			$replace = substr($filter[$i], 1, 1).''.substr($filter[$i], 20,1); 
			$input = preg_replace($pattern, $replace, $input); 
			
		}
		return $input; 
	}

	private function _XSS_Tag() 
	{
		$input = array(
					   'javascript', 
					   'vbscript', 
					   'expression', 
					   'applet', 
					   'meta', 
					   'xml', 
					   'blink', 
					   'link', 
					   'style', 
					   'script', 
					   'embed', 
					   'object', 
					   'iframe', 
					   'frame', 
					   'frameset', 
					   'ilayer', 
					   'layer', 
					   'bgsound', 
					   'title', 
					   'base'
					  );
		
		return $input;
	}
	
	private function _XSS_Event() 
	{
		$input = array(
					   'onabort', 
					   'onactivate', 
					   'onafterprint', 
					   'onafterupdate', 
					   'onbeforeactivate', 
					   'onbeforecopy', 
					   'onbeforecut', 
					   'onbeforedeactivate', 
					   'onbeforeeditfocus', 
					   'onbeforepaste', 
					   'onbeforeprint', 
					   'onbeforeunload', 
					   'onbeforeupdate', 
					   'onblur', 
					   'onbounce', 
					   'oncellchange', 
					   'onchange', 
					   'onclick', 
					   'oncontextmenu', 
					   'oncontrolselect', 
					   'oncopy', 
					   'oncut', 
					   'ondataavailable', 
					   'ondatasetchanged', 
					   'ondatasetcomplete', 
					   'ondblclick', 
					   'ondeactivate', 
					   'ondrag', 
					   'ondragend', 
					   'ondragenter', 
					   'ondragleave', 
					   'ondragover', 
					   'ondragstart', 
					   'ondrop', 
					   'onerror', 
					   'onerrorupdate', 
					   'onfilterchange', 
					   'onfinish', 
					   'onfocus', 
					   'onfocusin', 
					   'onfocusout', 
					   'onhelp', 
					   'onkeydown', 
					   'onkeypress', 
					   'onkeyup', 
					   'onlayoutcomplete', 
					   'onload', 
					   'onlosecapture', 
					   'onmousedown', 
					   'onmouseenter', 
					   'onmouseleave', 
					   'onmousemove', 
					   'onmouseout', 
					   'onmouseover', 
					   'onmouseup', 
					   'onmousewheel', 
					   'onmove', 
					   'onmoveend', 
					   'onmovestart', 
					   'onpaste', 
					   'onpropertychange', 
					   'onreadystatechange', 
					   'onreset', 
					   'onresize', 
					   'onresizeend', 
					   'onresizestart', 
					   'onrowenter', 
					   'onrowexit', 
					   'onrowsdelete', 
					   'onrowsinserted', 
					   'onscroll', 
					   'onselect', 
					   'onselectionchange', 
					   'onselectstart', 
					   'onstart', 
					   'onstop', 
					   'onsubmit', 
					   'onunload', 
					   'alert'
					  );
		
		return $input;
	}

}




?>