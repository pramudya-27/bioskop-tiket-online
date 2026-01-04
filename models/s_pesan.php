<?php 
	include_once '../config/crud.php';
	$date = date("Y-m-d");
	$proses->simpan("pemesan","
								'$_POST[id_pemesan]',
								'$_POST[id_member]',
								'$_POST[jm_tiket]',
								'$_POST[t_harga]',
								'$date',
								'1' ");
	
	// Deduct stock
	$sql_dtl = $proses->tampil("*", "dtl_pemesan", "WHERE id_pemesan = '$_POST[id_pemesan]'");
	foreach ($sql_dtl as $dtl) {
		$proses->edit("tiket", "stok = stok - 1", "id_tiket = '$dtl[id_tiket]'");
	}

    // Log debug info
    file_put_contents('../debug_pesan.log', "Order ID: " . $_POST['id_pemesan'] . " - Status: Saved\n", FILE_APPEND);

	echo "<script>window.open('../views/p_sub_tiket.php?id='+$_POST[id_pemesan])</script>";
	echo "<script>document.location = '../index.php'</script>";

 ?>