<?php
	session_name('SinterklaasLG');
	session_start();
	$debug=0; 
	//$debug = 1; //op 1 zetten om te debuggen
	date_default_timezone_set('Europe/Brussels');
	//$tijd=date('H:i:s', time());
	$tijd=time();
	$_SESSION['sint']['starttijd']=$tijd;

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
				$ReservatieAanwezig=$row['ReservatieAanwezig'];
				$Kind1Aanwezig=$row['Kind1Aanwezig'];
				$Kind2Aanwezig=$row['Kind2Aanwezig'];
				$Kind3Aanwezig=$row['Kind3Aanwezig'];
				$Kind4Aanwezig=$row['Kind4Aanwezig'];
				$Kind5Aanwezig=$row['Kind5Aanwezig'];
				echo "<span style=\"font-size: 30px;\"><b>$Tijdstip</b></span>&emsp;&emsp; ";
				
				echo "$Naam $Voornaam ($Adres $Postcode $Gemeente)";
				
				echo "<span style=\"font-size: 24px;\">";
				
				if ($AantalKinderen>=1)
				{
					//kind1
					echo "<h3><b>$Kind1Voornaam</b></h3>";
					echo "$Kind1Naam ($Kind1Leeftijd jaar)";
					if ($Kind1Aanwezig==0)
					{
						echo "<span style=\"color:red;\">&emsp;&emsp;Afwezig</span>";
					}
					echo "<br>";
					
					echo "&emsp;&emsp;<img src=\"../images/positief.jpg\"  style=\"height:20px;border:0;\" >&emsp;&emsp;$Kind1Goed<br>&emsp;&emsp;<img src=\"../images/negatief.jpg\"  style=\"height:20px;border:0;\" >&emsp;&emsp;$Kind1Beter<br>";
				}
				
				if ($AantalKinderen>=2)
				{
					//kind2
					echo "<h3><b>$Kind2Voornaam</b></h3>";
					echo "$Kind2Naam ($Kind2Leeftijd jaar)";
					if ($Kind2Aanwezig==0)
					{
						echo "<span style=\"color:red;\">&emsp;&emsp;Afwezig</span>";
					}
					echo "<br>";
					
					echo "&emsp;&emsp;<img src=\"../images/positief.jpg\"  style=\"height:20px;border:0;\" >&emsp;&emsp;$Kind2Goed<br>&emsp;&emsp;<img src=\"../images/negatief.jpg\"  style=\"height:20px;border:0;\" >&emsp;&emsp;$Kind2Beter<br>";
				}
				
				if ($AantalKinderen>=3)
				{
					//kind3
					echo "<h3><b>$Kind3Voornaam</b></h3>";
					echo "$Kind3Naam ($Kind3Leeftijd jaar)";
					if ($Kind3Aanwezig==0)
					{
						echo "<span style=\"color:red;\">&emsp;&emsp;Afwezig</span>";
					}
					echo "<br>";
					
					echo "&emsp;&emsp;<img src=\"../images/positief.jpg\"  style=\"height:20px;border:0;\" >&emsp;&emsp;$Kind3Goed<br>&emsp;&emsp;<img src=\"../images/negatief.jpg\"  style=\"height:20px;border:0;\" >&emsp;&emsp;$Kind3Beter<br>";
				}
				
				if ($AantalKinderen>=4)
				{
					//kind4
					echo "<h3><b>$Kind4Voornaam</b></h3>";
					echo "$Kind4Naam ($Kind4Leeftijd jaar)";
					if ($Kind4Aanwezig==0)
					{
						echo "<span style=\"color:red;\">&emsp;&emsp;Afwezig</span>";
					}
					echo "<br>";
					
					echo "&emsp;&emsp;<img src=\"../images/positief.jpg\"  style=\"height:20px;border:0;\" >&emsp;&emsp;$Kind4Goed<br>&emsp;&emsp;<img src=\"../images/negatief.jpg\"  style=\"height:20px;border:0;\" >&emsp;&emsp;$Kind4Beter<br>";
				}
				
				if ($AantalKinderen>=5)
				{
					//kind5
					echo "<h3><b>$Kind5Voornaam</b></h3>";
					echo "$Kind5Naam ($Kind5Leeftijd jaar)";
					if ($Kind5Aanwezig==0)
					{
						echo "<span style=\"color:red;\">&emsp;&emsp;Afwezig</span>";
					}
					echo "<br>";
					
					echo "&emsp;&emsp;<img src=\"../images/positief.jpg\"  style=\"height:20px;border:0;\" >&emsp;&emsp;$Kind5Goed<br>&emsp;&emsp;<img src=\"../images/negatief.jpg\"  style=\"height:20px;border:0;\" >&emsp;&emsp;$Kind5Beter<br>";
				}
				echo "<br></span>";
				echo "<br><br><br><input type=\"button\" class=\"buttongroen\" onclick=\"bezoek_klaar('$ReservatieId', '2')\" value=\"Bezoek klaar\" style=\"height: 75px; width: 225px;\"><br><br>";
			}
			
		}
		else
		{
			echo "Geen reservatie gevonden.<br>";
		}
		mysqli_close($link);
	}
?>