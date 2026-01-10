<?php 
	include '../config/crud.php';
	$proses->edit("tiket","
						harga = '$_POST[harga]',
						stok = '$_POST[stok]' ","id_tiket = '$_POST[id]'");
	echo "true";
 ?>