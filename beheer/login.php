<?php
	if (isset($_SESSION['login']['userid']))
	{
		header("Location: ./");
	}
	else
	{
		?>
		<table id="tbllogin" class="tblzonderlijnenlinkscenter">
			
		<?php
		echo "<tr class=\"tblzonderlijnenlinkscenter\">";
		echo "<td class=\"tblzonderlijnenlinkscenter\" >";
		echo "Gebruikersnaam</td><td class=\"tblzonderlijnenlinkscenter\" > <input id=\"txtGebruikersnaam\" value=\"\" size=\"25\" type=\"text\";\" onkeyup=\"opzoeken(event)\" autofocus>";
		//echo "<br>";
		echo "</td></tr>";
		echo "<tr class=\"tblzonderlijnenlinkscenter\">";
		echo "<td class=\"tblzonderlijnenlinkscenter\" >";
		echo "Wachtwoord</td><td class=\"tblzonderlijnenlinkscenter\" >  <input id=\"txtWachtwoord\" value=\"\" size=\"25\" type=\"password\";\" onkeyup=\"opzoeken(event)\" >";
		//echo "<br>";
		echo "</td></tr>";
		echo "</table>";
		echo "<br><br><input type=\"button\" onclick=\"aanmelden()\" value=\"Aanmelden\" class=\"form-submit-button\">";
		
		
	}
	echo "<div id=\"divLoginOpm\"></div>";
?>