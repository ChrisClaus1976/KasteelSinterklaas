<?php
	include('../includes/db_conn.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();
	
	if (isset($_GET['naam']) && isset($_GET['voornaam']))
	{
	
		$naam=$_GET['naam'];
		$voornaam=$_GET['voornaam'];
		
		$reservatieid=$_SESSION['reservatie']['reservatieid'];
		
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
		
		//unieke code maken
		$str=rand();
		$uniekecode = sha1($str);
		//echo $uniekecode;
		
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
				$Kind6Naam=$row['Kind6Naam'];
				$Kind6Voornaam=$row['Kind6Voornaam'];
				$Kind6Leeftijd=$row['Kind6Leeftijd'];
				$Kind6Goed=$row['Kind6Goed'];
				$Kind6Beter=$row['Kind6Beter'];
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
		$dagen = Array("zondag","maandag","dinsdag","woensdag","donderdag","vrijdag","zaterdag");
		$maanden = Array("*", "januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december");
		$datum=strtotime($ReservatieDatum);
			$wdag = date ('w', $datum);
			$dag = date('d', $datum);
			$maand =date('m', $datum);
			$jaar = date ('Y', $datum);
		$Datumlang = "{$dagen[$wdag]} $dag {$maanden[$maand]} $jaar";
		
		$query = "UPDATE TBL_Reservatie SET UniekeCode='$uniekecode', Status='Reservatie gedaan' WHERE ReservatieId='".$reservatieid."'";
		//echo "$query<br>";
		if (mysqli_query($link, $query))
		{
			$query = "UPDATE TBL_data SET Status='Reservatie gedaan' WHERE DataId='".$DataId."'";
			//echo "$query<br>";
			if (mysqli_query($link, $query))
			{
				$datum=date('Y-m-d');
				$tijd = date('H:i:s', time());
				$ipadres=$_SERVER['REMOTE_ADDR'];
				$query1 = "INSERT into TBL_reservatieLog
					(ReservatieId, Datum, Tijd, IpAdress, Veld,  Waarde)
					values 
					(\"$reservatieid\", '$datum', \"$tijd\", \"$ipadres\", \"UniekeCode\", \"$uniekecode\")";
				if (mysqli_query($link, $query1))
				{
					$query1 = "INSERT into TBL_reservatieLog
						(ReservatieId, Datum, Tijd, IpAdress, Veld,  Waarde)
						values 
						(\"$reservatieid\", '$datum', \"$tijd\", \"$ipadres\", \"Status\", \"Reservatie gedaan\")";
					if (mysqli_query($link, $query1))
					{
						$prijs = ($AantalKinderen * $prijskind) + ($AantalVolwassenen * $prijsvolw);
						$mededeling = "Reservatie $reservatieid";
						//mail sturen
						$onderwerp='Reservatie Het kasteel van Sinterklaas Gruitrode';
						$boodschap="<html><head><title>HTML email</title></head><body>Bedankt voor uw reservatie.<br><br><b>Uw inschrijving is pas definitief na de betaling.</b><br><br>Gelieve <b>$prijs euro</b> over te schrijven op rekening <b>BE15 7340 4044 1430</b> van <b>Sinterklaaswerking</b> met als mededeling <b>$mededeling</b>.<br><br>";

						$boodschap=$boodschap."We zien jullie graag terug op <b>$Datumlang</b> om <b>$ReservatieTijdstip</b>. Gelieve minstens 10 minuten op voorhand aanwezig te zijn.<br><br>";
						$boodschap=$boodschap."Parkeren kan op het Phil Bosmansplein, volg de vlaggen tot aan het kasteel (+/- 5 minuten wandelen).<br><br>Kan je door omstandigheden niet aanwezig zijn. Gelieve ons dan zo snel mogelijk te contacteren (via reply op deze mail), dan kunnen we het tijdslot terug openstellen voor een ander gezin.<br><br>Voor en na het bezoek ben je altijd welkom aan onze Sint-bar in de verwarmde tent op de binnenkoer van het Kasteel!<br><br><br>";

						$boodschap=$boodschap."Wij registreerden volgende gegevens:<br><br><b>Gegevens ouder(s)</b><br>Naam: $Naam<br>Voornaam: $Voornaam<br>Email: $Mailadres<br>Telefoonnummer: $Telefoon<br>Adres: $Adres $Postcode $Gemeente<br>Aantal volwassenen: $AantalVolwassenen<br><br><b>Gegevens kinderen</b><br>Aantal kinderen: $AantalKinderen<br><br>";
						
						if ($AantalKinderen>=1)
						{
							$boodschap=$boodschap."Kind 1:<br>Naam: $Kind1Naam<br>Voornaam: $Kind1Voornaam<br>Leeftijd: $Kind1Leeftijd<br>Goede eigenschappen: $Kind1Goed<br>Dingen die beter kunnen: $Kind1Beter<br><br>";
						}
						if ($AantalKinderen>=2)
						{
							$boodschap=$boodschap."Kind 2:<br>Naam: $Kind2Naam<br>Voornaam: $Kind2Voornaam<br>Leeftijd: $Kind2Leeftijd<br>Goede eigenschappen: $Kind2Goed<br>Dingen die beter kunnen: $Kind2Beter<br><br>";
						}
						if ($AantalKinderen>=3)
						{
							$boodschap=$boodschap."Kind 3:<br>Naam: $Kind3Naam<br>Voornaam: $Kind3Voornaam<br>Leeftijd: $Kind3Leeftijd<br>Goede eigenschappen: $Kind3Goed<br>Dingen die beter kunnen: $Kind3Beter<br><br>";
						}
						if ($AantalKinderen>=4)
						{
							$boodschap=$boodschap."Kind 4:<br>Naam: $Kind4Naam<br>Voornaam: $Kind4Voornaam<br>Leeftijd: $Kind4Leeftijd<br>Goede eigenschappen: $Kind4Goed<br>Dingen die beter kunnen: $Kind4Beter<br><br>";
						}
						if ($AantalKinderen>=5)
						{
							$boodschap=$boodschap."Kind 5:<br>Naam: $Kind5Naam<br>Voornaam: $Kind5Voornaam<br>Leeftijd: $Kind5Leeftijd<br>Goede eigenschappen: $Kind5Goed<br>Dingen die beter kunnen: $Kind5Beter<br><br>";
						}
						if ($AantalKinderen>=6)
						{
							$boodschap=$boodschap."Kind 6:<br>Naam: $Kind6Naam<br>Voornaam: $Kind6Voornaam<br>Leeftijd: $Kind6Leeftijd<br>Goede eigenschappen: $Kind6Goed<br>Dingen die beter kunnen: $Kind6Beter<br><br>";
						}
						$boodschap = $boodschap."<br>Je kunt deze gegevens wijzigen via deze link<br><a href='http://kasteelvansinterklaasgruitrode.be/dossier.php?naam=$Naam&code=$uniekecode'>http://kasteelvansinterklaasgruitrode.be/dossier.php?naam=$Naam&code=$uniekecode</a><br><br>";
						$boodschap=$boodschap."Met vriendelijke groeten<br>Medewerkers het kasteel van Sinterklaas Gruitrode";
						$boodschap = $boodschap."</body></html>";
						$ontvanger=$Mailadres;
						$query = "INSERT into TBL_mails 
							(Datum, Tijd, Type, ReservatieId, Verzender, Ontvanger, Onderwerp, Boodschap, Status)
							values 
							('$datum', \"$tijd\", \"Reservatie\", '$reservatieid', \"landelijkegildegruitrode@gmail.com\", \"$ontvanger\", \"$onderwerp\", \"$boodschap\", \"to do\")";
						if (mysqli_query($link, $query))
						{
							$nr = mysqli_insert_id($link);
							$_SESSION['reservatie']['status']="ReserveringOK";
							echo 1;
						}
						else
						{
							echo "Error bij toegang database (Error 005)<br>";
							echo "Error description: ".mysqli_error($link)."<br>$query";
							mysqli_close($link);
							exit;
						}
					}
					else
					{
						echo "Error bij toegang database (Error 004)<br>";
						//echo "Error description: ".mysqli_error($link);
						mysqli_close($link);
						exit;
					}
				}
				else
				{
					echo "Error bij toegang database (Error 003)<br>";
					//echo "Error description: ".mysqli_error($link);
					mysqli_close($link);
					exit;
				}
			}
			else
			{
				echo "Error bij toegang database (Error 002)<br>";
				//echo "Error description: ".mysqli_error($link);
				mysqli_close($link);
				exit;
			}
		}
		else
		{
			echo "Error bij toegang database (Error 001)<br>";
			//echo "Error description: ".mysqli_error($link);
			mysqli_close($link);
			exit;
		}
		
	}
?>
