<?php
	include('includes/opmaak.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();
	if (isset($_SESSION['reservatie']['reservatieid']) && isset($_SESSION['reservatie']['dataid']))
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
			function toon_maand1()
			{
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("divkalender").innerHTML = this.responseText;
					}
				};
				xhttp.open("GET", "ajax/toon_dagen.php?soort=wachtlijst" , true);
				xhttp.send();
			}
			
			function toon_maand2()
			{
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("divkalender").innerHTML = this.responseText;
					}
				};
				xhttp.open("GET", "ajax/toon_dagen.php?soort=contactlijst" , true);
				xhttp.send();
			}
			
			function selecteerdag(jaar, maand, dag)
			{
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("divkalendertot").innerHTML = this.responseText;
					}
				};
				xhttp.open("GET", "ajax/toon_agenda.php?jaar=" + jaar + "&maand=" + maand + "&dag=" + dag , true);
				xhttp.send();
			}
			
			function selecteertijdstip (dataid, datum, tijdstip)
			{
				antw = confirm("Wilt u " + tijdstip + " op " + datum + " reserveren?");
				if(antw)
				{
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							if (xhttp.responseText==0)
							{
								alert("Het gekozen tijdslot werd ondertussen door een ander gezin gereserveerd en is niet meer beschikbaar.");
								location.href = 'reserveer.php';
							}
							else
							{
								if (xhttp.responseText==1)
								{
									location.href = 'reservatie.php';
								}
								else
								{
									document.getElementById("formmelding").innerHTML = xhttp.responseText;
								}
							}
						}
					};
					xhttp.open("GET", "ajax/reservatie.php?dataid=" + dataid , true);
					xhttp.send();
				}
			}
			
			function terug()
			{
				location.reload();
			}
			
			function wachtlijst()
			{
				location.href = 'wachtlijst.php';
			}
			
			function contactlijst()
			{
				location.href = 'contactlijst.php';
			}
		</script>
	</head>
	<body>
		<div class="hero_area">
			<?php
				toon_header("reservatie");
				include('includes/db_conn.php');
				date_default_timezone_set('Europe/Brussels');
				
				$query  = "select * FROM TBL_parameters WHERE InGebruik = 1";
				$result = mysqli_query($link, $query);
				$aantal = mysqli_num_rows($result);
				if ($aantal>0)
				{
					while($row = mysqli_fetch_assoc($result))
					{
						$prijskind = $row['PrijsKind'];
						$prijsvolw = $row['PrijsVolwassene'];
						$prijskindopm = $row['PrijsKindOpm'];
						$prijsvolwopm = $row['PrijsVolwasseneOpm'];
					}
				}
				else
				{
					echo "ERROR. Er is een fout opgetreden bij het ophalen van de parametergegevens.<br>";
					exit();
				}
			?>
			<!-- section -->
			<section class="about_section layout_padding">
				<div class="container">
					<div class="row">
						<div class="col-md-8 px-0">
							<div class="detail-box">
								<div class="heading_container ">
									<h2>Privé rondleiding - een magisch avontuur</h2>
								</div>
								<?php

									echo "<div id=\"divkalendertot\">";
									
									echo "Bezoek de Sint met je gezin en beleef een avontuur om nooit te vergeten! Begin met een spannende rondleiding door het kasteel samen met de Pieten!<br><br><b>Ontmoet persoonlijk de Sint in zijn torenkamer en krijg een zak vol lekkers.</b><br><br>
									<b>Belangrijke info</b>
									<ul><li><b>Reserveren is verplicht:</b> Kies je datum en tijdstip.</li>
									<li><b>Duur: </b> Ongeveer 1 uur.</li>
									<li><b>Wees op tijd:</b> Als je te laat bent, kunnen we de toegang niet meer garanderen.</li>
									<li><b>Prijs:</b><br><ul><li>Kinderen: $prijskind € ";
									if ($prijskindopm != '')
									{
										echo " (inclusief $prijskindopm)";
									}
									echo "</li><li>Volwassenen: $prijsvolw € ";
									if ($prijsvolwopm != '')
									{
										echo " (inclusief $prijsvolwopm)";
									}
									echo "</li></ul></ul>
									<b>Locatie:</b> Kasteelstraat 2, 3670 Oudsbergen<br><br>";
									echo "";
									//echo "<h2>Omwille van de grote drukte duurt het langer dan normaal voordat u de bevestigingsmail ontvangt. Onze excuses hier voor.</h2>";
									echo "<div id=\"divkalender\"></div>";
									echo "<script>toon_maand1()</script>"; // met wachtlijst
									//echo "<script>toon_maand2()</script>"; // met contactlijst
									
									echo "</div>";
									
								?>
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