<?php
	session_name('SinterklaasLG');
	session_start();
	$debug=0; 
	//$debug = 1; //op 1 zetten om te debuggen
	date_default_timezone_set('Europe/Brussels');

	if(	isset($_GET['reservatieid']))
	{
		$reservatieid=$_GET['reservatieid'];
		
		include('../../includes/db_conn.php');
		$query  = "SELECT * FROM TBL_Reservatie WHERE ReservatieId='$reservatieid'";
					
		$result = mysqli_query($link, $query);
		$aantalrecords = mysqli_num_rows($result);
		if ($aantalrecords>0)
		{
			while($row = mysqli_fetch_assoc($result))
			{
				//$Datum=$row['Datum'];
				$Tijdstip=$row['Tijdstip'];
				$querydata  = "SELECT * FROM TBL_data WHERE DataId='$Tijdstip'";
					
				$resultdata = mysqli_query($link, $querydata);
				$aantalrecordsdata = mysqli_num_rows($resultdata);
				if ($aantalrecordsdata>0)
				{
					while($rowdata = mysqli_fetch_assoc($resultdata))
					{
						$Datum=$rowdata['Datum'];
						$Tijdstip=$rowdata['Tijdstip'];
					}
				}
				$ReservatieId=$row['ReservatieId'];
				$Naam=$row['Naam'];
				$Voornaam=$row['Voornaam'];
				$Telefoon=$row['Telefoon'];
				$Mailadres=$row['Mailadres'];
				$Adres=$row['Adres'];
				$Postcode=$row['Postcode'];
				$Gemeente=$row['Gemeente'];
				$AantalVolwassenen=$row['AantalVolwassenen'];
				$AantalKinderen=$row['AantalKinderen'];
				$Canceled=$row['Canceled'];
				$Status=$row['Status'];
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
				$BetaaldDatum=$row['BetaaldDatum'];
				$BetaaldBedrag=$row['BetaaldBedrag'];
				echo "Reservatie: $Datum $Tijdstip<br>";
				if ($BetaaldDatum!="")
				{
					echo "Deze reservatie werd betaald op $BetaaldDatum ($BetaaldBedrag €)<br><br>";
				}
				echo "<table>";
				echo "<tr><td colspan=2><h2><b>Gegevens ouder(s)</b></h2></td></tr>";
				echo "<tr><td>Naam</td><td>$Naam</td></tr>";
				echo "<tr><td>Voornaam</td><td>$Voornaam</td></tr>";
				echo "<tr><td>Telefoon</td><td>$Telefoon</td></tr>";
				echo "<tr><td>Mailadres</td><td>$Mailadres</td></tr>";
				echo "<tr><td>Adres</td><td>$Adres</td></tr>";
				echo "<tr><td>Gemeente</td><td>$Postcode $Gemeente</td></tr>";
				echo "<tr><td>Aantal volwassenen</td><td>$AantalVolwassenen</td></tr>";
				echo "<tr><td colspan=2><h2><b>Gegevens kinderen</b></h2></td></tr>";
				echo "<tr><td>Aantal kinderen</td><td>$AantalKinderen</td></tr>";
				
				if ($AantalKinderen>=1)
				{
					//kind1
					echo "<tr><td colspan=2>";
					echo "<div id=\"divKind1\">";
					
					echo "<table><tr><td><b>Kind 1</b></td></tr>";
					echo "<tr><td>Naam</td><td><input id=\"txtKind1Naam\" value=\"".$Kind1Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind1Naam', this.value);\" disabled></td></tr>";
					echo "<tr><td>Voornaam</td><td><input id=\"txtKind1Voornaam\" value=\"".$Kind1Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind1Voornaam', this.value);\"  disabled></td></tr>";
					echo "<tr><td>Leeftijd</td><td><input id=\"txtKind1Leeftijd\" value=\"".$Kind1Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind1Leeftijd', this.value);\"  disabled>  jaar</td></tr>";
					echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind1Goed\" value=\"".$Kind1Goed."\" size=\"100\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind1Goed', this.value);\"  disabled></td></tr>";
					echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind1Beter\" value=\"".$Kind1Beter."\" size=\"100\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind1Beter', this.value);\"  disabled></td></tr></table></div></td></tr>";
				}
				
				if ($AantalKinderen>=2)
				{
					//kind2
					echo "<tr><td colspan=2>";
					echo "<div id=\"divKind2\">";
					
					echo "<table><tr><td><b>Kind 2</b></td></tr>";
					echo "<tr><td>Naam</td><td><input id=\"txtKind2Naam\" value=\"".$Kind2Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind2Naam', this.value);\" disabled></td></tr>";
					echo "<tr><td>Voornaam</td><td><input id=\"txtKind2Voornaam\" value=\"".$Kind2Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind2Voornaam', this.value);\"  disabled></td></tr>";
					echo "<tr><td>Leeftijd</td><td><input id=\"txtKind2Leeftijd\" value=\"".$Kind2Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind2Leeftijd', this.value);\"  disabled> jaar</td></tr>";
					echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind2Goed\" value=\"".$Kind2Goed."\" size=\"100\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind2Goed', this.value);\"  disabled></td></tr>";
					echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind2Beter\" value=\"".$Kind2Beter."\" size=\"100\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind2Beter', this.value);\"  disabled></td></tr></table></div></td></tr>";
				}
				
				if ($AantalKinderen>=3)
				{
					//kind3
					echo "<tr><td colspan=2>";
					echo "<div id=\"divKind3\">";
					
					echo "<table><tr><td><b>Kind 3</b></td></tr>";
					echo "<tr><td>Naam</td><td><input id=\"txtKind3Naam\" value=\"".$Kind3Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind3Naam', this.value);\" disabled></td></tr>";
					echo "<tr><td>Voornaam</td><td><input id=\"txtKind3Voornaam\" value=\"".$Kind3Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind3Voornaam', this.value);\"  disabled></td></tr>";
					echo "<tr><td>Leeftijd</td><td><input id=\"txtKind3Leeftijd\" value=\"".$Kind3Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind3Leeftijd', this.value);\"  disabled> jaar</td></tr>";
					echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind3Goed\" value=\"".$Kind3Goed."\" size=\"100\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind3Goed', this.value);\"  disabled></td></tr>";
					echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind3Beter\" value=\"".$Kind3Beter."\" size=\"100\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind3Beter', this.value);\"  disabled></td></tr></table></div></td></tr>";
				}
				
				if ($AantalKinderen>=4)
				{
					//kind4
					echo "<tr><td colspan=2>";
					echo "<div id=\"divKind4\">";
					
					echo "<table><tr><td><b>Kind 4</b></td></tr>";
					echo "<tr><td>Naam</td><td><input id=\"txtKind4Naam\" value=\"".$Kind4Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind4Naam', this.value);\" disabled></td></tr>";
					echo "<tr><td>Voornaam</td><td><input id=\"txtKind4Voornaam\" value=\"".$Kind4Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind4Voornaam', this.value);\"  disabled></td></tr>";
					echo "<tr><td>Leeftijd</td><td><input id=\"txtKind4Leeftijd\" value=\"".$Kind4Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind4Leeftijd', this.value);\" disabled > jaar</td></tr>";
					echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind4Goed\" value=\"".$Kind4Goed."\" size=\"100\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind4Goed', this.value);\"  disabled></td></tr>";
					echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind4Beter\" value=\"".$Kind4Beter."\" size=\"100\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind4Beter', this.value);\"  disabled></td></tr></table></div></td></tr>";
				}
				
				if ($AantalKinderen>=5)
				{
					//kind5
					echo "<tr><td colspan=2>";
					echo "<div id=\"divKind5\">";
					
					echo "<table><tr><td><b>Kind 5</b></td></tr>";
					echo "<tr><td>Naam</td><td><input id=\"txtKind5Naam\" value=\"".$Kind5Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind5Naam', this.value);\" disabled></td></tr>";
					echo "<tr><td>Voornaam</td><td><input id=\"txtKind5Voornaam\" value=\"".$Kind5Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind5Voornaam', this.value);\" disabled ></td></tr>";
					echo "<tr><td>Leeftijd</td><td><input id=\"txtKind5Leeftijd\" value=\"".$Kind5Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind5Leeftijd', this.value);\"  disabled> jaar</td></tr>";
					echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind5Goed\" value=\"".$Kind5Goed."\" size=\"100\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind5Goed', this.value);\"  disabled></td></tr>";
					echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind5Beter\" value=\"".$Kind5Beter."\" size=\"100\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind5Beter', this.value);\"  disabled></td></tr></table></div></td></tr>";
				}
				echo "</table><br>";
				
				//mails
				echo "<h3><b>Mails</b></h3>";
				$querymail  = "SELECT * FROM TBL_mails WHERE ReservatieId='$reservatieid'";
					
				$resultmail = mysqli_query($link, $querymail);
				$aantalrecordsmail = mysqli_num_rows($resultmail);
				if ($aantalrecordsmail>0)
				{
					while($rowmail = mysqli_fetch_assoc($resultmail))
					{
						$MailDatum=$rowmail['Datum'];
						$MailTijd=$rowmail['Tijd'];
						$MailOntvanger=$rowmail['Ontvanger'];
						$MailOnderwerp=$rowmail['Onderwerp'];
						$MailBoodschap=$rowmail['Boodschap'];
						$MailResult=$rowmail['Antwoord'];
						echo "Datum: $MailDatum $MailTijd<br>Ontvanger: $MailOntvanger<br>Onderwerp: $MailOnderwerp<hr>$MailBoodschap<hr>Verzonden? $MailResult<hr><hr><br>";
						//echo "<button type=\"button\" class=\"collapsible\">$MailDatum $MailTijd</button><div class=\"collapsiblecontent\"><p>$MailBoodschap</p></div>";
					}
				}
				
				/*?>
							
							<script>
								var coll = document.getElementsByClassName("collapsible");
								var i;

								for (i = 0; i < coll.length; i++) 
								{
									coll[i].addEventListener("click", function() 
									{
										this.classList.toggle("active");
										var collapsiblecontent = this.nextElementSibling;
										if (collapsiblecontent.style.display === "block") 
										{
											collapsiblecontent.style.display = "none";
										}
										else 
										{
											collapsiblecontent.style.display = "block";
										}
									}
									);
								}
							</script>
						<?php*/
			}
			
		}
		else
		{
			echo "Geen reservatie gevonden.<br>";
		}
		mysqli_close($link);
	}
?>