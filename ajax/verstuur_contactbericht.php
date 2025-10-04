<?php
	include('../includes/opmaak.php');
	include('../includes/db_conn.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();

	function StuurMail($onderwerp, $boodschap, $ontvanger)
	{
		$to      = $ontvanger;
		$subject = $onderwerp;
		$message = $boodschap;
		$headers = 'From: landelijkegildegruitrode@gmail.com' . "\r\n" .
			'Reply-To: landelijkegildegruitrode@gmail.com' . "\r\n" .
			'BCC: chrisclaus@outlook.be' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);
		return 1;			
	}
	
	if (isset($_GET['naam']) && isset($_GET['email']) && isset($_GET['telefoonnummer']) && isset($_GET['boodschap']))
	{
		$mailadres=$_GET['email'];
		$naam=$_GET['naam'];
		$telefoon=$_GET['telefoonnummer'];
		$inhoud=$_GET['boodschap'];

		$onderwerp='Het kasteel van Sinterklaas Gruitrode';
		$boodschap="<html><head><title>HTML email</title></head><body>Bedankt voor uw bericht.<br><br>Naam: $naam<br>Email: $mailadres<br>Telefoonnummer: $telefoon<br>Boodschap: $inhoud<br><br>";
		
		$boodschap=$boodschap."Wij contacteren u zo snel mogelijk.<br>Medewerkers het kasteel van Sinterklaas Gruitrode";
		$boodschap = $boodschap."</body></html>";
		$ontvanger=$mailadres;
		
		$datum=date('Y-m-d');
		$tijd = date('H:i:s', time());
		$query = "INSERT into TBL_mails 
			(Datum, Tijd, Type, Verzender, Ontvanger, CC, Onderwerp, Boodschap, Status)
			values 
			('$datum', \"$tijd\", \"Contactformulier\", \"landelijkegildegruitrode@gmail.com\", \"$ontvanger\", \"landelijkegildegruitrode@gmail.com\", \"$onderwerp\", \"$boodschap\", \"to do\")";
		if (mysqli_query($link, $query))
		{
			$nr = mysqli_insert_id($link);
			echo "Bedankt voor uw boodschap. Wij contacteren u zo snel mogelijk.<br>";
		}
		

	}
	else
	{
		//echo "geen waardes";
		
	}
	mysqli_close($link);
?>