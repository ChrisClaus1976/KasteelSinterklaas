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
	<!-- Meta Pixel Code -->
		<script>
		!function(f,b,e,v,n,t,s)
		{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];
		s.parentNode.insertBefore(t,s)}(window, document,'script',
		'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '2140435552840271');
		fbq('track', 'PageView');
		</script>
		<noscript><img height="1" width="1" style="display:none"
		src="https://www.facebook.com/tr?id=2140435552840271&ev=PageView&noscript=1";
		/></noscript>
		<!-- End Meta Pixel Code -->

	<head>
		<?php
		opmaak_pagina();
		?>
		<script type="text/javascript">	
			
		</script>
	</head>
	<body>
		<div class="hero_area">
			<!-- header section strats -->
			<?php
				toon_header("home");
			?>	
			<!-- slider section -->
			<section class=" slider_section ">
				<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner">
						<div class="carousel-item active">
							<div class="container">
								<div class="row">
									<div class="col-md-8">
										<div class="detail-box">
											<h1>Privé rondleiding<br>
											<span>in het kasteel van de Sint</span></h1>
											<p>
											  Breng een persoonlijk bezoek aan de Sint met jullie gezin.<br>De pieten leiden jullie graag rond in hun kasteel (reserveren verplicht).
											</p>
											<div class="btn-box">
												<a href="reserveer.php" class="btn-2">Reserveer</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="carousel-item ">
							<div class="container">
								<div class="row">
									<div class="col-md-8">
										<div class="detail-box">
											<h1>Winterbar van Sinterklaas<br>
											<span></span></h1>
											<p>
											  Winterse warmte & feestelijke dranken in de verwarmde tent op het binnenplein.
											</p>
											<div class="btn-box">
												<a href="winterbar.php" class="btn-2">Meer info</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="carousel-item ">
							<div class="container">
								<div class="row">
									<div class="col-md-8">
										<div class="detail-box">
											<h1>Sinterklaaswandeling<br>
											<span>Met tussenstop in het kasteel van de Sint</span></h1>
											<p>
											  Kom op 29 november naar de Sinterklaaswandeling en bezichtig het kasteel.<br>Inschrijven verplicht aan 'De Royer Brem' te Gruitrode (Harmonieweg 35, 3670 Oudsbergen).
											</p>
											<div class="btn-box">
												<a href="wandeling.php" class="btn-2">Meer info</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="container idicator_container">
					<ol class="carousel-indicators">
						<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
					</ol>
			</section>
			<!-- end slider section -->	
		</div>
		
		<!-- about section -->

		<section class="about_section layout_padding">
			<div class="container">
				<div class="row">
					<div class="col-md-6 px-0">
						<div class="img_container">
							<div class="img-box">
								<img src="images/sintbureau.jpg" alt="" />
							</div>
						</div>
					</div>
					<div class="col-md-6 px-0">
						<div class="detail-box">
							<div class="heading_container ">
								<h2>Bezoek het kasteel van de Sint</h2>
							</div>
							<p>Bezoek de Sint op jouw manier!<br><br><ol><li><b>Privérondleiding met je gezin</b><br>Boek een rondleiding op een datum die voor jullie past en ontdek samen met de bewoners van het kasteel alle kamers.<br>Ideaal voor kinderen vanaf 3 jaar.</p>
							<div class="btn-box">
								<a href="reserveer.php">Boek privé rondleiding</a>
							</div></li>
							<br>
							<li><p><b>Vrije doorloopmomenten:</b><br>Kom langs wanneer je wilt en verken het kasteel op je eigen tempo. Geen reservatie nodig!</p></li><br>
							<p><li><b>Grote Sinterklaaswandeling op 30 november:</b><br>Doe mee aan deze speciale wandeling en ga op ontdekkingstocht in het kasteel.</p>
							<div class="btn-box">
								<a href="wandeling.php">Meer info over de Sinterklaaswandeling</a>
							</div></li></ol>
							
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- end about section -->
		<?php	

	toon_voet();
	toon_copyright();

?>

	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/custom.js"></script>
</body>

</html>

