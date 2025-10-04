<?php
	include('../includes/opmaak.php');
	include('../includes/db_conn.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();

	if (isset($_GET['dataid']))
	{
		$dataid = $_GET['dataid'];
		//echo "$dataid<br>";
		
		//controle of dit tijdstip nog vrij is_a
		$query  = "select * from TBL_data WHERE DataId='$dataid'";
		$result = mysqli_query($link, $query);
		$aantalrecords = mysqli_num_rows($result);
		if ($aantalrecords>0)
		{
			while($row = mysqli_fetch_assoc($result))
			{
				$Beschikbaar=$row['Beschikbaar'];
			}
		}
		if ($Beschikbaar==0)
		{
			//niet meer beschikbaar
			echo 0;
		}
		else
		{
			$_SESSION['reservatie']['dataid']=$dataid;
			$datum=date('Y-m-d');
			$tijd = date('H:i:s', time());
			$ipadres=$_SERVER['REMOTE_ADDR'];
			$query = "INSERT into TBL_Reservatie 
				(Tijdstip, Datum, Tijd, IpAdress)
				values 
				(\"$dataid\", '$datum', \"$tijd\", \"$ipadres\")";
			if (mysqli_query($link, $query))
			{
				$nr = mysqli_insert_id($link);
				$_SESSION['reservatie']['reservatieid']=$nr;
				$query = "UPDATE TBL_data SET Beschikbaar='0', Reservatietijd='$datum $tijd', ReservatieId=$nr WHERE DataId='".$dataid."'";
				if (mysqli_query($link, $query))
				{

					echo 1;
				}
				else
				{
					echo "Error bij toegang database (Error 001)<br>";
					//echo "Error description: ".mysqli_error($link);
					mysqli_close($link);
					exit;
				}
			}
		}
	}
	else
	{

	}
	mysqli_close($link);
?>		