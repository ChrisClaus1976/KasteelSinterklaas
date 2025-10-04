<?php
	include('../includes/db_conn.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();
	
	$bron=$_GET['bron'];
	
	$dataid=$_SESSION['reservatie']['dataid'];
	$reservatieid=$_SESSION['reservatie']['reservatieid'];
	echo "$dataid $reservatieid<br>";
	$query = "UPDATE TBL_data SET Beschikbaar='1', Reservatietijd='', ReservatieId='' WHERE DataId='".$dataid."'";
	echo "$query<br>";
	if (mysqli_query($link, $query))
	{
		$query = "UPDATE TBL_Reservatie SET Canceled=1 WHERE ReservatieId='".$reservatieid."'";
		echo "$query<br>";
		if (mysqli_query($link, $query))
		{
			$_SESSION['reservatie']=array();
			mysqli_close($link);
			header("Location: ".$bron);
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
		echo "Error bij toegang database (Error 001)<br>";
		//echo "Error description: ".mysqli_error($link);
		mysqli_close($link);
		exit;
	}
	
	
	
?>
