<?php 
	include_once '../config/crud.php';
	$proses->simpan("jadwal (id_jadwal, id_film, tgl_mulai, tgl_berhenti, id_sesi, id_ruang)","
							NULL,
							'$_POST[film]',
							'$_POST[mulai]',
							'$_POST[selesai]',
							'$_POST[sesi]',
							'$_POST[ruang]' ");
	echo "1";
 ?>