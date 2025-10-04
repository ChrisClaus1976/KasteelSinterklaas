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

				var xHTTP = new XMLHttpRequest();
				datum = encodeURIComponent(document.getElementById('selDatum').value);
				if (datum=="")
				{
					document.getElementById('divReservaties').innerHTML = '';
				}
				else
				{
					document.getElementById('divReservaties').innerHTML = 'Even geduld de mails worden verstuurd...';
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
					xHTTP.open("GET", "ajax/reservaties_herinneringsmail.php?datum=" + datum, true);
					xHTTP.send();
				}
			}

		</script>
	</head>
	<body>

		<?php
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
		echo "<div id=\"divReservaties\">";
		echo "</div>";
	?>
					
	</body>
</html>