<?php
	include('../includes/db_conn.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();
	
	$veld=$_GET['veld'];
	$waarde=$_GET['waarde'];
	
	$reservatieid=$_SESSION['reservatie']['reservatieid'];
	
	$query  = "select * from TBL_Reservatie WHERE ReservatieId='".$reservatieid."'";
	$result = mysqli_query($link, $query);
	$aantalreservatie = mysqli_num_rows($result);
	if ($aantalreservatie>0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$OudeWaarde=$row[$veld];
		}
	}
	else
	{
		$OudeWaarde="";
	}
	
	if ($OudeWaarde==$waarde)
	{
		//niets doen, zelfde waarde
	}
	else
	{
	
		//nieuwe gegevens opslaan
		$query = "UPDATE TBL_Reservatie SET $veld='$waarde' WHERE ReservatieId='".$reservatieid."'";
		//echo "$query<br>";
		if (mysqli_query($link, $query))
		{
			//echo "$veld aangepast<br>";
			$datum=date('Y-m-d');
			$tijd = date('H:i:s', time());
			$ipadres=$_SERVER['REMOTE_ADDR'];
			$query1 = "INSERT into TBL_reservatieLog
				(ReservatieId, Datum, Tijd, IpAdress, Veld, OudeWaarde, Waarde)
				values 
				(\"$reservatieid\", '$datum', \"$tijd\", \"$ipadres\", \"$veld\", \"$OudeWaarde\", \"$waarde\")";
			if (mysqli_query($link, $query1))
			{
				mysqli_close($link);
				return 1;
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
	}
?>
