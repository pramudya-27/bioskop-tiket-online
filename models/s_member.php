<?php 
	include_once '../config/crud.php';
	$pass = md5($_POST['pass']);	
		$proses->simpan("member","
								NULL,
								'$_POST[nama]',
								'$_POST[email]',
								'$pass',
								'$_POST[jk]',
								'$_POST[tgl_lahir]',
								''");
		echo "<script>alert('Berhasil membuat akun')</script>";
		echo "<script>document.location = '../index.php'</script>";
 ?>