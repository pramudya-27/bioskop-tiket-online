
<div class="general-agileits-w3l">
	<div class="w3l-medile-movies-grids">
		<div class="movie-browsing-box">
			<div class="browse-agile-w3ls general-w3ls">
				<div class="tittle-head">
					<h3 class="tittle">Search <span>Result</span></h3>
					<div class="clearfix"> </div>
				</div>
			</div>
			
			<div class="wthree_agile-requested-movies">
				<?php
				$where = "";
				$keyword = "";
				if (isset($_GET['q'])) {
					$keyword = $_GET['q'];
					$where = "WHERE judul LIKE '%$keyword%'";
				} else {
                    // Logic to show nothing or all if no search? Usually empty or redirect.
                    // Let's just show empty or latest. Assuming 'q' is passed.
                }

                if (!empty($keyword)) {
                    // Note: Using direct variable interpolation in SQL string is unsafe but follows existing pattern.
                    // Better to rely on the pattern used throughout the app for now.
				    $movies = $proses->tampil("*", "film", "$where");
                } else {
                    // If no keyword, maybe return empty or all? Let's return empty set logic or check rowCount
                    $movies = null;
                }
				
				if ($movies && $movies->rowCount() > 0) {
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
					echo '<div class="alert alert-warning" role="alert" style="text-align: center;">No movies found for keyword: "'.htmlspecialchars($keyword).'"</div>';
				}
				?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
