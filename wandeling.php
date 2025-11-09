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
				toon_header("wandeling");
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
									<h2>Sinterklaaswandeling</h2>
								</div>
								<div class="img_container">
									<div class="img-box">
										<img src="images/sinterklaaswandeling.jpg" alt="" />
									</div>
								</div>
								
								<p>De jaarlijkse <b>Sinterklaaswandeling</b> in Gruitrode is een <b>traditie</b> die al <b>meer dan 50 jaar bestaat</b>.<br><br>Deze wandeling vindt plaats in de prachtige bossen van Gruitrode, waar de natuur op zijn mooist is. Tijdens de wandeling worden kinderen en hun ouders meegenomen op een korte avontuurlijke tocht door de Royse bossen.<br><br>Een van de hoogtepunten van de wandeling is het bezoek aan het <b>Kasteel van Sinterklaas</b>, deze biedt een unieke ervaring waarbij kinderen en hun families de kans krijgen om Sinterklaas zelf te bezoeken. Dit is een onvergetelijke gelegenheid om persoonlijk met Sinterklaas te praten, je verlanglijstje mee te nemen en te genieten van zijn gezelschap.<br><br>Gezinnen krijgen een <b>exclusieve rondleiding door het kasteel</b>, samen met de Pieten. Tijdens de rondleiding zullen de Pieten de kinderen vermaken met grappige anekdotes en avonturen van de Sint en zijn Pieten.<br><br>Om de unieke ervaring compleet te maken, krijgen alle kinderen aan het einde een <b>snoepzak</b>, gevuld met traditionele Sinterklaas lekkernijen!<br><br>Het bezoek aan het Kasteel van Sinterklaas is een unieke gelegenheid om de echte Sinterklaas en zijn Pieten te ontmoeten, een rondleiding door het kasteel te beleven en te genieten van heerlijke Sinterklaas lekkernijen. Het is een ervaring die kinderen zich hun hele leven zullen herinneren.<br><br><h3><b>Praktische info:</b></h3><b><u>Kinderwandeling:</u></b><br><ul><li><b>Vertrek:</b> 'De Royer Brem', Harmonieweg 35, 3670 Gruitrode (Oudsbergen).</li><li><b>Uur:</b> Vertrek kinderwandeling tussen 11:00 en 15:00u. De Sint is aanwezig tussen 12:00 en 16:00u.</li><li><b>Inschrijven:</b> Inschrijven is verplicht en kan niet aan het kasteel, enkel bij 'De Royer Brem' op zaterdag 29 november. <font color=red>Online reserveren is niet nodig!</font></li><li><b>Afstand:</b> Kinderwandeling is ongeveer ±3km.</li><li><b>Inschrijfprijs:</b> <i>(verzekering Wandelsport Vlaanderen inbegrepen)</i><ul><li>Volwassenen: <ul><li>Leden erkende wandelfederatie: € 1,5</li><li>Niet leden: € 3,0</li></ul></li><li>Kinderen: Gratis</li></ul><li><b>Tegoedbon Snoepzak:</b> € 4, enkel te verkrijgen bij 'De Royer Brem'.</li></ul><br><b><u>Sportieve Wandeling:</u></b><ul><li><b>Vertrek:</b> 'De Royer Brem', Harmonieweg 35, 3670 Gruitrode (Oudsbergen).</li><li><b>Uur:</b> Starten tussen 08:00 en 15:00, laatste aankomsttijd 17:00</li><li><b>Afstanden:</b> 6-8-12 en 20 km wandelen door de Duinengordel, een 3000 ha uitgestrekt heide- bos en duinenlandschap.</li><li><b>Inschrijfprijs:</b> <i>(verzekering Wandelsport Vlaanderen inbegrepen)</i><ul><li>Leden erkende wandelfederatie: € 1,5</li><li>Niet leden: € 3,0</li></ul><li><b>Pauzezaal:</b> Zaal Elckerlyc, Elckerlycstraat, 3670 Neerglabbeek (Oudsbergen).</li></ul><br><b>Contact info:</b><br><table><tr><td>Mail:</td><td><a href="mailto:info@bos-heikabouters.be">info@bos-heikabouters.be</a></td></tr><tr><td>Website:</td><td><a href="https://www.bos-heikabouters.be" target="_blank">www.bos-heikabouters.be</a></td></tr><tr><td>Facebook:</td><td><a href="https://facebook.com/BosHeikabouters" target="_blank">facebook.com/BosHeikabouters</a></td></tr></table></p>
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

