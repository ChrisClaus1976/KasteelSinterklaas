<?php
	session_name('SinterklaasLG');
	session_start();
	$debug=0; 
	//$debug = 1; //op 1 zetten om te debuggen
	date_default_timezone_set('Europe/Brussels');

	
	include('../../includes/db_conn.php');
	echo "<h3>Wachtlijst</h3>";
	$query  = "SELECT * FROM TBL_Wachtlijst WHERE Deleted is null"; // ORDER BY Naam, Voornaam";
	//echo "$query<br>";
	$result = mysqli_query($link, $query);
	$aantalrecords = mysqli_num_rows($result);
	$aantal_res=0;
	if ($aantalrecords>0)
	{
		$nr=0;
		$aantkinderen = 0;
		$aantvolw = 0;
		?>
		<table class="tblmetlijnenlinks"><tr>
			<thead>
			<th  class="tblmetlijnenlinks"  width=50 rowspan=2>Nr</th>
			<th  class="tblmetlijnenlinks"  width=80 rowspan=2>Datum</th>
			<th  class="tblmetlijnenlinks"  width=50 rowspan=2>Tijdstip</th>
			<th  class="tblmetlijnenlinks" width=150 rowspan=2>Naam</th>
			<th  class="tblmetlijnenlinks" width=150 rowspan=2>Voornaam</th>
			<th  class="tblmetlijnenlinks" width=150 rowspan=2>Telefoon</th>
			<th  class="tblmetlijnenlinks" width=100 rowspan=2>Mailadres</th>
			<th  class="tblmetlijnenlinks" width=400  rowspan=2>Adres</th>
			<th  class="tblmetlijnenmidden" width=50  colspan=2>Aantal</th>
			<th  class="tblmetlijnenmidden" width=400 colspan=14>Momenten</th></tr>
			<tr>
			<th  class="tblmetlijnenlinks" width=25  >Volw</th>
			<th  class="tblmetlijnenlinks" width=25  >Kind</th>
			
			<?php
			
			$query1  = "select * from TBL_WachtlijstMoment WHERE WachtlijstMomentInGebruik=1 ORDER BY WachtlijstOrder";
			//echo "$query<br>";
			$result1 = mysqli_query($link, $query1);
			while($row1 = mysqli_fetch_assoc($result1))
			{
				$WachtlijstMomentKort=$row1['WachtlijstMomentKort'];
				echo "<th  class=\"tblmetlijnenlinks\"  width=10>$WachtlijstMomentKort</th>";
			}

			?>
			</tr>
			</thead>
		<?php
		while($row = mysqli_fetch_assoc($result))
		{
			$WachtlijstId=$row['WachtlijstId'];
			$Datum=$row['Datum'];
			$Tijd=$row['Tijd'];
			$Naam=$row['Naam'];
			$Voornaam=$row['Voornaam'];
			$Telefoon=strtolower($row['Telefoon']);
			$Mailadres=strtolower($row['Mailadres']);
			//$Mail2511=$row['Mail2511'];
			$aantalkinderen=$row['AantalKinderen'];
			$aantalvolwassenen=$row['AantalVolwassenen'];
			$Moment1=$row['Moment1'];
			$Moment2=$row['Moment2'];
			$Moment3=$row['Moment3'];
			$Moment4=$row['Moment4'];
			$Moment5=$row['Moment5'];
			$Moment6=$row['Moment6'];
			$Moment7=$row['Moment7'];
			$Moment8=$row['Moment8'];
			$Moment9=$row['Moment9'];
			$Moment10=$row['Moment10'];
			$Moment11=$row['Moment11'];
			$Moment12=$row['Moment12'];
			$Moment13=$row['Moment13'];
			$Moment14=$row['Moment14'];
			//kijken of er een reservatie aan gekoppeld werd
			$query1  = "SELECT * FROM TBL_Reservatie WHERE (Mailadres = '$Mailadres' OR Telefoon = '$Telefoon') AND Canceled IS NULL";
			//echo "$query1<br>";
			$result1 = mysqli_query($link, $query1);
			$aantalrecords1 = mysqli_num_rows($result1);
			
				
			$Adres=$row['Adres'];
			$Postcode=$row['Postcode'];
			$Gemeente=$row['Gemeente'];
			
							
			if ($aantalrecords1==0)
			{
				$nr++;
				$aantkinderen = $aantkinderen + $aantalkinderen;
				$aantvolw = $aantvolw + $aantalvolwassenen;
				echo "<tr><td class=\"tblmetlijnenlinks\">$nr</td><td class=\"tblmetlijnenlinks\">$Datum</td><td class=\"tblmetlijnenlinks\">$Tijd</td><td class=\"tblmetlijnenlinks\">$Naam</td><td class=\"tblmetlijnenlinks\">$Voornaam</td><td class=\"tblmetlijnenlinks\">$Telefoon</td><td class=\"tblmetlijnenlinks\">$Mailadres</td><td class=\"tblmetlijnenlinks\">$Adres $Postcode $Gemeente</td>";
				echo "<td class=\"tblmetlijnenrechts\">$aantalvolwassenen</td>";
				echo "<td class=\"tblmetlijnenrechts\">$aantalkinderen</td>";
				
				
				echo "<td class=\"tblmetlijnenmidden\">".toon_moment($Moment1)."</td>";
				echo "<td class=\"tblmetlijnenmidden\">".toon_moment($Moment2)."</td>";

				
				echo "<td class=\"tblmetlijnenmidden\">".toon_moment($Moment3)."</td>";
				echo "<td class=\"tblmetlijnenmidden\">".toon_moment($Moment4)."</td>";

				
				echo "<td class=\"tblmetlijnenmidden\">".toon_moment($Moment5)."</td>";
				echo "<td class=\"tblmetlijnenmidden\">".toon_moment($Moment6)."</td>";
				echo "<td class=\"tblmetlijnenmidden\">".toon_moment($Moment7)."</td>";
				echo "<td class=\"tblmetlijnenmidden\">".toon_moment($Moment8)."</td>";
				echo "<td class=\"tblmetlijnenmidden\">".toon_moment($Moment9)."</td>";
				echo "<td class=\"tblmetlijnenmidden\">".toon_moment($Moment10)."</td>";
				echo "<td class=\"tblmetlijnenmidden\">".toon_moment($Moment11)."</td>";
				echo "<td class=\"tblmetlijnenmidden\">".toon_moment($Moment12)."</td>";
				echo "<td class=\"tblmetlijnenmidden\">".toon_moment($Moment13)."</td>";
				echo "<td class=\"tblmetlijnenmidden\">".toon_moment($Moment14)."</td>";
			
				echo "<td>";
				$divnaam = "divWachtlijst".$WachtlijstId;
				if ($aantalrecords1>0)
				{
					$aantal_res++;
					while($row1 = mysqli_fetch_assoc($result1))
					{
						$ReservatieId = $row1['ReservatieId'];
						$Tel=strtolower($row1['Telefoon']);
						$Mail=strtolower($row1['Mailadres']);
					}
					echo "reservatie ($ReservatieId)";
					/*if ($Mail==$Mailadres)
					{
						echo " Mail ";
					}
					if ($Tel==$Telefoon)
					{
						echo " Tel ";
					}*/

					
				}
				else
				{	
					echo "<input type=\"button\" onclick=\"wachtlijstnaarreservatielijst('$WachtlijstId', '$divnaam')\" value=\"Reservatie maken\">";
				}
				/*if ($Mail2511==1)
				{
					echo "Mail ivm 25/11";
				}*/
				echo "</td>";
				echo "</tr>";
				
				echo "<tr><td colspan=24><div id=\"$divnaam\" hidden>test</div></td></tr>";
			}
		}
		echo "<tr><td class=\"tblzonderlijnenlinks\"></td><td class=\"tblzonderlijnenlinks\"></td><td class=\"tblzonderlijnenlinks\"></td><td class=\"tblzonderlijnenlinks\"></td>";
		echo "<td class=\"tblzonderlijnenlinks\"></td><td class=\"tblzonderlijnenlinks\"></td><td class=\"tblzonderlijnenlinks\"></td><td class=\"tblzonderlijnenlinks\"></td>";
		echo "<td class=\"tblmetlijnenrechts\">$aantvolw</td><td class=\"tblmetlijnenrechts\">$aantkinderen</td></tr>";
		echo "</table><br><br>";
		
		echo "Aantal waarvoor er een reservatie gedaan is: $aantal_res<br><br>";

		
	}
	
	echo "<h3>Contactlijst</h3>";
	$Adres="";
	$Postcode="";
	$Gemeente="";
	$query  = "SELECT * FROM TBL_Contactgegevens";
	//echo "$query<br>";
	$result = mysqli_query($link, $query);
	$aantalrecords = mysqli_num_rows($result);
	if ($aantalrecords>0)
	{
		$nr=0;
		?>
		<table class="tblmetlijnenlinks">
			<th  class="tblmetlijnenlinks"  width=50>Nr</th>
			<th  class="tblmetlijnenlinks"  width=75>Datum</th>
			<th  class="tblmetlijnenlinks"  width=50>Tijdstip</th>
			<th  class="tblmetlijnenlinks" width=150>Naam</th>
			<th  class="tblmetlijnenlinks" width=150>Voornaam</th>
			<th  class="tblmetlijnenlinks" width=150>Telefoon</th>
			<th  class="tblmetlijnenlinks" width=100>Mailadres</th>
			
		<?php
		while($row = mysqli_fetch_assoc($result))
		{
			$Datum=$row['Datum'];
			$Tijd=$row['Tijd'];
			$Naam=$row['Naam'];
			$Voornaam=$row['Voornaam'];
			$Telefoon=$row['Telefoon'];
			$Mailadres=$row['Mailadres'];
			$Mail2511=$row['Mail2511'];
			/*$Adres=$row['Adres'];
			$Postcode=$row['Postcode'];
			$Gemeente=$row['Gemeente'];*/
			$nr++;
							
			echo "<tr><td class=\"tblmetlijnenlinks\">$nr</td><td class=\"tblmetlijnenlinks\">$Datum</td><td class=\"tblmetlijnenlinks\">$Tijd</td><td class=\"tblmetlijnenlinks\">$Naam</td><td class=\"tblmetlijnenlinks\">$Voornaam</td><td class=\"tblmetlijnenlinks\">$Telefoon</td><td class=\"tblmetlijnenlinks\">$Mailadres</td>";
			
			if ($Mail2511==1)
			{
				echo "<td>Mail ivm 25/11</td>";
			}
			echo "</tr>";
		}
		
		echo "</table><br><br>";
		
		
		

		
	}
	mysqli_close($link);
	exit();
	
	function toon_moment($moment)
	{
		if ($moment == 1)
		{
			return "X";
		}
	}
?>