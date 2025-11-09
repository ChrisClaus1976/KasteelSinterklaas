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
				toon_header("winterbar");
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
									<h2>Winterbar van Sinterklaas</h2>
								</div>
								<div class="img_container">
									<div class="img-box">
										<img src="images/winterbar.jpg" alt="" />
									</div>
								</div>
								
								<p><b><h4>Winterse Warmte & Feestelijke Dranken!</h4></b><br>
								Kom naar onze winterbar in verwarmde tent en geniet van eten en drinken aan democratische prijzen.<br><br>
								<!--Heb je geen tijdslot kunnen reserveren of kan je niet aanwezig zijn op 2 december?<br>Kom dan naar de Winterbar van Sinterklaas. Het prachtige kasteel van de Sint kan bewonderd worden vanuit de binnenkoer met een drankje.<br>Inkom is gratis en reserveren is niet nodig.<br><br>-->
								<b>Bierliefhebbers opgelet!</b><br>Onze bar biedt een selectie van twee overheerlijke lokale bieren van Dorser:<br><ul><li>Dorser: Wild Wardje</li><li>Dorser: Magnus</li></ul>Naast deze lokale brouwsels hebben we ook nog een aanbod van andere dranken:<br><ul><li>Pils</li><li>Witte wijn</li><li>Rode wijn</li><li>Glühwein</li><li>Warme chocolademelk</li><li>Koffie</li><li>Diverse frisdranken</li></ul>
								
								<b>Wanneer:</b><br><ul><li>Vrijdag 14 november (vanaf 19u00)</li><li>Zaterdag 15 november (vanaf 10u00)</li><li>Zondag 16 november (vanaf 10u00)</li><br><li>Vrijdag 21 november (vanaf 19u00)</li><li>Zaterdag 22 november (vanaf 10u00)</li><li>Zondag 23 november (vanaf 10u00)</li><br><li>Vrijdag 28 november (vanaf 19u00)</li><li>Zaterdag 29 november (vanaf 10u00)</li><li>Zondag 30 november (vanaf 10u00 - tot 17:00)</li></ul><b>Locatie:</b><br>Aan de prachtige Commanderij van Gruitrode, gelegen in het centrum van Gruitrode, met een vernieuwe parking aan de overzijde van de Commanderij. 								<!--Voorzien van verschillende vuurkorven om je te verwarmen en voldoende overdekte zitplaatsen.<br><br>-->
								Kom en geniet van de warmte in een betoverende sfeer bij <b>Winterbar van Sinterklaas</b>.<br><br>Vergeet niet om je vrienden en familie mee te brengen naar deze sprookjesachtige locatie!<br><br>
								Wil je toch graag op de foto met de Sint, kom dan op 29 november naar de Sinterklaaswandeling. Meer info vind je </p><div class="btn-box">
												<a href="wandeling.php" class="btn-2">hier</a>
											</div><br>
										of bezoek ons tijdens een van de vrije doorloopmomenten.
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

