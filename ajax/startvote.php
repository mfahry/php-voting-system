<?php
	include_once '../config/constants.php';
	include_once '../classes/MysqlPDO.php';
	
	/*
	 * Proses awal 
	 * cek nim apakah sudah pernah memilih sebelumnya
	 * 1. jika belum tampilkan halaman pemilihan terurut dari mulai himpunan->presma->dpm
	 * 2. jika sudah tampilkan halaman sudah memilih
	 * 3. jika suda tetapi belum seluruhnya memilih, tampilkan pilihan sebelumnya dan opsi untuk mengganti pilihan
	 */
	
	$nim = strip_tags(htmlentities(stripslashes(trim($_POST['nim']))));
	
	/*
	 * cek apakah sudah diunlock
	 */ 
	 $db = new MysqlPDO(_DBUSER_,_DBPASS_,_DBHOST_,_DBNAME_);
	 
	 $sql = "SELECT * FROM mahasiswa WHERE(nim = ?) AND(status = 'unlock') LIMIT 1";
	 $db->prepare($sql);
	 $db->statement(array($nim));
	 
	 if($db->execute()){
	 	/*
		 * Cari prodi dari nama nimnya
		 * 301 -> MI
		 * 302 -> TK
		 * 303 -> KA
		 */
		if($db->rowCount() > 0)
		{
			$prodi = substr($nim, 0, 3);
		
			if($prodi == "301")
			{
				// prodi MI
				echo "Anda prodi MI"; 
			}elseif($prodi == "302"){
				// Prodi TK
				echo "Anda prodi TK"; 
			}elseif($prodi == "303"){
				// Prodi KA
				echo "Anda prodi KA"; 
			}
		}else{
			echo "lock";
		}
	 }else{
	 	 echo "error";
	 }
	 exit();
	
?>