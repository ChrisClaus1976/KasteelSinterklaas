<?php
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();

	if (isset($_SESSION['kalendermaand']) && isset($_SESSION['kalenderjaar']))
	{
	
	$maand=$_SESSION['kalendermaand'];

	$jaar=$_SESSION['kalenderjaar'];
	if ($maand==12)
	{
		$maandnieuw=1;
		$jaar= $jaar+1;
		$_SESSION['kalenderjaar']=intval($jaar);
	}
	else
	{
		$maandnieuw=$maand+1;
	}
	
	$_SESSION['kalendermaand']=intval($maandnieuw);

	}
?>