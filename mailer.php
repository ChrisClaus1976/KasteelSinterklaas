<?php
	include('includes/db_conn.php');
	set_time_limit(6000);
	
	
	//https://myaccount.google.com/  enable 2FA
	//https://myaccount.google.com/apppasswords  voeg app toe (bv Mail)
	
	
	//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	//Load Composer's autoloader
	require 'vendor/autoload.php';

	function stuur_mail($Verzender, $Ontvanger, $CC, $Onderwerp, $Boodschap, $Bijlage)
	{
		//Create an instance; passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try 
		{
			//Server settings
			$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username   = 'landelijkegildegruitrode@gmail.com';                     //SMTP username
			//$mail->Password   = 'gnnb gkoa incm ltbk';                               //SMTP password  2024
			$mail->Password   = 'swtw wvgq voon ymdl';                               //SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
			$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

			//Recipients
			$mail->setFrom('landelijkegildegruitrode@gmail.com', 'Landelijke Gilde Gruitrode');
			$mail->addAddress($Ontvanger);
			if ($CC=='')
			{
				
			}
			else
			{
				$mail->addCC($CC);
			}
			$mail->addBCC('chrisclaus@outlook.be');

			if ($Bijlage!="")
			{
				//Attachments
				//$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
				//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
				$mail->addAttachment($Bijlage);         //Add attachments
			}

			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			//$mail->Subject = 'Here is the subject';
			$mail->Subject = $Onderwerp;
			//$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
			$mail->Body    = $Boodschap;
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();
			//echo 'Message has been sent';
			return 1;
		} 
		catch (Exception $e) 
		{
			return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
	
	$query  = "select * from TBL_mails WHERE Status = 'to do' LIMIT 20";
	$result = mysqli_query($link, $query);
	$aantalmails = mysqli_num_rows($result);
	echo "Aantal: $aantalmails<br>";
	if ($aantalmails>0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$MailId=$row['MailId'];
			$Verzender=$row['Verzender'];
			$Ontvanger=$row['Ontvanger'];
			$CC=$row['CC'];
			$Onderwerp=$row['Onderwerp'];
			$Boodschap=$row['Boodschap'];
			$Bijlage=$row['Bijlage'];
			$datum=date('Y-m-d');
			$tijd = date('H:i:s', time());
			
			//echo "$MailId - $Verzender - $Ontvanger - $Onderwerp - $Boodschap<br>";
			$query1 = "INSERT into TBL_maillog
				(MailId, Datum, Tijd, Ontvanger)
				values 
				(\"$MailId\", '$datum', \"$tijd\", \"$Ontvanger\")";
			if (mysqli_query($link, $query1))
			{
				$nr = mysqli_insert_id($link);
				$antw = stuur_mail($Verzender, $Ontvanger, $CC, $Onderwerp, $Boodschap, $Bijlage);
				//echo "<br>Antw: $antw<br>";
				$query2 = "UPDATE TBL_maillog SET Antwoord='$antw' WHERE MaillogId='".$nr."'";
				if (mysqli_query($link, $query2))
				{
					if ($antw == 1)
					{
						$query = "UPDATE TBL_mails SET Antwoord='OK', Status='done' WHERE MailId='".$MailId."'";
					}
					else
					{
						$query = "UPDATE TBL_mails SET Antwoord='$antw', Status='error' WHERE MailId='".$MailId."'";
					}

					echo "$query<br>";
					if (mysqli_query($link, $query))
					{
						//echo "OK";
					}
				}
			}
		}
	}
	
	
	sleep(60);
	
	$query  = "select * from TBL_mails WHERE Status = 'to do' LIMIT 20";
	$result = mysqli_query($link, $query);
	$aantalmails = mysqli_num_rows($result);
	echo "Aantal: $aantalmails<br>";
	if ($aantalmails>0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$MailId=$row['MailId'];
			$Verzender=$row['Verzender'];
			$Ontvanger=$row['Ontvanger'];
			$CC=$row['CC'];
			$Onderwerp=$row['Onderwerp'];
			$Boodschap=$row['Boodschap'];
			$Bijlage=$row['Bijlage'];
			$datum=date('Y-m-d');
			$tijd = date('H:i:s', time());
			
			//echo "$MailId - $Verzender - $Ontvanger - $Onderwerp - $Boodschap<br>";
			$query1 = "INSERT into TBL_maillog
				(MailId, Datum, Tijd, Ontvanger)
				values 
				(\"$MailId\", '$datum', \"$tijd\", \"$Ontvanger\")";
			if (mysqli_query($link, $query1))
			{
				$nr = mysqli_insert_id($link);
				$antw = stuur_mail($Verzender, $Ontvanger, $CC, $Onderwerp, $Boodschap, $Bijlage);
				//echo "<br>Antw: $antw<br>";
				$query2 = "UPDATE TBL_maillog SET Antwoord='$antw' WHERE MaillogId='".$nr."'";
				if (mysqli_query($link, $query2))
				{
					if ($antw == 1)
					{
						$query = "UPDATE TBL_mails SET Antwoord='OK', Status='done' WHERE MailId='".$MailId."'";
					}
					else
					{
						$query = "UPDATE TBL_mails SET Antwoord='$antw', Status='error' WHERE MailId='".$MailId."'";
					}

					echo "$query<br>";
					if (mysqli_query($link, $query))
					{
						//echo "OK";
					}
				}
			}
		}
	}
	
	sleep(60);
	
	$query  = "select * from TBL_mails WHERE Status = 'to do' LIMIT 20";
	$result = mysqli_query($link, $query);
	$aantalmails = mysqli_num_rows($result);
	echo "Aantal: $aantalmails<br>";
	if ($aantalmails>0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$MailId=$row['MailId'];
			$Verzender=$row['Verzender'];
			$Ontvanger=$row['Ontvanger'];
			$CC=$row['CC'];
			$Onderwerp=$row['Onderwerp'];
			$Boodschap=$row['Boodschap'];
			$Bijlage=$row['Bijlage'];
			$datum=date('Y-m-d');
			$tijd = date('H:i:s', time());
			
			//echo "$MailId - $Verzender - $Ontvanger - $Onderwerp - $Boodschap<br>";
			$query1 = "INSERT into TBL_maillog
				(MailId, Datum, Tijd, Ontvanger)
				values 
				(\"$MailId\", '$datum', \"$tijd\", \"$Ontvanger\")";
			if (mysqli_query($link, $query1))
			{
				$nr = mysqli_insert_id($link);
				$antw = stuur_mail($Verzender, $Ontvanger, $CC, $Onderwerp, $Boodschap, $Bijlage);
				//echo "<br>Antw: $antw<br>";
				$query2 = "UPDATE TBL_maillog SET Antwoord='$antw' WHERE MaillogId='".$nr."'";
				if (mysqli_query($link, $query2))
				{
					if ($antw == 1)
					{
						$query = "UPDATE TBL_mails SET Antwoord='OK', Status='done' WHERE MailId='".$MailId."'";
					}
					else
					{
						$query = "UPDATE TBL_mails SET Antwoord='$antw', Status='error' WHERE MailId='".$MailId."'";
					}

					echo "$query<br>";
					if (mysqli_query($link, $query))
					{
						//echo "OK";
					}
				}
			}
		}
	}
	sleep(60);
	
	$query  = "select * from TBL_mails WHERE Status = 'to do' LIMIT 20";
	$result = mysqli_query($link, $query);
	$aantalmails = mysqli_num_rows($result);
	echo "Aantal: $aantalmails<br>";
	if ($aantalmails>0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$MailId=$row['MailId'];
			$Verzender=$row['Verzender'];
			$Ontvanger=$row['Ontvanger'];
			$CC=$row['CC'];
			$Onderwerp=$row['Onderwerp'];
			$Boodschap=$row['Boodschap'];
			$Bijlage=$row['Bijlage'];
			$datum=date('Y-m-d');
			$tijd = date('H:i:s', time());
			
			//echo "$MailId - $Verzender - $Ontvanger - $Onderwerp - $Boodschap<br>";
			$query1 = "INSERT into TBL_maillog
				(MailId, Datum, Tijd, Ontvanger)
				values 
				(\"$MailId\", '$datum', \"$tijd\", \"$Ontvanger\")";
			if (mysqli_query($link, $query1))
			{
				$nr = mysqli_insert_id($link);
				$antw = stuur_mail($Verzender, $Ontvanger, $CC, $Onderwerp, $Boodschap, $Bijlage);
				//echo "<br>Antw: $antw<br>";
				$query2 = "UPDATE TBL_maillog SET Antwoord='$antw' WHERE MaillogId='".$nr."'";
				if (mysqli_query($link, $query2))
				{
					if ($antw == 1)
					{
						$query = "UPDATE TBL_mails SET Antwoord='OK', Status='done' WHERE MailId='".$MailId."'";
					}
					else
					{
						$query = "UPDATE TBL_mails SET Antwoord='$antw', Status='error' WHERE MailId='".$MailId."'";
					}

					echo "$query<br>";
					if (mysqli_query($link, $query))
					{
						//echo "OK";
					}
				}
			}
		}
	}
	

	
	echo "<br><br>EINDE<br>";
	
	mysqli_close($link);
?>