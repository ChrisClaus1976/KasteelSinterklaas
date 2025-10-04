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
						$MailEnquete=$row1['MailEnquete'];
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
							
					
							if ($Mailadres!="" && $MailEnquete!=1)
							{
								echo " - Mail sturen";
								$query = "UPDATE TBL_Reservatie SET MailEnquete='1' WHERE ReservatieId='".$ReservatieId."'";
								//echo "$query<br>";
								if (mysqli_query($link, $query))
								{
									
									//mail sturen
									$datum=date('Y-m-d');
									$tijd = date('H:i:s', time());
									$onderwerp='Het kasteel van Sinterklaas Gruitrode: bevraging';
									$boodschap="<html><head><title>HTML email</title></head><body>Beste $Voornaam $Naam<br><br>De afgelopen weken hebben een 70-tal vrijwilligers van onze vereniging zich kosteloos ingezet om u en uw kinderen een onvergetelijk moment te laten beleven. <br><br>Wij kijken er alleszins met veel positiviteit op terug en denken alvast na over de mogelijkheden voor volgend jaar. Omdat we hierbij ook rekening willen houden met de mening en suggesties van onze bezoekers willen we u vragen om een paar minuten tijd te maken om onderstaande bevraging in te vullen. Op deze manier hopen we om van 'Het Kasteel van Sinterklaas' een nog mooie beleving te maken voor jong en oud.<br><br>";
									$boodschap = $boodschap."<br>Je kunt de bevraging invullen via deze link <br><a href='https://forms.gle/YNXrUamdYZQYbFRu6'>https://forms.gle/YNXrUamdYZQYbFRu6</a><br><br>";
									$boodschap=$boodschap."Met vriendelijke groeten<br>Medewerkers het kasteel van Sinterklaas Gruitrode";
									$boodschap = $boodschap."</body></html>";
									$ontvanger=$Mailadres;
									$query = "INSERT into TBL_mails 
										(Datum, Tijd, Type, ReservatieId, Verzender, Ontvanger, Onderwerp, Boodschap,  Status)
										values 
										('$datum', \"$tijd\", \"Enquetemail\", \"$ReservatieId\", \"landelijkegildegruitrode@gmail.com\", \"$ontvanger\", \"$onderwerp\", \"$boodschap\", \"to do1\")";
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