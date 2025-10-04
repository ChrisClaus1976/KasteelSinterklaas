<?php
	include('includes/opmaak.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();
	if (!isset($_SESSION['login']['username']))
	{
		echo "<script>location.href = 'index.php';</script>";
	}
	include('../includes/db_conn.php');
	?>
	<html>
	<head>

		<LINK href="css/style.css" rel="stylesheet" type="text/css">
		<script type="text/javascript">	
			function betaling_tonen()
			{
				document.getElementById('divReservaties').innerHTML = '';
				var xHTTP = new XMLHttpRequest();
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
				xHTTP.open("GET", "ajax/betaling_tonen.php", true);
				xHTTP.send();
			}
			
			function reservatie_tonen(reservatieid)
			{
				document.getElementById('divReservaties').innerHTML = '';
				var xHTTP = new XMLHttpRequest();
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
				xHTTP.open("GET", "ajax/reservatie.php?reservatieid=" + reservatieid, true);
				xHTTP.send();
			}
			
			function betalingregistreren(reservatieid)
			{
				let bedrag = prompt("Geef bedrag van betaling in.");

				if (bedrag != null) 
				{
					var xHTTP = new XMLHttpRequest();
					if (window.XMLHttpRequest)
					{    
						xmlhttp = new XMLHttpRequest();
					}

					xHTTP.onreadystatechange = function() 
					{
						if (xHTTP.readyState == 4 && xHTTP.status == 200) 
						{
							if (xHTTP.responseText==0)
							{
								location.reload();
							}
							else
							{
								if (xHTTP.responseText==1)
								{
									alert("Gelieve een getal in te geven.");
								}
								else
								{
									if (xHTTP.responseText==2)
									{
										alert("Het bedrag komt niet overeen met het aantal ingeschreven kinderen.");
									}
									else
									{
										document.getElementById("formmelding").innerHTML = xHTTP.responseText;
									}
								}
							}
						}
					};
					xHTTP.open("GET", "ajax/betalingregistreren.php?reservatieid=" + reservatieid + "&bedrag=" + bedrag, true);
					xHTTP.send();
				}
			}
			
			function betalingsherinnering(reservatieid)
			{
				antw=confirm('Wilt u een herinneringsmails sturen i.v.m. de betaling?');
				if(antw)
				{
					//alert("mailen");
					var xHTTP = new XMLHttpRequest();
					if (window.XMLHttpRequest)
					{    
						xmlhttp = new XMLHttpRequest();
					}

					xHTTP.onreadystatechange = function() 
					{
						if (xHTTP.readyState == 4 && xHTTP.status == 200) 
						{
							if (xHTTP.responseText==0)
							{
								location.reload();
							}
							else
							{
								document.getElementById("formmelding").innerHTML = xHTTP.responseText;
							}
						}
					};
					xHTTP.open("GET", "ajax/betalingsherinnering.php?reservatieid=" + reservatieid, true);
					xHTTP.send();
				}
				else
				{
					//alert ("niet mailen");
				}
			}
			
		</script>
	</head>
	<body>

		<?php
		hoofding($link, 'betaling', '');
		start_tabel();
			if (isset($_SESSION['login']['username']))
			{
				echo "Via deze pagina kun je de betaling van een reservatie bevestigen. De ouders krijgen een bevestigingsmail van deze betaling.<br>";				
				echo "<div id=\"divReservaties\">";
				echo "</div>";
				echo "<div id=\"formmelding\"></div>";
				echo "<script>betaling_tonen()</script>";
			}
			else
			{
				include "login.php";
			}
		
		eind_tabel();
		
		?>
					
	</body>
</html>

