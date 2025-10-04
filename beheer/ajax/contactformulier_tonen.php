<?php
	session_name('SinterklaasLG');
	session_start();
	$debug=0; 
	//$debug = 1; //op 1 zetten om te debuggen
	date_default_timezone_set('Europe/Brussels');

	//if(	isset($_GET['datum']))
	{
		//$datum=$_GET['datum'];
		//echo "Datum $datum<br>";
		include('../../includes/db_conn.php');
		$query  = "SELECT * FROM TBL_mails WHERE Type='Contactformulier'";
					

		//echo "$query<br>";
		$result = mysqli_query($link, $query);
		$aantalrecords = mysqli_num_rows($result);
		if ($aantalrecords>0)
		{
			?>
			<table class="tblmetlijnenlinks">
				<th  class="tblmetlijnenlinks"  width=50>Nr</th>
				<th  class="tblmetlijnenlinks"  width=75>Datum</th>
				<th  class="tblmetlijnenlinks"  width=50>Tijd</th>
				<th  class="tblmetlijnenlinks" width=100>Mailadres</th>
				<th  class="tblmetlijnenlinks" width=700>Boodschap</th>
				
			<?php
			$nr=0;
			while($row = mysqli_fetch_assoc($result))
			{
				$MailId=$row['MailId'];
				$Datum=$row['Datum'];
				$Tijd=$row['Tijd'];
				$Ontvanger=$row['Ontvanger'];
				$Boodschap=$row['Boodschap'];

					
				$nr++;
				echo "<tr onclick=\"reservatie_tonen1($MailId)\"><td class=\"tblmetlijnenlinks\">$nr</td><td class=\"tblmetlijnenlinks\">$Datum</td><td class=\"tblmetlijnenlinks\">$Tijd</td><td class=\"tblmetlijnenlinks\">$Ontvanger</td><td class=\"tblmetlijnenlinks\">$Boodschap</td>";
				
				echo "</tr>";

			}
			
			echo "</table>";
		}
		else
		{
			echo "Geen gegevens gevonden.<br>";
		}
		mysqli_close($link);
	}
?>