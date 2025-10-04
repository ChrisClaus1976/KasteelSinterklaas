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
		
			function verstuur_bericht()
			{
				//document.getElementById("divBericht").innerHTML = "test";
			
				var errors = false;
				document.getElementById('Naam').style.backgroundColor = '';
				document.getElementById('Email').style.backgroundColor = '';
				document.getElementById('Telefoonnummer').style.backgroundColor = '';
				document.getElementById('Boodschap').style.backgroundColor = '';
				if(document.getElementById('Naam').value == '')
				{
					document.getElementById('Naam').style.backgroundColor = 'red';
					errors = true;
				}
				if(document.getElementById('Email').value == ''){
					document.getElementById('Email').style.backgroundColor = 'red';
					errors = true;
				}
				else {
					if(!validateEmail(document.getElementById('Email').value)){
						document.getElementById('Email').style.backgroundColor = 'red';
						errors = true;
					}
				}
				if(document.getElementById('Telefoonnummer').value == '')
				{
					document.getElementById('Telefoonnummer').style.backgroundColor = 'red';
					errors = true;
				}
				if(document.getElementById('Boodschap').value == '')
				{
					document.getElementById('Boodschap').style.backgroundColor = 'red';
					errors = true;
				}
				
				if(errors) //controleren of er errors (velden niet ingevuld) waren
				{
					
				}
				else
				{
					
					var xhttp = new XMLHttpRequest();
					
					naam = encodeURIComponent(document.getElementById('Naam').value);
					email = encodeURIComponent(document.getElementById('Email').value);
					telefoonnummer = encodeURIComponent(document.getElementById('Telefoonnummer').value);
					boodschap = encodeURIComponent(document.getElementById('Boodschap').value);

					//alert(naam + email + telefoonnummer + boodschap);
					xhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							document.getElementById("divBericht").innerHTML = this.responseText;
						}
					};
					xhttp.open("GET", "ajax/verstuur_contactbericht.php?naam=" + naam + "&email=" + email + "&telefoonnummer=" + telefoonnummer + "&boodschap=" + boodschap , true);
					xhttp.send();
				}
			}
		</script>
	</head>

	<body>
		<div class="hero_area">
			<?php
				toon_header("contacteerons");
			?>
			<!-- section -->
			<section class="contact_section layout_padding">
				<div class="container">
					<div class="heading_container heading_center">
						<h2>
							Contacteer ons
						</h2>
						<h4>
							Heb je een vraag? Misschien vind je het antwoord op je vraag bij het overzicht van de veelgestelde vragen.<br>Heb je een andere vraag? Stuur je bericht via onderstaand formulier en we zullen je zo snel mogelijk antwoorden.
						</h4>
					</div>
					<div class="">
						<div class="row">
							<div class="col-md-7 mx-auto">
								<form action="#">
									<div class="contact_form-container">
										<div id="divBericht">
											<div>
												<input type="text" id="Naam" placeholder="Naam" />
											</div>
											<div>
												<input type="email" id="Email" placeholder="Email" />
											</div>
											<div>
												<input type="text" id="Telefoonnummer" placeholder="Telefoonnummer" />
											</div>
											<div class="">
												<input type="text" id="Boodschap" placeholder="Boodschap" />
											</div>
											<div class="btn-box ">
												<button type="button" onclick="verstuur_bericht()">
													Verstuur
												</button>
											</div>
										</div>
									</div>
								</form>
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