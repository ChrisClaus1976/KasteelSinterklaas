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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
	</head>
	<body>
		<div class="hero_area">
			<?php
				toon_header("kalender");
			?>	
			<!-- section -->
			<section class="about_section layout_padding">
				<div class="container">
					<div class="row">
						<div class="col-md-8 px-0">
							<div class="detail-box">
								<div class="heading_container ">
									<h2>Kalender</h2>
								</div>
								<div class="img_container">
									<div class="img-box">
										<img src="kalender/kalender1.jfif" alt="" />
									</div>
								</div>
								
								<p>
								<table style="width:100%">
								<tr><td colspan=4><b>Vrijdag 14 november</b></td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-moon-fill" style="color: #FFD43B;"></i></td><td style="width:15%">19:30 - </td><td>Winterbar open - <i>Fun quiz</i></td></tr>
								<tr><td colspan=4><b>Zaterdag 15 november</b></td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-sun-fill" style="color: #FFD43B;"></i></td><td style="width:15%">10:00 - 16:00</td><td>Privé rondleidingen, reservatie is verplicht - Winterbar open</td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-sunset-fill" style="color: #ff9f00;"></i></td><td style="width:15%">17:00 - 19:00</td><td>Vrij doorloopmoment - Winterbar open</td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-moon-fill" style="color: #FFD43B;"></i></td><td style="width:15%">19:00 - </td><td>Winterbar open  - <i>Live muziek / winterbeats</i></td></tr>
								<tr><td colspan=4><b>Zondag 16 november</b></td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-sun-fill" style="color: #FFD43B;"></i></td><td style="width:15%">10:00 - 16:00</td><td>Privé rondleidingen, reservatie is verplicht - Winterbar open</td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-sunset-fill" style="color: #ff9f00;"></i></td><td style="width:15%">17:00 - 19:00</td><td>Vrij doorloopmoment - Winterbar open</td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-moon-fill" style="color: #FFD43B;"></i></td><td style="width:15%">19:00 - </td><td>Winterbar open  - <i>Live muziek / winterbeats</i></td></tr>
								</table><br><br>
								
								<table style="width:100%">
								<tr><td colspan=4><b>Vrijdag 21 november</b></td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-moon-fill" style="color: #FFD43B;"></i></td><td style="width:15%">19:00 - </td><td>Winterbar open</td></tr>
								<tr><td colspan=4><b>Zaterdag 22 november</b></td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-sun-fill" style="color: #FFD43B;"></i></td><td style="width:15%">10:00 - 16:00</td><td>Privé rondleidingen, reservatie is verplicht - Winterbar open</td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-sunset-fill" style="color: #ff9f00;"></i></td><td style="width:15%">17:00 - 19:00</td><td>Vrij doorloopmoment - Winterbar open</td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-moon-fill" style="color: #FFD43B;"></i></td><td style="width:15%">19:00 - </td><td>Winterbar open - <i>Live muziek / winterbeats</i></td></tr>
								<tr><td colspan=4><b>Zondag 23 november</b></td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-sun-fill" style="color: #FFD43B;"></i></td><td style="width:15%">10:00 - 16:00</td><td>Privé rondleidingen, reservatie is verplicht - Winterbar open</td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-sunset-fill" style="color: #ff9f00;"></i></td><td style="width:15%">17:00 - 19:00</td><td>Vrij doorloopmoment - Winterbar open</td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-moon-fill" style="color: #FFD43B;"></i></td><td style="width:15%">19:00 - </td><td>Winterbar open - <i>Live muziek / winterbeats</i></td></tr>
								</table><br><br>
								
								<table style="width:100%">
								<tr><td colspan=4><b>Vrijdag 28 november</b></td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-moon-fill" style="color: #FFD43B;"></i></td><td style="width:15%">19:00 - </td><td>Winterbar open - <i>Pieten karaoke</i></td></tr>
								<tr><td colspan=4><b>Zaterdag 29 november</b></td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-sun-fill" style="color: #FFD43B;"></i></td><td style="width:15%">12:00 - 16:00</td><td>Sinterklaaswandeling - Winterbar open</td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-moon-fill" style="color: #FFD43B;"></i></td><td style="width:15%">19:00 - </td><td>Winterbar open - <i>Comedy: open mic</i></td></tr>
								<tr><td colspan=4><b>Zondag 30 november</b></td></tr>
								<tr><td style="width:5%"></td><td style="width:5%"><i class="bi bi-sun-fill" style="color: #FFD43B;"></i></td><td style="width:15%">10:00 - 16:00</td><td>Privé rondleidingen, reservatie is verplicht - Winterbar open</td></tr>
								</table><br><br>
								
							
								Tijdens de vrije doorloopmomenten kunt u het kasteel vrij bezoeken. De Sint is dan niet beschikbaar, hij is de huisbezoeken voor 6 december aan het voorbereiden.<br><br>
								En vergeet niet, de winterbar is open tijdens zowel de privé rondleidingen als de vrije doorloopmomenten. We hebben een gezellige, verwarmde tent waar je kunt opwarmen met een heerlijke warme drank of een smakelijke snack. Dus trek je warmste trui aan, kom langs en geniet van een magische beleving in het Sinterklaas-kasteel!
								</p>
								
								<p>
								
								</p>
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

