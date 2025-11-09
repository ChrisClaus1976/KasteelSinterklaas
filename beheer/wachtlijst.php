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
			function wachtlijst_tonen()
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
				xHTTP.open("GET", "ajax/wachtlijst_tonen.php" , true);
				xHTTP.send();
			}
			
					
			function wachtlijstnaarreservatielijst(wachtlijstid, divnaam)
			{
				document.getElementById(divnaam).hidden  = false;
				//document.getElementById(divnaam).innerHTML = wachtlijstid + " - " + divnaam;
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById(divnaam).innerHTML = xhttp.responseText;
					}
				};

				xhttp.open("GET", "ajax/wachtlijst_toon_vrije_reservaties.php?wachtlijstid=" + wachtlijstid , true);
				xhttp.send();
			}
			
			function wachtlijstnaarreservatie(wachtlijstid, data_id)
			{
				antw=confirm('Wilt u dit tijdstip toekennen aan dit gezin (er wordt een mail verzonden)?');
				if(antw)
				{
					//alert(wachtlijstid + " - " + data_id);
					//document.getElementById("divReservatiesMelding").innerHTML = wachtlijstid + " - " + data_id;
			
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							if (xhttp.responseText==0)
							{
								alert("Reservatie is gemaakt");
								location.reload();
							}
							else
							{
								document.getElementById("divReservatiesMelding").innerHTML = xhttp.responseText;
							}
						}
					};

					xhttp.open("GET", "ajax/wachtlijst_naar_reservatie.php?wachtlijstid=" + wachtlijstid + "&dataid=" + data_id, true);
					xhttp.send();
				}
			}
			
		</script>
	</head>
	<body>

		<?php
		hoofding($link, 'wachtlijst', '');
		start_tabel();
			if (isset($_SESSION['login']['username']))
			{
				
				echo "<div id=\"divReservaties\">";
				echo "</div>";
				echo "<div id=\"divReservatiesMelding\">";
				echo "</div>";
				echo "<script>wachtlijst_tonen()</script>";
			}
			else
			{
				include "login.php";
			}
		eind_tabel();
		?>
					
	</body>
</html>

