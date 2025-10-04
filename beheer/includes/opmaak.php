<?php

	function hoofding($link, $menuitem, $subitem)
	{
		echo "<html>";
		echo "<head>";
		echo "<title>Het kasteel van Sinterklaas Gruitrode</title>";
	  
			
		?>
		<link rel="stylesheet" href="css/style.css">
		<?php
		$Ingelogd=false;
		if (! empty($_SESSION['login']['userid'])) 
		{
			//echo "Gebruiker gekend in sessie<br>";
			$Ingelogd=true;
			$userid=$_SESSION['login']['userid'];
			$username=$_SESSION['login']['username'];
			$naam=$_SESSION['login']['naam'];
			$voornaam=$_SESSION['login']['voornaam'];
			$wachtlijst=$_SESSION['login']['wachtlijst'];
			$contactformulier=$_SESSION['login']['contactformulier'];
			$betaling=$_SESSION['login']['betaling'];
		
		
			echo "<div class=\"topnav\" id=\"Hoofdmenu\">";
				if ($menuitem=='home') 
				{
					echo "<a href=\"index.php\" class=\"active\">Home</a>";	
				}
				else 
				{
					echo "<a href=\"index.php\">Home</a>"; 	
				}
				/*if ($menuitem=='tijdsloten')	
				{
					echo "<a href=\"tijdsloten.php\" class=\"active\">Tijdsloten</a>";
				}
				else 
				{
					echo "<a href=\"tijdsloten.php\">Tijdsloten</a>";	
				}*/
				if ($menuitem=='reservaties')	
				{
					echo "<a href=\"reservaties.php\" class=\"active\">Reservaties</a>";
				}
				else 
				{
					echo "<a href=\"reservaties.php\">Reservaties</a>";	
				}
				if ($wachtlijst==1)
				{
					if ($menuitem=='wachtlijst')	
					{
						echo "<a href=\"wachtlijst.php\" class=\"active\">Wachtlijst</a>";
					}
					else 
					{
						echo "<a href=\"wachtlijst.php\">Wachtlijst</a>";	
					}
				}
				if ($contactformulier==1)
				{
					if ($menuitem=='contactformulier')	
					{
						echo "<a href=\"contactformulier.php\" class=\"active\">Contactformulier</a>";
					}
					else 
					{
						echo "<a href=\"contactformulier.php\">Contactformulier</a>";	
					}
				}
				
				if ($betaling==1)
				{
					if ($menuitem=='betaling')	
					{
						echo "<a href=\"betaling.php\" class=\"active\">Betaling</a>";
					}
					else 
					{
						echo "<a href=\"betaling.php\">Betaling</a>";	
					}
				}
					
				echo "<div class=\"topnav-right\">";
				if ($Ingelogd)
				{
					
					echo "<a href=\"index.php\">Welkom $voornaam $naam</a>
					<a href=\"logout.php\">Afmelden</a>";
					
				}

				echo "</div>";
				
				echo "<a href=\"javascript:void(0);\" class=\"icon\" onclick=\"myFunction()\">
					<i class=\"fa fa-bars\"></i>
				</a>
			</div>";
		}
		else
		{
			echo "<div class=\"topnav\" id=\"Hoofdmenu\">";
				if ($menuitem=='home') 
				{
					echo "<a href=\"index.php\" class=\"active\">Home</a>";	
				}
				else 
				{
					echo "<a href=\"index.php\">Home</a>"; 
				}					
			echo "</div>";
		}
	}
	
	function start_tabel() // tabel voor inhoud maken met 2 kolommen
	{
		?>
		<table id="tbl" class="css_tbl_hoofding">
			<th width=1%;></th>
			<th width=98%;></th>
			<th width=1%;></th>
		<?php
		echo "<tr class=\"css_tbl_hoofding\"><td class=\"hoofd\" valign=\"top\">";
		include ("balklinks.php");
		echo "</td><td class=\"css_tbl_hoofding\">";
		
	}
	
	function eind_tabel()
	{
		echo "</td><td class=\"css_tbl_hoofding\" valign=\"top\">";
		include ("balkrechts.php");
		echo "</td></tr></table>";	
	}
	
	function voetnoot()
	{
		
	}
?>