<?php 
	include '../config/crud.php';
	$sql1 = $proses->tampil("kursi","dtl_pemesan,tiket","WHERE tiket.id_tiket = '$_POST[tiket]' AND dtl_pemesan.kursi = '$_POST[kursi]' AND tiket.id_tiket = dtl_pemesan.id_tiket AND dtl_pemesan.tgl_tayang = '$_POST[tgl_tayang]' AND dtl_pemesan.id_sesi = '$_POST[sesi]'");
	$row1 = $sql1->rowcount();
	if ($row1 == 1) {
		echo "<script>alert('Kursi Sudah Di Pesan')</script>";
		echo "<script>document.location = '../index.php'</script>";
	}else{
		$proses->simpan("dtl_pemesan","
										NULL,
										'$_POST[kursi]',
										'$_POST[tiket]',
										'$_POST[pemesan]',
										'$_POST[tgl_tayang]',
										'$_POST[sesi]' ");
		echo "<script>alert('Berhasi Menambahkan')</script>";
		echo "<script>document.location = '../index.php'</script>";
	}
 ?>