<?php
	include_once '../../config/crud.php'; 
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$judul = "Edit Data Sesi";
		$button = "Edit";
		$onclick = "p_edit_sesi($id)";
		$qr = $proses->tampil("*","sesi","WHERE id_sesi = '$id'");
		$dt = $qr->fetch();
	}else{
		$id = "";
		$judul = "Tambah Data Sesi";
		$button = "Simpan";
		$onclick = "tmb_sesi()";
		$dt = array_fill(1, 3, "");
	}
 ?>
<div class="bg-box">
	<div class="bar">
		<p onclick="thickbox('','exit')">&times;</p>
		<h2><?php echo $judul; ?></h2>
	</div>
	<div class="in-box">
		<p>Nama Sesi</p>
		<input type="text" id="nama" value="<?php echo $dt[1]; ?>">

		<p>Jam Mulai</p>
		<input type="time" id="mulai" value="<?php echo $dt[2]; ?>" placeholder="HH:MM">

		<p>Jam Selesai</p>
		<input type="time" id="selesai" value="<?php echo $dt[3]; ?>" placeholder="HH:MM">

		<button class="btn-simpan" onclick="<?php echo $onclick; ?>"><?php echo $button; ?></button>
		<button class="btn-batal" onclick="thickbox('','exit')">Batal</button>
	</div>
</div>