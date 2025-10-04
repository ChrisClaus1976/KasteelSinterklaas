<?php
	session_name('SinterklaasLG');
	session_start();
	$debug=0; 
	//$debug = 1; //op 1 zetten om te debuggen
	date_default_timezone_set('Europe/Brussels');

	include('../../includes/db_conn.php');
		$query  = "select * FROM TBL_parameters WHERE InGebruik = 1";
		$result = mysqli_query($link, $query);
		$aantal = mysqli_num_rows($result);
		if ($aantal>0)
		{
			while($row = mysqli_fetch_assoc($result))
			{
				$prijskind = $row['PrijsKind'];
				$prijsvolw = $row['PrijsVolwassene'];
				$prijskindopm = $row['PrijsKindOpm'];
				$prijsvolwopm = $row['PrijsVolwasseneOpm'];
			}
		}
		else
		{
			echo "ERROR. Er is een fout opgetreden bij het ophalen van de parametergegevens.<br>";
			exit();
		}
		//echo "Datum $datum<br>";
		
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
				TBL_Reservatie.BetaaldBedrag
			FROM
				TBL_data
				LEFT JOIN
				TBL_Reservatie
				ON 
					TBL_data.DataId = TBL_Reservatie.Tijdstip
			ORDER BY TBL_Reservatie.ReservatieId";
					

		//echo "$query<br>";
		$result = mysqli_query($link, $query);
		$aantalrecords = mysqli_num_rows($result);
		if ($aantalrecords>0)
		{
			?>
			<table class="tblmetlijnenlinks">
				<th  class="tblmetlijnenlinks"  width=50>ReservatieId</th>
				<th  class="tblmetlijnenlinks"  width=75>Datum</th>
				<th  class="tblmetlijnenlinks"  width=50>Tijdstip</th>
				<th  class="tblmetlijnenlinks" width=100>Naam</th>
				<th  class="tblmetlijnenlinks" width=100>Voornaam</th>
				<th  class="tblmetlijnenlinks" width=100>Telefoon</th>
				<th  class="tblmetlijnenlinks" width=100>Mailadres</th>
				<th  class="tblmetlijnenlinks" width=400>Adres</th>
				<th  class="tblmetlijnenrechts" width=75>Volwassenen</th>
				<th  class="tblmetlijnenrechts" width=75>Kinderen</th>
				<th  class="tblmetlijnenrechts" width=75>Bedrag</th>
				<th  class="tblmetlijnenlinks" width=150>Betaald</th>
				
			<?php

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
				$Canceled=$row['Canceled'];
				$Status=$row['Status'];
				$BetaaldDatum=$row['BetaaldDatum'];
				$BetaaldBedrag=$row['BetaaldBedrag'];
				$bedrag=($AantalKinderen * $prijskind) + ($AantalVolwassenen * $prijsvolw);
				if ($Canceled!=1)
				{
					//aantal herinneringsmails
					if ($ReservatieId == "")
					{
						$aantal1=0;
					}
					else
					{
						$query1  = "select * FROM TBL_mails WHERE Type = \"Herinnering betaling\" AND ReservatieId=$ReservatieId";
						$result1 = mysqli_query($link, $query1);
						$aanta1l = mysqli_num_rows($result1);
					}


					echo "<tr onclick=\"reservatie_tonen1($ReservatieId)\"><td class=\"tblmetlijnenrechts\" >$ReservatieId</td><td class=\"tblmetlijnenlinks\">$Datum</td><td class=\"tblmetlijnenlinks\">$Tijdstip</td><td class=\"tblmetlijnenlinks\">$Naam</td><td class=\"tblmetlijnenlinks\">$Voornaam</td><td class=\"tblmetlijnenlinks\">$Telefoon</td><td class=\"tblmetlijnenlinks\">$Mailadres</td><td class=\"tblmetlijnenlinks\">$Adres $Postcode $Gemeente</td><td class=\"tblmetlijnenrechts\">$AantalVolwassenen</td><td class=\"tblmetlijnenrechts\">$AantalKinderen</td><td class=\"tblmetlijnenrechts\">$bedrag €</td>";
					if ($BetaaldDatum!='')
					{
						if ($BetaaldBedrag==$bedrag)
						{
							echo "<td class=\"tblmetlijnenlinks\">$BetaaldBedrag € ($BetaaldDatum)</td>";
						}
						else
						{
							echo "<td class=\"tblmetlijnenlinks\"><span style=\"color:red\">$BetaaldBedrag € ($BetaaldDatum)</span>&emsp;&emsp;<img src=\"../images/euro.png\"  title=\"Betaling registreren\"  style=\"height:25px;border:0;\"  onclick=\"betalingregistreren('$ReservatieId')\"></td>";
						}
						
					}
					else
					{
						if ($bedrag!=0)
						{
							echo "<td class=\"tblmetlijnenlinks\">&emsp;&emsp;<img src=\"../images/euro.png\"  title=\"Betaling registreren\"  style=\"height:25px;border:0;\"  onclick=\"betalingregistreren('$ReservatieId')\">&emsp;&emsp;<img src=\"../images/mail.jpg\"  title=\"Herinneringsmail sturen\"  style=\"height:25px;border:0;\"  onclick=\"betalingsherinnering('$ReservatieId')\"> ($aanta1l)";
							echo "</td>";
						}
						else
						{
							echo "<td class=\"tblmetlijnenlinks\"></td>";
						}
					}
					//echo "<td class=\"tblmetlijnenlinks\">$Status</td>";
					echo "</tr>";
				}
			}
			
			echo "</table>";
		}
		else
		{
			echo "Geen reservaties op deze dag.<br>";
		}
		mysqli_close($link);

?>