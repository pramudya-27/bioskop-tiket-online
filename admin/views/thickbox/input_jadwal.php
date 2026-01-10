<?php
	include_once '../../config/crud.php'; 
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$judul = "Edit Data Jadwal";
		$button = "Edit";
		$onclick = "p_edit_jadwal($id)";
		$qr = $proses->tampil("*","jadwal","WHERE id_jadwal = '$id'");
		$dt = $qr->fetch();
	}else{
		$id = "";
		$judul = "Tambah Data Jadwal";
		$button = "Simpan";
		$onclick = "tmb_jadwal()";
        // Initialize with keys to avoid errors
		$dt = [
            'id_film' => '',
            'tgl_mulai' => '',
            'tgl_berhenti' => '',
            'id_sesi' => '',
            'id_ruang' => ''
        ];
	}
 ?>
<div class="bg-box">
	<div class="bar">
		<p onclick="thickbox('','exit')">&times;</p>
		<h2><?php echo $judul; ?></h2>
	</div>
	<div class="in-box">
		<p>Film</p>
		<select id="film">
			<option value="">Pilih Film</option>
			<?php
				$q_film = $proses->tampil("*","film","");
				foreach($q_film as $f) {
					// Use specific key
					$selected = ($dt['id_film'] == $f['id_film']) ? 'selected' : ''; 
					echo "<option value='$f[id_film]' $selected>$f[judul]</option>";
				}
			?>
		</select>

		<p>Tanggal Mulai</p>
		<input type="text" id="mulai" value="<?php echo $dt['tgl_mulai']; ?>" placeholder="YY/MM/DD">

		<p>Tanggal Selesai</p>
		<input type="text" id="selesai" value="<?php echo $dt['tgl_berhenti']; ?>" placeholder="YY/MM/DD">

		<p>ID Sesi</p>
		<input type="text" id="sesi" value="<?php echo $dt['id_sesi']; ?>">

		<p>ID Ruang</p>
		<input type="text" id="ruang" value="<?php echo $dt['id_ruang']; ?>">

		<button class="btn-simpan" onclick="<?php echo $onclick; ?>"><?php echo $button; ?></button>
		<button class="btn-batal" onclick="thickbox('','exit')">Batal</button>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$("#mulai").datepicker({dateFormat:"yy/mm/dd"});
		$("#selesai").datepicker({dateFormat:"yy/mm/dd"}); 
	})
</script>