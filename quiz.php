<?php
	include('includes/opmaak.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();
	if (isset($_SESSION['reservatie']['reservatieid'])  && isset($_SESSION['reservatie']['dataid']))
	{
		$http=$_SERVER['REQUEST_SCHEME'];  // http of https
		$server=$_SERVER['SERVER_NAME'];
		$bestand=$_SERVER['PHP_SELF'];
		$currentPage = $http.'://'.$server.$bestand;
		cancelreservatie($currentPage);
	}
	//$_SESSION=array();
	?>
	<html>
	<head>
		<?php
		opmaak_pagina();
		?>
		<script type="text/javascript">	
			
		</script>
	</head>
	<body>
		<div class="hero_area">
			<?php
				toon_header("quiz");
			?>	
			<!-- section -->
			<section class="about_section layout_padding">
				<div class="container">
					<div class="row">
						<!--<div class="col-md-6 px-0">
							<div class="img_container">
								<div class="img-box">
									<img src="images/sint2.jpeg" alt="" />
								</div>
							</div>
						</div>-->
						<div class="col-md-8 px-0">
							<div class="detail-box">
								<div class="heading_container ">
									<h2>Sinterklaas-quiz</h2>
								</div>
								<div class="img_container">
									<div class="img-box">
										<img src="images/quiz.jpg" alt="" />
									</div>
								</div>
								
								<p>
								De Sint is benieuwd naar wie de slimste dorpsgenoten zijn. Daarom organiseren zijn vrienden van Landelijke Gilde Gruitrode en Dorser Brouwers een dorpsquiz (voor niet quizploegen) waar plezier voorop staat. Wees er snel bij want de plaatsen zijn beperkt!<br><br>

								<ul><li>Wanneer: vrijdag 14 november 2025</li>
								<li>Deuren open: 19:30</li>
								<li>Start quiz: 20:00</li>
								<li>20 € / ploeg, max 6 deelnemers / ploeg</li></ul><br>
								Inschrijven kan door een mail te sturen naar <b>emielvbaelen@gmail.com</b> met vermelding van uw ploegnaam en aantal deelnemers en mits overschrijving van <b>20 €</b> naar <b>BE17 7352 0800 0421</b> met vermelding van <b>‘ploegnaam - quiz’</b><br><br></p>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- end section -->
		</div>
		<?php	
			toon_voet();
			toon_copyright();
		?>
		<script src="js/jquery-3.4.1.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/custom.js"></script>
	</body>
</html>

