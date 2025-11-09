<?php
	include('includes/opmaak.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();
	if (!isset($_SESSION['reservatie']['reservatieid']))
	{
		//als er geen reservatie in geheugen is dan terug naar startpagina.
		echo "<script>location.href = 'reserveer.php';</script>";
	}
	else
	{
		if (isset($_SESSION['reservatie']['status']) && $_SESSION['reservatie']['status']=="ReserveringOK")
		{
			//als er een geldige reservatie in geheugen is dan terug naar startpagina.
			$_SESSION=array();
			echo "<script>location.href = 'reserveer.php';</script>";
		}
	}
	include('includes/db_conn.php');
	$query  = "select * FROM TBL_parameters WHERE InGebruik = 1";
	$result = mysqli_query($link, $query);
	$aantal = mysqli_num_rows($result);
	if ($aantal>0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$prijskind = $row['PrijsKind'];
			$prijsvolw = $row['PrijsVolwassene'];
			$prijskindopm = $row['PrijsKindOpm'];
			$prijsvolwopm = $row['PrijsVolwasseneOpm'];
		}
	}
	else
	{
		echo "ERROR. Er is een fout opgetreden bij het ophalen van de parametergegevens.<br>";
		exit();
	}
	?>
	<html>
	<head>
		<?php
		opmaak_pagina();
		?>
		<script type="text/javascript">	
			function validateEmail(email)
			{
				var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				return re.test(email);
			}
			
			function isNumeric(value)
			{
				return /^-?\d+$/.test(value);
			}
			
			function sla_waarde_op(veld, waarde)
			{
				var xhttp = new XMLHttpRequest();
				//alert(veld);
				waarde=encodeURIComponent(waarde);
				xhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						if (xhttp.responseText==0)
						{
						
						}
						else
						{
							document.getElementById("formmelding").innerHTML = xhttp.responseText;
						}
					}
				};

				xhttp.open("GET", "ajax/BewaarGegevensReservatie.php?veld=" + veld + "&waarde=" + waarde , true);
				xhttp.send();
			}
			
			function controleer_korting(code)
			{
				var xhttp = new XMLHttpRequest();
				//alert(code);
				code=encodeURIComponent(code);
				document.getElementById("divKorting").innerHTML = "";
				if (code=='')
				{
					
				}
				else
				{
					xhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							//document.getElementById("formmelding").innerHTML = xhttp.responseText;
							if (xhttp.responseText==0)
							{
								sla_waarde_op('KortingCode', '')
								document.getElementById("divKorting").innerHTML = "<p style='color:red;'>Code niet gekend</p>";
							}
							else
							{
								if (xhttp.responseText==1)
								{
									sla_waarde_op('KortingCode', code)
									document.getElementById("divKorting").innerHTML = "Code OK";
								}
								else
								{
									if (xhttp.responseText==2)
									{
										sla_waarde_op('KortingCode', '')
										document.getElementById("divKorting").innerHTML = "<p style='color:red;'>Code niet meer geldig</p>";
									}
									else
									{
										sla_waarde_op('KortingCode', '')
										document.getElementById("formmelding").innerHTML = xhttp.responseText;
									}
								}
							}
						}
					};

					xhttp.open("GET", "ajax/ControleerKortingCode.php?code=" + code  , true);
					xhttp.send();
				}
			}
			
			function selecteerAantalVolwassenen(kindprijs, volwprijs)
			{
				veld = "AantalVolwassenen";
				aantalkind = encodeURIComponent(document.getElementById('selAantalKinderen').value);
				aantalvolw = encodeURIComponent(document.getElementById('selAantalVolwassenen').value);
				prijskind = aantalkind * kindprijs;
				prijsvolw = aantalvolw * volwprijs;
				prijs = prijskind + prijsvolw;
				document.getElementById('divPrijs').innerHTML = prijs + " €";
				sla_waarde_op(veld, aantalvolw);
			}
			
			function selecteerAantalKinderen(kindprijs, volwprijs)
			{
				veld = "AantalKinderen";
				aantalkind = encodeURIComponent(document.getElementById('selAantalKinderen').value);
				aantalvolw = encodeURIComponent(document.getElementById('selAantalVolwassenen').value);
				//alert (veld + " - " + aantal);
				
				if (aantalkind == "")
				{
					//alert(aantalkind);
					sla_waarde_op(veld, '');
					document.getElementById('divPrijs').innerHTML = ' ';
					document.getElementById('divKind1').hidden  = true;
					document.getElementById('divKind2').hidden  = true;
					document.getElementById('divKind3').hidden  = true;
					document.getElementById('divKind4').hidden  = true;
					document.getElementById('divKind5').hidden  = true;
					document.getElementById('divKind6').hidden  = true;
					kind1leeg();
					kind2leeg();
					kind3leeg();
					kind4leeg();
					kind5leeg();
					kind6leeg();
				}
				else
				{
					sla_waarde_op(veld, aantalkind);
					if (aantalkind == 1)
					{
						//alert(aantalkind);
						document.getElementById('divKind1').hidden  = false;
						document.getElementById('divKind2').hidden  = true;
						document.getElementById('divKind3').hidden  = true;
						document.getElementById('divKind4').hidden  = true;
						document.getElementById('divKind5').hidden  = true;
						document.getElementById('divKind6').hidden  = true;
						kind2leeg();
						kind3leeg();
						kind4leeg();
						kind5leeg();
						kind6leeg();
					}
					else
					{
						if (aantalkind == 2)
						{
							//alert(aantalkind);
							document.getElementById('divKind1').hidden  = false;
							document.getElementById('divKind2').hidden  = false;
							document.getElementById('divKind3').hidden  = true;
							document.getElementById('divKind4').hidden  = true;
							document.getElementById('divKind5').hidden  = true;
							document.getElementById('divKind6').hidden  = true;
							kind3leeg();
							kind4leeg();
							kind5leeg();
							kind6leeg();
						}
						else
						{
							if (aantalkind == 3)
							{
								//alert(aantalkind);
								document.getElementById('divKind1').hidden  = false;
								document.getElementById('divKind2').hidden  = false;
								document.getElementById('divKind3').hidden  = false;
								document.getElementById('divKind4').hidden  = true;
								document.getElementById('divKind5').hidden  = true;
								document.getElementById('divKind6').hidden  = true;
								kind4leeg();
								kind5leeg();
								kind6leeg();
							}
							else
							{
								if (aantalkind == 4)
								{
									//alert(aantalkind);
									document.getElementById('divKind1').hidden  = false;
									document.getElementById('divKind2').hidden  = false;
									document.getElementById('divKind3').hidden  = false;
									document.getElementById('divKind4').hidden  = false;
									document.getElementById('divKind5').hidden  = true;
									document.getElementById('divKind6').hidden  = true;
									kind5leeg();
									kind6leeg();
								}
								else
								{
									if (aantalkind == 5)
									{
										//alert(aantalkind);
										document.getElementById('divKind1').hidden  = false;
										document.getElementById('divKind2').hidden  = false;
										document.getElementById('divKind3').hidden  = false;
										document.getElementById('divKind4').hidden  = false;
										document.getElementById('divKind5').hidden  = false;
										document.getElementById('divKind6').hidden  = true;
										kind6leeg();
									}
									else
									{
										if (aantalkind == 6)
										{
											//alert(aantalkind);
											document.getElementById('divKind1').hidden  = false;
											document.getElementById('divKind2').hidden  = false;
											document.getElementById('divKind3').hidden  = false;
											document.getElementById('divKind4').hidden  = false;
											document.getElementById('divKind5').hidden  = false;
											document.getElementById('divKind6').hidden  = false;
										}
									}
								}
							}
						}
					}
					prijskind = aantalkind * kindprijs;
					prijsvolw = aantalvolw * volwprijs;
					prijs = prijskind + prijsvolw;
					document.getElementById('divPrijs').innerHTML = prijs + " €";
				}
			}
			
			function kind1leeg()
			{
				sla_waarde_op('Kind1Naam','');
				sla_waarde_op('Kind1Voornaam','');
				sla_waarde_op('Kind1Leeftijd','');
				sla_waarde_op('Kind1Goed','');
				sla_waarde_op('Kind1Beter','');
				document.getElementById('txtKind1Naam').value = '';
				document.getElementById('txtKind1Voornaam').value = '';
				document.getElementById('txtKind1Leeftijd').value = '';
				document.getElementById('txtKind1Goed').value = '';
				document.getElementById('txtKind1Beter').value = '';
			}
			
			function kind2leeg()
			{
				sla_waarde_op('Kind2Naam','');
				sla_waarde_op('Kind2Voornaam','');
				sla_waarde_op('Kind2Leeftijd','');
				sla_waarde_op('Kind2Goed','');
				sla_waarde_op('Kind2Beter','');
				document.getElementById('txtKind2Naam').value = '';
				document.getElementById('txtKind2Voornaam').value = '';
				document.getElementById('txtKind2Leeftijd').value = '';
				document.getElementById('txtKind2Goed').value = '';
				document.getElementById('txtKind2Beter').value = '';
			}
			
			function kind3leeg()
			{
				sla_waarde_op('Kind3Naam','');
				sla_waarde_op('Kind3Voornaam','');
				sla_waarde_op('Kind3Leeftijd','');
				sla_waarde_op('Kind3Goed','');
				sla_waarde_op('Kind3Beter','');
				document.getElementById('txtKind3Naam').value = '';
				document.getElementById('txtKind3Voornaam').value = '';
				document.getElementById('txtKind3Leeftijd').value = '';
				document.getElementById('txtKind3Goed').value = '';
				document.getElementById('txtKind3Beter').value = '';
			}
			
			function kind4leeg()
			{
				sla_waarde_op('Kind4Naam','');
				sla_waarde_op('Kind4Voornaam','');
				sla_waarde_op('Kind4Leeftijd','');
				sla_waarde_op('Kind4Goed','');
				sla_waarde_op('Kind4Beter','');
				document.getElementById('txtKind4Naam').value = '';
				document.getElementById('txtKind4Voornaam').value = '';
				document.getElementById('txtKind4Leeftijd').value = '';
				document.getElementById('txtKind4Goed').value = '';
				document.getElementById('txtKind4Beter').value = '';
			}
			
			function kind5leeg()
			{
				sla_waarde_op('Kind5Naam','');
				sla_waarde_op('Kind5Voornaam','');
				sla_waarde_op('Kind5Leeftijd','');
				sla_waarde_op('Kind5Goed','');
				sla_waarde_op('Kind5Beter','');
				document.getElementById('txtKind5Naam').value = '';
				document.getElementById('txtKind5Voornaam').value = '';
				document.getElementById('txtKind5Leeftijd').value = '';
				document.getElementById('txtKind5Goed').value = '';
				document.getElementById('txtKind5Beter').value = '';
			}
			
			function kind6leeg()
			{
				sla_waarde_op('Kind6Naam','');
				sla_waarde_op('Kind6Voornaam','');
				sla_waarde_op('Kind6Leeftijd','');
				sla_waarde_op('Kind6Goed','');
				sla_waarde_op('Kind6Beter','');
				document.getElementById('txtKind6Naam').value = '';
				document.getElementById('txtKind6Voornaam').value = '';
				document.getElementById('txtKind6Leeftijd').value = '';
				document.getElementById('txtKind6Goed').value = '';
				document.getElementById('txtKind6Beter').value = '';
			}
			
			function TijdstipReserveren()
			{
				var errors = false;
				//alle achtergronden wit maken
				document.getElementById('formmelding').innerHTML = '';
				document.getElementById('txtNaam').style.backgroundColor = '';
				document.getElementById('txtVoornaam').style.backgroundColor = '';
				document.getElementById('txtTelefoon').style.backgroundColor = '';
				document.getElementById('txtMail').style.backgroundColor = '';
				document.getElementById('txtAdres').style.backgroundColor = '';
				document.getElementById('txtPostcode').style.backgroundColor = '';
				document.getElementById('txtGemeente').style.backgroundColor = '';
				document.getElementById('selAantalVolwassenen').style.backgroundColor = '';
				document.getElementById('selAantalKinderen').style.backgroundColor = '';
				
				document.getElementById('txtKind1Naam').style.backgroundColor = '';
				document.getElementById('txtKind1Voornaam').style.backgroundColor = '';
				document.getElementById('txtKind1Leeftijd').style.backgroundColor = '';
				
				document.getElementById('txtKind2Naam').style.backgroundColor = '';
				document.getElementById('txtKind2Voornaam').style.backgroundColor = '';
				document.getElementById('txtKind2Leeftijd').style.backgroundColor = '';
				
				document.getElementById('txtKind3Naam').style.backgroundColor = '';
				document.getElementById('txtKind3Voornaam').style.backgroundColor = '';
				document.getElementById('txtKind3Leeftijd').style.backgroundColor = '';
				
				document.getElementById('txtKind4Naam').style.backgroundColor = '';
				document.getElementById('txtKind4Voornaam').style.backgroundColor = '';
				document.getElementById('txtKind4Leeftijd').style.backgroundColor = '';
				
				document.getElementById('txtKind5Naam').style.backgroundColor = '';
				document.getElementById('txtKind5Voornaam').style.backgroundColor = '';
				document.getElementById('txtKind5Leeftijd').style.backgroundColor = '';
				
				document.getElementById('txtKind6Naam').style.backgroundColor = '';
				document.getElementById('txtKind6Voornaam').style.backgroundColor = '';
				document.getElementById('txtKind6Leeftijd').style.backgroundColor = '';
				
				
				// elk verplicht veld controleren of het ingevuld is.
				if(document.getElementById('txtNaam').value == '')
				{
					document.getElementById('txtNaam').style.backgroundColor = 'red';
					errors = true;
				}
				if(document.getElementById('txtVoornaam').value == '')
				{
					document.getElementById('txtVoornaam').style.backgroundColor = 'red';
					errors = true;
				}
				if(document.getElementById('txtTelefoon').value == '')
				{
					document.getElementById('txtTelefoon').style.backgroundColor = 'red';
					errors = true;
				}			
				if(document.getElementById('txtMail').value == ''){
					//mailadres is niet ingevuld
					document.getElementById('txtMail').style.backgroundColor = 'red';
					errors = true;
				}
				else 
				{
					if(!validateEmail(document.getElementById('txtMail').value))
					{
						document.getElementById('txtMail').style.backgroundColor = 'red';
						errors = true;
					}
				}				
				if(document.getElementById('txtAdres').value == '')
				{
					document.getElementById('txtAdres').style.backgroundColor = 'red';
					errors = true;
				}					
				if(document.getElementById('txtPostcode').value == '')
				{
					document.getElementById('txtPostcode').style.backgroundColor = 'red';
					errors = true;
				}
				if(document.getElementById('txtGemeente').value == '')
				{
					document.getElementById('txtGemeente').style.backgroundColor = 'red';
					errors = true;
				}
				if(document.getElementById('selAantalVolwassenen').value == '')
				{
					document.getElementById('selAantalVolwassenen').style.backgroundColor = 'red';
					errors = true;
				}
				else
				{
					AantalVolwassenen = document.getElementById('selAantalVolwassenen').value;
					if ( isNumeric(AantalVolwassenen) ) 
					{
					   // perform some operation with number.
					}
					else
					{
						document.getElementById('selAantalVolwassenen').style.backgroundColor = 'red';
						errors = true;
					}
				}
				if(document.getElementById('selAantalKinderen').value == '')
				{
					document.getElementById('selAantalKinderen').style.backgroundColor = 'red';
					errors = true;
				}
				AantalKinderen = document.getElementById('selAantalKinderen').value;
				if (AantalKinderen >= 1)
				{
					if(document.getElementById('txtKind1Naam').value == '')
					{
						document.getElementById('txtKind1Naam').style.backgroundColor = 'red';
						errors = true;
					}
					if(document.getElementById('txtKind1Voornaam').value == '')
					{
						document.getElementById('txtKind1Voornaam').style.backgroundColor = 'red';
						errors = true;
					}
					if(document.getElementById('txtKind1Leeftijd').value == '')
					{
						document.getElementById('txtKind1Leeftijd').style.backgroundColor = 'red';
						errors = true;
					}
					
				}
				
				if (AantalKinderen >= 2)
				{
					if(document.getElementById('txtKind2Naam').value == '')
					{
						document.getElementById('txtKind2Naam').style.backgroundColor = 'red';
						errors = true;
					}
					if(document.getElementById('txtKind2Voornaam').value == '')
					{
						document.getElementById('txtKind2Voornaam').style.backgroundColor = 'red';
						errors = true;
					}
					if(document.getElementById('txtKind2Leeftijd').value == '')
					{
						document.getElementById('txtKind2Leeftijd').style.backgroundColor = 'red';
						errors = true;
					}
					
				}
				
				if (AantalKinderen >= 3)
				{
					if(document.getElementById('txtKind3Naam').value == '')
					{
						document.getElementById('txtKind3Naam').style.backgroundColor = 'red';
						errors = true;
					}
					if(document.getElementById('txtKind3Voornaam').value == '')
					{
						document.getElementById('txtKind3Voornaam').style.backgroundColor = 'red';
						errors = true;
					}
					if(document.getElementById('txtKind3Leeftijd').value == '')
					{
						document.getElementById('txtKind3Leeftijd').style.backgroundColor = 'red';
						errors = true;
					}
					
				}
				
				if (AantalKinderen >= 4)
				{
					if(document.getElementById('txtKind4Naam').value == '')
					{
						document.getElementById('txtKind4Naam').style.backgroundColor = 'red';
						errors = true;
					}
					if(document.getElementById('txtKind4Voornaam').value == '')
					{
						document.getElementById('txtKind4Voornaam').style.backgroundColor = 'red';
						errors = true;
					}
					if(document.getElementById('txtKind4Leeftijd').value == '')
					{
						document.getElementById('txtKind4Leeftijd').style.backgroundColor = 'red';
						errors = true;
					}
					
				}
				
				if (AantalKinderen >= 5)
				{
					if(document.getElementById('txtKind5Naam').value == '')
					{
						document.getElementById('txtKind5Naam').style.backgroundColor = 'red';
						errors = true;
					}
					if(document.getElementById('txtKind5Voornaam').value == '')
					{
						document.getElementById('txtKind5Voornaam').style.backgroundColor = 'red';
						errors = true;
					}
					if(document.getElementById('txtKind5Leeftijd').value == '')
					{
						document.getElementById('txtKind5Leeftijd').style.backgroundColor = 'red';
						errors = true;
					}
					
				}
				
				if (AantalKinderen >= 6)
				{
					if(document.getElementById('txtKind6Naam').value == '')
					{
						document.getElementById('txtKind6Naam').style.backgroundColor = 'red';
						errors = true;
					}
					if(document.getElementById('txtKind6Voornaam').value == '')
					{
						document.getElementById('txtKind6Voornaam').style.backgroundColor = 'red';
						errors = true;
					}
					if(document.getElementById('txtKind6Leeftijd').value == '')
					{
						document.getElementById('txtKind6Leeftijd').style.backgroundColor = 'red';
						errors = true;
					}
					
				}
				if(errors) //controleren of er errors (velden niet ingevuld) waren
				{
					//alert("verplicht");
					document.getElementById('formmelding').innerHTML = 'Vul de verplichte velden in.';
				}
				else
				{
					if (document.getElementById("chkBetalingOK").checked)
					{
						var xhttp = new XMLHttpRequest();
						document.getElementById("formmelding").innerHTML = 'De reservatie wordt verwerkt ...';
						naam = encodeURIComponent(document.getElementById('txtNaam').value);
						voornaam = encodeURIComponent(document.getElementById('txtVoornaam').value);						
						telefoon = encodeURIComponent(document.getElementById('txtTelefoon').value);
						mail = document.getElementById('txtMail').value;
						mailadres = encodeURIComponent(document.getElementById('txtMail').value);
						adres = encodeURIComponent(document.getElementById('txtAdres').value);
						postcode = encodeURIComponent(document.getElementById('txtPostcode').value);
						gemeente = encodeURIComponent(document.getElementById('txtGemeente').value);
						aantalvolwassenen = encodeURIComponent(document.getElementById('selAantalVolwassenen').value);
						aantalkinderen = encodeURIComponent(document.getElementById('selAantalKinderen').value);
						
						naamkind1 = encodeURIComponent(document.getElementById('txtKind1Naam').value);
						voornaamkind1 = encodeURIComponent(document.getElementById('txtKind1Voornaam').value);
						leeftijdkind1 = encodeURIComponent(document.getElementById('txtKind1Leeftijd').value);
						goedkind1 = encodeURIComponent(document.getElementById('txtKind1Goed').value);
						beterkind1 = encodeURIComponent(document.getElementById('txtKind1Beter').value);
						
						naamkind2 = encodeURIComponent(document.getElementById('txtKind2Naam').value);
						voornaamkind2 = encodeURIComponent(document.getElementById('txtKind2Voornaam').value);
						leeftijdkind2 = encodeURIComponent(document.getElementById('txtKind2Leeftijd').value);
						goedkind2 = encodeURIComponent(document.getElementById('txtKind2Goed').value);
						beterkind2 = encodeURIComponent(document.getElementById('txtKind2Beter').value);
						
						naamkind3 = encodeURIComponent(document.getElementById('txtKind3Naam').value);
						voornaamkind3 = encodeURIComponent(document.getElementById('txtKind3Voornaam').value);
						leeftijdkind3 = encodeURIComponent(document.getElementById('txtKind3Leeftijd').value);
						goedkind3 = encodeURIComponent(document.getElementById('txtKind3Goed').value);
						beterkind3 = encodeURIComponent(document.getElementById('txtKind3Beter').value);
						
						naamkind4 = encodeURIComponent(document.getElementById('txtKind4Naam').value);
						voornaamkind4 = encodeURIComponent(document.getElementById('txtKind4Voornaam').value);
						leeftijdkind4 = encodeURIComponent(document.getElementById('txtKind4Leeftijd').value);
						goedkind4 = encodeURIComponent(document.getElementById('txtKind4Goed').value);
						beterkind4 = encodeURIComponent(document.getElementById('txtKind4Beter').value);
						
						naamkind5 = encodeURIComponent(document.getElementById('txtKind5Naam').value);
						voornaamkind5 = encodeURIComponent(document.getElementById('txtKind5Voornaam').value);
						leeftijdkind5 = encodeURIComponent(document.getElementById('txtKind5Leeftijd').value);
						goedkind5 = encodeURIComponent(document.getElementById('txtKind5Goed').value);
						beterkind5 = encodeURIComponent(document.getElementById('txtKind5Beter').value);
						
						naamkind6 = encodeURIComponent(document.getElementById('txtKind6Naam').value);
						voornaamkind6 = encodeURIComponent(document.getElementById('txtKind6Voornaam').value);
						leeftijdkind6 = encodeURIComponent(document.getElementById('txtKind6Leeftijd').value);
						goedkind6 = encodeURIComponent(document.getElementById('txtKind6Goed').value);
						beterkind6 = encodeURIComponent(document.getElementById('txtKind6Beter').value);
						
						xhttp.onreadystatechange = function() 
						{
							if (this.readyState == 4 && this.status == 200) 
							{
								
								if (xhttp.responseText=="1")
								{
									//alles OK
									alert("De reservatie is gelukt. Je ontvangt een mail op " + mail + " met de nodige info. Indien je geen mail ontvangen hebt, kijk eens bij de ongewenste/spam mails. Het kan even duren voordat de mail verstuurd wordt.");
									location.href = 'reservatie.php';
								}
								else
								{
									document.getElementById("formmelding").innerHTML = xhttp.responseText;
								}
							}
						};

						xhttp.open("GET", "ajax/BewaarReservatie.php?naam=" + naam + "&voornaam=" + voornaam + "&telefoon=" + telefoon + "&mailadres=" + mailadres + "&adres=" + adres + 
						"&postcode=" + postcode + "&gemeente=" + gemeente + "&aantalvolwassenen=" + aantalvolwassenen +"&aantalkinderen=" + aantalkinderen + 
						"&naamkind1=" + naamkind1 + "&voornaamkind1=" + voornaamkind1 + "&leeftijdkind1=" + leeftijdkind1 + "&goedkind1=" + goedkind1 + "&beterkind1=" + beterkind1 +
						"&naamkind2=" + naamkind2 + "&voornaamkind2=" + voornaamkind2 + "&leeftijdkind2=" + leeftijdkind2 + "&goedkind2=" + goedkind2 + "&beterkind2=" + beterkind2 +
						"&naamkind3=" + naamkind3 + "&voornaamkind3=" + voornaamkind3 + "&leeftijdkind3=" + leeftijdkind3 + "&goedkind3=" + goedkind3 + "&beterkind3=" + beterkind3 +
						"&naamkind4=" + naamkind4 + "&voornaamkind4=" + voornaamkind4 + "&leeftijdkind4=" + leeftijdkind4 + "&goedkind4=" + goedkind4 + "&beterkind4=" + beterkind4 +
						"&naamkind5=" + naamkind5 + "&voornaamkind5=" + voornaamkind5 + "&leeftijdkind5=" + leeftijdkind5 + "&goedkind5=" + goedkind5 + "&beterkind5=" + beterkind5 +
						"&naamkind6=" + naamkind6 + "&voornaamkind6=" + voornaamkind6 + "&leeftijdkind6=" + leeftijdkind6 + "&goedkind6=" + goedkind6 + "&beterkind6=" + beterkind6 , true); // alle velden toevoegen
						xhttp.send();
						
						
					}
					else
					{
						document.getElementById('chkBetalingOK').style.backgroundColor = 'red';
						document.getElementById('formmelding').innerHTML = '<span style="color:red">Je moet akkoord gaan met de betaling.</span>';
					}
					
				}
			}
		</script>
	</head>
	<body>
		<div class="hero_area">

			<?php
				toon_header("reservatie");
			?>

			<!--  section -->

			<section class="about_section layout_padding">
				<div class="container">
					<div class="row">
						<div class="col-md-10 px-0">
							<div class="detail-box">
								<?php
								
									echo "<div id=\"divreservatie\">";
									$dataid=$_SESSION['reservatie']['dataid'];
									$reservatieid=$_SESSION['reservatie']['reservatieid'];
									$query  = "select * from TBL_data WHERE DataId='$dataid'";
									$result = mysqli_query($link, $query);
									$aantal = mysqli_num_rows($result);
									if ($aantal>0)
									{	
										while($row = mysqli_fetch_assoc($result))
										{
											$Datum=$row['Datum'];
											$Tijdstip=$row['Tijdstip'];
										}
									}
									
									$query  = "select * from TBL_Reservatie WHERE ReservatieId='".$reservatieid."'";
									$result = mysqli_query($link, $query);
									$aantalreservatie = mysqli_num_rows($result);
									if ($aantalreservatie>0)
									{
										while($row = mysqli_fetch_assoc($result))
										{
											$Naam=$row['Naam'];
											$Voornaam=$row['Voornaam'];
											$Telefoon=$row['Telefoon'];
											$Mailadres=$row['Mailadres'];
											$Adres=$row['Adres'];
											$Postcode=$row['Postcode'];
											$Gemeente=$row['Gemeente'];
											$AantalKinderen=$row['AantalKinderen'];
											$AantalVolwassenen=$row['AantalVolwassenen'];
											$Kind1Naam=$row['Kind1Naam'];
											$Kind1Voornaam=$row['Kind1Voornaam'];
											$Kind1Leeftijd=$row['Kind1Leeftijd'];
											$Kind1Goed=$row['Kind1Goed'];
											$Kind1Beter=$row['Kind1Beter'];
											$Kind2Naam=$row['Kind2Naam'];
											$Kind2Voornaam=$row['Kind2Voornaam'];
											$Kind2Leeftijd=$row['Kind2Leeftijd'];
											$Kind2Goed=$row['Kind2Goed'];
											$Kind2Beter=$row['Kind2Beter'];
											$Kind3Naam=$row['Kind3Naam'];
											$Kind3Voornaam=$row['Kind3Voornaam'];
											$Kind3Leeftijd=$row['Kind3Leeftijd'];
											$Kind3Goed=$row['Kind3Goed'];
											$Kind3Beter=$row['Kind3Beter'];
											$Kind4Naam=$row['Kind4Naam'];
											$Kind4Voornaam=$row['Kind4Voornaam'];
											$Kind4Leeftijd=$row['Kind4Leeftijd'];
											$Kind4Goed=$row['Kind4Goed'];
											$Kind4Beter=$row['Kind4Beter'];
											$Kind5Naam=$row['Kind5Naam'];
											$Kind5Voornaam=$row['Kind5Voornaam'];
											$Kind5Leeftijd=$row['Kind5Leeftijd'];
											$Kind5Goed=$row['Kind5Goed'];
											$Kind5Beter=$row['Kind5Beter'];
											$Kind6Naam=$row['Kind6Naam'];
											$Kind6Voornaam=$row['Kind6Voornaam'];
											$Kind6Leeftijd=$row['Kind6Leeftijd'];
											$Kind6Goed=$row['Kind6Goed'];
											$Kind6Beter=$row['Kind6Beter'];
											$VerklaringBetaling=$row['VerklaringBetaling'];
											$KortingCode=$row['KortingCode'];
										}
									}

									echo "<div class=\"heading_container \"><h2>Reservatie</h2><h5><b>$Datum - $Tijdstip</b></h5></div>";
									echo "Gelieve onderstaande velden in te vullen om het tijdstip te reserveren.<br>Na het reserveren ontvangt u een bevestigingsmail.<br><br>Gelieve deze pagina <b><i>niet</i></b> te sluiten, anders wordt de reservatie ongedaan gemaakt.<br><br>";
									echo "<table>";
									echo "<tr><td colspan=2><h5><b>Gegevens ouder(s)</b></h5></td></tr>";
									echo "<tr><td>Naam</td><td><input id=\"txtNaam\" value=\"".$Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Naam', this.value);\" autofocus></td></tr>";
									echo "<tr><td>Voornaam</td><td><input id=\"txtVoornaam\" value=\"".$Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Voornaam', this.value);\" ></td></tr>";
									echo "<tr><td>Telefoon</td><td><input id=\"txtTelefoon\" value=\"".$Telefoon."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Telefoon', this.value);\" ></td></tr>";
									echo "<tr><td>Mailadres</td><td><input id=\"txtMail\" value=\"".$Mailadres."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Mailadres', this.value);\" ></td></tr>";
									echo "<tr><td>Adres</td><td><input id=\"txtAdres\" value=\"".$Adres."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Adres', this.value);\" ></td></tr>";
									echo "<tr><td>Gemeente</td><td><input id=\"txtPostcode\" value=\"".$Postcode."\" size=\"10\" type=\"text\";\" onfocusout=\"sla_waarde_op('Postcode', this.value);\" >
									<input id=\"txtGemeente\" value=\"".$Gemeente."\" size=\"23\" type=\"text\";\" onfocusout=\"sla_waarde_op('Gemeente', this.value);\" ></td></tr>";
									echo "<tr><td>Aantal volwassenen</td><td>";
									echo "<select id=\"selAantalVolwassenen\"  onChange=\"selecteerAantalVolwassenen($prijskind, $prijsvolw);\">";
									if ($AantalVolwassenen=='')
									{
										echo "<option value=\"\" selected></option>";
									}
									else
									{
										echo "<option value=\"\"></option>";
									}
									for ($x = 1; $x <= 6; $x++) 
									{
										if ($x == $AantalVolwassenen)
										{
											echo "<option value=\"$x\" selected>$x</option>";
										}
										else
										{
											echo "<option value=\"$x\">$x</option>";
										}
									}
									echo "</select> Per volwassene betaalt u $prijsvolw €. ";
									if ($prijsvolwopm != '')
									{
										echo "Hiervoor krijgt elke volwassene $prijsvolwopm.";
									}
									echo "</td></tr>";
									echo "<tr><td colspan=2><h5><b>Gegevens kinderen</b></h5></td></tr>";
									echo "<tr><td>Aantal kinderen</td><td>";
									echo "<select id=\"selAantalKinderen\"  onChange=\"selecteerAantalKinderen($prijskind, $prijsvolw);\">";
									if ($AantalKinderen=='')
									{
										echo "<option value=\"\" selected></option>";
									}
									else
									{
										echo "<option value=\"\"></option>";
									}
									for ($x = 1; $x <= 6; $x++) 
									{
										if ($x == $AantalKinderen)
										{
											echo "<option value=\"$x\" selected>$x</option>";
										}
										else
										{
											echo "<option value=\"$x\">$x</option>";
										}
									}
									echo "</select> Per kind betaalt u $prijskind €. ";
									
									echo "Hiervoor krijgt elk kind een snoepzak.";
									echo "</td></tr>";
									echo "<tr><td colspan=2><i>\"De goede eigenschappen\" en \"Dingen die beter kunnen\" kunnen nadien nog aangevuld worden (je ontvangt hiervoor een bevestigingsmail).</i></td></tr>";
									//kind1
									echo "<tr><td colspan=2>";
									echo "<div id=\"divKind1\">";
									
									echo "<table><tr><td><b>Kind 1</b></td></tr>";
									echo "<tr><td>Naam</td><td><input id=\"txtKind1Naam\" value=\"".$Kind1Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind1Naam', this.value);\"></td></tr>";
									echo "<tr><td>Voornaam</td><td><input id=\"txtKind1Voornaam\" value=\"".$Kind1Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind1Voornaam', this.value);\" ></td></tr>";
									echo "<tr><td>Leeftijd</td><td><input id=\"txtKind1Leeftijd\" value=\"".$Kind1Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind1Leeftijd', this.value);\" >  jaar</td></tr>";
									echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind1Goed\" value=\"".$Kind1Goed."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind1Goed', this.value);\" ></td></tr>";
									echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind1Beter\" value=\"".$Kind1Beter."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind1Beter', this.value);\" ></td></tr></table></div></td></tr>";
									
									//kind2
									echo "<tr><td colspan=2>";
									echo "<div id=\"divKind2\">";
									
									echo "<table><tr><td><b>Kind 2</b></td></tr>";
									echo "<tr><td>Naam</td><td><input id=\"txtKind2Naam\" value=\"".$Kind2Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind2Naam', this.value);\"></td></tr>";
									echo "<tr><td>Voornaam</td><td><input id=\"txtKind2Voornaam\" value=\"".$Kind2Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind2Voornaam', this.value);\" ></td></tr>";
									echo "<tr><td>Leeftijd</td><td><input id=\"txtKind2Leeftijd\" value=\"".$Kind2Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind2Leeftijd', this.value);\" > jaar</td></tr>";
									echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind2Goed\" value=\"".$Kind2Goed."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind2Goed', this.value);\" ></td></tr>";
									echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind2Beter\" value=\"".$Kind2Beter."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind2Beter', this.value);\" ></td></tr></table></div></td></tr>";
									
									//kind3
									echo "<tr><td colspan=2>";
									echo "<div id=\"divKind3\">";
									
									echo "<table><tr><td><b>Kind 3</b></td></tr>";
									echo "<tr><td>Naam</td><td><input id=\"txtKind3Naam\" value=\"".$Kind3Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind3Naam', this.value);\"></td></tr>";
									echo "<tr><td>Voornaam</td><td><input id=\"txtKind3Voornaam\" value=\"".$Kind3Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind3Voornaam', this.value);\" ></td></tr>";
									echo "<tr><td>Leeftijd</td><td><input id=\"txtKind3Leeftijd\" value=\"".$Kind3Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind3Leeftijd', this.value);\" > jaar</td></tr>";
									echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind3Goed\" value=\"".$Kind3Goed."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind3Goed', this.value);\" ></td></tr>";
									echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind3Beter\" value=\"".$Kind3Beter."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind3Beter', this.value);\" ></td></tr></table></div></td></tr>";
									
									//kind4
									echo "<tr><td colspan=2>";
									echo "<div id=\"divKind4\">";
									
									echo "<table><tr><td><b>Kind 4</b></td></tr>";
									echo "<tr><td>Naam</td><td><input id=\"txtKind4Naam\" value=\"".$Kind4Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind4Naam', this.value);\"></td></tr>";
									echo "<tr><td>Voornaam</td><td><input id=\"txtKind4Voornaam\" value=\"".$Kind4Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind4Voornaam', this.value);\" ></td></tr>";
									echo "<tr><td>Leeftijd</td><td><input id=\"txtKind4Leeftijd\" value=\"".$Kind4Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind4Leeftijd', this.value);\" > jaar</td></tr>";
									echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind4Goed\" value=\"".$Kind4Goed."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind4Goed', this.value);\" ></td></tr>";
									echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind4Beter\" value=\"".$Kind4Beter."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind4Beter', this.value);\" ></td></tr></table></div></td></tr>";
									
									//kind5
									echo "<tr><td colspan=2>";
									echo "<div id=\"divKind5\">";
									
									echo "<table><tr><td><b>Kind 5</b></td></tr>";
									echo "<tr><td>Naam</td><td><input id=\"txtKind5Naam\" value=\"".$Kind5Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind5Naam', this.value);\"></td></tr>";
									echo "<tr><td>Voornaam</td><td><input id=\"txtKind5Voornaam\" value=\"".$Kind5Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind5Voornaam', this.value);\" ></td></tr>";
									echo "<tr><td>Leeftijd</td><td><input id=\"txtKind5Leeftijd\" value=\"".$Kind5Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind5Leeftijd', this.value);\" > jaar</td></tr>";
									echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind5Goed\" value=\"".$Kind5Goed."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind5Goed', this.value);\" ></td></tr>";
									echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind5Beter\" value=\"".$Kind5Beter."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind5Beter', this.value);\" ></td></tr></table></div></td></tr>";
									
									//kind6
									echo "<tr><td colspan=2>";
									echo "<div id=\"divKind6\">";
									
									echo "<table><tr><td><b>Kind 6</b></td></tr>";
									echo "<tr><td>Naam</td><td><input id=\"txtKind6Naam\" value=\"".$Kind6Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind6Naam', this.value);\"></td></tr>";
									echo "<tr><td>Voornaam</td><td><input id=\"txtKind6Voornaam\" value=\"".$Kind6Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind6Voornaam', this.value);\" ></td></tr>";
									echo "<tr><td>Leeftijd</td><td><input id=\"txtKind6Leeftijd\" value=\"".$Kind6Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind6Leeftijd', this.value);\" > jaar</td></tr>";
									echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind6Goed\" value=\"".$Kind6Goed."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind6Goed', this.value);\" ></td></tr>";
									echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind6Beter\" value=\"".$Kind6Beter."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind6Beter', this.value);\" ></td></tr></table></div></td></tr>";
									
									//prijs
									echo "<tr><td><b>Prijs</b></td></tr>";
									echo "<tr><td>Prijs</td><td><div id=\"divPrijs\"></div></td></tr>";
									//echo "<tr><td>Kortingscode</td><td><table><tr><td><input id=\"txtKortingCode\" value=\"".$KortingCode."\" size=\"10\" type=\"text\";\" onfocusout=\"controleer_korting(this.value);\"></td><td><div id=\"divKorting\"></div></td></tr></table></td></tr>";
									if ($VerklaringBetaling=="J")
									{
										echo "<tr><td></td><td><input type=\"checkbox\" name=\"chkBetalingOK\" id=\"chkBetalingOK\" checked> Ik verklaar dat ik het verschuldigde bedrag ga overschrijven.<br>De gegevens om te betalen, worden verzonden in de bevestigingsmail.</td></tr>";
									}
									else
									{
										echo "<tr><td></td><td><input type=\"checkbox\" name=\"chkBetalingOK\" id=\"chkBetalingOK\" > Ik verklaar dat ik het verschuldigde bedrag ga overschrijven.<br>De gegevens om te betalen, worden verzonden in de bevestigingsmail.</td></tr>";
									}
									
									echo "</table>";

									echo "<br><input type=\"button\" onclick=\"TijdstipReserveren()\" value=\"Tijdstip reserveren\">";
									
									echo "<div id=\"formmelding\">";
									echo "</div>";
									
								echo "<script>selecteerAantalKinderen($prijskind, $prijsvolw);</script>";
								?>
							</div>
						</div>
					</div>
				</div>
			</section>
		<!-- end section -->
		</div>

		<?php
			
			toon_voet();

			toon_copyright();
			mysqli_close($link);
		?>

		<script src="js/jquery-3.4.1.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/custom.js"></script>
	</body>
</html>
