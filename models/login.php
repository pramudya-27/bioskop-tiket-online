<?php
	include_once __DIR__ . '/../config/crud.php';
	
	session_start();
	if (isset($_POST['login'])) {
		$email = $_POST['email'];
		$pass = md5($_POST['pass']);
		
		$sql5 = $proses->con->prepare("SELECT * FROM member WHERE email = ? AND password = ?");
		$sql5->execute([$email, $pass]);
		$row5 = $sql5->rowCount();
		$dt5 = $sql5->fetch();
		
		if ($row5 == 0) {
			echo "<script>alert('Gagal Login !!')</script>";
			echo "<script>document.location = '../index.php'</script>";
		}else{
			$_SESSION['id'] = $dt5['id_member'];
			echo "<script>alert('Anda Berhasil login')</script>";
			echo "<script>document.location = '../index.php'</script>";
		}
	}
 ?>