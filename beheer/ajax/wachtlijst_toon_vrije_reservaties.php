<?php
	session_name('SinterklaasLG');
	session_start();
	$debug=0; 
	//$debug = 1; //op 1 zetten om te debuggen
	date_default_timezone_set('Europe/Brussels');

	if (isset($_GET['wachtlijstid']))
	{
	
		$wachtlijstid=$_GET['wachtlijstid'];
	
		include('../../includes/db_conn.php');
		
		$query  = "SELECT * FROM TBL_data WHERE ReservatieId = 0 OR ReservatieId is null ORDER BY Datum, Tijdstip";
		//echo "$query<br>";
		$result = mysqli_query($link, $query);
		$aantalrecords = mysqli_num_rows($result);

		if ($aantalrecords>0)
		{
			while($row = mysqli_fetch_assoc($result))
			{
				$DataId=$row['DataId'];
				$Datum=$row['Datum'];
				$Tijdstip=$row['Tijdstip'];

				echo "$Datum - $Tijdstip ";
				echo "<input type=\"button\" onclick=\"wachtlijstnaarreservatie('$wachtlijstid', '$DataId')\" value=\"Reservatie maken\"><br>";
			}

			
		}
		
		
		mysqli_close($link);
	}
	exit();
?>