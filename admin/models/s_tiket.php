<?php 
	include_once '../config/crud.php';
	$proses->simpan("tiket","
							NULL,
							'$_POST[harga]',
							'$_POST[stok]', 
							'' ");
	echo "berhasil";
 ?>