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
			function contactformulier_tonen()
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
				xHTTP.open("GET", "ajax/contactformulier_tonen.php" , true);
				xHTTP.send();
			}
			
			
		</script>
	</head>
	<body>

		<?php
		hoofding($link, 'contactformulier', '');
		start_tabel();
			if (isset($_SESSION['login']['username']))
			{
				
				echo "<div id=\"divReservaties\">";
				echo "</div>";
				echo "<script>contactformulier_tonen()</script>";
			}
			else
			{
				include "login.php";
			}
		eind_tabel();
		?>
					
	</body>
</html>

