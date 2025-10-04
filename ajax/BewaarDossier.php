<?php
	include('../includes/db_conn.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();
	
	
	if (isset($_GET['naamkind1']) && isset($_GET['voornaamkind1']))
	{
	
		$naamkind1=$_GET['naamkind1'];
		$voornaamkind1=$_GET['voornaamkind1'];
		//echo "$naamkind1 $voornaamkind1<br>";
		
		$reservatieid=$_SESSION['reservatie']['reservatieid'];
		
		
		$query  = "select * from TBL_Reservatie WHERE ReservatieId='".$reservatieid."'";
		$result = mysqli_query($link, $query);
		$aantalreservatie = mysqli_num_rows($result);
		if ($aantalreservatie>0)
		{
			while($row = mysqli_fetch_assoc($result))
			{
				$Tijdstip=$row['Tijdstip'];
				$Naam=$row['Naam'];
				$Voornaam=$row['Voornaam'];
				$Telefoon=$row['Telefoon'];
				$Mailadres=$row['Mailadres'];
				$Adres=$row['Adres'];
				$Postcode=$row['Postcode'];
				$Gemeente=$row['Gemeente'];
				$AantalKinderen=$row['AantalKinderen'];
				$AantalVolwassenen=$row['AantalVolwassenen'];
				$Kind1Naam=$row['Kind1Naam'];
				$Kind1Voornaam=$row['Kind1Voornaam'];
				$Kind1Leeftijd=$row['Kind1Leeftijd'];
				$Kind1Goed=$row['Kind1Goed'];
				$Kind1Beter=$row['Kind1Beter'];
				$Kind2Naam=$row['Kind2Naam'];
				$Kind2Voornaam=$row['Kind2Voornaam'];
				$Kind2Leeftijd=$row['Kind2Leeftijd'];
				$Kind2Goed=$row['Kind2Goed'];
				$Kind2Beter=$row['Kind2Beter'];
				$Kind3Naam=$row['Kind3Naam'];
				$Kind3Voornaam=$row['Kind3Voornaam'];
				$Kind3Leeftijd=$row['Kind3Leeftijd'];
				$Kind3Goed=$row['Kind3Goed'];
				$Kind3Beter=$row['Kind3Beter'];
				$Kind4Naam=$row['Kind4Naam'];
				$Kind4Voornaam=$row['Kind4Voornaam'];
				$Kind4Leeftijd=$row['Kind4Leeftijd'];
				$Kind4Goed=$row['Kind4Goed'];
				$Kind4Beter=$row['Kind4Beter'];
				$Kind5Naam=$row['Kind5Naam'];
				$Kind5Voornaam=$row['Kind5Voornaam'];
				$Kind5Leeftijd=$row['Kind5Leeftijd'];
				$Kind5Goed=$row['Kind5Goed'];
				$Kind5Beter=$row['Kind5Beter'];
				$VerklaringBetaling=$row['VerklaringBetaling'];
				$KortingCode=$row['KortingCode'];
			}
		}
		
		$query  = "select * from TBL_data WHERE DataId='".$Tijdstip."'";
		$result = mysqli_query($link, $query);
		$aantaltijdstip = mysqli_num_rows($result);
		if ($aantaltijdstip>0)
		{
			while($row = mysqli_fetch_assoc($result))
			{
				$DataId=$row['DataId'];
				$ReservatieDatum=$row['Datum'];
				$ReservatieTijdstip=$row['Tijdstip'];
			}
		}
		
		echo 1;
		
	}
?>
