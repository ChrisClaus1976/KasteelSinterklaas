<?php
	include('../includes/db_conn.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();
	
	if (isset($_GET['naam']) && isset($_GET['voornaam']) && isset($_GET['telefoon']) && isset($_GET['mailadres']))
	{
	
		$naam=$_GET['naam'];
		$voornaam=$_GET['voornaam'];
		$telefoon=$_GET['telefoon'];
		$mailadres=$_GET['mailadres'];
		$adres=$_GET['adres'];
		$postcode=$_GET['postcode'];
		$gemeente=$_GET['gemeente'];
		$aantalkinderen=$_GET['aantalkinderen'];
		$aantalvolwassenen=$_GET['aantalvolwassenen'];
		
		$moment1=$_GET['moment1'];
		$moment2=$_GET['moment2'];
		$moment3=$_GET['moment3'];
		$moment4=$_GET['moment4'];
		$moment5=$_GET['moment5'];
		$moment6=$_GET['moment6'];
		$moment7=$_GET['moment7'];
		$moment8=$_GET['moment8'];
		$moment9=$_GET['moment9'];
		$moment10=$_GET['moment10'];
		$moment11=$_GET['moment11'];
		$moment12=$_GET['moment12'];
		$moment13=$_GET['moment13'];
		$moment14=$_GET['moment14'];
		
		$momenten = array();
		$query  = "select * from TBL_WachtlijstMoment WHERE WachtlijstMomentInGebruik=1 ORDER BY WachtlijstOrder";
		$result = mysqli_query($link, $query);
		$aantal = mysqli_num_rows($result);
		if ($aantal>0)
		{
			while($row = mysqli_fetch_assoc($result))
			{
				$WachtlijstOrder=$row['WachtlijstOrder'];
				$WachtlijstMoment=$row['WachtlijstMoment'];
				$momenten[$WachtlijstOrder]=$WachtlijstMoment;
			}
		}
	
		$datum=date('Y-m-d');
		$tijd = date('H:i:s', time());
		
		$query = "INSERT into TBL_Wachtlijst
					(Datum, Tijd, Naam, Voornaam, Telefoon, Mailadres, Adres, Postcode, Gemeente, AantalKinderen, AantalVolwassenen, Moment1, Moment2, Moment3, Moment4, Moment5, Moment6, Moment7, Moment8, Moment9, Moment10, Moment11, Moment12, Moment13, Moment14 )
					values 
					('$datum', \"$tijd\", \"$naam\", \"$voornaam\", \"$telefoon\", \"$mailadres\", \"$adres\", \"$postcode\", \"$gemeente\", '$aantalkinderen', '$aantalvolwassenen', '$moment1', '$moment2', '$moment3', '$moment4', '$moment5', '$moment6', '$moment7', '$moment8', '$moment9', '$moment10', '$moment11', '$moment12', '$moment13', '$moment14')";
		//echo "$query<br>";
		if (mysqli_query($link, $query))
		{
			
			//mail sturen
			$onderwerp='Wachtlijst Het kasteel van Sinterklaas Gruitrode';
			$boodschap="<html><head><title>HTML email</title></head><body>Bedankt voor de registratie van uw gegevens.<br><br>Je staat op de wachtlijst. Zodra er extra tijdsloten vrij komen wordt u op de hoogte gebracht.<br><br>We doen ons best om zo snel mogelijk extra tijdsloten vrij te maken.<br><br>Sinterklaas en zijn Pieten zullen er alles aan doen om nog zoveel mogelijk kinderen te ontvangen.<br><br>Dit is <u>geen</u> reservatie voor een bezoek aan het kasteel van Sinterklaas.<br><br>U kunt altijd zonder reservatie de Sint bezoeken op 29 november tijdens de Sinterklaaswandeling. <b>Let op</b> inschrijven is hiervoor verplicht in de Harmoniezaal (Harmonieweg 38a, 3670 Oudsbergen).<br>Meer info via <a href='http://kasteelvansinterklaasgruitrode.be/wandeling.php'>http://kasteelvansinterklaasgruitrode.be/wandeling.php</a><br><br>";
			$boodschap=$boodschap."We registreerden volgende gegevens:<br>Naam: $naam<br>Voornaam: $voornaam<br>Telefoon: $telefoon<br>Mailadres: $mailadres<br>Adres: $adres, $postcode $gemeente<br>";
			$boodschap=$boodschap."Aantal kinderen: $aantalkinderen<br>Aantal volwassenen: $aantalvolwassenen<br><br>";
			$boodschap=$boodschap."Opgegeven momenten dat u aangaf:<br>";
			
			if ($moment1 == 1)
			{
				$boodschap=$boodschap."{$momenten[1]}<br>";
			}
			if ($moment2 == 1)
			{
				$boodschap=$boodschap."{$momenten[2]}<br>";
			}
			if ($moment3 == 1)
			{
				$boodschap=$boodschap."{$momenten[3]}<br>";
			}
			if ($moment4 == 1)
			{
				$boodschap=$boodschap."{$momenten[4]}<br>";
			}
			if ($moment5 == 1)
			{
				$boodschap=$boodschap."{$momenten[5]}<br>";
			}
			if ($moment6 == 1)
			{
				$boodschap=$boodschap."{$momenten[6]}<br>";
			}
			if ($moment7 == 1)
			{
				$boodschap=$boodschap."{$momenten[7]}<br>";
			}
			if ($moment8 == 1)
			{
				$boodschap=$boodschap."{$momenten[8]}<br>";
			}
			if ($moment9== 1)
			{
				$boodschap=$boodschap."{$momenten[9]}<br>";
			}
			if ($moment10 == 1)
			{
				$boodschap=$boodschap."{$momenten[10]}<br>";
			}
			if ($moment11 == 1)
			{
				$boodschap=$boodschap."{$momenten[11]}<br>";
			}
			if ($moment12 == 1)
			{
				$boodschap=$boodschap."{$momenten[12]}<br>";
			}
			if ($moment13 == 1)
			{
				$boodschap=$boodschap."{$momenten[13]}<br>";
			}
			if ($moment14 == 1)
			{
				$boodschap=$boodschap."{$momenten[14]}<br>";
			}
		
			
			$boodschap=$boodschap."<br><br>Met vriendelijke groeten<br>Medewerkers het kasteel van Sinterklaas Gruitrode";
			$boodschap = $boodschap."</body></html>";
			$ontvanger=$mailadres;
			$query = "INSERT into TBL_mails 
				(Datum, Tijd, Type, Verzender, Ontvanger, Onderwerp, Boodschap, Status)
				values 
				('$datum', \"$tijd\", \"Wachtlijst\", \"landelijkegildegruitrode@gmail.com\", \"$ontvanger\", \"$onderwerp\", \"$boodschap\", \"to do\")";
			if (mysqli_query($link, $query))
			{
				$nr = mysqli_insert_id($link);
				echo 1;
			}
			else
			{
				echo "Error bij toegang database (Error 001)<br>";
				echo "Error description: ".mysqli_error($link)."<br>$query";
				mysqli_close($link);
				exit;
			}
		}
	}
?>
