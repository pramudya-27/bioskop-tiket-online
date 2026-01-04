<?php 
	include '../../config/crud.php';
	$proses->edit("pemesan","
							status = '2' ","id_pemesan = '$_POST[id]'");
	echo "1";
 ?>