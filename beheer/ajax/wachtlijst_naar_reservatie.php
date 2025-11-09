<?php
	session_name('SinterklaasLG');
	session_start();
	$debug=0; 
	//$debug = 1; //op 1 zetten om te debuggen
	date_default_timezone_set('Europe/Brussels');
	$datumvandaag=date('Y-m-d');
	$tijd = date('H:i:s', time());

	if (isset($_GET['wachtlijstid']) && isset($_GET['dataid']))
	{
		include('../../includes/db_conn.php');
		
		$wachtlijstid=$_GET['wachtlijstid'];
		$dataid=$_GET['dataid'];
		
	
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
		
		
		
		
		//datagegevens ophalen
		$query  = "SELECT * FROM TBL_data WHERE DataId = $dataid";
		//echo "$query<br>";
		$result = mysqli_query($link, $query);
		$aantalrecords = mysqli_num_rows($result);

		if ($aantalrecords>0)
		{
			while($row = mysqli_fetch_assoc($result))
			{
				$ReservatieDatum=$row['Datum'];
				$ReservatieTijdstip=$row['Tijdstip'];
				
				//echo "$ReservatieDatum $ReservatieTijdstip<br>"; exit();
				
				$dagen = Array("zondag","maandag","dinsdag","woensdag","donderdag","vrijdag","zaterdag");
				$maanden = Array("*", "januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december");
				$datum=strtotime($ReservatieDatum);
				$wdag = date ('w', $datum);
				$dag = date('d', $datum);
				$maand = date('m', $datum);
				$jaar = date ('Y', $datum);
				$Datumlang = "{$dagen[$wdag]} $dag {$maanden[$maand]} $jaar";
				//echo "$ReservatieDatum $ReservatieTijdstip - $datum - $Datumlang<br>"; exit();
			}

			$query  = "SELECT * FROM TBL_Wachtlijst WHERE WachtlijstId = $wachtlijstid";
			//echo "$query<br>";
			$result = mysqli_query($link, $query);
			$aantalrecords = mysqli_num_rows($result);

			if ($aantalrecords>0)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$naam=$row['Naam'];
					$voornaam=$row['Voornaam'];
					$telefoon=$row['Telefoon'];
					$mailadres=$row['Mailadres'];
					$adres=$row['Adres'];
					$postcode=$row['Postcode'];
					$gemeente=$row['Gemeente'];
					$aantalkinderen=$row['AantalKinderen'];
					$aantalvolwassenen=$row['AantalVolwassenen'];
					//unieke code maken
					$str=rand();
					$uniekecode = sha1($str);
					//echo $uniekecode;
					$prijs = ($aantalkinderen * $prijskind) + ($aantalvolwassenen * $prijsvolw);

					$query = "INSERT into TBL_Reservatie
								(Tijdstip, Datum, Tijd, Naam, Voornaam, Telefoon, Mailadres, Adres, Postcode, Gemeente, AantalKinderen, AantalVolwassenen, UniekeCode, Status )
								values 
								('$dataid', '$datumvandaag', \"$tijd\", \"$naam\", \"$voornaam\", \"$telefoon\", \"$mailadres\", \"$adres\", \"$postcode\", \"$gemeente\", '$aantalkinderen', '$aantalvolwassenen', '$uniekecode', 'Via wachtlijst')";
					//echo "$query<br>";
					if (mysqli_query($link, $query))
					{
						//Reservatie gemaakt
						$reservatieid = mysqli_insert_id($link);
						$queryupd = "UPDATE TBL_data SET Beschikbaar='0', Reservatietijd='$datumvandaag $tijd', ReservatieId=$reservatieid, Status='Via wachtlijst' WHERE DataId='".$dataid."'";
						if (mysqli_query($link, $queryupd))
						{
							//data aangepast
							
							$mededeling = "Reservatie $reservatieid";
							//mail sturen
							$onderwerp='Reservatie Het kasteel van Sinterklaas Gruitrode';
							$boodschap="<html><head><title>HTML email</title></head><body>Beste $voornaam,<br><br>U stond op de wachtlijst voor een reservatie.<br>Wij hebben een tijdslot voor u kunnen reserveren.<br><br>";
							$boodschap=$boodschap."We zien jullie graag terug op <b>$Datumlang</b> om <b>$ReservatieTijdstip</b>. Gelieve minstens 10 minuten op voorhand aanwezig te zijn.<br><br>";
							
							$boodschap=$boodschap."Parkeren kan op het Phil Bosmansplein, volg de vlaggen tot aan het kasteel (+/- 5 minuten wandelen).<br><br>Kan je door omstandigheden niet aanwezig zijn. Gelieve ons dan zo snel mogelijk te contacteren (via reply op deze mail), dan kunnen we het tijdslot terug openstellen voor een ander gezin.<br><br>Voor en na het bezoek ben je altijd welkom aan onze Sint-bar in de verwarmde tent op de binnenkoer van het Kasteel!<br><br><br>";
							
							$boodschap=$boodschap."<b>Uw inschrijving is pas definitief na de betaling.</b><br><br>Gelieve <b>$prijs euro</b> over te schrijven op rekening <b>BE15 7340 4044 1430</b> van <b>Sinterklaaswerking</b> met als mededeling <b>$mededeling</b>.<br><br>";

							$boodschap=$boodschap."Wij registreerden volgende gegevens:<br><br><b>Gegevens ouder(s)</b><br>Naam: $naam<br>Voornaam: $voornaam<br>Email: $mailadres<br>Telefoonnummer: $telefoon<br>Adres: $adres $postcode $gemeente<br><br>Aantal volwassenen: $aantalvolwassenen<br>Aantal kinderen: $aantalkinderen<br><br>";
							$boodschap = $boodschap."<br>Gelieve de gegevens van de kinderen aan te passen via deze link<br><a href='http://claus-solutions.be/KasteelSinterklaas/dossier.php?naam=$naam&code=$uniekecode'>http://claus-solutions.be/KasteelSinterklaas/dossier.php?naam=$naam&code=$uniekecode</a><br><br>";
							$boodschap=$boodschap."Met vriendelijke groeten<br>Medewerkers het kasteel van Sinterklaas Gruitrode";
							
							$boodschap = $boodschap."</body></html>";
							$ontvanger=$mailadres;
							$query = "INSERT into TBL_mails 
								(Datum, Tijd, Type, ReservatieId, Verzender, Ontvanger, Onderwerp, Boodschap, Status)
								values 
								('$datum', \"$tijd\", \"Reservatie\", '$reservatieid', \"landelijkegildegruitrode@gmail.com\", \"$ontvanger\", \"$onderwerp\", \"$boodschap\", \"to do\")";
							if (mysqli_query($link, $query))
							{
								$nr = mysqli_insert_id($link);
								return 0;
							}
							else
							{
								echo "Error bij toegang database (Error 001)<br>";
								echo "Error description: ".mysqli_error($link)."<br>$query";
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
						
						
						mysqli_close($link);

					}
				}
			}
		}
	}
	exit();
?>