
<div class="general-agileits-w3l">
	<div class="w3l-medile-movies-grids">
		<div class="movie-browsing-box">
			<div class="browse-agile-w3ls general-w3ls">
				<div class="tittle-head">
					<h3 class="tittle">A-Z List of <span>Movies</span></h3>
					<div class="clearfix"> </div>
				</div>
				<div class="container" style="text-align: center; margin-bottom: 30px;">
					<?php
					$letters = range('A', 'Z');
					echo '<a href="index.php?p=az_list" class="btn btn-default" style="margin: 2px;">ALL</a>';
					foreach ($letters as $letter) {
						echo '<a href="index.php?p=az_list&letter=' . $letter . '" class="btn btn-default" style="margin: 2px;">' . $letter . '</a>';
					}
					?>
				</div>
			</div>
			
			<div class="wthree_agile-requested-movies">
				<?php
				$where = "";
				if (isset($_GET['letter'])) {
					$letter = $_GET['letter'];
					$where = "WHERE judul LIKE '$letter%'";
				}
				$order = "ORDER BY judul ASC";
				
				$movies = $proses->tampil("*", "film", "$where $order");
				if ($movies->rowCount() > 0) {
					foreach ($movies as $dt) {
				?>
						<div class="col-md-2 w3l-movie-gride-agile requested-movies">
							<a href="views/info_film.php?id=<?php echo $dt[0]; ?>" class="hvr-sweep-to-bottom"><img src="admin/assets/img/film/<?php echo $dt['gambar']; ?>" class="img-responsive" title="<?php echo $dt['judul'] ?>" style="height: 250px;width: 260px;" alt=" ">
								<div class="w3l-action-icon"><i class="fa fa-play-circle-o" aria-hidden="true"></i></div>
							</a>
							<div class="mid-1 agileits_w3layouts_mid_1_home">
								<div class="w3l-movie-text">
									<h6><a href="views/info_film.php?id=<?php echo $dt[0]; ?>"><?php echo $dt['judul'] ?></a></h6>
								</div>
								<div class="mid-2 agile_mid_2_home">
									<p><?php echo $dt['rilis']; ?></p>
									<p style="margin-left: 58px;"><?php echo $dt['rating']; ?></p>
									<p style="float: right;color: red;font-weight: bold;"><?php echo $dt['score']; ?></p>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
				<?php
					}
				} else {
					echo '<div class="alert alert-warning" role="alert" style="text-align: center;">No movies found.</div>';
				}
				?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
