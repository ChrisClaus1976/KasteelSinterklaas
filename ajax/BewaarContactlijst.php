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
	
		$datum=date('Y-m-d');
		$tijd = date('H:i:s', time());
		
		$query = "INSERT into TBL_Contactgegevens
					(Datum, Tijd, Naam, Voornaam, Telefoon, Mailadres)
					values 
					('$datum', \"$tijd\", \"$naam\", \"$voornaam\", \"$telefoon\", \"$mailadres\")";
		//echo "$query<br>";
		if (mysqli_query($link, $query))
		{
			
		echo 1;
		}
		else
		{
			echo "Error bij toegang database (Error 001)<br>";
			echo "Error description: ".mysqli_error($link); //."<br>$query";
			mysqli_close($link);
			exit;
		}
	}
?>
