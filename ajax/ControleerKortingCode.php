<?php
	$debug=0;
	//$debug=1;
	include('../includes/db_conn.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();
	
	$code=$_GET['code'];
	
	$reservatieid=$_SESSION['reservatie']['reservatieid'];
	
	if ($debug==1)
	{
		echo "$code - $reservatieid<br>";
	}
	
	$query  = "select * FROM TBL_kortingcode WHERE Code='".$code."'";
	if ($debug==1)
	{
		echo "$query<br>";
	}
	$result = mysqli_query($link, $query);
	$aantalcode = mysqli_num_rows($result);
	if ($debug==1)
	{
		echo "Aantal: $aantalcode<br>";
	}
	if ($aantalcode>0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$aantal=$row['Aantal'];
			if ($debug==1)
			{
				echo "Aantal code: $aantal<br>";
			}
		}
		if ($aantal>0)
		{
			mysqli_close($link);
			if ($debug==1)
			{
				echo "Return 1<br>";
			}
			echo 1;
		}
		else
		{
			mysqli_close($link);
			if ($debug==1)
			{
				echo "Return 2<br>";
			}
			echo 2;
		}
	}
	else
	{
		mysqli_close($link);
		if ($debug==1)
		{
			echo "Return 0<br>";
		}
		echo 0;
	}

	
?>
