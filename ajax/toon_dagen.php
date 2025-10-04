<?php
	
	include('../includes/db_conn.php');
	date_default_timezone_set('Europe/Brussels');
	$datum=date('Y-m-d');
	session_name("SinterklaasLG");
	session_start();
	
	$query  = "select * FROM TBL_parameters WHERE InGebruik = 1";
	$result = mysqli_query($link, $query);
	$aantal = mysqli_num_rows($result);
	if ($aantal>0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$startdatum = $row['ReservatieStartdatum'];
			$starttijd = $row['ReservatieStarttijd'];
			$onholddatum = $row['ReservatieOnHoldDatum'];
			$datumwandeling = $row['WandelingDatum'];
		}
	}
	else
	{
		echo "ERROR. Er is een fout opgetreden bij het ophalen van de reservatiegegevens<br>";
		exit();
	}
	
	
	//$startdatum = "2024-10-13";
	//$starttijd = "11:45:00";
	
	
	
	$soort="";
	if (isset($_GET['soort']))
	{
		$soort=$_GET['soort'];
	}

	$dagen = Array("Zondag","Maandag","Dinsdag","Woensdag","Donderdag","Vrijdag","Zaterdag");
	$maanden = Array("*", "januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december");
	$inschrijven = false;
	if ($datum > $onholddatum) // inschrijvingen afgesloten
	{
		echo "Er zijn spijtig genoeg geen vrije momenten meer.<br><br>Kom regelmatig terug kijken of er terug vrije momenten zijn.<br><br>Je kunt zonder afspraak tijdens de vrije doorloopmomenten het kasteel bezoeken.<br><br>";
		if ($datum < $datumwandeling)
		{
			echo "Je kunt de Sint nog bezoeken op 29 november tijdens de Sinterklaaswandeling. Meer info vind je <a href=\"http://kasteelvansinterklaasgruitrode.be/wandeling.php\">hier</a><br>";
		}
		echo "Wil je op de hoogte gehouden worden van andere initiatieven van de Landelijke Gilde Guitrode, laat dan hier je gegevens achter.<br>";
		echo "<input type=\"button\" onclick=\"contactlijst()\" value=\"Laat je gegevens hier alvast achter om op de hoogte gehouden te worden.\"><br>";
	}
	else
	{
		if ($datum < $startdatum)
		{
			//nog niet open
			echo "<br><span style=\"color:red\">De reservaties staan nog niet open. Nog even geduld.<br>Binnenkort verschijnen de beschikbare data op deze pagina.</span><br>";
			
			echo "<div class=\"btn-box\"><a href=\"kalender.php\">Bekijk alvast de kalender</a></div>";
		}
		else
		{
			if ($datum == $startdatum)
			{
				$tijd = date('H:i:s', time());
				//echo "$tijd";
				if ($tijd < $starttijd)
				{
					//nog niet open
					echo "<br><span style=\"color:red\">De reservaties staan nog niet open. Nog een beetje geduld.<br>Binnenkort verschijnen de beschikbare data op deze pagina.</span><br>";
					echo "<div class=\"btn-box\"><a href=\"kalender.php\">Bekijk alvast de kalender</a></div>";
				}
				else
				{
					//inschrijven
					$inschrijven= true;
				}
			}
			else
			{
				$inschrijven = true;
			}
				
			if ($inschrijven)		
			{
				//na de opening -- inschrijven
				$query  = "select DISTINCT Datum from TBL_data WHERE Beschikbaar=1 AND Datum>'$datum' ORDER BY Datum";
				$result = mysqli_query($link, $query);
				$aantalreservatie = mysqli_num_rows($result);
				if ($aantalreservatie>0)
				{
					echo "Beschikbare data:<br>";
					while($row = mysqli_fetch_assoc($result))
					{
						$Datum=$row['Datum'];
						$datum=strtotime($Datum);
						$wdag = date ('w', $datum);
						$dag = date('d', $datum);
						$maand =date('m', $datum);
						$jaar = date ('Y', $datum);
						//echo "$Datum $dag $maand $jaar<br>";
						
						echo "<input type=\"button\" onclick=\"selecteerdag('$jaar', '$maand', '$dag')\" value=\"{$dagen[$wdag]} $dag {$maanden[$maand]} $jaar\" style=\"height: 75px; width: 250px;\"><br><br>";

					}
				}
				else
				{
					echo "Er zijn spijtig genoeg geen vrije momenten meer.<br><br>Kom regelmatig terug kijken of er terug vrije momenten zijn.<br><br>Je kunt zonder afspraak tijdens de vrije doorloopmomenten het kasteel bezoeken.<br><br>";
					if ($datum < $datumwandeling)
					{
						echo "Je kunt de Sint nog bezoeken op 29 november tijdens de Sinterklaaswandeling. Meer info vind je <a href=\"http://kasteelvansinterklaasgruitrode.be/wandeling.php\">hier</a><br>";
					}
					//if ($soort=="wachtlijst")
					//{
						//echo "We zijn aan het kijken om extra momenten te organiseren.<br><br>";
						echo "<input type=\"button\" onclick=\"wachtlijst()\" value=\"Laat je gegevens achter op de wachtlijst, wij contacteren je als er vrije momenten zijn.\"><br>";
					/*}
					else
					{
						if ($soort=="contactlijst")
						{
							
							echo "Wil je op de hoogte gehouden worden van andere initiatieven van de Landelijke Gilde Guitrode, laat dan hier je gegevens achter.<br>";
							echo "<input type=\"button\" onclick=\"contactlijst()\" value=\"Laat je gegevens hier alvast achter om op de hoogte gehouden te worden.\"><br>";
						}
					}*/
				}
			}
		}
	}

	mysqli_close($link);
?>