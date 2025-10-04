<?php
	//include('../includes/opmaak.php');
	include('../includes/db_conn.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();

	define("ADAY", (60*60*24));
	if (isset($_SESSION['kalendermaand']) && isset($_SESSION['kalenderjaar']))
	{
	
	$maand=$_SESSION['kalendermaand'];

	$jaar=$_SESSION['kalenderjaar'];
	
	$datumvandaag=date('Y-m-d');
	$datumdag=date('d');
	$datummaand=date('m');
	$datumjaar=date('Y');
	
	
	$start = mktime (12, 0, 0, $maand, 1, $jaar);
	//echo "START: $start<br>";
	$firstDayArray = getdate($start);
	//var_dump($firstDayArray);
	$maanden = Array("Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December");
	
	$dagen = Array("Zondag","Maandag","Dinsdag","Woensdag","Donderdag","Vrijdag","Zaterdag");
	$maandkalender = "<TABLE BORDER=1 CELLPADDING=5 width=100%><tr>";
	foreach ($dagen as $dag) 
	{
		$maandkalender .= "<TD BGCOLOR=\"#cccccc\" ALIGN=CENTER width=500px><strong>$dag</strong></td>\n";
	}
	for ($count=0; $count < (6*7); $count++) 
	{
		$dagArray = getdate($start);
		//var_dump($dagArray);
		if (($count % 7) == 0) 
		{
			if ($dagArray['mon'] != $maand) 
			{
				break;
			} 
			else 
			{
				$maandkalender .= "</tr><tr height='50'>\n";
			}
		}
		if ($count < $firstDayArray['wday'] ||  $dagArray['mon'] != $maand) 
		{
			$maandkalender .= "<td>&nbsp;</td>\n";
		} 
		else 
		{
			$dag=$dagArray['mday'];
			if ($maand==$datummaand && $jaar == $datumjaar && $dag == $datumdag)
			{
				$maandkalender .= "<td ALIGN=CENTER ><p class=\"tekst20kalenderrood\">".$dag."</p>";
			}
			else
			{
				$maandkalender .= "<td ALIGN=CENTER ><p class=\"tekst20kalenderwit\">".$dag."</p>";
			}
			
			$datum=date('Y-m-d', mktime(0,0,0,$maand,$dag,$jaar));
			//echo "$datum - $datumvandaag<br>";
			if ($datum > $datumvandaag)
			{
				$query  = "select DISTINCT Datum from TBL_data WHERE Datum = '$datum'";
				$result = mysqli_query($link, $query);
				$aantalreservatie = mysqli_num_rows($result);
				if ($aantalreservatie>0)
				{
					while($row = mysqli_fetch_assoc($result))
					{
						$Datum=$row['Datum'];
						
						$maandkalender .=  "<img src=\"images/logo.png\" style=\"height:30px;border:0;cursor:pointer;\" onclick=\"reserveer('$jaar', '$maand' , '$dag')\">";
						
					}
				}
				else
				{
					$maandkalender .=" &nbsp;&nbsp; ";
				}
			}
			$maandkalender .="</td>\n";
			$start += ADAY;
		}
	}
	$maandkalender .= "</tr></table>";
	$maand = $maand - 1;
	//echo "$maanden[$maand] $jaar<br>";
	echo "$maandkalender<br>";
	//var_dump($_SESSION);
	}
	else
	{
		//echo "dump:<br>";
		//var_dump($_SESSION);
	}
	mysqli_close($link);
?>