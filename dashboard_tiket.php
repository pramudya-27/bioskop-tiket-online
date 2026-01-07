<?php 
	include_once "config/crud.php";
	session_start();
	if (!isset($_SESSION['id'])) {
		echo "<script>alert('Harap login terlebih dahulu');document.location='index.php'</script>";
		exit;
	}
	$id_member = $_SESSION['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard Tiket - Movies Mania</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<!-- Reuse existing CSS -->
	<link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link href="assets/bootstrap/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link href="assets/bootstrap/css/font-awesome.css" rel="stylesheet"> 
	
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Tangerine:400,700' rel='stylesheet' type='text/css'>
	<link href="//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900" rel="stylesheet">
	<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

	<style>
		body {
			background-color: #f5f5f5;
			padding-top: 50px;
		}
		.dashboard-container {
			background: #fff;
			padding: 30px;
			box-shadow: 0 0 20px rgba(0,0,0,0.1);
			margin-bottom: 50px;
		}
		.nav-tabs {
			margin-bottom: 20px;
		}
		.nav-tabs > li > a {
			color: #333;
			font-weight: 600;
		}
		.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
			color: #fe423f;
		}
		.table th {
			background-color: #333;
			color: #fff;
		}
		.page-header h1 {
			margin-top: 0;
			border-bottom: 2px solid #fe423f;
			display: inline-block;
			padding-bottom: 10px;
		}
		.btn-back {
			margin-bottom: 20px;
		}
	</style>
</head>
<body>

<div class="container">
	<a href="index.php" class="btn btn-default btn-back"><i class="fa fa-arrow-left"></i> Kembali ke Home</a>
	
	<div class="dashboard-container">
		<div class="page-header">
			<h1>Dashboard Tiket</h1>
		</div>

		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#aktif" aria-controls="aktif" role="tab" data-toggle="tab">Tiket Aktif</a></li>
			<li role="presentation"><a href="#transaksi" aria-controls="transaksi" role="tab" data-toggle="tab">Daftar Transaksi</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<!-- TIKET AKTIF -->
			<div role="tabpanel" class="tab-pane active" id="aktif">
				<h3>Tiket Saya (Upcoming)</h3>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>No</th>
							<th>Film</th>
							<th>Tanggal Tayang</th>
							<th>Jam Tayang</th>
							<th>Kursi</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							// Logic: Join pemesan -> dtl_pemesan -> tiket -> film -> jadwal -> sesi
							// Filter by status '2' (paid) and future date
							$today = date('Y-m-d');
							$sql_aktif = $proses->tampil("film.judul, film.rilis, sesi.mulai as jam_tayang, sesi_pilih.mulai as jam_pilih, jadwal.tgl_mulai as tanggal_tayang, dtl_pemesan.tgl_tayang as tanggal_pilih, dtl_pemesan.kursi, dtl_pemesan.id_dtl_pemesan, dtl_pemesan.id_pemesan", 
								"pemesan 
								JOIN dtl_pemesan ON pemesan.id_pemesan = dtl_pemesan.id_pemesan 
								JOIN tiket ON dtl_pemesan.id_tiket = tiket.id_tiket
								JOIN film ON tiket.id_film = film.id_film
								JOIN jadwal ON film.id_jadwal = jadwal.id_jadwal
								JOIN sesi ON jadwal.id_sesi = sesi.id_sesi
								LEFT JOIN sesi as sesi_pilih ON dtl_pemesan.id_sesi = sesi_pilih.id_sesi",
								"WHERE pemesan.id_member = '$id_member' AND pemesan.status = '2' AND dtl_pemesan.tgl_tayang >= '$today' ORDER BY dtl_pemesan.tgl_tayang ASC, sesi.mulai ASC");
							
							$no = 1;
							foreach ($sql_aktif as $row) {
						?>
						<tr>
							<td><?php echo $no++; ?></td>
							<td><?php echo $row['judul']; ?></td>
							<td><?php echo date('d F Y', strtotime($row['tanggal_pilih'] ? $row['tanggal_pilih'] : $row['tanggal_tayang'])); ?></td>
							<td><?php echo $row['jam_pilih'] ? substr($row['jam_pilih'],0,5) : substr($row['jam_tayang'],0,5); ?></td>
							<td><?php echo $row['kursi']; ?></td>
							<td>
								<a href="admin/views/p_tiket.php?id=<?php echo $row['id_dtl_pemesan']; ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i> Cetak</a>
								<a href="models/h_tiket_dashboard.php?id=<?php echo $row['id_dtl_pemesan']; ?>" onclick="return confirm('Yakin ingin menghapus tiket ini?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>

			<!-- DAFTAR TRANSAKSI -->
			<div role="tabpanel" class="tab-pane" id="transaksi">
				<h3>Riwayat Transaksi</h3>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>ID Pemesanan</th>
							<th>Tanggal Pesan</th>
							<th>Total Tiket</th>
							<th>Total Harga</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$sql_hist = $proses->tampil("*", "pemesan", "WHERE id_member = '$id_member' AND status = '2' ORDER BY tgl_pesan DESC");
							foreach ($sql_hist as $hist) {
						?>
						<tr>
							<td><?php echo $hist['id_pemesan']; ?></td>
							<td><?php echo $hist['tgl_pesan']; ?></td>
							<td><?php echo $hist['jml_tiket_pesan']; ?></td>
							<td>Rp. <?php echo number_format($hist['total_harga'], 2, ',', '.'); ?></td>
							<td>
								<?php 
									if ($hist['status'] == '2') echo '<span class="label label-success">Lunas</span>';
									else echo '<span class="label label-warning">Pending</span>';
								?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="assets/bootstrap/js/jquery-1.11.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.js"></script>

</body>
</html>
