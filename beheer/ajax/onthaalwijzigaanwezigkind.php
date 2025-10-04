<?php
	session_name('SinterklaasLG');
	session_start();
	$debug=0; 
	//$debug = 1; //op 1 zetten om te debuggen
	date_default_timezone_set('Europe/Brussels');

	if(	isset($_GET['reservatieid']) && isset($_GET['veld']) && isset($_GET['waarde']))
	{
		$reservatieid=$_GET['reservatieid'];
		$veld=$_GET['veld'];
		$waarde=$_GET['waarde'];

		include('../../includes/db_conn.php');
		
		$query = "UPDATE TBL_Reservatie SET $veld='$waarde' WHERE ReservatieId='".$reservatieid."'";
		//echo "$query<br>";
		//exit();
		if (mysqli_query($link, $query))
		{
			echo 1;
		}
		else
		{
			echo "Error bij toegang database (Error 002)<br>";
			//echo "Error description: ".mysqli_error($link);
			mysqli_close($link);
			exit;
		}		
		mysqli_close($link);
	}
?>