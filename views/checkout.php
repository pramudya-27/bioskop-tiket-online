<?php 
	include '../config/crud.php';
	// Validate session
	session_start();
	if (!isset($_SESSION['id'])) {
		header("location: ../index.php");
	}

	$id_pemesan = $_POST['id_pemesan'];
	$t_harga    = $_POST['t_harga'];
	$jm_tiket   = $_POST['jm_tiket'];
	$id_member  = $_POST['id_member'];
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Checkout - Movies Place</title>
	<link href="../assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<style>
		body { background-color: #f5f5f5; font-family: 'Montserrat', sans-serif; }
		.payment-box {
			background: #fff;
			margin: 50px auto;
			padding: 30px;
			width: 500px;
			box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
			border-radius: 8px;
			text-align: center;
		}
		.dana-logo {
			width: 150px;
			margin-bottom: 20px;
		}
		.amount {
			font-size: 24px;
			font-weight: bold;
			color: #1fa39a;
			margin: 20px 0;
		}
		.btn-pay {
			background-color: #108ee9; /* DANA Blue */
			color: #fff;
			font-weight: bold;
			width: 100%;
			padding: 10px;
			border: none;
			border-radius: 5px;
			font-size: 18px;
		}
		.btn-pay:hover {
			background-color: #0d74be;
			color: #fff;
		}
	</style>
</head>
<body>

	<div class="payment-box">
		<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png" class="dana-logo" alt="DANA">
		
		<h3>Konfirmasi Pembayaran</h3>
		<p>Total Pembayaran:</p>
		<div class="amount">Rp. <?php echo number_format($t_harga, 2, ',', '.'); ?></div>
		
		<p>Metode Pembayaran: <strong>DANA</strong></p>
		
		<form action="../models/s_pesan.php" method="post" id="paymentForm">
			<input type="hidden" name="id_pemesan" value="<?php echo $id_pemesan; ?>">
			<input type="hidden" name="t_harga" value="<?php echo $t_harga; ?>">
			<input type="hidden" name="jm_tiket" value="<?php echo $jm_tiket; ?>">
			<input type="hidden" name="id_member" value="<?php echo $id_member; ?>">
			
			<button type="button" class="btn-pay" onclick="processPayment()">BAYAR SEKARANG</button>
		</form>
	</div>

	<script>
		function processPayment() {
			var btn = document.querySelector('.btn-pay');
			btn.innerHTML = "Memproses...";
			btn.disabled = true;

			// Simulate processing delay
			setTimeout(function() {
				alert("Pembayaran Berhasil! Mengalihkan...");
				document.getElementById('paymentForm').submit();
			}, 2000);
		}
	</script>

</body>
</html>
