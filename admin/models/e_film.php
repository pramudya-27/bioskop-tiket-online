<?php 
	include '../config/crud.php';
	$foto = $_FILES['gambar']['name'];
	$alamat = $_FILES['gambar']['tmp_name'];

	if (empty($foto)) {
		$judul = addslashes($_POST['judul']);
		$sinopsis = addslashes($_POST['sinopsis']);
		$proses->edit("film","	judul = '$judul',
							rating = '$_POST[rating]',
							durasi = '$_POST[durasi]',
							id_tiket = '$_POST[id_tiket]',
							sinopsis = '$sinopsis',
							score = '$_POST[score]',
							rilis = '$_POST[rilis]'","id_film = '$_POST[id]' ");
		echo "true";
	}else{
		$judul = addslashes($_POST['judul']);
		$sinopsis = addslashes($_POST['sinopsis']);
		move_uploaded_file($alamat, '../assets/img/film/'.$foto);
		$proses->edit("film","	judul = '$judul',
								rating = '$_POST[rating]',
								durasi = '$_POST[durasi]',
								id_tiket = '$_POST[id_tiket]',
								sinopsis = '$sinopsis',
								score = '$_POST[score]',
								rilis = '$_POST[rilis]',
								gambar = '$foto'","id_film = '$_POST[id]' ");
		echo "true";
	}
 ?>