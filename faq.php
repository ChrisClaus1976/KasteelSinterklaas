<?php
	include('includes/opmaak.php');
	date_default_timezone_set('Europe/Brussels');
	session_name("SinterklaasLG");
	session_start();
	if (isset($_SESSION['reservatie']['reservatieid'])  && isset($_SESSION['reservatie']['dataid']))
	{
		$http=$_SERVER['REQUEST_SCHEME'];  // http of https
		$server=$_SERVER['SERVER_NAME'];
		$bestand=$_SERVER['PHP_SELF'];
		$currentPage = $http.'://'.$server.$bestand;
		cancelreservatie($currentPage);
	}
	//$_SESSION=array();
	include('includes/db_conn.php');
	?>
	<html>
	<head>
		 <?php
		 opmaak_pagina();
		 ?>
		  <script type="text/javascript">	
			
		</script>
	</head>
	<body>
	<div class="hero_area">

		<?php
			toon_header("faq");
		?>
		<!--</div>-->

		<!-- contact section -->

		<section class="about_section layout_padding">
			<div class="container">
				<div class="row">
					<div class="col-md-8 px-0">
						<div class="detail-box">
							<div class="heading_container ">
								<h2>FAQ</h2>
								
							</div>
							
							<?php
							$query  = "select Distinct FaqDeel from TBL_Faq WHERE FaqZichtbaar=1";
							$result = mysqli_query($link, $query);
							$aantal = mysqli_num_rows($result);
							if ($aantal>0)
							{								
								while($row = mysqli_fetch_assoc($result))
								{
									$FaqDeel=$row['FaqDeel'];
									echo "<div class=\"heading_container \"><h3>$FaqDeel</h3></div>";
									$query1  = "select * from TBL_Faq WHERE FaqDeel='$FaqDeel' AND FaqZichtbaar=1 ORDER BY FaqVolgorde";
									$result1 = mysqli_query($link, $query1);
									$aantal1 = mysqli_num_rows($result1);
									if ($aantal1>0)
									{	
										while($row1 = mysqli_fetch_assoc($result1))
										{
											$FaqVraag=$row1['FaqVraag'];
											$FaqAntwoord=$row1['FaqAntwoord'];
											echo "<button type=\"button\" class=\"collapsible\">$FaqVraag</button><div class=\"collapsiblecontent\"><p>$FaqAntwoord</p></div>";
										}
									}
								}
							}
							
							?>
							
							<script>
								var coll = document.getElementsByClassName("collapsible");
								var i;

								for (i = 0; i < coll.length; i++) 
								{
									coll[i].addEventListener("click", function() 
									{
										this.classList.toggle("active");
										var collapsiblecontent = this.nextElementSibling;
										if (collapsiblecontent.style.display === "block") 
										{
											collapsiblecontent.style.display = "none";
										}
										else 
										{
											collapsiblecontent.style.display = "block";
										}
									}
									);
								}
							</script>
						</div>
					</div>
				</div>
			</div>
		</section>

	<!-- end contact section -->

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