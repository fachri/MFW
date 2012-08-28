<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 


/*----------------------------------------------------------------------------------------------------
 *	Variable
 *----------------------------------------------------------------------------------------------------
 *
 *	Class ini digunakan untuk proses/eksekusi berhubung dengan Variable Global. Variable Global 
 *	digunakan sebagai pengganti querystring
 *
 */
 
class Variable
{

 	public $Variable;

/*----------------------------------------------------------------------------------------------------
 *	Construct
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini tidak melakukan proses.
 *
 */
 
	public function __construct()
	{
		$this->Variable	= $GLOBALS['Variable']; 
	}
	

/*----------------------------------------------------------------------------------------------------
 *	Pop
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini akan melakukan proses penghapusan Variable Global, sesuai dengan nama keys-nya.
 *
 *	cth, pemanggilan dari dalam class
 *		Variable::Pop('Halaman');
 *
 */
 
	public function Pop($variable)
	{
		$variable = ucfirst($variable);
		
		if ( isset($this->Variable[$variable]) )
			unset($this->Variable[$variable]);
	}
	

/*----------------------------------------------------------------------------------------------------
 *	Cetak
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini akan mencetak, seluruh variable global dalam bentuk format alamat url.
 *
 *	cth, pemanggilan dari dalam class
 *		Variable::Cetak();
 *
 *	cth, output
 *		/Variable1/Isi1/Variable2/Isi2/Variable3
 *
 */
 
	public function Cetak()
	{
		$array_keys = array();
		
		if ( isset($this->Variable) and is_array($this->Variable) ) :
		
			$array_keys = array_keys($this->Variable);
			$cetak		= NULL;
			
			for ($c=0; $c<count($array_keys); $c++)
			{
				$cetak .= '/'.$array_keys[$c];
				if (isset($this->Variable[$array_keys[$c]]))
				{
					$cetak .= '/'.$this->Variable[$array_keys[$c]];
				}
			}
			
			return $cetak;
		
		endif;
	}
	
	public function Get()
	{
		return $this->Cetak();
	}
}




?>