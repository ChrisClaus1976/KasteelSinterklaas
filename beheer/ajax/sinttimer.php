
<?php
	session_name('SinterklaasLG');
	session_start();
	$debug=0; 
	//$debug = 1; //op 1 zetten om te debuggen
	date_default_timezone_set('Europe/Brussels');
	
	$starttijd=$_SESSION['sint']['starttijd'];
	
	//$datum=date('Y-m-d');
	//$tijd=date('H:i:s', time());
	$tijd=time();
	$verschil = $tijd - $starttijd;
	
	$rest = $verschil % 60;
	
	$minuten = ($verschil - $rest) / 60;
	$seconden = $verschil - ($minuten * 60);
	
	//echo "$minuten : $seconden";
	$output = sprintf('%02d:%02d', ($verschil/ 60 % 60), $verschil% 60);
	if ($verschil>240)
	{
		echo "<span style=\"font-size:20px;color:red;\">$output</span>";
	}
	else
	{
		if ($verschil>180)
		{
			echo "<span style=\"font-size:20px;color:orange;\">$output</span>";
		}
		else
		{
			echo "<span style=\"font-size:20px;\">$output</span>";
		}
	}
?>

