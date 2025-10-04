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
			function reservaties_tonen()
			{
				document.getElementById('divReservaties').innerHTML = 'Even geduld de lijst wordt opgebouwd...';
				var xHTTP = new XMLHttpRequest();
				datum = encodeURIComponent(document.getElementById('selDatum').value);
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
			
			function excel_export_poort()
		{
			//alert("1");
			var xhttp = new XMLHttpRequest();
			datum=document.getElementById('selDatum').value;
			
			if (datum="")
			{
				
			}
			else
			{
				location.href = "excel/lijst_poort.php?datum=" + datum;
			}
		}
		</script>
	</head>
	<body>

		<?php
		hoofding($link, 'reservaties', '');
		start_tabel();
			if (isset($_SESSION['login']['username']))
			{
				$query = "select DISTINCT Datum from TBL_data WHERE Beschikbaar < 5 ORDER BY Datum";
				$result = mysqli_query($link, $query);
				$aantalrecords = mysqli_num_rows($result);
				echo "<select id=\"selDatum\" onChange=\"reservaties_tonen();\">";
				echo "<option value=\"\" selected></option>";
				if ($aantalrecords>0)
				{
					while($row = mysqli_fetch_assoc($result))
					{
						$Datum=$row['Datum'];
						echo "<option value=\"$Datum\">$Datum</option>";
					}
				}
				echo "</select>";
				echo "&nbsp&nbsp&nbsp<input type=\"button\" onclick=\"excel_export_poort()\" value=\"Export excel lijst poort\">";
				echo "<div id=\"divReservaties\">";
				echo "</div>";
				echo "<script>reservaties_tonen()</script>";
				mysqli_close($link);
			}
			else
			{
				include "login.php";
			}
		
		eind_tabel();
		?>
					
	</body>
</html>

