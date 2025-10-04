<?php
	session_name('SinterklaasLG');
	session_start();
	$debug=0; 
	//$debug = 1; //op 1 zetten om te debuggen
	date_default_timezone_set('Europe/Brussels');

	if(	isset($_GET['datum']) && $_GET['datum']!='')
	{
		$datumget=$_GET['datum'];
		//echo "Datum $datum<br>";
		include('../../includes/db_conn.php');
		$query = "SELECT * FROM TBL_data WHERE Beschikbaar<5";
		if ($datumget != '')
		{
			$query = $query. " AND TBL_data.Datum='$datumget' ";
		}
		$query = $query. " ORDER BY TBL_data.Datum, TBL_data.Tijdstip, TBL_data.DataId ";
		//echo "$query<br>";
		$result = mysqli_query($link, $query);
		$aantalrecords = mysqli_num_rows($result);
		if ($aantalrecords>0)
		{
			
			$nr=0;
			while($row = mysqli_fetch_assoc($result))
			{
				$ReservatieDatum=$row['Datum'];
				$ReservatieTijdstip=$row['Tijdstip'];
				$ReservatieId=$row['ReservatieId'];
				$nr++;
				echo " $nr - $ReservatieDatum - $ReservatieTijdstip";
				$query1 = "SELECT * FROM TBL_Reservatie WHERE ReservatieId='$ReservatieId' ";
				$result1 = mysqli_query($link, $query1);
				$aantalrecords1 = mysqli_num_rows($result1);
				if ($aantalrecords1>0)
				{
					while($row1 = mysqli_fetch_assoc($result1))
					{
						$Naam=$row1['Naam'];
						$Voornaam=$row1['Voornaam'];
						$Telefoon=$row1['Telefoon'];
						$Mailadres=$row1['Mailadres'];
						$Adres=$row1['Adres'];
						$Postcode=$row1['Postcode'];
						$Gemeente=$row1['Gemeente'];
						$AantalVolwassenen=$row1['AantalVolwassenen'];
						$AantalKinderen=$row1['AantalKinderen'];
						$Canceled=$row1['Canceled'];
						$Status=$row1['Status'];
						$BetaaldDatum=$row1['BetaaldDatum'];
						$BetaaldBedrag=$row1['BetaaldBedrag'];
						$UniekeCode=$row1['UniekeCode'];
						$MailHerinnering=$row1['MailHerinnering'];
						if ($Canceled!=1) // && $Status == "Reservatie gedaan")
						{
							echo "- $ReservatieId - $Naam - $Voornaam - $Telefoon - $Mailadres - $Adres $Postcode $Gemeente - $AantalVolwassenen - $AantalKinderen";
							if ($BetaaldDatum!='')
							{
								$bedrag=$AantalKinderen*4;
								if ($BetaaldBedrag==$bedrag)
								{
									echo " - $BetaaldBedrag € ($BetaaldDatum)";
								}
								else
								{
									echo " - <span style=\"color:red\">$BetaaldBedrag € ($BetaaldDatum)</span></td>";
								}
							}
							echo " - $UniekeCode";
							
					
							if ($Mailadres!="" && $MailHerinnering!=1)
							{
								echo " - Mail sturen";
								$query = "UPDATE TBL_Reservatie SET MailHerinnering='1' WHERE ReservatieId='".$ReservatieId."'";
								//echo "$query<br>";
								if (mysqli_query($link, $query))
								{
									$dagen = Array("zondag","maandag","dinsdag","woensdag","donderdag","vrijdag","zaterdag");
									$maanden = Array("*", "januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december");
									$datum=strtotime($ReservatieDatum);
										$wdag = date ('w', $datum);
										$dag = date('d', $datum);
										$maand =date('m', $datum);
										$jaar = date ('Y', $datum);
									$Datumlang = "{$dagen[$wdag]} $dag {$maanden[$maand]} $jaar";
									
									//mail sturen
									$datum=date('Y-m-d');
									$tijd = date('H:i:s', time());
									$onderwerp='Het kasteel van Sinterklaas Gruitrode: herinnering';
									$boodschap="<html><head><title>HTML email</title></head><body>Beste $Voornaam $Naam<br><br>Met dit bericht willen we u herinneren aan uw reservatie op <b>$Datumlang</b> om <b>$ReservatieTijdstip</b>. Mogen wij u vriendelijk verzoeken om zeker 10 minuten op voorhand aanwezig te zijn. Te laat = geen toegang.<br><br>Parkeren kan tegenover het kasteel in de Opstraat. Als het te slecht weer is, parkeert u beter op het Phil Bosmansplein, de parking tegenover het kasteel is dan moeilijk bereikbaar.<br><br>Voor en na uw bezoek aan de Sint bent u van harte welkom in de winterbar op de binnenkoer van het kasteel.<br><br>";
									$boodschap = $boodschap."<br>Je kunt de eigenschappen van de kinderen wijzigen via deze link<br><a href='http://kasteelvansinterklaasgruitrode.be/dossier.php?naam=$Naam&code=$UniekeCode'>http://kasteelvansinterklaasgruitrode.be/dossier.php?naam=$Naam&code=$UniekeCode</a><br><br>";
									$boodschap=$boodschap."Met vriendelijke groeten<br>Medewerkers het kasteel van Sinterklaas Gruitrode";
									$boodschap = $boodschap."</body></html>";
									$ontvanger=$Mailadres;
									$query = "INSERT into TBL_mails 
										(Datum, Tijd, Type, ReservatieId, Verzender, Ontvanger, Onderwerp, Boodschap, Bijlage, Status)
										values 
										('$datum', \"$tijd\", \"Herinneringsmail\", \"$ReservatieId\", \"landelijkegildegruitrode@gmail.com\", \"$ontvanger\", \"$onderwerp\", \"$boodschap\", \"plan.png\", \"to do1\")";
									if (mysqli_query($link, $query))
									{
										//$nr = mysqli_insert_id($link);
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
								echo " - GEEN mail sturen";
							}
						}
					}
				}
				echo "<br>";
			}
		}
		else
		{
			echo "Geen reservaties op deze dag.<br>";
		}
		mysqli_close($link);
	}
?>