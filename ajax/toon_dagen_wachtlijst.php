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
			$einddatum = $row['ReservatieWachtlijstEinddatum'];
			$eindtijd = $row['ReservatieWachtlijstEindtijd'];
		}
	}
	else
	{
		echo "ERROR. Er is een fout opgetreden bij het ophalen van de reservatiegegevens<br>";
		exit();
	}
	
	$soort="";
	if (isset($_GET['soort']))
	{
		$soort=$_GET['soort'];
	}

	$dagen = Array("Zondag","Maandag","Dinsdag","Woensdag","Donderdag","Vrijdag","Zaterdag");
	$maanden = Array("*", "januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december");
	$inschrijven = false;
	echo "<br>";
	//echo "einddatum: $einddatum - eindtijd: $eindtijd<br>";
	if ($datum > $einddatum)
	{
		echo "Er zijn spijtig genoeg geen vrije momenten meer.<br><br>"; //Kom regelmatig terug kijken of er terug vrije momenten zijn.<br><br>";
		if ($soort=="wachtlijst")
		{
			echo "We zijn aan het kijken om extra momenten te organiseren.<br><br>";
		}
		else
		{
			if ($soort=="contactlijst")
			{
				if ($datum < "2024-11-30")
				{
					echo "Je kunt de Sint nog bezoeken op 30 november tijdens de Sinterklaaswandeling. Meer info vind je <a href=\"http://kasteelvansinterklaasgruitrode.be/wandeling.php\">hier</a><br>";
				}
			}
		}
	}
	else
	{
		if ($datum == $einddatum)
		{
			$tijd = date('H:i:s', time());
			//echo "$tijd";
			if ($tijd > $eindtijd)
			{
				echo "Er zijn spijtig genoeg geen vrije momenten meer.<br><br>"; //Kom regelmatig terug kijken of er terug vrije momenten zijn.<br><br>";
				if ($soort=="wachtlijst")
				{
					echo "We zijn aan het kijken om extra momenten te organiseren.<br><br>";
				}
				else
				{
					if ($soort=="contactlijst")
					{
						if ($datum < "2024-11-30")
						{
							echo "Je kunt de Sint nog bezoeken op 30 november tijdens de Sinterklaaswandeling. Meer info vind je <a href=\"http://kasteelvansinterklaasgruitrode.be/wandeling.php\">hier</a><br>";
						}
					}
				}
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
				echo "<h2>Let op:</h2><span style=\"color:red\">Deze pagina is enkel voor personen die op de wachtlijst staan. Inschrijvingen van personen die niet op de wachtlijst staan, worden geannuleerd.</span><br>";
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
				
			}
		}
	}

	mysqli_close($link);
?>