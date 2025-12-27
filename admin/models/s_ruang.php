<?php 
	include_once '../config/crud.php';
	$proses->simpan("ruang","
							NULL,
							'$_POST[nama]',
							'$_POST[kursi]' ");
	echo "1";
 ?>