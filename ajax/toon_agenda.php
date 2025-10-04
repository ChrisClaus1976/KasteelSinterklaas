<?php
	include('../includes/opmaak.php');
	include('../includes/db_conn.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();

	define("ADAY", (60*60*24));
	$maanden = Array("**", "Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December");
	if (isset($_GET['jaar']) && isset($_GET['maand']) && isset($_GET['dag']))
	{
	
		$dag=$_GET['dag'];
		$maand=$_GET['maand'];
		$jaar=$_GET['jaar'];
		
		$dagen = Array("Zondag","Maandag","Dinsdag","Woensdag","Donderdag","Vrijdag","Zaterdag");
		$maanden = Array("*", "januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december");
		$datum=mktime(0, 0, 0, $maand, $dag, $jaar);
		//$datum=strtotime($Datum);
			$wdag = date ('w', $datum);
			$dag = date('d', $datum);
			$maand =date('m', $datum);
			$jaar = date ('Y', $datum);
		$Datumlang = "{$dagen[$wdag]} $dag {$maanden[$maand]} $jaar";
	
		echo "Selecteer een vrij moment om Sinterklaas te bezoeken.<br><u><b>$Datumlang</b></u><br>";
		$datum=date('Y-m-d', mktime(0,0,0,$maand,$dag,$jaar));
		$query  = "select * from TBL_data WHERE Datum = '$datum' ORDER BY Datum, Tijdstip";
		$result = mysqli_query($link, $query);
		$aantalreservatie = mysqli_num_rows($result);
		if ($aantalreservatie>0)
		{
			echo "<table>";
			while($row = mysqli_fetch_assoc($result))
			{
				$DataId=$row['DataId'];
				$Datum=$row['Datum'];
				$Tijdstip=$row['Tijdstip'];
				$Beschikbaar=$row['Beschikbaar'];
				echo "<tr><td width=75>$Tijdstip</td><td>";
				if ($Beschikbaar==1)
				{
					echo "<input type=\"button\" onclick=\"selecteertijdstip('$DataId', '$Datum', '$Tijdstip')\" value=\"Selecteer $Tijdstip\" style=\"width: 250px;\">";
				}
				else
				{
					echo "Dit moment is niet meer beschikbaar";
				}
				echo "</td></tr>";
			}
		}
		echo "</table>";
		echo "<input type=\"button\" onclick=\"terug()\" value=\"Terug naar kalender\">";
	}
	else
	{
		//echo "dump:<br>";
		//var_dump($_SESSION);
	}
	mysqli_close($link);
?>