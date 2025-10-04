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
				xHTTP.open("GET", "ajax/tijdsloten_tonen.php?datum=" + datum, true);
				xHTTP.send();
			}
		</script>
	</head>
	<body>

		<?php
		hoofding($link, 'tijdsloten', '');
		start_tabel();
			if (isset($_SESSION['login']['username']))
			{
				$query = "select DISTINCT Datum from TBL_data ORDER BY Datum";
				$result = mysqli_query($link, $query);
				$aantalrecords = mysqli_num_rows($result);
				echo "<select id=\"selDatum\" onChange=\"kiesdatum(this.value);\">";
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
				echo "<div id=\"divReservaties\">";
				echo "</div>";
			}
			else
			{
				include "login.php";
			}
		
		eind_tabel();
		?>
					
	</body>
</html>

