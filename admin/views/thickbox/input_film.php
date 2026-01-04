<?php
	include_once '../../config/crud.php';
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$judul = "Edit Data Film";
		$button = "Edit";
		$onclick = "edit_film($id)";
		$sql = $proses->tampil("*","film","WHERE id_film = '$id' ");
		$data = $sql->fetch();
	}else{
		$id = "";
		$judul = "Tambah Data Film";
		$button = "Simpan";
		$onclick = "simpan_film()";
		$data = array_fill(0, 10, "");
		$data['durasi'] = "";
		$data['id_jadwal'] = "";
		$data['id_tiket'] = "";
		$data['rating'] = "";
		$data['score'] = "";
		$data['rilis'] = "";
		$data['sinopsis'] = "";
	}
?>
<div class="bg-box">
	<div class="bar">
		<p onclick="thickbox('','exit')">&times;</p>
		<h2><?php echo $judul ?></h2>
	</div>
	<div class="in-box">
		<form id="<?php echo $button; ?>">
			<input type="hidden" name="id" value="<?php echo $data[0]; ?>">
			<p>Judul Film</p>
			<input type="text" name="judul" value="<?php echo $data[1]; ?>" required>

			<p>Genre</p>
			<input type="text" name="genre" value="<?php echo $data[2]; ?>" required>

			<p>Durasi</p>
			<input type="time" name="durasi" placeholder="HH:MM" value="<?php echo $data['durasi']; ?>" required>

			<p>ID Jadwal</p>
			<input type="text" name="jadwal" value="<?php echo $data['id_jadwal']; ?>" required>

			<p>ID Tiket</p>
			<input type="text" name="id_tiket" value="<?php echo isset($data['id_tiket']) ? $data['id_tiket'] : ''; ?>">

			<p>Rating</p>
			<?php 
				if ($data['rating'] == "G") {
					$g = "selected";
					$pg = "";
					$pg13 = "";
					$r = "";
				}elseif ($data['rating'] == "PG") {
					$pg = "selected";
					$g = "";
					$pg13 = "";
					$r = "";
				}elseif ($data['rating'] == "PG-13") {
					$pg13 = "selected";
					$g = "";
					$pg = "";
					$r = "";
				}elseif ($data['rating'] == "R") {
					$r = "selected";
					$pg = "";
					$g = "";
					$pg13 = "";
				}else{
					$g = "";
					$pg = "";
					$r = "";
					$pg13 = "";
				}
			 ?>
			<select name="rating">
				<option>--Pilih--</option>
				<option value="G" <?php echo $g; ?> >G</option>
				<option value="PG" <?php echo $pg; ?> >PG</option>
				<option value="PG-13" <?php echo $pg13; ?> >PG-13</option>
				<option value="R" <?php echo $r; ?> >R</option>
			</select>

			<p>Score</p>
			<input type="number" name="score" max="10" min="0" value="<?php echo $data['score']; ?>">

			<p>Rilis</p>
			<input type="text" name="rilis" placeholder="YY" value="<?php echo $data['rilis']; ?>">

			<p>Sinopsis</p>
			<textarea name="sinopsis" required><?php echo $data['sinopsis']; ?></textarea>

			<p>Gambar/Foto/Poster</p>
			<input type="file" name="gambar">
			
			<input type="submit" value="<?php echo $button; ?>" class="btn-simpan">
			<button type="button" class="btn-batal" onclick="thickbox('','exit')">Batal</button>
		</form>
	</div>
</div>
<script type="text/javascript">
	$("#Simpan").on('submit',(function(e){
		e.preventDefault();
		$.ajax({
			url:"models/s_film.php",
			type:"POST",
			data:new FormData(this),
			processData:false,
			contentType:false,
			cache:false,
			success:function(msg){
				if (msg == "true") {
					swal("Berhasil !!","Berhasil Menyimpan Data ","success");
					$(".content").load('views/tmp_film.php');
					$(".bg-thick").fadeOut(500);
				}
			}
		})
	}))
	$("#Edit").on('submit',(function(e){
		e.preventDefault();
		$.ajax({
			url:"models/e_film.php",
			type:"POST",
			data:new FormData(this),
			processData:false,
			contentType:false,
			cache:false,
			success:function(msg){
				if (msg == "true") {
					swal("Berhasil !!","Berhasil Mengedit Data ","success");
					$(".content").load('views/tmp_film.php');
					$(".bg-thick").fadeOut(500);
				}
			}
		})
	}))
</script>