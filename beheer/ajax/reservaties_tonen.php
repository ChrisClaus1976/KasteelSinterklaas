<?php
	session_name('SinterklaasLG');
	session_start();
	$debug=0; 
	//$debug = 1; //op 1 zetten om te debuggen
	date_default_timezone_set('Europe/Brussels');

	if(	isset($_GET['datum']))
	{
		$datum=$_GET['datum'];
		//echo "Datum $datum<br>";
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
		
		$query = "SELECT * FROM TBL_data WHERE Beschikbaar<5";
		if ($datum != '')
		{
			$query = $query. " AND TBL_data.Datum='$datum'";
		}
		$query = $query. " ORDER BY TBL_data.Datum, TBL_data.Tijdstip, TBL_data.DataId ";
		//echo "$query<br>";
		$result = mysqli_query($link, $query);
		$aantalrecords = mysqli_num_rows($result);
		if ($aantalrecords>0)
		{
			?>
			<table class="tblmetlijnenlinks">
				<th  class="tblmetlijnenlinks"  width=40>Nr</th>
				<th  class="tblmetlijnenlinks"  width=75>Datum</th>
				<th  class="tblmetlijnenlinks"  width=50>Tijdstip</th>
				<th  class="tblmetlijnenlinks"  width=50>ReservatieId</th>
				<th  class="tblmetlijnenlinks" width=150>Naam</th>
				<th  class="tblmetlijnenlinks" width=150>Voornaam</th>
				<th  class="tblmetlijnenlinks" width=100>Telefoon</th>
				<th  class="tblmetlijnenlinks" width=100>Mailadres</th>
				<th  class="tblmetlijnenlinks" width=350>Adres</th>
				<th  class="tblmetlijnenrechts" width=75>Volwassenen</th>
				<th  class="tblmetlijnenrechts" width=75>Kinderen</th>
				<th  class="tblmetlijnenlinks" width=150>Betaald</th>
				<!--<th  class="tblmetlijnenlinks" width=150>Status</th>-->
			<?php
			$nr=0;
			$aantalkinderen=0;
			$aantalvolwassenen=0;
			$aantalvrijesloten=0;
			$aantalgereserveerdesloten=0;
			$aantalreservesloten=0;
			$vorigetijd='';
			while($row = mysqli_fetch_assoc($result))
			{
				$Datum=$row['Datum'];
				$Tijdstip=$row['Tijdstip'];
				$ReservatieId=$row['ReservatieId'];
				$Beschikbaar=$row['Beschikbaar'];
				$nr++;
				echo "<tr onclick=\"reservatie_tonen($ReservatieId)\"><td class=\"tblmetlijnenlinks\">$nr</td><td class=\"tblmetlijnenlinks\">$Datum</td>";
				if ($Tijdstip==$vorigetijd)
				{
					echo "<td class=\"tblmetlijnenlinkskleur\">$Tijdstip</td>";
				}
				else
				{
					echo "<td class=\"tblmetlijnenlinks\">$Tijdstip</td>";
					$vorigetijd=$Tijdstip;
				}
				if ($ReservatieId != "")
				{
					$query1 = "SELECT * FROM TBL_Reservatie WHERE ReservatieId='$ReservatieId' ";
					$result1 = mysqli_query($link, $query1);
					$aantalrecords1 = mysqli_num_rows($result1);
					if ($aantalrecords1>0)
					{
						while($row1 = mysqli_fetch_assoc($result1))
						{
							$Naam=$row1['Naam'];
							$Voornaam=$row1['Voornaam'];
							$Telefoon=$row1['Telefoon'];
							$Mailadres=$row1['Mailadres'];
							$Adres=$row1['Adres'];
							$Postcode=$row1['Postcode'];
							$Gemeente=$row1['Gemeente'];
							$Vereniging=$row1['Vereniging'];
							$AantalVolwassenen=$row1['AantalVolwassenen'];
							$AantalKinderen=$row1['AantalKinderen'];
							$Canceled=$row1['Canceled'];
							$Status=$row1['Status'];
							$BetaaldDatum=$row1['BetaaldDatum'];
							$BetaaldBedrag=$row1['BetaaldBedrag'];
							if ($Canceled!=1) // && $Status == "Reservatie gedaan")
							{
								
								$aantalkinderen = $aantalkinderen + $AantalKinderen;
								$aantalvolwassenen = $aantalvolwassenen + $AantalVolwassenen;
								echo "<td class=\"tblmetlijnenrechts\" > $ReservatieId</td><td class=\"tblmetlijnenlinks\">$Naam</td><td class=\"tblmetlijnenlinks\">$Voornaam</td><td class=\"tblmetlijnenlinks\">$Telefoon</td><td class=\"tblmetlijnenlinks\">$Mailadres</td><td class=\"tblmetlijnenlinks\">$Adres $Postcode $Gemeente</td><td class=\"tblmetlijnenrechts\">$AantalVolwassenen</td><td class=\"tblmetlijnenrechts\">$AantalKinderen</td>";
								if ($BetaaldDatum!='')
								{
									$bedrag=($AantalKinderen * $prijskind) + ($AantalVolwassenen * $prijsvolw);
									if ($BetaaldBedrag==$bedrag)
									{
										echo "<td class=\"tblmetlijnenlinks\">$BetaaldBedrag € ($BetaaldDatum)</td>";
									}
									else
									{
										echo "<td class=\"tblmetlijnenlinks\"><span style=\"color:red\">$BetaaldBedrag € ($BetaaldDatum)</span></td>";
									}
								}
								else
								{
									echo "<td class=\"tblmetlijnenlinks\"></td>";
								}
								//echo "<td class=\"tblmetlijnenlinks\">$Status</td>";
								echo "<td>$Vereniging</td>";
								$aantalgereserveerdesloten++;
							}
						}
					}
					else
					{
						$aantalvrijesloten++;
						echo "<td class=\"tblmetlijnenlinks\" colspan=9></td>";
					}
				}
				else
				{
					if ($Beschikbaar == 0)
					{
						$aantalreservesloten++;
						echo "<td class=\"tblmetlijnenlinks\" colspan=9>reserve</td>";
					}
					else
					{
						$aantalvrijesloten++;
						echo "<td class=\"tblmetlijnenlinks\" colspan=9></td>";
					}
				}
				echo "</tr>";
			}
			echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td class=\"tblmetlijnenrechts\"><b>$aantalvolwassenen</b></td><td class=\"tblmetlijnenrechts\"><b>$aantalkinderen</b></td><td></td></tr>";
			echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td class=\"tblmetlijnenrechts\">Volwassenen</td><td class=\"tblmetlijnenrechts\">Kinderen</td><td></td></tr>";
			echo "</table><br>";
			echo "Aantal gereserveerde sloten: $aantalgereserveerdesloten<br>";
			echo "Aantal vrije sloten: $aantalvrijesloten<br>";
			echo "Aantal reserve sloten: $aantalreservesloten<br>";
		}
		else
		{
			echo "Geen reservaties op deze dag.<br>";
		}
		mysqli_close($link);
	}
?>