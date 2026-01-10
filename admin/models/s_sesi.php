<?php 
	include_once '../config/crud.php';
	$proses->simpan("sesi","
							NULL,
							'$_POST[nama]',
							'$_POST[mulai]',
							'$_POST[selesai]' ");
	echo "1";
 ?>
