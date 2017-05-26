<?php
class MysqlPDO{
        /*
         * Variabel Lokal dalam bentuk array yang menyimpan kolom - kolom untuk eksekusi Prepared Statement
         * Digunakan bila menggunakan method prepare
         */
	private $columnSet = array();

        /*
         * Variabel Koneksi Default
         */
	private $conn = "";

        /*
         * Variabel koneksi tambahan jika dilakukan proses Query tanpa Prepared Statement
         */
        private $connQuery = "";

        /*
         * Variabel lokal user database
         */
        private $user = "";

        /*
         * Variabel lokal password database
         */
        private $pass = "";

        /*
         * Variabel lokal Host database
         */
        private $host = "";

        /*
         * Variabel lokal nama database
         */
        private $dbName = "";
		
		/*
		 * Variabel lokal untuk port database
		 */
		private $port = "";

        /*
         * Variabel lokal error database, mempunyai nilai jika terdapat error pada eksekusi
         */
        private $errorMsg = "";

        /*
         * Konstruktor yang secara otomatis melakukan koneksi ke database
         * @type METHOD
         * @return BOOLEAN
         *
         * @user STRING username yang digunakan pada database bersangkutan
         * @pass STRING password yang digunakan pada database bersangkutan
         * @host STRING hostname yang digunakan pada server
         * @dbName STRING nama database yang ingin dikoneksikan
         *
         */
	function __construct($user = "",$pass = "",$host = "",$dbName = "",$port = ""){
            try{
                $this->host = $host;
                $this->user = $user;
                $this->pass = $pass;
                $this->dbName = $dbName;
				$this->port = $port;
                
				if($port != ""){
					$connectionScript = "mysql:host=$host:$port;dbname=$dbName";
				}else{
					$connectionScript = "mysql:host=$host;dbname=$dbName";
				}
				
				
				$this->conn = new PDO($connectionScript,$user,$pass);
                return TRUE;
            }catch(PDOException $e){
				$this->errorMsg = "Connection failed to database";
                return FALSE;
            }
            
		
	}

        /*
         * Digunakan bila melakukan koneksi pada database yang berbeda
         * tapi telah membuat objek sebelumnya
         * 
         * @type METHOD
         * @return BOOLEAN
         */
        function reconnect(){
            try{
				if($this->port != ""){
					$connectionScript = "mysql:host=".$this->host.":".$this->port.";dbname=".$this->dbName;
				}else{
					$connectionScript = "mysql:host=".$this->host.";dbname=".$this->dbName;
				}
                $newConnection = new PDO($connectionScript,$this->user,$this->pass);
                $this->conn = $newConnection;
                return TRUE;
            }catch(PDOException $e){
                $this->errorMsg = "Connection failed to database";
                return FALSE;
            }
        }

        function activateErrorAndException(){
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        /*
         * Memulai proses query yang
         * dapat dikembalikan ke posisi semula setelah pemanggilan method eksekusi query
         *
         * @type VOID
         */
        function beginTransaction(){
            $this->conn->beginTransaction();
        }

        /*
         * Mengakhiri proses query dengan menutup proses manipulasi pada database
         * digunakan jika telah dipanggil method {beginTransaction}
         *
         * @type VOID
         */
        function commit(){
            $this->conn->commit();
        }

        /*
         * Mengembalikan eksekusi yang telah dilakukan
         * digunakan jika telah dipanggil method {beginTransaction}
         *
         * @type VOID
         */
        function rollback(){
            $this->db->rollBack();
        }
        
        /*
         * Quoting value
         *
         * @stat ARRAY merupakan array dari nilai prepared statement
         * @quot BOOLEAN Merupakan status penyaringan kutip (QUOTE) untuk mencegah inject Query
         */
        public function quote($value){
            return $this->conn->quote($value);
        }

        /*
         * Set Username Database
         * @type VOID
         */
        public function setUser($user) {
            $this->user = $user;
        }

        /*
         * Set Password Database
         * @type VOID
         */
        public function setPass($pass) {
            $this->pass = $pass;
        }

        /*
         * Set Nama Host
         * @type VOID
         */
        public function setHost($host) {
            $this->host = $host;
        }
        
        /*
         * Set Nama Database
         * @type VOID
         */
        public function setDbName($dbName) {
            $this->dbName = $dbName;
        }
		
		/*
         * Set Specific Database Port
         * @type VOID
         */
        public function setPort($port) {
            $this->port = $port;
        }

        /*
         * Menjalankan Fungsi Prepared pada statement
         *
         * @type VOID
         */
	public function prepare($qry){
		$this->conn = $this->conn->prepare($qry);
	}

        /*
         * Mengeset nilai statement dalam bentuk array
         *
         * @type VOID
         *
         * @stat ARRAY merupakan array dari nilai prepared statement
         * 
         */
        public function statement($stat=array()){
            $this->columnSet = $stat;
	}
        /*
         * Mengambil Pesan Error jika terdapat kegagalan dalam koneksi database
         *
         * @type METHOD
         * @Return STRING
         */
        public function getErrorMessage(){
            return $this->errorMsg;
        }

        /*
         * Eksekusi Query untuk Statement biasa / tanpa prepare
         * Koneksi baru dengan nama $connQuery otomatis dibuat untuk menggantikan koneksi lama dari $conn
         * Agar method-method lainnya dapat berinteraksi{mendapatkan nilai} dari method lainnya
         * ex:rowCount|columnCount|fetch
         *
         * @type METHOD
         * @return BOOLEAN
         */
        public function executeQuery($queryString = ""){
            if($this->connQuery = $this->conn->query($queryString)){
                return TRUE;
            }else{
                $this->errorMsg = $this->conn->errorInfo();
                return FALSE;
            }
        }

        /*
         * Eksekusi Query untuk Prepared Statement
         *
         * @type METHOD
         * @return BOOLEAN
         */
        public function execute(){
		if($this->conn->execute($this->columnSet)){
                    return TRUE;
		}else{
                    $this->errorMsg = $this->conn->errorInfo();
                    return FALSE;
		}
	}

        /*
         * @type METHOD
         * @return INTEGER
         *
         * Mengecek method rowCount
         * opsi 1 = Kembalikan rowCount dari koneksi lama jika melakukan eksekusi query dengan prepared
         * opsi 2 = Kembalikan rowCount dari koneksi baru {connQuery} jika melakukan eksekusi query tanpa prepared
         */
	public function rowCount(){
            
		if(method_exists($this->conn, "rowCount")){
                    return $this->conn->rowCount();
                }else{
                    return $this->connQuery->rowCount();
                }
	}

        /*
         * @type METHOD
         * @return INTEGER
         *
         * Mengecek method Fetch
         * opsi 1 = Kembalikan columnCount dari koneksi lama jika melakukan eksekusi query dengan prepared
         * opsi 2 = Kembalikan columnCount dari koneksi baru {connQuery} jika melakukan eksekusi query tanpa prepared
         */
	public function columnCount(){
            if(method_exists($this->conn, "columnCount")){
                return $this->conn->columnCount();
            }else{
                return $this->connQuery->columnCount();
            }
	}

	/*
         * @type METHOD
         * @return Object PDO::Fetch
         *
         * Mengecek method Fetch
         * opsi 1 = Kembalikan Fetch dari koneksi lama jika melakukan eksekusi query dengan prepared
         * opsi 2 = Kembalikan Fetch dari koneksi baru {connQuery} jika melakukan eksekusi query tanpa prepared
         */
	public function fetch(){
            if(method_exists($this->conn, "fetch")){
                return $this->conn->fetch();
            }else{
                return $this->connQuery->fetch();
            }
	}
}
?>
