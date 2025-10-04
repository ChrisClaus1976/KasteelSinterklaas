<?php
	
	include('../includes/db_conn.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();
	
	$datum=date('Y-m-d');

	$dagen = Array("Zondag","Maandag","Dinsdag","Woensdag","Donderdag","Vrijdag","Zaterdag");
	$maanden = Array("*", "januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december");
	
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
		echo "Er zijn spijtig genoeg geen vrije momenten meer.<br>";
		echo "We zijn aan het kijken om extra momenten te organiseren.<br><br>Kom regelmatig terug kijken of er terug vrije momenten zijn.<br>";
		echo "<input type=\"button\" onclick=\"wachtlijst()\" value=\"Laat je gegevens hier alvast achter, wij contacteren je als er vrije momenten zijn.\"><br>";
	}

	mysqli_close($link);
?>