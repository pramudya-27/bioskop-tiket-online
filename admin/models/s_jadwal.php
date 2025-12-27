<?php 
	include_once '../config/crud.php';
	$proses->simpan("jadwal","
							NULL,
							'$_POST[mulai]',
							'$_POST[selesai]',
							'$_POST[sesi]',
							'$_POST[ruang]' ");
	echo "1";
 ?>