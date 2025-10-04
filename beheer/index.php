<?php
	include('includes/opmaak.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();

	include('../includes/db_conn.php');
	?>
	<html>
	<head>

		<LINK href="css/style.css" rel="stylesheet" type="text/css">
		<script type="text/javascript">	
			function aanmelden()
		{
			document.getElementById('divLoginOpm').innerHTML = '';
			
			var xHTTP = new XMLHttpRequest();
			gebruikersnaam = encodeURIComponent(document.getElementById('txtGebruikersnaam').value);
			wachtwoord = encodeURIComponent(document.getElementById('txtWachtwoord').value);
			if (window.XMLHttpRequest)
			{    
				xmlhttp = new XMLHttpRequest();
			}

			xHTTP.onreadystatechange = function() 
			{
				if (xHTTP.readyState == 4 && xHTTP.status == 200) 
				{
					if((xHTTP.responseText).trim() == '1')
					{
						location.href = 'index.php';
					}
					else 
					{
						document.getElementById("divLoginOpm").innerHTML = xHTTP.responseText;
						//alert('Verkeerde gegevens');window.location='index.php';
					}
				}
			};
			xHTTP.open("GET", "ajax/aanmelden.php?gebruikersnaam=" + gebruikersnaam + "&wachtwoord=" + wachtwoord, true);
			xHTTP.send();
		}
		
			function kiesdatum(datum)
			{
				document.getElementById('divReservaties').innerHTML = '';
				//alert(datum);
				var xHTTP = new XMLHttpRequest();
				datum = encodeURIComponent(datum);
				if (window.XMLHttpRequest)
				{    
					xmlhttp = new XMLHttpRequest();
				}

				xHTTP.onreadystatechange = function() 
				{
					if (xHTTP.readyState == 4 && xHTTP.status == 200) 
					{
						document.getElementById("divReservaties").innerHTML = xHTTP.responseText;
					}
				};
				xHTTP.open("GET", "ajax/reservaties_tonen.php?datum=" + datum, true);
				xHTTP.send();
			}
		</script>
	</head>
	<body>

		<?php
		hoofding($link, 'home', '');
		start_tabel();
			if (isset($_SESSION['login']['username']))
			{
				$naam=$_SESSION['login']['naam'];
				$voornaam=$_SESSION['login']['voornaam'];
				echo "Welkom $voornaam $naam<br>";
			}
			else
			{
				include "login.php";
			}
		
		eind_tabel();
		mysqli_close($link);
		?>
					
	</body>
</html>




