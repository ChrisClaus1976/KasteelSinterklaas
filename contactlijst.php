<?php
	include('includes/opmaak.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();

	include('includes/db_conn.php');
	?>
	<html>
	<head>
		<?php
		opmaak_pagina();
		?>
		<script type="text/javascript">	
			function validateEmail(email)
			{
				var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				return re.test(email);
			}
			
			function isNumeric(value)
			{
				return /^-?\d+$/.test(value);
			}
				
			function ContactlijstOpslaan()
			{
				var errors = false;
				//alle achtergronden wit maken
				document.getElementById('formmelding').innerHTML = '';
				document.getElementById('txtNaam').style.backgroundColor = '';
				document.getElementById('txtVoornaam').style.backgroundColor = '';
				document.getElementById('txtTelefoon').style.backgroundColor = '';
				document.getElementById('txtMail').style.backgroundColor = '';

				
				
				// elk verplicht veld controleren of het ingevuld is.
				if(document.getElementById('txtNaam').value == '')
				{
					document.getElementById('txtNaam').style.backgroundColor = 'red';
					errors = true;
				}
				if(document.getElementById('txtVoornaam').value == '')
				{
					document.getElementById('txtVoornaam').style.backgroundColor = 'red';
					errors = true;
				}
				if(document.getElementById('txtTelefoon').value == '')
				{
					document.getElementById('txtTelefoon').style.backgroundColor = 'red';
					errors = true;
				}			
				if(document.getElementById('txtMail').value == ''){
					//mailadres is niet ingevuld
					document.getElementById('txtMail').style.backgroundColor = 'red';
					errors = true;
				}
				else 
				{
					if(!validateEmail(document.getElementById('txtMail').value))
					{
						document.getElementById('txtMail').style.backgroundColor = 'red';
						errors = true;
					}
				}	

				if(errors) //controleren of er errors (velden niet ingevuld) waren
				{
					//alert("verplicht");
					document.getElementById('formmelding').innerHTML = 'Vul de verplichte velden in.';
				}
				else
				{
					var xhttp = new XMLHttpRequest();
					document.getElementById("formmelding").innerHTML = 'De gegevens worden verwerkt ...';
					naam = encodeURIComponent(document.getElementById('txtNaam').value);
					voornaam = encodeURIComponent(document.getElementById('txtVoornaam').value);						
					telefoon = encodeURIComponent(document.getElementById('txtTelefoon').value);
					mail=document.getElementById('txtMail').value;
					mailadres = encodeURIComponent(document.getElementById('txtMail').value);
					
					xhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							if (xhttp.responseText=="1")
							{
								//alles OK
								alert("Je staat op de contactlijst.");
								location.href = 'reserveer.php';
							}
							else
							{
								document.getElementById("formmelding").innerHTML = xhttp.responseText;
							}
						}
					};

					xhttp.open("GET", "ajax/BewaarContactlijst.php?naam=" + naam + "&voornaam=" + voornaam + "&telefoon=" + telefoon + "&mailadres=" + mailadres , true);
					xhttp.send();
				}
			}
		</script>
	</head>
	<body>
		<div class="hero_area">

			<?php
				toon_header("reservatie");
			?>

			<!--  section -->

			<section class="about_section layout_padding">
				<div class="container">
					<div class="row">
						<div class="col-md-8 px-0">
							<div class="detail-box">
								<?php
								
									echo "<div id=\"divreservatie\">";
									
									echo "<div class=\"heading_container \"><h2>Contactlijst</h2></div>";
									echo "Gelieve onderstaande velden in te vullen om op de contactlijst geplaatst te worden om op de hoogte gehouden te worden van de activiteiten van de Landelijke Gilde Gruitrode.<br><br>";
									echo "<table>";
									echo "<tr><td colspan=2><h5><b>Gegevens</b></h5></td></tr>";
									echo "<tr><td>Naam</td><td><input id=\"txtNaam\" value=\"\" size=\"40\" type=\"text\";\"></td></tr>";
									echo "<tr><td>Voornaam</td><td><input id=\"txtVoornaam\" value=\"\" size=\"40\" type=\"text\";\"></td></tr>";
									echo "<tr><td>Telefoon</td><td><input id=\"txtTelefoon\" value=\"\" size=\"40\" type=\"text\";\"></td></tr>";
									echo "<tr><td>Mailadres</td><td><input id=\"txtMail\" value=\"\" size=\"40\" type=\"text\";\"></td></tr>";
									//echo "<tr><td>Adres</td><td><input id=\"txtAdres\" value=\"\" size=\"40\" type=\"text\";\"></td></tr>";
									//echo "<tr><td>Gemeente</td><td><input id=\"txtPostcode\" value=\"\" size=\"10\" type=\"text\";\">	<input id=\"txtGemeente\" value=\"\" size=\"23\" type=\"text\";\" ></td></tr>";
									
									
									echo "</table>";

									echo "<br><input type=\"button\" onclick=\"ContactlijstOpslaan()\" value=\"Op contactlijst plaatsen\">";
									
									echo "<div id=\"formmelding\">";
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
			mysqli_close($link);
		?>

		<script src="js/jquery-3.4.1.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/custom.js"></script>
	</body>
</html>
