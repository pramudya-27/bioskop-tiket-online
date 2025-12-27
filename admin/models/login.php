<?php
	include_once '../config/crud.php';

	session_start();
	if (isset($_POST['login'])) {
		$user = $_POST['user'];
		$pass = md5($_POST['pass']);
		
		$sql5 = $proses->con->prepare("SELECT * FROM admin WHERE nama = ? AND password = ?");
		$sql5->execute([$user, $pass]);
		$row5 = $sql5->rowCount();
		$dt5 = $sql5->fetch();
		
		if ($row5 == 0) {
			echo "<script>alert('Gagal Login !!')</script>";
			echo "<script>document.location = '../views/login.php'</script>";
		}else{
			if ($dt5['level'] == "admin") {
				$_SESSION['id'] = $dt5['id_admin'];
				$_SESSION['level'] = $dt5['level'];
				echo "<script>alert('Anda Berhasil login sebagai Admin')</script>";
				echo "<script>document.location = '../index.php'</script>";
			}else{
				$_SESSION['id'] = $dt5['id_admin'];
				$_SESSION['level'] = $dt5['level'];
				echo "<script>alert('Anda Berhasil login sebagai Manager ')</script>";
				echo "<script>document.location = '../index.php'</script>";
			}
		}
	}
 ?>