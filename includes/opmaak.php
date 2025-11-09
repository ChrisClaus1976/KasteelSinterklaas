<?php

	function toon_header($pagina)
	{
		echo "<div class=\"hero_bg_box\">";
			echo "<div class=\"img-box\">";
				echo "<img src=\"images/kasteel.jpg\" alt=\"\">";
				echo "</div>";
			echo "</div>";
		
		echo "<header class=\"header_section\">";
				/*echo "<div class=\"header_top\">";
					echo "<div class=\"container-fluid\">";
						echo "<div class=\"contact_link-container\">";
							echo "<a href=\"\" class=\"contact_link1\">";
								echo "<i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i>";
								echo "<span>";
									echo "Het kasteel van Sinterklaas";
								echo "</span>";
							echo "</a>";
							echo "<a href=\"\" class=\"contact_link3\">";
								echo "<i class=\"fa fa-envelope\" aria-hidden=\"true\"></i>";
								echo "<span>";
									echo "sinterklaas@landelijkegildegruitrode.be";
								echo "</span>";
							echo "</a>";
						echo "</div>";
					echo "</div>";
				echo "</div>";*/

				echo "<div class=\"header_bottom\">";
					echo "<div class=\"container-fluid\">";
						echo "<nav class=\"navbar navbar-expand-lg custom_nav-container\">";
							echo "<a class=\"navbar-brand\" href=\"index.php\">";
								echo "<span>";
									echo "Het kasteel van Sinterklaas Gruitrode";
								echo "</span>";
							echo "</a>";
							echo "<button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">";
							echo "<span class=\"\"></span>";
							echo "</button>";

							echo "<div class=\"collapse navbar-collapse ml-auto\" id=\"navbarSupportedContent\">";
								echo "<ul class=\"navbar-nav  \">";

									if ($pagina=='home')
									{
										echo "<li class=\"nav-item active\">";
									}
									else
									{
										echo "<li class=\"nav-item\">";
									}
									
									echo "<a class=\"nav-link\" href=\"index.php\">Home <span class=\"sr-only\">(current)</span></a>";
									echo "</li>";
									if ($pagina=='reservatie')
									{
										echo "<li class=\"nav-item active\">";
									}
									else
									{
										echo "<li class=\"nav-item\">";
									}
									echo "<a class=\"nav-link\" href=\"reserveer.php\">privé rondleiding</a>";
									echo "</li>";
									
									if ($pagina=='winterbar')
									{
										echo "<li class=\"nav-item active\">";
									}
									else
									{
										echo "<li class=\"nav-item\">";
									}
									echo "<a class=\"nav-link\" href=\"winterbar.php\">Sinterklaasbar</a>";
									echo "</li>";
									
									if ($pagina=='quiz')
									{
										echo "<li class=\"nav-item active\">";
									}
									else
									{
										echo "<li class=\"nav-item\">";
									}
									echo "<a class=\"nav-link\" href=\"quiz.php\">Sinterklaas-quiz</a>";
									echo "</li>";
									
									if ($pagina=='wandeling')
									{
										echo "<li class=\"nav-item active\">";
									}
									else
									{
										echo "<li class=\"nav-item\">";
									}
									echo "<a class=\"nav-link\" href=\"wandeling.php\">Sinterklaaswandeling</a>";
									echo "</li>";
									
									if ($pagina=='kalender')
									{
										echo "<li class=\"nav-item active\">";
									}
									else
									{
										echo "<li class=\"nav-item\">";
									}
									echo "<a class=\"nav-link\" href=\"kalender.php\">Kalender</a>";
									echo "</li>";
									
									
									if ($pagina=='faq')
									{
										echo "<li class=\"nav-item active\">";
									}
									else
									{
										echo "<li class=\"nav-item\">";
									}
									echo "<a class=\"nav-link\" href=\"faq.php\">FAQ</a>";
									echo "</li>";
									
									if ($pagina=='contacteerons')
									{
										echo "<li class=\"nav-item active\">";
									}
									else
									{
										echo "<li class=\"nav-item\">";
									}
									echo "<a class=\"nav-link\" href=\"contact.php\">Contacteer ons</a>";
									echo "</li>";
									
								echo "</ul>";
							echo "</div>";
						echo "</nav>";
					echo "</div>";
				echo "</div>";
			echo "</header>";
			// end header section
	}

	function toon_voet()
	{
		echo "<section class=\"info_section\">";
			echo "<div class=\"container\">";
				echo "<div class=\"row\">";
					echo "<div class=\"col-md-4\">";
						echo "<div class=\"info_info\">";
							echo "<h5>";
							  echo "Het kasteel van Sinterklaas";
							echo "</h5>";
						echo "</div>";
						echo "<div class=\"info_contact\">";
							echo "<div class=\"info_text\">";
								echo "Een organisatie van Landelijke Gilde Gruitrode en Sinterklaaswerking in samenwerking met";
							echo "</div>";
							echo "<div class=\"info_text\">";
								//echo "<img src=\"images/lgg.jpg\" alt=\"\" height=75px />";
								//echo " <img src=\"images/Tejater de Kwibus.jpeg\" alt=\"\" height=75px />";
								echo " <img src=\"images/Bos en Heikabouters.jpeg\" alt=\"\" height=75px />";
								echo " <img src=\"images/Dorser.jpg\" alt=\"\" height=75px />";
							//echo "</div>";
							//echo "<div class=\"info_text\">";
								echo " <img src=\"images/Oudsbergen.png\" alt=\"\" height=75px />";
							echo "</div>";
						echo "</div>";
					echo "</div>";
					echo "<div class=\"col-md-4\">";
						echo "<div class=\"info_info\">";
							echo "<h5>";
								echo "Contacteer Ons";
							echo "</h5>";
						echo "</div>";
						echo "<div class=\"info_contact\">";	
							echo "<div class=\"info_text\">";
								echo "Landelijke Gilde Gruitrode";
							echo "</div>";
							echo "<div class=\"info_text\">";
								echo "landelijkegildegruitrode@gmail.com";
							echo "</div>";
							echo "<div class=\"info_text\">";
								echo "<img src=\"images/lgg.jpg\" alt=\"\" height=75px />";
							echo "</div>";
						echo "</div>";
					echo "</div>";
					echo "<div class=\"col-md-3\">";
						echo "<div class=\"info_info\">";
							echo "<h5>";
								echo "Sponsors";
							echo "</h5>";
						echo "</div>";
						echo "<div class=\"info_contact\">";	
							
							echo "<div class=\"info_text\">";
								echo "<img src=\"sponsor/jodasign.jpg\" alt=\"\" height=75px />";
							echo "</div>";
							echo "<div class=\"info_text\">";
								echo "<img src=\"sponsor/kerkhofs.png\" alt=\"\" height=75px />";
							echo "</div>";
							echo "<div class=\"info_text\">";
								echo "<img src=\"sponsor/HendrikxStallenbouw.png\" alt=\"\" height=75px />";
							echo "</div>";
							echo "<div class=\"info_text\">";
								echo "<img src=\"sponsor/selfiestation.png\" alt=\"\" height=75px />";
							echo "</div>";
							echo "<div class=\"info_text\">";
								echo "<img src=\"sponsor/vanreusel.png\" alt=\"\" height=75px />";
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</section>";
	}
	
	function toon_copyright()
	{
		echo "<footer class=\"container-fluid footer_section\">";
		echo "<p>";
			echo "&copy; <span id=\"currentYear\"></span> All Rights Reserved. Landelijke Gilde Gruitrode";
		echo "</p>";
		echo "</footer>";
	}
	
	
	function opmaak_pagina()
	{
		?>
		<!-- Basic -->
		  <meta charset="utf-8" />
		  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
		  <!-- Mobile Metas -->
		  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		  <!-- Site Metas -->
		  <meta name="keywords" content="" />
		  <meta name="description" content="" />
		  <meta name="author" content="" />
		  <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">

		  <title>Het kasteel van Sinterklaas Gruitrode</title>

		  <!-- bootstrap core css -->
		  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

		  <!-- fonts style -->
		  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,600,700&display=swap" rel="stylesheet" />

		  <!-- Custom styles for this template -->
		  <link href="css/style.css" rel="stylesheet" />
		  <!-- responsive style -->
		  <link href="css/responsive.css" rel="stylesheet" />
		  <?php
		
	}
	
	function cancelreservatie($currentPage)
	{
		echo "<script>antw=confirm('De reservering is nog niet voltooid. Wilt u deze afbreken, zoja dan wordt dit tijdstip terug vrijgegeven?');
		if(antw)
		{
			location.href = 'ajax/cancelreservatie.php?bron=".$currentPage."';
		}
		else
		{
			location.href = 'reservatie.php';
		}</script>";
	}
?>
