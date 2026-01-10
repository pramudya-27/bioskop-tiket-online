<?php 
	include '../config/crud.php';
	$sql1 = $proses->tampil("kursi","dtl_pemesan,tiket","WHERE tiket.id_tiket = '$_POST[tiket]' AND dtl_pemesan.kursi = '$_POST[kursi]' AND tiket.id_tiket = dtl_pemesan.id_tiket AND dtl_pemesan.tgl_tayang = '$_POST[tgl_tayang]' AND dtl_pemesan.id_sesi = '$_POST[sesi]'");
	$row1 = $sql1->rowcount();
	if ($row1 == 1) {
		echo "<script>alert('Kursi Sudah Di Pesan')</script>";
		echo "<script>document.location = '../index.php'</script>";
	}else{
		try {
			$tgl = date('Y-m-d', strtotime($_POST['tgl_tayang'])); // Ensure correct format
			$sql = "INSERT INTO dtl_pemesan (id_dtl_pemesan, kursi, id_tiket, id_pemesan, tgl_tayang, id_sesi) 
					VALUES (NULL, '$_POST[kursi]', '$_POST[tiket]', '$_POST[pemesan]', '$tgl', '$_POST[sesi]')";
			
			$stmt = $proses->con->prepare($sql);
			if ($stmt->execute()) {
				echo "<script>alert('Berhasil Menambahkan')</script>";
				echo "<script>document.location = '../index.php'</script>";
			} else {
				$err = $stmt->errorInfo();
                var_dump($err);
                var_dump($_POST);
                die("Save Failed");
				// echo "<script>alert('Gagal Menambahkan: " . $err[2] . "')</script>";
				// echo "<script>history.back();</script>";
			}
		} catch (PDOException $e) {
			echo "<script>alert('Error: " . $e->getMessage() . "')</script>";
			echo "<script>history.back();</script>";
		}
	}
 ?>