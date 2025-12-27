<?php
	include_once '../../config/crud.php'; 
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$judul = "Edit Data Ruang";
		$button = "Edit";
		$onclick = "p_edit_ruang($id)";
		$qr = $proses->tampil("*","ruang","WHERE id_ruang = '$id'");
		$dt = $qr->fetch();
	}else{
		$id = "";
		$judul = "Tambah Data Ruang";
		$button = "Simpan";
		$onclick = "tmb_ruang()";
		// Initialize empty array
		$dt = array_fill(0, 3, "");
	}
 ?>
<div class="bg-box">
	<div class="bar">
		<p onclick="thickbox('','exit')">&times;</p>
		<h2><?php echo $judul; ?></h2>
	</div>
	<div class="in-box">
		<p>Nama</p>
		<input type="text" id="nama" value="<?php echo $dt[1]; ?>" placeholder="Ex: A-1">

		<p>Jumlah Kursi</p>
		<input type="number" id="kursi" value="<?php echo $dt[2]; ?>">

		<button class="btn-simpan" onclick="<?php echo $onclick; ?>"><?php echo $button; ?></button>
		<button class="btn-batal" onclick="thickbox('','exit')">Batal</button>
	</div>
</div>
