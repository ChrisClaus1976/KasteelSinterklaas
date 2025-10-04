<?php
	session_name('SinterklaasLG');
	session_start();
	$debug=0; 
	//$debug = 1; //op 1 zetten om te debuggen
	date_default_timezone_set('Europe/Brussels');

	if(	isset($_GET['gebruikersnaam']) && $_GET['gebruikersnaam'] != '' && isset($_GET['wachtwoord']))
	{
		$gebruikersnaam=$_GET['gebruikersnaam'];
		$wachtwoord=$_GET['wachtwoord'];
		if ($debug==1)
		{
			echo "$gebruikersnaam - $wachtwoord<br>";
		}
		include('../../includes/db_conn.php');
		$query  = "select * from TBL_users WHERE Username='".$gebruikersnaam."' AND InGebruik='1'";
		$result = mysqli_query($link, $query);
		$aantalrecords = mysqli_num_rows($result);
		if ($aantalrecords>0)
		{
			while($row = mysqli_fetch_assoc($result))
			{
				$Wachtwoord=$row['Wachtwoord'];
				if ($Wachtwoord==$wachtwoord)
				{
					$UserId=$row['UserId'];
					$Naam=$row['Naam'];
					$Voornaam=$row['Voornaam'];
					$Wachtlijst=$row['Wachtlijst'];
					$Contactformulier=$row['Contactformulier'];
					$Betaling=$row['Betaling'];
					$_SESSION['login']['userid']=$UserId;
					$_SESSION['login']['username']=$gebruikersnaam;
					$_SESSION['login']['naam']=$Naam;
					$_SESSION['login']['voornaam']=$Voornaam;
					$_SESSION['login']['wachtlijst']=$Wachtlijst;
					$_SESSION['login']['contactformulier']=$Contactformulier;
					$_SESSION['login']['betaling']=$Betaling;
					$datum=date('Y-m-d');
					$tijd=date('H:i:s', time());
					$ipadres=$_SERVER['REMOTE_ADDR'];
					$querylog = "INSERT into TBL_log 
								(Datum, Tijd, Type, Username, ipadres) 
								values ('$datum', \"$tijd\", \"Aanmelden\", \"$gebruikersnaam\", \"$ipadres\")";
					if (mysqli_query($link, $querylog))
					{
						//echo "insert in LOG=OK.<br>";
					}
					else
					{
						echo "Error schrijven in log.".mysqli_error($link)."<br>";
						if ($debug==1)
						{
							echo $querylog."<br>";
						}
					}	
					echo 1;
				}
				else
				{
					echo "<p class=\"tekst16_0_rood\">Wachtwoord is foutief</p>";
				}
			}
		}
		else
		{
			echo "<p class=\"tekst16_0_rood\">Gebruikersnaam onbekend</p>";
		}
		mysqli_close($link);
	}
?>