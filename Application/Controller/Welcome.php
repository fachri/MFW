<?php if (! defined('SYSTEM')) exit('No direct script access allowed');

class Welcome extends Controller
{
	# Digunakan untuk navigasi
	public $navigation;
	public $access;
	private $languageCode;
	
	public function __construct()
	{
		parent::__construct();
		
		/*
		 *	Jika website anda ingin memanfaatkan sistem multi-bahasa, maka gunakan code dibawah untuk
		 * 	melakukan proses pemanggilan string-string pada halaman bahasa dan letakkan di seluruh
		 * 	halaman yang memerlukan proses bahasa.
		 * 
		 * 	Sistem pemilihan bahasa disimpan pada Sesi user dengan menyimpan kode bahasa yang digunakan
		 *	Jika user belum mempunyai sesi, maka sistem secara otomatis akan membuatkan sesi dengan 
		 * 	value bahasa pertama (0) pada konfigurasi website.
		 */
		 
		 
		 /*
				
		if ( ! $this->Session->Cetak($this->configuration['Sesi']['Bahasa']) ) :
			$this->Session->Daftar( $this->configuration['Sesi']['Bahasa'], $this->configuration['Bahasa'][0] );
		endif;
		
		$this->$languageCode = $this->Sesi->Cetak($this->configuration['Sesi']['Bahasa']);
		$this->Language( $this->$languageCode );
		
		/*
		 *	Akhir dari proses bahasa
		 */
		 
/*
		$this->Model(
					 array(
					 	   "Access"
					 	  )
					);
					
		$this->Access->Check();
	*/			
	}
	
	public function index()
	{
		#print_r($this->configuration);
		
		
		$this->Rute->ControllerOpen("Welcome/Test");
		
		
		
		echo '<a href="'.$this->Rute->Controller("Welcome/Test").'">test</a>';
		
		#echo $this->
		#$this->Rute->ControllerOpen("Merchants");
	}
	
	public function Test()
	{
		$add = array(
					 "test1"=>"1", 
					 "2"=>"test2"
					);
		
		$this->Session->Add($add);
		echo "Add: ".$this->Session->Get("test1")."<br/>";
		echo "Add: ".$this->Session->Get("2")."<br/>";
		$this->Session->Delete($add);
		echo "Add: ".$this->Session->Get("test1")."<br/>";
		echo "Add: ".$this->Session->Get("2")."<br/>";
	}
}


?>