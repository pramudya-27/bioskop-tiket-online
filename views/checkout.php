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
		.logo-container {
			height: 60px;
			display: flex;
			align-items: center;
			justify-content: center;
			margin-bottom: 20px;
		}
		.payment-logo {
			max-height: 100%;
			max-width: 150px;
			display: none; /* Hidden by default */
		}
		.payment-logo.active {
			display: block;
		}
		.amount {
			font-size: 24px;
			font-weight: bold;
			color: #1fa39a;
			margin: 20px 0;
		}
		.payment-options {
			text-align: left;
			margin: 20px 0;
			border-top: 1px solid #eee;
			border-bottom: 1px solid #eee;
			padding: 15px 0;
		}
		.payment-option {
			display: flex;
			align-items: center;
			padding: 10px;
			cursor: pointer;
			border-radius: 5px;
			transition: background 0.2s;
		}
		.payment-option:hover {
			background-color: #f9f9f9;
		}
		.payment-option input[type="radio"] {
			margin-right: 15px;
			transform: scale(1.2);
			accent-color: #1fa39a;
		}
		.payment-option label {
			margin-bottom: 0;
			cursor: pointer;
			flex-grow: 1;
			font-weight: 500;
		}
		.btn-pay {
			background-color: #ccc; /* Default disabled color */
			color: #fff;
			font-weight: bold;
			width: 100%;
			padding: 10px;
			border: none;
			border-radius: 5px;
			font-size: 18px;
			cursor: not-allowed;
			transition: all 0.3s;
		}
		.btn-pay.active {
			background-color: #1a1a1a;
			cursor: pointer;
		}
		.btn-pay.active:hover {
			opacity: 0.9;
		}
		/* Specific colors for when valid */
		.btn-pay.dana { background-color: #108ee9; }
		.btn-pay.shopeepay { background-color: #ee4d2d; }
		.btn-pay.gopay { background-color: #00aed6; }

	</style>
</head>
<body>

	<div class="payment-box">
		<div class="logo-container">
			<!-- Logos can be swapped or shown based on selection. For now using text or generic placeholder if no image -->
			<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png" id="logo-dana" class="payment-logo" alt="DANA">
			<img src="https://upload.wikimedia.org/wikipedia/commons/f/fe/Shopee.svg" id="logo-shopeepay" class="payment-logo" alt="ShopeePay" style="width: 120px;">
			<img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" id="logo-gopay" class="payment-logo" alt="GoPay" style="width: 120px;">
			<h3 id="logo-placeholder" style="color: #ccc; margin: 0;">Pilih Pembayaran</h3>
		</div>
		
		<h3>Konfirmasi Pembayaran</h3>
		<p>Total Pembayaran:</p>
		<div class="amount">Rp. <?php echo number_format($t_harga, 2, ',', '.'); ?></div>
		
		<div class="payment-options">
			<p style="margin-bottom: 15px; font-weight: bold;">Pilih Metode Pembayaran:</p>
			
			<div class="payment-option" onclick="selectPayment('dana')">
				<input type="radio" name="payment_method" id="dana" value="dana">
				<label for="dana">DANA</label>
			</div>
			
			<div class="payment-option" onclick="selectPayment('shopeepay')">
				<input type="radio" name="payment_method" id="shopeepay" value="shopeepay">
				<label for="shopeepay">ShopeePay</label>
			</div>
			
			<div class="payment-option" onclick="selectPayment('gopay')">
				<input type="radio" name="payment_method" id="gopay" value="gopay">
				<label for="gopay">GoPay</label>
			</div>
		</div>

		<p>Metode Pembayaran: <strong id="selected-method-text">-</strong></p>
		
		<form action="../models/s_pesan.php" method="post" id="paymentForm">
			<input type="hidden" name="id_pemesan" value="<?php echo $id_pemesan; ?>">
			<input type="hidden" name="t_harga" value="<?php echo $t_harga; ?>">
			<input type="hidden" name="jm_tiket" value="<?php echo $jm_tiket; ?>">
			<input type="hidden" name="id_member" value="<?php echo $id_member; ?>">
			<!-- Although not saved to DB yet, we send it just in case -->
			<input type="hidden" name="metode_pembayaran" id="input_metode">
			
			<button type="button" class="btn-pay" onclick="processPayment()" disabled>BAYAR SEKARANG</button>
		</form>
	</div>

	<script>
		function selectPayment(method) {
			// Check the radio button
			document.getElementById(method).checked = true;
			document.getElementById('input_metode').value = method;

			// Update Text
			var displayText = "";
			if(method === 'dana') displayText = "DANA";
			else if(method === 'shopeepay') displayText = "ShopeePay";
			else if(method === 'gopay') displayText = "GoPay";
			document.getElementById('selected-method-text').innerText = displayText;

			// Update Logo
			document.querySelectorAll('.payment-logo').forEach(el => el.classList.remove('active'));
			document.getElementById('logo-placeholder').style.display = 'none';
			document.getElementById('logo-' + method).classList.add('active');

			// Enable Button and style it
			var btn = document.querySelector('.btn-pay');
			btn.disabled = false;
			btn.classList.add('active');
			
			// Remove old color classes
			btn.classList.remove('dana', 'shopeepay', 'gopay');
			// Add new color class
			btn.classList.add(method);
		}

		function processPayment() {
			var method = document.querySelector('input[name="payment_method"]:checked');
			if (!method) {
				alert("Silakan pilih metode pembayaran terlebih dahulu!");
				return;
			}

			var btn = document.querySelector('.btn-pay');
			btn.innerHTML = "Memproses...";
			btn.disabled = true;
			btn.style.opacity = "0.7";

			// Simulate processing delay
			setTimeout(function() {
				alert("Pembayaran via " + method.value.toUpperCase() + " Berhasil! Mengalihkan...");
				document.getElementById('paymentForm').submit();
			}, 2000);
		}
	</script>

</body>
</html>
