<?php
	include '../config/crud.php';
	include '../models/login.php';

	$sql4 = $proses->tampil("MAX(id_pemesan) as kode","pemesan","");
	$dt4 = $sql4->fetch();
	$kode = $dt4['kode'];
    
    if ($kode) {
	    $nu = (int) substr($kode, 4,5);
    } else {
        $nu = 0;
    }
	$nu++;

	$char = "PMSN";
	$newid = $char . sprintf("%05s",$nu);

    // 1. Fetch Film & Tiket
	$qi = $proses->tampil("film.*, tiket.id_tiket, tiket.harga, tiket.stok","film,tiket","WHERE film.id_film ='$_GET[id]' AND film.id_tiket = tiket.id_tiket");
	$di = $qi->fetch();

	if (!$di) {
        echo "<script>alert('Data film belum lengkap!'); window.location='../index.php';</script>";
        exit;
    }

    // 2. Fetch All Schedules (Jadwal) for this film
    // Join with Sesi and Ruang to get times and capacity
    $q_jadwal = $proses->tampil("jadwal.*, sesi.sesi as nama_sesi, sesi.mulai, sesi.selesai, ruang.jm_kursi", 
                                "jadwal, sesi, ruang", 
                                "WHERE jadwal.id_film = '$_GET[id]' AND jadwal.id_sesi = sesi.id_sesi AND jadwal.id_ruang = ruang.id_ruang");
    
    $schedules = [];
    $min_date = null;
    $max_date = null;

    // Use fetchAll if available, or loop
    // connect is PDO.
    while ($row = $q_jadwal->fetch(PDO::FETCH_ASSOC)) {
        $schedules[] = $row;
        
        // Calculate global min/max date
        $start = $row['tgl_mulai'];
        $end = $row['tgl_berhenti'];
        
        if ($min_date === null || $start < $min_date) $min_date = $start;
        if ($max_date === null || $end > $max_date) $max_date = $end;
    }
    
    // If no schedules found
    if (empty($schedules)) {
         echo "<script>alert('Belum ada jadwal untuk film ini.'); window.location='../index.php';</script>";
         exit;
    }

	if (isset($_SESSION['id'])) {
		$hidden = "hidden";
		$akun = "";
	}else{
		$hidden = "";
		$akun = "hidden";
	}
 ?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $di['judul']; ?></title>
<link rel="stylesheet" type="text/css" href="../assets/css/film.css">
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Movies Place" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="../assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!-- pop-up -->
<link href="../assets/bootstrap/css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
<!-- //pop-up -->
<link href="../assets/bootstrap/css/easy-responsive-tabs.css" rel='stylesheet' type='text/css'/>
<link rel="stylesheet" type="text/css" href="../assets/bootstrap/css/zoomslider.css" />
<link rel="stylesheet" type="text/css" href="../assets/bootstrap/css/style.css" />
<link href="../assets/bootstrap/css/font-awesome.css" rel="stylesheet"> 
<script type="text/javascript" src="../assets/bootstrap/js/modernizr-2.6.2.min.js"></script>
<!--/web-fonts-->
<link href='//fonts.googleapis.com/css?family=Tangerine:400,700' rel='stylesheet' type='text/css'>
<link href="//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900" rel="stylesheet">
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<!--//web-fonts-->
</head>
<body>
<!--/main-header-->
  <!--/banner-section-->
	<div id="demo-1" class="banner-inner" style="background: url(../admin/assets/img/film/<?php echo $di['gambar'] ?>) no-repeat 0px 0px;background-size: cover;background-position: center;">
	 <div class="banner-inner-dott">
		<!--/header-w3l-->
			   <div class="header-w3-agileits" id="home">
			     <div class="inner-header-agile part2">	
				<nav class="navbar navbar-default">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<h1><a  href="../index.php"><span>I</span>tpln <span>M</span>ovies</a></h1>
					</div>
					<!-- navbar-header -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
							<li><a href="../index.php">Home</a></li>
								<li><a href="#" >A - z list</a></li>
						</ul>

					</div>
					<div class="clearfix"> </div>	
				</nav>
					<div class="w3ls_search">
						<div class="cd-main-header">
							<ul class="cd-header-buttons">
								<li><a class="cd-search-trigger" href="#cd-search"> <span></span></a></li>
							</ul> <!-- cd-header-buttons -->
						</div>
						<div id="cd-search" class="cd-search">
							<form action="#" method="post">
								<input name="Search" type="search" placeholder="Search...">
							</form>
						</div>
					</div>
				</div> 
			</div>
		<!--//header-w3l-->
		</div>
    </div>
  <!--/banner-section-->
 <!--//main-header-->
						<div class="modal fade" id="kranjang" tabindex="-1" role="dialog" >
							<div class="modal-dialog" style="width: 80%;">
							<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4>Daftar Belanja</h4>
										<div class="login-form">
											<form action="../models/s_pesan.php" method="post">
												<table class="table">
												<?php
													$sql1 = $proses->tampil("*","dtl_pemesan","WHERE dtl_pemesan.id_pemesan = '$newid'");
													$row1 = $sql1->rowCount();

													$sql3 = $proses->tampil("SUM(tiket.harga)","tiket,dtl_pemesan","WHERE tiket.id_tiket = dtl_pemesan.id_tiket AND dtl_pemesan.id_pemesan = '$newid' ");
													$dt3 = $sql3->fetch();

												 	$no = "1";

													$sql2 = $proses->tampil("*","film,tiket,dtl_pemesan","WHERE film.id_tiket = tiket.id_tiket AND tiket.id_tiket = dtl_pemesan.id_tiket AND dtl_pemesan.id_pemesan = '$newid'");
													foreach ($sql2 as $dt2) {
												 ?>
													<tr>
														<td><?php echo $no++; ?></td>
														<td><?php echo $dt2['judul']; ?></td>
														<td><?php echo $dt2['rilis']; ?></td>														<td>No Kursi : <?php echo $dt2['kursi']; ?></td>
														<td>No Kursi : <?php echo $dt2['kursi']; ?></td>
														<td>Rp. <?php echo number_format($dt2['harga'],2,",","."); ?></td>
														<td><a href="../models/h_dtl_pesan.php?id=<?php echo $dt2['id_dtl_pemesan']; ?>" class="btn btn-danger btn-sm">DELETE</a></td>
													</tr>
													
												<?php } ?>
												</table>
													<input type="hidden" name="id_pemesan" value="<?php echo $newid; ?>">
													<input type="hidden" name="id_member" value="<?php echo $_SESSION['id']; ?>">
													<input type="hidden" name="jm_tiket" value="<?php echo $row1; ?>">
													<input type="hidden" name="t_harga" value="<?php echo $dt3[0]; ?>">
												<?php if ($row1 > 0) { ?>
												<div class="tp" style="width: 100px;">
													<input type="submit" value="Beli" class="btn btn-success btn-block">
												</div>
												<?php } ?>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
	         <!--/banner-bottom-->
			  <div class="w3_agilits_banner_bootm">
			     <div class="w3_agilits_inner_bottom">
			            <div class="col-md-6 wthree_agile_login">
						     <ul>
									<li><a href="#" class="login"  data-toggle="modal" data-target="#myModal4" <?php echo $hidden; ?> >Login</a></li>
									<li><a href="#" class="login reg"  data-toggle="modal" data-target="#myModal5" <?php echo $hidden; ?> >Register</a></li>
									<div style="margin-top: -20px;" <?php echo $akun; ?>>
										
										<li class="dropdown">
											<a href="#"  class="dropdown-toggle" data-toggle="dropdown" style="color: #fff;" >ACCOUNT <b class="caret"></b></a>
											<ul class="dropdown-menu multi-column columns-3" style="width: 200px;">
												<li>
												<div class="col-sm-4">
													<ul class="multi-column-dropdown">
														<li><a href="../models/logout.php" >LOGOUT</a></li>
													</ul>
												</div>
												</li>
											</ul>
										</li>

									</div>

								</ul>
						</div>
								<button style="padding: 5px 18px;border:1px;background-color: #000;color:#fff;text-transform: uppercase;float: right;font-size: 15px;" data-toggle="modal" data-target="#kranjang" <?php echo $akun; ?> >Keranjang</button>
						
				</div>
			</div>
			<!--//banner-bottom-->
		     <!-- Modal1 -->
					<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" >

							<div class="modal-dialog">
							<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4>Login</h4>
										<div class="login-form">
											<form action="../models/login.php" method="post">
												<input type="email" name="email" placeholder="E-mail" required="">
												<input type="password" name="pass" placeholder="Password" required="">
												<div class="tp">
													<input type="submit" name="login" value="LOGIN NOW">
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
				<!-- //Modal1 -->
				  <!-- Modal1 -->
					<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" >

							<div class="modal-dialog">
							<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4>Register</h4>
										<div class="login-form">
											<form action="../models/s_member.php" method="post">
											    <input type="text" name="nama" placeholder="Name" required="">
												<input type="email" name="email" placeholder="E-mail" required="">
												<input type="text" name="tgl_lahir" id="tgl_lahir" placeholder="Date Birth">
												<input type="radio" name="jk" value="Laki-laki">Laki-laki
												<input type="radio" name="jk" value="Perempuan">Perempuan
												<input type="password" name="pass" placeholder="Password" required="">
												<div class="tp">
													<input type="submit" value="REGISTER NOW">
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
						
				<!-- //Modal1 -->
						<!-- breadcrumb -->
	<div class="w3_breadcrumb">
	<div class="breadcrumb-inner">	
			<ul>
				<li><a href="../index.php">Home</a><i>//</i></li>
				
				<li>Single</li>
			</ul>
		</div>
	</div>
<!-- //breadcrumb -->

						<div class="modal fade" id="add" tabindex="-1" role="dialog" >
							<div class="modal-dialog">
							<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4>Pilih Nomor Kursi</h4>
										<br>
										<div class="login-form">
											<form action="../models/s_dtl_pesan.php" method="post" id="bookingForm">
												<input type="hidden" name="tiket" id="id_tiket" value="<?php echo $di['id_tiket']; ?>">
												<input type="hidden" name="pemesan" value="<?php echo $newid; ?>">
												
												<div class="form-group">
													<label>Pilih Tanggal</label>
													<input type="text" name="tgl_tayang" id="datepicker_film" class="number" placeholder="Pilih Tanggal" required autocomplete="off">
												</div>

												<div class="form-group">
													<label>Pilih Sesi</label>
													<select name="sesi" id="sesi_select" class="number" required>
                                                        <option value="">Pilih Tanggal Terlebih Dahulu</option>
													</select>
												</div>


												<div class="form-group">
													<label>Pilih Nomor Kursi</label>
													<!-- Visual Seat Picker Container -->
													<div id="seat_map_container">
														<div class="seat-legend">
															<span class="legend-item"><span class="seat available"></span> Tersedia</span>
															<span class="legend-item"><span class="seat occupied"></span> Terisi</span>
															<span class="legend-item"><span class="seat selected"></span> Dipilih</span>
														</div>
														<div id="seat_grid" class="seat-grid"></div>
													</div>
													<input type="hidden" name="kursi" id="input_kursi" required>
													<p id="selected_seat_display" style="margin-top: 5px; font-weight: bold;">Kursi dipilih: -</p>
												</div>
												<div class="tp" style="width: 100px;">
													<input type="submit" value="ADD">
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
						<style type="text/css">
							.number{
								border:1px solid #999999;
								width: 100%;
								height: 50px;
								text-align: center;
							}
							/* Seat Picker CSS */
							#seat_map_container {
								margin-top: 10px;
								border: 1px solid #ddd;
								padding: 10px;
								border-radius: 5px;
								background: #f9f9f9;
							}
							.seat-legend {
								display: flex;
								gap: 15px;
								margin-bottom: 10px;
								justify-content: center;
								font-size: 12px;
							}
							.legend-item {
								display: flex;
								align-items: center;
								gap: 5px;
							}
							.seat-grid {
								display: grid;
								grid-template-columns: repeat(5, 1fr); /* 5 columns default */
								gap: 10px;
								max-height: 300px;
								overflow-y: auto;
								padding: 5px;
							}
							.seat {
								height: 40px;
								display: flex;
								align-items: center;
								justify-content: center;
								border: 1px solid #ccc;
								border-radius: 5px;
								cursor: pointer;
								font-size: 12px;
								font-weight: bold;
								transition: all 0.2s;
							}
							.seat.available {
								background-color: #fff;
								color: #333;
							}
							.seat.occupied {
								background-color: #d9534f; /* Red for occupied */
								color: #fff;
								cursor: not-allowed;
								border-color: #d43f3a;
							}
							.seat.selected {
								background-color: #4CAF50; /* Green for selected */
								color: white;
								border-color: #45a049;
							}
							.seat:hover:not(.occupied):not(.selected) {
								background-color: #f0f0f0;
							}
						</style>

				<div class="w3_content_agilleinfo_inner">
					<div class="agile_featured_movies">
						<div class="latest-news-agile-info">
							<div class="col-md-8 latest-news-agile-left-content">
								<div class="single video_agile_player">
									<div class="video-grid-single-page-agileits" style="float: left;">
									<img src="../admin/assets/img/film/<?php echo $di['gambar'] ?>" alt="" class="img-responsive" style="width: 300px;height: 400px;" title="<?php echo $di['judul']; ?>" />
									</div>
										<div class="info">
											<h4 style="font-size: 30px; margin: 0px;"><?php echo $di['judul']; ?></h4>
											<p class="bar-kusus"><?php echo substr($di['durasi'] ?? '',0,5); ?> | Rp.<?php echo number_format($di['harga'],2,",","."); ?> | <?php echo date('d F Y', strtotime($min_date)); ?> - <?php echo date('d F Y', strtotime($max_date)); ?></p>
											<fieldset>
												<legend>Summary</legend>
												<p><?php echo $di['sinopsis']; ?></p>
											</fieldset>
											<button class="buy" data-toggle="modal" data-target="#add" <?php echo $akun; ?> >ADD</button>
										</div>
								</div>
							</div>
						</div>
							<div class="clearfix"> </div>
					</div>
				</div>
			<!--//content-inner-section-->
<style type="text/css">
	.buy{
		width: 100px;
		padding: 8px 0px;
		border:1px;
		float: right;
		background-color: #1fa39a;
		color: #fff;
		-webkit-transition:all 0.3s;
	}
	.buy:hover{
		background-color: #24ccad;
		-webkit-transition:all 0.3s;
	}
	.bar-kusus{
		padding: 4px 0px; 
		border:1px solid #eee;
		width: 457px;
		text-align: center;
		border-radius: 25px;
	}
</style>

	<!--/footer-bottom-->
			<div class="w3agile_footer_copy">
				    <p>© 2026 Itpln Movies. All rights reserved | Design by CREATE TABLE </a></p>
			</div>
		<a href="#home" id="toTop" class="scroll" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>

<script src="../assets/bootstrap/js/jquery-1.11.1.min.js"></script>
	<!-- Dropdown-Menu-JavaScript -->
			<script>
				$(document).ready(function(){
					$(".dropdown").hover(            
						function() {
							$('.dropdown-menu', this).stop( true, true ).slideDown("fast");
							$(this).toggleClass('open');        
						},
						function() {
							$('.dropdown-menu', this).stop( true, true ).slideUp("fast");
							$(this).toggleClass('open');       
						}
					);
				});
			</script>
		<!-- //Dropdown-Menu-JavaScript -->
		<!-- search-jQuery -->
				<script src="../assets/bootstrap/js/main.js"></script>
			
			<script src="../assets/bootstrap/js/simplePlayer.js"></script>
			<script>
				$("document").ready(function() {
					$("#video").simplePlayer();
				});
			</script>
			<script>
				$("document").ready(function() {
					$("#video1").simplePlayer();
				});
			</script>
			<script>
				$("document").ready(function() {
					$("#video2").simplePlayer();
				});
			</script>
				<script>
				$("document").ready(function() {
					$("#video3").simplePlayer();
				});
			</script>
			<script>
				$("document").ready(function() {
					$("#video4").simplePlayer();
				});
			</script>
			<script>
				$("document").ready(function() {
					$("#video5").simplePlayer();
				});
			</script>
			<script>
				$("document").ready(function() {
					$("#video6").simplePlayer();
				});
			</script>
			<script>
				$("document").ready(function() {
					$("#video6").simplePlayer();
				});
			</script>

			<!-- pop-up-box -->  
		<script src="../assets/bootstrap/js/jquery.magnific-popup.js" type="text/javascript"></script>
	<!--//pop-up-box -->
	<script>
		$(document).ready(function() {
		$('.w3_play_icon,.w3_play_icon1,.w3_play_icon2').magnificPopup({
			type: 'inline',
			fixedContentPos: false,
			fixedBgPos: true,
			overflowY: 'auto',
			closeBtnInside: true,
			preloader: false,
			midClick: true,
			removalDelay: 300,
			mainClass: 'my-mfp-zoom-in'
		});
																		
		});
	</script>
<script src="../assets/bootstrap/js/easy-responsive-tabs.js"></script>
<script>
$(document).ready(function () {
$('#horizontalTab').easyResponsiveTabs({
type: 'default', //Types: default, vertical, accordion           
width: 'auto', //auto or any width like 600px
fit: true,   // 100% fit in a container
closed: 'accordion', // Start closed if in accordion view
activate: function(event) { // Callback function if tab is switched
var $tab = $(this);
var $info = $('#tabInfo');
var $name = $('span', $info);
$name.text($tab.text());
$info.show();
}
});
$('#verticalTab').easyResponsiveTabs({
type: 'vertical',
width: 'auto',
fit: true
});
});
</script>
<link href="../assets/bootstrap/css/owl.carousel.css" rel="stylesheet" type="text/css" media="all">
<script src="../assets/bootstrap/js/owl.carousel.js"></script>
<script>
	$(document).ready(function() { 
		$("#owl-demo").owlCarousel({
	 
		 autoPlay: 3000, //Set AutoPlay to 3 seconds
		  autoPlay : true,
		   navigation :true,

		  items : 5,
		  itemsDesktop : [640,4],
		  itemsDesktopSmall : [414,3]
	 
		});
	 
	}); 
</script> 

<!--/script-->
<script type="text/javascript" src="../assets/bootstrap/js/move-top.js"></script>
<script type="text/javascript" src="../assets/bootstrap/js/easing.js"></script>

<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},900);
				});
			});
</script>
 <script type="text/javascript">
						$(document).ready(function() {
							/*
							var defaults = {
					  			containerID: 'toTop', // fading element id
								containerHoverID: 'toTopHover', // fading element hover id
								scrollSpeed: 1200,
								easingType: 'linear' 
					 		};
							*/
							
							$().UItoTop({ easingType: 'easeOutQuart' });
							
						});
					</script>
<!--end-smooth-scrolling-->
	<script src="../assets/bootstrap/js/bootstrap.js"></script>

 

</body>
</html>
<link rel="stylesheet" type="text/css" href="../assets/js/jquery-ui.css">
<script type="text/javascript" src="../assets/js/jquery-ui.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$("#tgl_lahir").datepicker({dateFormat:"yy/mm/dd",changeYear:true,changeMonth:true,yearRange:"-50:"});

        // Backend Data injected into JS
        var schedules = <?php echo json_encode($schedules); ?>;
        // Format: [{id_jadwal, tgl_mulai, tgl_berhenti, id_sesi, id_ruang, nama_sesi, mulai, selesai, jm_kursi}, ...]

		// Config datepicker for film
        // Use Global Min/Max from PHP
		var minDate = new Date("<?php echo $min_date; ?>");
		var maxDate = new Date("<?php echo $max_date; ?>");
		
        var selectedSchedule = null;
        var total_seats = 0;

		$("#datepicker_film").datepicker({
			dateFormat: "yy-mm-dd",
			minDate: minDate,
			maxDate: maxDate,
			onSelect: function(dateText) {
                updateSessionDropdown(dateText);
				loadSeats();
			}
		});

        function updateSessionDropdown(dateText) {
            var select = $("#sesi_select");
            select.empty();
            select.append('<option value="">Pilih Sesi</option>');
            
            var selectedDate = new Date(dateText);
            
            // Filter schedules that cover this date
            var availableSchedules = schedules.filter(function(sch) {
                var start = new Date(sch.tgl_mulai);
                var end = new Date(sch.tgl_berhenti);
                return selectedDate >= start && selectedDate <= end;
            });
            
            if (availableSchedules.length === 0) {
                 select.append('<option value="">Tidak ada jadwal pada tanggal ini</option>');
                 return;
            }

            availableSchedules.forEach(function(sch) {
                select.append('<option value="' + sch.id_sesi + '" data-ruang="' + sch.id_ruang + '" data-seats="' + sch.jm_kursi + '">' + sch.mulai + ' - ' + sch.selesai + '</option>');
            });
        }

		// Event Listener for Session Change
		$("#sesi_select").change(function() {
            var option = $(this).find(':selected');
            var seats = option.data('seats');
            if (seats) {
                total_seats = parseInt(seats);
            }
			loadSeats();
		});

		
		function loadSeats() {
			var date = $("#datepicker_film").val();
			var session = $("#sesi_select").val();
			var ticket_id = $("#id_tiket").val();

			// Always render grid skeleton
			var occupiedSeats = [];
            
            // If date/session is selected, fetch real availability
			if (date && session) {
				$.ajax({
					url: '../models/get_seats.php',
					type: 'POST',
					data: {
						tgl_mulai: date,
						id_sesi: session,
						id_tiket: ticket_id
					},
					dataType: 'json',
					success: function(data) {
                        if (data.error) {
                            alert("Error: " + data.error);
                            renderGrid([], true);
                        } else {
						    renderGrid(data, true);
                        }
					},
					error: function(xhr, status, error) {
						console.error("Ajax Error:", status, error, xhr.responseText);
                        // Try to parse JSON response text if available
                        var errorMsg = error;
                        try {
                            var json = JSON.parse(xhr.responseText);
                            if (json.error) errorMsg = json.error;
                        } catch(e) {}
                        
						alert("Gagal memuat data kursi: " + errorMsg);
						renderGrid([], true);
					}
				});
			} else {
                renderGrid([], false);
            }
		}

		function renderGrid(occupiedSeats, isReady) {
			var grid = $("#seat_grid");
			grid.empty();
			
            if (total_seats === 0) {
                 grid.html('<p style="grid-column: 1/-1; text-align: center;">Silakan pilih tanggal dan sesi.</p>');
                 return;
            }

			for (var i = 1; i <= total_seats; i++) {
				// Pastikan i dibaca sebagai angka agar cocok dengan data array
				var isOccupied = occupiedSeats.includes(parseInt(i));
				
				var cssClass = isOccupied ? "seat occupied" : "seat available";
				var title = isOccupied ? "Kursi " + i + " (Terisi)" : "Kursi " + i;
				
				// --- [PERUBAHAN UTAMA DI SINI] ---
				// Jika kursi terisi (isOccupied), isi teks dengan "X"
				// Jika kursi kosong, isi teks dengan nomor kursi (i)
				var seatLabel = isOccupied ? "X" : i;

				// Masukkan variable seatLabel ke dalam HTML
				var seatBtn = $('<div class="' + cssClass + '" data-seat="' + i + '" title="' + title + '" style="color: #000;">' + seatLabel + '</div>');
				
				if (!isOccupied) {
					seatBtn.click(function() {
                        if (!$("#datepicker_film").val() || !$("#sesi_select").val()) {
                            alert("Silakan pilih tanggal dan sesi terlebih dahulu!");
                            return;
                        }
						$(".seat.selected").removeClass("selected").addClass("available"); 
						$(this).removeClass("available").addClass("selected");
						var seatNum = $(this).data("seat");
						$("#input_kursi").val(seatNum);
						$("#selected_seat_display").text("Kursi dipilih: " + seatNum);
					});
				}

				grid.append(seatBtn);
			}
		}
        // Initial Load
        loadSeats();
	})
</script>