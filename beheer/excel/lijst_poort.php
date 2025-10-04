<?php
	session_name("SinterklaasLG");
	session_start();
	
	$Hosting="localhost";
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
	
	$debug = 0;
	//$debug = 1; //op 1 zetten om te debuggen
	//gegevens tijdzone correct instellen
	date_default_timezone_set('Europe/Brussels');
	$datum=date('Y-m-d');
	
	//errors aan zetten
	//error_reporting(E_ALL); 
	//ini_set('display_errors', '1'); 

	$_SESSION['login']['username']="CC";
	if (isset($_SESSION['login']['username']))
	{
		if (isset($_GET['datum']))
		{
			include('../vendor1/autoload.php');
			
			//$gebruikersnaam = $_SESSION['login']['username'];
			$datum = $_GET['datum'];
			
			
			//use PhpOffice\PhpSpreadsheet\Helper\Sample;
			//use PhpOffice\PhpSpreadsheet\IOFactory;
			//use PhpOffice\PhpSpreadsheet\Spreadsheet;
			$query  = "SELECT
						TBL_data.Datum, 
						TBL_data.Tijdstip, 
						TBL_Reservatie.ReservatieId, 
						TBL_Reservatie.Naam, 
						TBL_Reservatie.Voornaam, 
						TBL_Reservatie.Telefoon, 
						TBL_Reservatie.Mailadres, 
						TBL_Reservatie.Adres, 
						TBL_Reservatie.Postcode, 
						TBL_Reservatie.Gemeente, 
						TBL_Reservatie.AantalKinderen, 
						TBL_Reservatie.AantalVolwassenen, 
						TBL_Reservatie.Kind1Naam, 
						TBL_Reservatie.Kind1Voornaam, 
						TBL_Reservatie.Kind1Leeftijd, 
						TBL_Reservatie.Kind1Goed, 
						TBL_Reservatie.Kind1Beter, 
						TBL_Reservatie.Kind2Naam, 
						TBL_Reservatie.Kind2Voornaam, 
						TBL_Reservatie.Kind2Leeftijd, 
						TBL_Reservatie.Kind2Goed, 
						TBL_Reservatie.Kind2Beter, 
						TBL_Reservatie.Kind3Naam, 
						TBL_Reservatie.Kind3Voornaam, 
						TBL_Reservatie.Kind3Leeftijd, 
						TBL_Reservatie.Kind3Goed, 
						TBL_Reservatie.Kind3Beter, 
						TBL_Reservatie.Kind4Naam, 
						TBL_Reservatie.Kind4Voornaam, 
						TBL_Reservatie.Kind4Leeftijd, 
						TBL_Reservatie.Kind4Goed, 
						TBL_Reservatie.Kind4Beter, 
						TBL_Reservatie.Kind5Naam, 
						TBL_Reservatie.Kind5Voornaam, 
						TBL_Reservatie.Kind5Leeftijd, 
						TBL_Reservatie.Kind5Goed, 
						TBL_Reservatie.Kind5Beter, 
						TBL_Reservatie.Kind6Naam, 
						TBL_Reservatie.Kind6Voornaam, 
						TBL_Reservatie.Kind6Leeftijd, 
						TBL_Reservatie.Kind6Goed, 
						TBL_Reservatie.Kind6Beter, 
						TBL_Reservatie.BetaaldDatum, 
						TBL_Reservatie.BetaaldBedrag
					FROM
						TBL_data
						INNER JOIN
						TBL_Reservatie
						ON 
							TBL_data.DataId = TBL_Reservatie.Tijdstip
					WHERE
						TBL_Reservatie.Canceled IS NULL AND TBL_data.Datum='" . $datum . "'
					ORDER BY
						TBL_data.Datum, 
						TBL_data.Tijdstip, 
						TBL_data.DataId";
			//echo "$query<br>";
			
			//Excel document maken
			
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("LG")
										->setLastModifiedBy("LG");
			//Hoofding
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1','Bezoekerlijst Kasteel van Sinterklaas ' . $datum)
			->setCellValue('A3','Groepnr')
			->setCellValue('B3','Tijd')
			->setCellValue('C3','Res.nr')
			->setCellValue('D3','Naam')
			->setCellValue('E3','Voornaam')
			->setCellValue('F3','Aantal volw')
			->setCellValue('G3','Aantal kind');
			
			$groepnr=0;
			$teller=4;

			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_assoc($result))
			{
				$groepnr++;
				$ReservatieId=$row['ReservatieId'];
				$Tijdstip=$row['Tijdstip'];
				$Naam=$row['Naam'];
				$Voornaam=$row['Voornaam'];
				$AantalKinderen=$row['AantalKinderen'];
				$AantalVolwassenen=$row['AantalVolwassenen'];
				
				//output starten	
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$teller, $groepnr);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$teller, $Tijdstip);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$teller, $ReservatieId);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$teller, $Naam);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$teller, $Voornaam);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$teller, $AantalVolwassenen);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$teller, $AantalKinderen);
				$teller++;
			}
			
			// Kolommen autosizen
			//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
			
			// Werkblad benoemen
			$objPHPExcel->getActiveSheet()->setTitle('Lijst poort');
			// Eerste werkblad activeren
			$objPHPExcel->setActiveSheetIndex(0);
			// Uitvoer
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="Lijstpoort.xls"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}
	}
?>

