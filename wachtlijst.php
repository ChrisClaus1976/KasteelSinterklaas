<?php
	include('includes/opmaak.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();

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

				xhttp.open("GET", "ajax/BewaarGegevensWachtlijst.php?veld=" + veld + "&waarde=" + waarde , true);
				xhttp.send();
			}
			
			
			function WachtlijstOpslaan()
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
				document.getElementById('selAantalKinderen').style.backgroundColor = '';
				document.getElementById('selAantalVolwassenen').style.backgroundColor = '';
				
				
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
				if(document.getElementById('selAantalKinderen').value == '')
				{
					document.getElementById('selAantalKinderen').style.backgroundColor = 'red';
					errors = true;
				}
				if(document.getElementById('selAantalVolwassenen').value == '')
				{
					document.getElementById('selAantalVolwassenen').style.backgroundColor = 'red';
					errors = true;
				}
				if(errors) //controleren of er errors (velden niet ingevuld) waren
				{
					//alert("verplicht");
					document.getElementById('formmelding').innerHTML = '<span style="color:red">Vul de verplichte velden in.</span>';
				}
				else
				{
					//controle of er een tijdslot geselecteerd is
					moment1=0;
					moment2=0;
					moment3=0;
					moment4=0;
					moment5=0;
					moment6=0;
					moment7=0;
					moment8=0;
					moment9=0;
					moment10=0;
					moment11=0;
					moment12=0;
					moment13=0;
					moment14=0;
					
					if (document.getElementById('moment1').checked)
					{
						moment1=1;
					}
					if (document.getElementById('moment2').checked)
					{
						moment2=1;
					}
					if (document.getElementById('moment3').checked)
					{
						moment3=1;
					}
					if (document.getElementById('moment4').checked)
					{
						moment4=1;
					}
					if (document.getElementById('moment5').checked)
					{
						moment5=1;
					}
					if (document.getElementById('moment6').checked)
					{
						moment6=1;
					}
					if (document.getElementById('moment7').checked)
					{
						moment7=1;
					}
					if (document.getElementById('moment8').checked)
					{
						moment8=1;
					}
					if (document.getElementById('moment9').checked)
					{
						moment9=1;
					}
					if (document.getElementById('moment10').checked)
					{
						moment10=1;
					}
					if (document.getElementById('moment11').checked)
					{
						moment11=1;
					}
					if (document.getElementById('moment12').checked)
					{
						moment12=1;
					}
					if (document.getElementById('moment13').checked)
					{
						moment13=1;
					}
					if (document.getElementById('moment14').checked)
					{
						moment14=1;
					}
					totaalmoment = moment1 + moment2 + moment3 + moment4 + moment5 + moment6 + moment7 + moment8 + moment9 + moment10 + moment11 + moment12 + moment13 + moment14 ;
					if (totaalmoment == 0)
					{
						//geen tijdslot geselecteerd
						document.getElementById('formmelding').innerHTML = '<span style="color:red">Selecteer minimaal 1 moment.</span>';
					}
					else
					{
					
						var xhttp = new XMLHttpRequest();
						document.getElementById("formmelding").innerHTML = 'De gegevens worden verwerkt ...';
						naam = encodeURIComponent(document.getElementById('txtNaam').value);
						voornaam = encodeURIComponent(document.getElementById('txtVoornaam').value);						
						telefoon = encodeURIComponent(document.getElementById('txtTelefoon').value);
						mail=document.getElementById('txtMail').value;
						mailadres = encodeURIComponent(document.getElementById('txtMail').value);
						adres = encodeURIComponent(document.getElementById('txtAdres').value);
						postcode = encodeURIComponent(document.getElementById('txtPostcode').value);
						gemeente = encodeURIComponent(document.getElementById('txtGemeente').value);
						aantalkinderen = document.getElementById('selAantalKinderen').value
						aantalvolwassenen = document.getElementById('selAantalVolwassenen').value
						
						xhttp.onreadystatechange = function() 
						{
							if (this.readyState == 4 && this.status == 200) 
							{
								if (xhttp.responseText=="1")
								{
									//alles OK
									alert("Je staat op de wachtlijst. Je ontvangt een mail op " + mail + ". Indien je geen mail ontvangen hebt, kijk eens bij de ongewenste/spam mails.");
									location.href = 'reserveer.php';
								}
								else
								{
									document.getElementById("formmelding").innerHTML = xhttp.responseText;
								}
							}
						};

						xhttp.open("GET", "ajax/BewaarWachtlijst.php?naam=" + naam + "&voornaam=" + voornaam + "&telefoon=" + telefoon + "&mailadres=" + mailadres + "&adres=" + adres + "&postcode=" + postcode + 
						"&gemeente=" + gemeente + "&aantalkinderen=" + aantalkinderen + "&aantalvolwassenen=" + aantalvolwassenen + "&moment1=" + moment1 + "&moment2=" + moment2 + "&moment3=" + moment3
						 + "&moment4=" + moment4 + "&moment5=" + moment5 + "&moment6=" + moment6 + "&moment7=" + moment7 + "&moment8=" + moment8 + "&moment9=" + moment9 + "&moment10=" + moment10
						  + "&moment11=" + moment11 + "&moment12=" + moment12 + "&moment13=" + moment13 + "&moment14=" + moment14, true);
						xhttp.send();
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
						<div class="col-md-8 px-0">
							<div class="detail-box">
								<?php
								
									echo "<div id=\"divreservatie\">";
									
									echo "<div class=\"heading_container \"><h2>Wachtlijst</h2></div>";
									echo "Gelieve onderstaande velden in te vullen om op de wachtlijst geplaatst te worden.<br>U ontvangt een bevestigingsmail na het invullen.<br><br>";
									echo "<table>";
									echo "<tr><td colspan=2><h5><b>Gegevens</b></h5></td></tr>";
									echo "<tr><td>Naam</td><td><input id=\"txtNaam\" value=\"\" size=\"40\" type=\"text\";\"></td></tr>";
									echo "<tr><td>Voornaam</td><td><input id=\"txtVoornaam\" value=\"\" size=\"40\" type=\"text\";\"></td></tr>";
									echo "<tr><td>Telefoon</td><td><input id=\"txtTelefoon\" value=\"\" size=\"40\" type=\"text\";\"></td></tr>";
									echo "<tr><td>Mailadres</td><td><input id=\"txtMail\" value=\"\" size=\"40\" type=\"text\";\"></td></tr>";
									echo "<tr><td>Adres</td><td><input id=\"txtAdres\" value=\"\" size=\"40\" type=\"text\";\"></td></tr>";
									echo "<tr><td>Gemeente</td><td><input id=\"txtPostcode\" value=\"\" size=\"10\" type=\"text\";\">
									<input id=\"txtGemeente\" value=\"\" size=\"23\" type=\"text\";\" ></td></tr>";
									
									echo "<tr><td>Aantal volwassenen</td><td>";
									echo "<select id=\"selAantalVolwassenen\" >";
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
									echo "</select>";
									
									echo "</td></tr>";
									
									echo "<tr><td>Aantal kinderen</td><td>";
									echo "<select id=\"selAantalKinderen\" >";
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
									echo "</select>";
									
									echo "</td></tr>";
									
									echo "</table><br>";
									
									echo "Ik kan op volgende momenten:<br>";
									
									$query  = "select * from TBL_WachtlijstMoment WHERE WachtlijstMomentInGebruik=1 ORDER BY WachtlijstOrder";
									$result = mysqli_query($link, $query);
									$aantal = mysqli_num_rows($result);
									if ($aantal>0)
									{
										while($row = mysqli_fetch_assoc($result))
										{
											$WachtlijstOrder=$row['WachtlijstOrder'];
											$WachtlijstMoment=$row['WachtlijstMoment'];
											$id = "moment".$WachtlijstOrder;
											if ($WachtlijstMoment != "")
											{
												echo "<input type=\"checkbox\" id=\"$id\" name=\"$id\" value=\"\">&nbsp&nbsp $WachtlijstMoment<br>";
											}
											else
											{
												echo "<input type=\"checkbox\" id=\"$id\" name=\"$id\" value=\"\" hidden>";
											}
										}
									}
								

									echo "<br><input type=\"button\" onclick=\"WachtlijstOpslaan()\" value=\"Op wachtlijst plaatsen\">";
									
									echo "<div id=\"formmelding\">";
									echo "</div>";
									
								?>
								<script>selecteerAantalKinderen();</script>
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
