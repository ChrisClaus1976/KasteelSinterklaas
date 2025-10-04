<?php
	include('includes/opmaak.php');
	include('../includes/db_conn.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();
	$datum=date('Y-m-d');

	$tijd=time();
	$_SESSION['sint']['starttijd']=$tijd;
	//$datum="2024-11-16"; // TEST
	
	?>
	<html>
	<head>

		<LINK href="css/style.css" rel="stylesheet" type="text/css">
		<script type="text/javascript">	
			//setInterval(sinttimer, 1000);			
			function sinttimer()
			{
				/*document.getElementById('divTijd').innerHTML = '';
				var xHTTP = new XMLHttpRequest();
				if (window.XMLHttpRequest)
				{    
					xmlhttp = new XMLHttpRequest();
				}

				xHTTP.onreadystatechange = function() 
				{
					if (xHTTP.readyState == 4 && xHTTP.status == 200) 
					{
						document.getElementById("divTijd").innerHTML = xHTTP.responseText;
					}
				};
				xHTTP.open("GET", "ajax/sinttimer.php", true);
				xHTTP.send();*/
			}
			
			function reservatie_tonen(reservatieid)
			{
				sinttimer()
				document.getElementById('divGegevens').innerHTML = 'Even geduld...';
				var xHTTP = new XMLHttpRequest();
				if (window.XMLHttpRequest)
				{    
					xmlhttp = new XMLHttpRequest();
				}

				xHTTP.onreadystatechange = function() 
				{
					if (xHTTP.readyState == 4 && xHTTP.status == 200) 
					{
						document.getElementById("divGegevens").innerHTML = xHTTP.responseText;
					}
				};
				xHTTP.open("GET", "ajax/sintreservatie.php?reservatieid=" + reservatieid, true);
				xHTTP.send();
				
			}
			
			function bezoek_klaar(reservatieid, waarde)
			{
				antw=confirm('Bezoek bij de Sint klaar?');
				if(antw)
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
							if (xHTTP.responseText==1)
							{
								location.reload();
							}
							else
							{
								document.getElementById("divError").innerHTML = xHTTP.responseText;
							}
							
						}
					};
					xHTTP.open("GET", "ajax/onthaalwijzigaanwezig.php?reservatieid=" + reservatieid + "&waarde=" + waarde, true);
					xHTTP.send();
				}
			}
			
		</script>
	</head>
	<body>
	<?php
	echo "<table><tr>";
	echo "<td><h1>Sint $datum</h1></td>";
	echo "<td><div id=\"divTijd\">";
	echo "</div></td></tr></table>";
	//tijdsloten tonen
	
	
	?>
	<table class="tblzonderlijnenlinksboven">
		<th  class="tblzonderlijnenlinksboven"  width=10%></th>
		<th  class="tblzonderlijnenlinksboven"  width=90%></th>
	<?php
	echo "<tr class=\"tblzonderlijnenlinksboven\"><td class=\"tblzonderlijnenlinksboven\">";
	
	$query  = "SELECT
			TBL_data.DataId, 
			TBL_data.Datum, 
			TBL_data.Tijdstip, 
			TBL_data.Beschikbaar, 
			TBL_data.ReservatieId, 
			TBL_data.`Status`, 
			TBL_Reservatie.ReservatieId, 
			TBL_Reservatie.Canceled, 
			TBL_Reservatie.Naam, 
			TBL_Reservatie.Voornaam, 
			TBL_Reservatie.Telefoon, 
			TBL_Reservatie.Mailadres, 
			TBL_Reservatie.Adres, 
			TBL_Reservatie.Postcode, 
			TBL_Reservatie.Gemeente, 
			TBL_Reservatie.AantalKinderen, 
			TBL_Reservatie.AantalVolwassenen,
			TBL_Reservatie.BetaaldDatum,
			TBL_Reservatie.BetaaldBedrag,
			TBL_Reservatie.Kind1Voornaam,
			TBL_Reservatie.Kind2Voornaam,
			TBL_Reservatie.Kind3Voornaam,
			TBL_Reservatie.Kind4Voornaam,
			TBL_Reservatie.Kind5Voornaam
		FROM
			TBL_data
			LEFT JOIN
			TBL_Reservatie
			ON 
				TBL_data.DataId = TBL_Reservatie.Tijdstip";
				
	if ($datum != '')
	{
		$query = $query. " WHERE TBL_data.Datum='$datum' AND TBL_Reservatie.ReservatieAanwezig='1'";
	}
	$query = $query. " ORDER BY TBL_data.Datum, TBL_data.Tijdstip ";
	$result = mysqli_query($link, $query);
	$aantalrecords = mysqli_num_rows($result);
	if ($aantalrecords>0)
	{
		//echo "<table class=\"tblmetlijnenlinks\">";
		while($row = mysqli_fetch_assoc($result))
		{
			$Datum=$row['Datum'];
			$Tijdstip=$row['Tijdstip'];
			$ReservatieId=$row['ReservatieId'];
			$Naam=$row['Naam'];
			$Voornaam=$row['Voornaam'];
			$Telefoon=$row['Telefoon'];
			$Mailadres=$row['Mailadres'];
			$Adres=$row['Adres'];
			$Postcode=$row['Postcode'];
			$Gemeente=$row['Gemeente'];
			$AantalVolwassenen=$row['AantalVolwassenen'];
			$AantalKinderen=$row['AantalKinderen'];
			$Kind1Voornaam=$row['Kind1Voornaam'];
			$Kind2Voornaam=$row['Kind2Voornaam'];
			$Kind3Voornaam=$row['Kind3Voornaam'];
			$Kind4Voornaam=$row['Kind4Voornaam'];
			$Kind5Voornaam=$row['Kind5Voornaam'];
			$Canceled=$row['Canceled'];
			$Status=$row['Status'];
			$BetaaldDatum=$row['BetaaldDatum'];
			$BetaaldBedrag=$row['BetaaldBedrag'];
			if ($Canceled!=1)
			{
				$tekstbutton="";
				if ($AantalKinderen>=1)
				{
					$tekstbutton = $tekstbutton."$Kind1Voornaam";
				}
				if ($AantalKinderen>=2)
				{
					$tekstbutton = $tekstbutton."&#10$Kind2Voornaam";
				}
				if ($AantalKinderen>=3)
				{
					$tekstbutton = $tekstbutton."&#10$Kind3Voornaam";
				}
				if ($AantalKinderen>=4)
				{
					$tekstbutton = $tekstbutton."&#10$Kind4Voornaam";
				}
				if ($AantalKinderen>=5)
				{
					$tekstbutton = $tekstbutton."&#10$Kind5Voornaam";
				}
				//echo "<tr onclick=\"reservatie_tonen($ReservatieId)\"><td class=\"tblmetlijnenlinks\">$tekstbutton</td></tr>";
				echo "<input type=\"button\" class=\"buttonsint\" onclick=\"reservatie_tonen('$ReservatieId')\" value=\"$tekstbutton\" style=\"height: 150px; width: 100px;\"><br><br>";
			}
		}
		//echo "</table>";
	}
	else
	{
		echo "Geen gezinnen aanwezig in het kasteel.<br>";
	}
	echo "</td>";
	echo "<td class=\"tblzonderlijnenlinksboven\">";
	
	echo "<div id=\"divGegevens\">";
	echo "</div>";
	echo "</td></tr>";
	echo "</table>";
	mysqli_close($link);
?>

</body>
</html>