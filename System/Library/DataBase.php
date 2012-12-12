<?php if (! defined('SYSTEM')) exit('No direct script access allowed'); 


/*----------------------------------------------------------------------------------------------------
 *	BasisData
 *----------------------------------------------------------------------------------------------------
 *
 *	Pustaka Class BasisData, digunakan untuk menangani seluruh proses eksekusi BasisData.
 *	Pada class ini, proses eksekusi dilakukan menggunaan metode MySQLi
 *
 *	Class ini dapat digunakan di Model & Kontroler
 *
 */
 
class DataBase extends MyFrameWork
{
	private $page;
	private $connection;
	private $process;
	private $pageVariable;
	private $dbConfig;
	public $limit;
	public $row;
	public $dbName;
	
	
/*----------------------------------------------------------------------------------------------------
 *	Construct
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini memanggil Class MyFrameWork, untuk mendapatkan Array Lokasi yang akan digunakan untuk
 *	mengambil lokasi Aplikasi/Konfigurasi/BasisData.php. File tersebut akan digunakan untuk
 *	menyesuaikan konfigurasi BasisData yang dibuat oleh Pengembang.
 *
 *	Fungsi ini sudah dikonfigurasi untuk dipanggil oleh Model / Kontroler, Variable yang digunakan
 *	untuk memanggil class ini:
 *		$this->DB->NAMAFUNCTION()/VARIABLE
 *
 */
	
	public function __construct()
	{
		parent::__construct();
		
		require($this->Location('ACDataBase'));
		$this->dbConfig = $database;
		
		if ( isset($this->configuration['pageVariable']) and $this->configuration['pageVariable'] != "" )
			$this->pageVariable = $this->configuration['pageVariable'];
		
		if ( $this->pageVariable == NULL )
			$this->pageVariable = 'Page';
		
	}
	
/*----------------------------------------------------------------------------------------------------
 *	Buka
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini akan memulai melakukan proses koneksi ke BasisData, dengan menyesuaikan konfigurasi
 *	yang sudah dibuat oleh User.
 *
 *	cth,
 *		$this->DB->Buka();
 * 
 * 		* maka database yang akan digunakan adalah konfigurasi default dari MyFrameWork yaitu 'mfw'
 * 
 * 	cth,
 * 		$this->DB->Buka('tambahan);
 * 
 * 		* maka database yang akan digunakan adalah konfigurasi user dengan nama 'tambahan'
 *
 */
	
	public function Open( $config = 'mfw' )
	{
		if (! isset($this->dbConfig[$config]['port']) or $this->dbConfig[$config]['port'] == NULL )
		{
			$this->dbConfig[$config]['port'] .= 3306;
		}
		
		$this->connection = new mysqli(
					   		  		   $this->dbConfig[$config]['host'],
					   		  		   $this->dbConfig[$config]['user'],
					  		  		   $this->dbConfig[$config]['password'],
					  		  		   $this->dbConfig[$config]['database'],
									   $this->dbConfig[$config]['port']
					  		 	      );

		$this->dbName = $this->dbConfig[$config]['database'];
	}
	
/*----------------------------------------------------------------------------------------------------
 *	Tutup
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini akan menutup koneksi ke BasisData, dan mengosongkan Variable yang digunakan oleh system.
 *
 *	cth,
 *		$this->DB->tutup();
 *
 */
	
	public function Close()
	{
		mysqli_close($this->connection);
		$this->connection	= NULL;
		$this->process		= NULL;
	}
	
/*----------------------------------------------------------------------------------------------------
 *	Query
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini melakukan proses eksekusi SQL. Proses eksekusi ini akan menampilkan seluruh Baris yang
 *	berada dalam table, untuk membatasi per-halaman, Pengembang harus mengisi Variable $this->Batas
 *	dengan angka batasan baris yang ditampilkan per-halaman.
 *
 *	cth, pengisian Variable $this->Batas
 *		$this->DB-Batas		= 10;
 *
 */
	
	public function Query($sql)
	{
		$this->page		= self::Position();
		$valid			= TRUE;
		
		if (isset($this->limit))
		{
			$this->process 	= $this->connection->query($sql);
			$this->row		= self::Result('total');
			$sql			= $sql.' LIMIT '.(($this->page-1)*$this->limit).','.$this->limit;
		}
		
		$this->process = $this->connection->query($sql);
		
		$strCheck = strpos(strtolower($sql), "insert");
		if ($strCheck !== FALSE) $valid = FALSE;
		
		$strCheck = strpos(strtolower($sql), "update");
		if ($strCheck !== FALSE) $valid = FALSE;
		
		$strCheck = strpos(strtolower($sql), "delete");
		if ($strCheck !== FALSE) $valid = FALSE;
	
		if ($valid == TRUE)
			$this->row		= self::Result('total');
	}
	
/*----------------------------------------------------------------------------------------------------
 *	Hasil
 *----------------------------------------------------------------------------------------------------
 *
 *	Fungsi ini yang memperoleh hasil proses eksekusi
 *
 *	cth, pengambilan hasil proses
 *		while ($hasil = $this->DB->Hasil())
 *		{
 *			echo $this->DB->uid;
 *		}
 *
 */
	
	public function Result( $type = "object" )
	{
		switch( $type ) :
			case 'total'	: return $this->process->num_rows;
							  break;
			
			case 'id'		: return $this->connection->insert_id;
							  break;
			
			case 'update'	: return $this->connection->affected_rows;
							  break;
			
			case 'array'	: return $this->process->fetch_array();
							  break;
			
			case 'fields'	: return $this->process->fetch_fields();
							  break; 
			
			default			: return $this->process->fetch_object();
		endswitch;
	}
	
/*	
	public function Error()
	{
		return $this->connection->error;
	}
*/

	# memasukkan fungsi halaman untuk memeriksa lokasi halaman

	private function Position()
	{
		$page = 1;

		if (isset($GLOBALS['Variable'][$this->pageVariable]))
		{
			if (is_numeric($GLOBALS['Variable'][$this->pageVariable]) and $GLOBALS['Variable'][$this->pageVariable] >= 1)
			{
				$page = $GLOBALS['Variable'][$this->pageVariable];
			}
		}
		
		return $page;
	}
	
	public function Page()
	{
		if (isset($this->row) and $this->row > 0)
			$return['rows'] = $this->row;
		
		if (isset($this->limit) and $this->limit != NULL)
			$return['limit'] = $this->limit;
		
		$return['position'] = $this->page;
		$return['total'] = ceil($this->row/$this->limit);
		
		return $return;
	}
	
}

  
?>