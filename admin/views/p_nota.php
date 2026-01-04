<?php 
	include_once "../../config/crud.php";
	$id_pemesan = $_GET['id'];
	// Fetch Order Info
	$sql_pemesan = $proses->tampil("pemesan.*, member.nama","pemesan LEFT JOIN member ON pemesan.id_member = member.id_member","WHERE pemesan.id_pemesan = '$id_pemesan'");
	$pemesan = $sql_pemesan->fetch();

	// Fetch Order Details
	$sql_dtl = $proses->tampil("*","dtl_pemesan,tiket,film","WHERE dtl_pemesan.id_pemesan = '$id_pemesan' AND dtl_pemesan.id_tiket = tiket.id_tiket AND tiket.id_film = film.id_film");
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Nota Pemesanan - <?php echo $id_pemesan; ?></title>
 	<style>
 		body { font-family: 'Courier New', Courier, monospace; width: 80mm; margin: 0 auto; color: #333; }
 		h1, h2, h3 { text-align: center; margin: 5px 0; }
 		.header { border-bottom: 2px dashed #333; padding-bottom: 10px; margin-bottom: 10px; }
 		.info { margin-bottom: 10px; font-size: 12px; }
 		table { width: 100%; border-collapse: collapse; font-size: 12px; }
 		th { text-align: left; border-bottom: 1px solid #333; }
 		td { padding: 5px 0; }
 		.total { border-top: 2px dashed #333; font-weight: bold; font-size: 14px; text-align: right; padding-top: 5px; margin-top: 5px; }
 		.footer { text-align: center; margin-top: 20px; font-size: 10px; }
 	</style>
 </head>
 <body>
 	<div class="header">
 		<h1>Movies Mania</h1>
 		<p style="text-align: center;">Nota Pembelian Tiket</p>
 	</div>

 	<div class="info">
 		ID Pemesan: <?php echo $pemesan['id_pemesan']; ?><br>
 		Nama: <?php echo $pemesan['nama'] != null ? $pemesan['nama'] : 'User ID: '.$pemesan['id_member'].' (Deleted)'; ?><br>
 		Tanggal: <?php echo isset($pemesan['tgl_pesan']) ? date("d-m-Y", strtotime($pemesan['tgl_pesan'])) : '-'; ?><br>
 	</div>

 	<table>
 		<thead>
 			<tr>
 				<th>Film</th>
 				<th>Kursi</th>
 				<th style="text-align: right;">Harga</th>
 			</tr>
 		</thead>
 		<tbody>
 			<?php foreach ($sql_dtl as $dtl) { ?>
 			<tr>
 				<td><?php echo substr($dtl['judul'], 0, 15); ?></td>
 				<td><?php echo $dtl['kursi']; ?></td>
 				<td style="text-align: right;"><?php echo number_format($dtl['harga'], 0, ',', '.'); ?></td>
 			</tr>
 			<?php } ?>
 		</tbody>
 	</table>

 	<div class="total">
 		Total: Rp <?php echo number_format($pemesan['total_harga'], 0, ',', '.'); ?>
 	</div>

 	<div class="footer">
 		Terima Kasih<br>
 		Selamat Menonton
 	</div>

 	<script>
 		window.print();
 	</script>
 </body>
 </html>
