<?php 
	include '../config/crud.php';
	$proses->hapus("dtl_pemesan","id_dtl_pemesan = '$_GET[id]'");
	echo "<script>alert('Tiket berhasil dihapus');document.location='../dashboard_tiket.php'</script>";
 ?>
