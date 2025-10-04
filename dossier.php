<?php
	include('includes/opmaak.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();
	$_SESSION=array();
	if (isset($_GET['code']) && isset($_GET['naam']))
	{
		//als er geen reservatie in geheugen is dan terug naar startpagina.
		$code = $_GET['code'];
		$code=str_replace("\\","",$code);
		$naam = $_GET['naam'];
	}
	else
	{	
		echo "<script>location.href = 'index.php';</script>";
	}

	include('includes/db_conn.php');
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
			
			function selecteerAantalKinderen(AantalKinderen)
			{
				aantal = AantalKinderen;
				//alert(aantal);
				if (aantal == "")
				{
					document.getElementById('divPrijs').innerHTML = ' ';
					document.getElementById('divKind1').hidden  = true;
					document.getElementById('divKind2').hidden  = true;
					document.getElementById('divKind3').hidden  = true;
					document.getElementById('divKind4').hidden  = true;
					document.getElementById('divKind5').hidden  = true;
					document.getElementById('divKind6').hidden  = true;
					
				}
				else
				{
					if (aantal == 1)
					{
						//alert(aantal);
						document.getElementById('divKind1').hidden  = false;
						document.getElementById('divKind2').hidden  = true;
						document.getElementById('divKind3').hidden  = true;
						document.getElementById('divKind4').hidden  = true;
						document.getElementById('divKind5').hidden  = true;
						document.getElementById('divKind6').hidden  = true;

					}
					else
					{
						if (aantal == 2)
						{
							//alert(aantal);
							document.getElementById('divKind1').hidden  = false;
							document.getElementById('divKind2').hidden  = false;
							document.getElementById('divKind3').hidden  = true;
							document.getElementById('divKind4').hidden  = true;
							document.getElementById('divKind5').hidden  = true;
							document.getElementById('divKind6').hidden  = true;
						}
						else
						{
							if (aantal == 3)
							{
								//alert(aantal);
								document.getElementById('divKind1').hidden  = false;
								document.getElementById('divKind2').hidden  = false;
								document.getElementById('divKind3').hidden  = false;
								document.getElementById('divKind4').hidden  = true;
								document.getElementById('divKind5').hidden  = true;
								document.getElementById('divKind6').hidden  = true;
							}
							else
							{
								if (aantal == 4)
								{
									//alert(aantal);
									document.getElementById('divKind1').hidden  = false;
									document.getElementById('divKind2').hidden  = false;
									document.getElementById('divKind3').hidden  = false;
									document.getElementById('divKind4').hidden  = false;
									document.getElementById('divKind5').hidden  = true;
									document.getElementById('divKind6').hidden  = true;
								}
								else
								{
									if (aantal == 5)
									{
										//alert(aantal);
										document.getElementById('divKind1').hidden  = false;
										document.getElementById('divKind2').hidden  = false;
										document.getElementById('divKind3').hidden  = false;
										document.getElementById('divKind4').hidden  = false;
										document.getElementById('divKind5').hidden  = false;
										document.getElementById('divKind6').hidden  = true;
									}
									else
									{
										if (aantal == 6)
										{
											//alert(aantal);
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
				}
			}
			
			
			function Opslaan(AantalKinderen)
			{
				var errors = false;
				//alle achtergronden wit maken
				document.getElementById('formmelding').innerHTML = '';
				
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
					var xhttp = new XMLHttpRequest();
					document.getElementById("formmelding").innerHTML = 'De gegevens worden verwerkt ...';
					
					naamkind1 = encodeURIComponent(document.getElementById('txtKind1Naam').value);
					voornaamkind1 = encodeURIComponent(document.getElementById('txtKind1Voornaam').value);
										
					xhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							if (xhttp.responseText=="1")
							{
								//alles OK
								alert("De gegevens zijn verwerkt.");
								document.getElementById("formmelding").innerHTML = "";;
							}
							else
							{
								document.getElementById("formmelding").innerHTML = xhttp.responseText;
							}
						}
					};

					xhttp.open("GET", "ajax/BewaarDossier.php?naamkind1=" + naamkind1 + "&voornaamkind1=" + voornaamkind1 , true);
					xhttp.send();
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
						<div class="col-md-8 px-0">
							<div class="detail-box">
								<?php
								
									echo "<div id=\"divreservatie\">";
									
									$query  = "select * from TBL_Reservatie WHERE Naam='".$naam."' AND UniekeCode='$code'";
									$result = mysqli_query($link, $query);
									$aantalreservatie = mysqli_num_rows($result);
									if ($aantalreservatie>0)
									{
										while($row = mysqli_fetch_assoc($result))
										{
											$ReservatieId=$row['ReservatieId'];
											$_SESSION['reservatie']['reservatieid']=$ReservatieId;
											$tijdstip=$row['Tijdstip'];
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
									else
									{
										echo "<script>location.href = 'index.php';</script>";
									}
									
									$query  = "select * from TBL_data WHERE DataId='$tijdstip'";
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

									echo "<div class=\"heading_container \"><h2>Gegevens reservatie</h2><h5><b>$Datum - $Tijdstip</b></h5></div>";
									echo "Wij registreerden volgende gegevens.<br><br>";
									echo "<table>";
									echo "<tr><td colspan=2><h5><b>Gegevens ouder(s)</b></h5></td></tr>";
									echo "<tr><td>Naam</td><td>$Naam</td></tr>";
									echo "<tr><td>Voornaam</td><td>$Voornaam</td></tr>";
									echo "<tr><td>Telefoon</td><td>$Telefoon</td></tr>";
									echo "<tr><td>Mailadres</td><td>$Mailadres</td></tr>";
									echo "<tr><td>Adres</td><td>$Adres</td></tr>";
									echo "<tr><td>Gemeente</td><td>$Postcode $Gemeente</td></tr>";
									echo "<tr><td>Aantal volwassenen</td><td>$AantalVolwassenen</td></tr>";
									echo "<tr><td colspan=2><h5><b>Gegevens kinderen</b></h5></td></tr>";
									echo "<tr><td>Aantal kinderen</td><td>$AantalKinderen</td></tr>";
									
									//if ($AantalKinderen>=1)
									{
										//kind1
										echo "<tr><td colspan=2>";
										echo "<div id=\"divKind1\">";
										
										echo "<table><tr><td><b>Kind 1</b></td></tr>";
										echo "<tr><td>Naam</td><td><input id=\"txtKind1Naam\" value=\"".$Kind1Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind1Naam', this.value);\"></td></tr>";
										echo "<tr><td>Voornaam</td><td><input id=\"txtKind1Voornaam\" value=\"".$Kind1Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind1Voornaam', this.value);\" ></td></tr>";
										echo "<tr><td>Leeftijd</td><td><input id=\"txtKind1Leeftijd\" value=\"".$Kind1Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind1Leeftijd', this.value);\" >  jaar</td></tr>";
										echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind1Goed\" value=\"".$Kind1Goed."\" size=\"40\" type=\"textarea\";\" onfocusout=\"sla_waarde_op('Kind1Goed', this.value);\" ></td></tr>";
										echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind1Beter\" value=\"".$Kind1Beter."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind1Beter', this.value);\" ></td></tr></table></div></td></tr>";
									}
									
									//if ($AantalKinderen>=2)
									{
										//kind2
										echo "<tr><td colspan=2>";
										echo "<div id=\"divKind2\">";
										
										echo "<table><tr><td><b>Kind 2</b></td></tr>";
										echo "<tr><td>Naam</td><td><input id=\"txtKind2Naam\" value=\"".$Kind2Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind2Naam', this.value);\"></td></tr>";
										echo "<tr><td>Voornaam</td><td><input id=\"txtKind2Voornaam\" value=\"".$Kind2Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind2Voornaam', this.value);\" ></td></tr>";
										echo "<tr><td>Leeftijd</td><td><input id=\"txtKind2Leeftijd\" value=\"".$Kind2Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind2Leeftijd', this.value);\" > jaar</td></tr>";
										echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind2Goed\" value=\"".$Kind2Goed."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind2Goed', this.value);\" ></td></tr>";
										echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind2Beter\" value=\"".$Kind2Beter."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind2Beter', this.value);\" ></td></tr></table></div></td></tr>";
									}
									
									//if ($AantalKinderen>=3)
									{
										//kind3
										echo "<tr><td colspan=2>";
										echo "<div id=\"divKind3\">";
										
										echo "<table><tr><td><b>Kind 3</b></td></tr>";
										echo "<tr><td>Naam</td><td><input id=\"txtKind3Naam\" value=\"".$Kind3Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind3Naam', this.value);\"></td></tr>";
										echo "<tr><td>Voornaam</td><td><input id=\"txtKind3Voornaam\" value=\"".$Kind3Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind3Voornaam', this.value);\" ></td></tr>";
										echo "<tr><td>Leeftijd</td><td><input id=\"txtKind3Leeftijd\" value=\"".$Kind3Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind3Leeftijd', this.value);\" > jaar</td></tr>";
										echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind3Goed\" value=\"".$Kind3Goed."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind3Goed', this.value);\" ></td></tr>";
										echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind3Beter\" value=\"".$Kind3Beter."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind3Beter', this.value);\" ></td></tr></table></div></td></tr>";
									}
									
									//if ($AantalKinderen>=4)
									{
										//kind4
										echo "<tr><td colspan=2>";
										echo "<div id=\"divKind4\">";
										
										echo "<table><tr><td><b>Kind 4</b></td></tr>";
										echo "<tr><td>Naam</td><td><input id=\"txtKind4Naam\" value=\"".$Kind4Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind4Naam', this.value);\"></td></tr>";
										echo "<tr><td>Voornaam</td><td><input id=\"txtKind4Voornaam\" value=\"".$Kind4Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind4Voornaam', this.value);\" ></td></tr>";
										echo "<tr><td>Leeftijd</td><td><input id=\"txtKind4Leeftijd\" value=\"".$Kind4Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind4Leeftijd', this.value);\" > jaar</td></tr>";
										echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind4Goed\" value=\"".$Kind4Goed."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind4Goed', this.value);\" ></td></tr>";
										echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind4Beter\" value=\"".$Kind4Beter."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind4Beter', this.value);\" ></td></tr></table></div></td></tr>";
									}
									
									//if ($AantalKinderen>=5)
									{
										//kind5
										echo "<tr><td colspan=2>";
										echo "<div id=\"divKind5\">";
										
										echo "<table><tr><td><b>Kind 5</b></td></tr>";
										echo "<tr><td>Naam</td><td><input id=\"txtKind5Naam\" value=\"".$Kind5Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind5Naam', this.value);\"></td></tr>";
										echo "<tr><td>Voornaam</td><td><input id=\"txtKind5Voornaam\" value=\"".$Kind5Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind5Voornaam', this.value);\" ></td></tr>";
										echo "<tr><td>Leeftijd</td><td><input id=\"txtKind5Leeftijd\" value=\"".$Kind5Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind5Leeftijd', this.value);\" > jaar</td></tr>";
										echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind5Goed\" value=\"".$Kind5Goed."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind5Goed', this.value);\" ></td></tr>";
										echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind5Beter\" value=\"".$Kind5Beter."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind5Beter', this.value);\" ></td></tr></table></div></td></tr>";
									}
									
									//if ($AantalKinderen>=6)
									{
										//kind5
										echo "<tr><td colspan=2>";
										echo "<div id=\"divKind6\">";
										
										echo "<table><tr><td><b>Kind 6</b></td></tr>";
										echo "<tr><td>Naam</td><td><input id=\"txtKind6Naam\" value=\"".$Kind6Naam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind6Naam', this.value);\"></td></tr>";
										echo "<tr><td>Voornaam</td><td><input id=\"txtKind6Voornaam\" value=\"".$Kind6Voornaam."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind6Voornaam', this.value);\" ></td></tr>";
										echo "<tr><td>Leeftijd</td><td><input id=\"txtKind6Leeftijd\" value=\"".$Kind6Leeftijd."\" size=\"2\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind6Leeftijd', this.value);\" > jaar</td></tr>";
										echo "<tr><td>Goede eigenschappen</td><td><input id=\"txtKind56oed\" value=\"".$Kind6Goed."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind6Goed', this.value);\" ></td></tr>";
										echo "<tr><td>Dingen die beter kunnen</td><td><input id=\"txtKind6Beter\" value=\"".$Kind6Beter."\" size=\"40\" type=\"text\";\" onfocusout=\"sla_waarde_op('Kind6Beter', this.value);\" ></td></tr></table></div></td></tr>";
									}
									
									echo "</table><br>";
									
									echo "We zien jullie graag terug op <b>$Datum</b> om <b>$Tijdstip</b>. Gelieve minstens 10 minuten op voorhand aanwezig te zijn.<br><br>Parkeren kan op het Phil Bosmansplein, volg de vlaggen tot aan het kasteel (+/- 5 minuten wandelen).<br><br>Kan je door omstandigheden niet aanwezig zijn. Gelieve ons dan zo snel mogelijk te contacteren, dan kunnen we het tijdslot terug openstellen voor een ander gezin.<br><br>
									Voor en na het bezoek ben je altijd welkom aan onze Sint-bar in de verwarmde tent op de binnenkoer van het Kasteel!";

									echo "<br><input type=\"button\" onclick=\"Opslaan($AantalKinderen)\" value=\"Gegevens opslaan\">";
									
									
									echo "<div id=\"formmelding\">";
									echo "</div>";
									echo "<div id=\"formmelding\"></div>";
									echo "<script>selecteerAantalKinderen($AantalKinderen);</script>";
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
