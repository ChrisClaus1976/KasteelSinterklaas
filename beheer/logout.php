<?php
	session_name('SinterklaasLG');
	session_start();
	date_default_timezone_set('Europe/Brussels');
	include('../includes/db_conn.php');
	$gebruikersnaam=$_SESSION['login']['username'];
	$datum=date('Y-m-d');
	$tijd=date('H:i:s', time());
	$ipadres=$_SERVER['REMOTE_ADDR'];
	$querylog = "INSERT into TBL_log 
		(Datum, Tijd, Type, Username, ipadres) 
		values ('$datum', \"$tijd\", \"Afmelden\", \"$gebruikersnaam\", \"$ipadres\")";
	if (mysqli_query($link, $querylog))
	{
		//echo "insert in LOG=OK.<br>";
	}
	else
	{
		echo "Error schrijven in log.".mysqli_error($link)."<br>";
		echo $querylog."<br>";
	}	
	$_SESSION = array();
	mysqli_close($link);
	//var_dump($_SESSION);
	header("Location: ./");
?>