<?php
	session_name('SinterklaasLG');
	session_start();
	$debug=0; 
	//$debug = 1; //op 1 zetten om te debuggen
	date_default_timezone_set('Europe/Brussels');

	if(	isset($_GET['reservatieid']) && isset($_GET['bedrag']))
	{
		$reservatieid=$_GET['reservatieid'];
		$bedrag=intval($_GET['bedrag']);
		
		//echo "ReservatieId: $reservatieid - Bedrag: $bedrag €<br>";
		if (is_int($bedrag))
		{
			//bedrag is integer
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
			
			$query  = "SELECT * FROM TBL_Reservatie WHERE ReservatieId='$reservatieid'";

			//echo "$query<br>";
			$result = mysqli_query($link, $query);
			$aantalrecords = mysqli_num_rows($result);
			if ($aantalrecords>0)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$AantalKinderen=$row['AantalKinderen'];
					$AantalVolwassenen=$row['AantalVolwassenen'];
					$Mailadres=$row['Mailadres'];
					$Tijdstip=$row['Tijdstip'];
					$query1  = "SELECT * FROM TBL_data WHERE DataId='$Tijdstip'";

					//echo "$query1<br>";
					$result1 = mysqli_query($link, $query1);
					$aantalrecords1 = mysqli_num_rows($result1);
					if ($aantalrecords1>0)
					{
						while($row1 = mysqli_fetch_assoc($result1))
						{
							$ReservatieDatum=$row1['Datum'];
							$ReservatieTijdstip=$row1['Tijdstip'];
						}
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
				
				$tebetalen = ($AantalKinderen * $prijskind) + ($AantalVolwassenen * $prijsvolw);
				if ($tebetalen == $bedrag)
				{
					//betaling loggen
					$datum=date('Y-m-d');
					$tijd=date('H:i:s', time());
					$ipadres=$_SERVER['REMOTE_ADDR'];
					$gebruikersnaam=$_SESSION['login']['username'];
					$querylog = "INSERT into TBL_log 
								(Datum, Tijd, Type, Username, ipadres, ReservatieId, Waarde) 
								values ('$datum', \"$tijd\", \"Betaling\", \"$gebruikersnaam\", \"$ipadres\", \"$reservatieid\", \"$bedrag\")";
					if (mysqli_query($link, $querylog))
					{
						//echo "insert in LOG=OK.<br>";
						//aanpassen reservatie
						$query = "UPDATE TBL_Reservatie SET BetaaldDatum='$datum', BetaaldBedrag='$bedrag' WHERE ReservatieId='".$reservatieid."'";
						if (mysqli_query($link, $query))
						{
							//mail sturen
							$onderwerp='Het kasteel van Sinterklaas Gruitrode: betaling geregistreerd';
							$boodschap="<html><head><title>HTML email</title></head><body>Beste<br><br>Wij registreerden de betaling van $bedrag euro voor uw bezoek aan het Kasteel van Sinterklaas.<br><br>Met deze betaling is de reservatie (nr $reservatieid) volledig in orde. De Sint kijkt uit naar uw bezoek.<br><br>Je reserveerde op $Datumlang om $ReservatieTijdstip. Graag willen we u er aan herinneren om minstens 10 minuten op voorhand aanwezig te zijn.<br>Indien u uw tijdslot mist, kunnen we niet garanderen dat u nog toegang heeft tot het kasteel.<br><br>";
							
							$boodschap=$boodschap."Met vriendelijke groeten<br>Medewerkers het kasteel van Sinterklaas Gruitrode";
							$boodschap = $boodschap."</body></html>";
							$ontvanger=$Mailadres;
							$query = "INSERT into TBL_mails 
								(Datum, Tijd, Type, ReservatieId, Verzender, Ontvanger, Onderwerp, Boodschap, Status)
								values 
								('$datum', \"$tijd\", \"Betaling\", \"$reservatieid\", \"landelijkegildegruitrode@gmail.com\", \"$ontvanger\", \"$onderwerp\", \"$boodschap\", \"to do\")";
							if (mysqli_query($link, $query))
							{
								$nr = mysqli_insert_id($link);
								echo 0;
							}
							else
							{
								echo "Error bij toegang database (Error 003)<br>";
								//echo "Error description: ".mysqli_error($link)."<br>$query";
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
				else
				{
					echo 2;
				}
			}
		}
		else
		{
			echo 1;
		}
		mysqli_close($link);
	}
?>