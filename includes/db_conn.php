<?php
	$Hosting="srv042150.webreus.net";
	//$Hosting="localhost";
	$DatabaseUser="c30240lg1";
	$DatabasePwd="Xty!3P1MwXty!3P1Mw";
	$Database="c30240lg1";
	
	
	error_reporting(E_ALL); 
	ini_set('display_errors', '1');
	
	//echo "Hosting: $Hosting<br>User: $DatabaseUser<br>Database: $Database<br>";
	$link = @mysqli_connect($Hosting,$DatabaseUser,$DatabasePwd,$Database);
	// Opmerking:
	// Afhankelijk van de instellingen in PHP.ini zou het kunnen dat de functie mysqli_connect zelf al foutmeldingen geeft 
	// als de connectie faalt
	// Dat kan je onderdrukken door een '@' te plaatsen voor de functie:
	// $link = @mysqli_connect('localhost','usrcursusphp','pwdcursusphp','CursusPHP');
	
	// Als de link faalt, dan wordt onderstaande code uitgevoerd
	if(!$link){
		echo "Verbinding mislukt!<br><br>Deze website is momenteel niet bereikbaar.<br>";
		
		// Wat meer uitleg waarom de verbinding niet geslaagd is
		echo mysqli_connect_error();
		
		// Deze regel zorgt er voor dat het script hierna stopt, anders wordt code uitgevoerd waarvoor
		// een databaseverbinding nodig is en die is nu niet actief.
		exit();
	}
	
	if (!mysqli_set_charset($link, "utf8")){
		echo "Verbinding niet omgezet naar UTF8";
	}
	
?>