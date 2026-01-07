<?php 
	include_once "../../config/crud.php";
	$sql = $proses->tampil("*, sesi_pilih.mulai as jam_pilih",
		"dtl_pemesan 
		JOIN tiket ON dtl_pemesan.id_tiket = tiket.id_tiket 
		JOIN film ON tiket.id_film = film.id_film 
		JOIN jadwal ON film.id_jadwal = jadwal.id_jadwal 
		JOIN ruang ON jadwal.id_ruang = ruang.id_ruang 
		JOIN sesi ON jadwal.id_sesi = sesi.id_sesi 
		LEFT JOIN sesi as sesi_pilih ON dtl_pemesan.id_sesi = sesi_pilih.id_sesi",
		"WHERE dtl_pemesan.id_dtl_pemesan = '$_GET[id]'");
	$dt = $sql->fetch();
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Cetak Tiket</title>
 </head>
 <body>
 	<div class="box-tiket">
 		<div class="kepala-tiket">
 			<h1>Movie Place Cinema</h1>
 		</div>
 		<div class="isi">
 			<h2><?php echo $dt['judul']; ?></h2>
 			<table>
 				<tr>
 					<td>DATE</td>
 					<td>:</td>
 					<td id="font"><?php echo date("d F Y",strtotime($dt['tgl_tayang'] ? $dt['tgl_tayang'] : $dt['tgl_mulai'])); ?></td>
 				</tr>
 				<tr>
 					<td>TIME</td>
 					<td>:</td>
 					<td id="font"><?php echo substr($dt['jam_pilih'] ? $dt['jam_pilih'] : $dt['mulai'], 0,5) ?></td>
 				</tr>
 				<tr>
 					<td>KURSI</td>
 					<td>:</td>
 					<td id="font"><?php echo $dt['kursi']; ?></td>
 				</tr>
 				<tr>
 					<td>HARGA</td>
 					<td>:</td>
 					<td> Rp.<?php echo number_format($dt['harga'],2,",","."); ?></td>
 				</tr>
 			</table>	
 		</div>
 		<div class="sesi">
 			<h1><?php echo $dt['sesi']; ?></h1>
 		</div>
 	</div>
 </body>
 </html>
 <style type="text/css">
 	.box-tiket{
 		position: absolute;
 		width: 400px;
 		height: 350px;
 		color: #4c4447;
 		font-family: lucida console;
 		background-color: #ebf3f4;
 	}
 	.kepala-tiket{
 		width: 100%;
 		height: 100px;
 		text-align: center;
 		font-size: 18px;
 		border-bottom: 3px solid #4c4447;
 	}
 	.kepala-tiket h1{
 		padding: 15px;
 	}
 	.isi{
 		padding: 20px;
 		float: left;
 	}
 	.sesi{
 		float: left;
 		padding: 0px;
 		margin:0px;
 	}
 	.sesi h1{
 		font-size: 130px;
 	}
 	#font{
 		font-size: 25px;
 		font-weight: bold;
 	}
 </style>
 <script type="text/javascript">
 	window.load=b_print();
	function b_print(){
		window.print();
	};
 </script>