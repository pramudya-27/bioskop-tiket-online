<?php 
	include_once '../config/crud.php';
		$foto = $_FILES['gambar']['name'];
		$alamat = $_FILES['gambar']['tmp_name'];

		move_uploaded_file($alamat, '../assets/img/film/'.$foto);
		$proses->simpan("film (judul, rating, durasi, id_jadwal, id_tiket, sinopsis, score, rilis, gambar)","
								'$_POST[judul]',
								'$_POST[rating]',
								'$_POST[durasi]',
								'$_POST[jadwal]',
								'$_POST[id_tiket]',
								'$_POST[sinopsis]',
								'$_POST[score]',
								'$_POST[rilis]',
								'$foto'");
		echo "true";
 ?>