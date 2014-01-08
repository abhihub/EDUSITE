<?php
//require 'common.php';
require 'ProceduresToJson.php';
$widgetJobs = new ProcedureToJson();
$widgetJobs->init();
if(empty($_SESSION['user'])) 
{ 
	header("Location: index.php"); 
	die("Redirecting to index.php"); 
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name = "format-detection" content = "telephone=no" />
	<title>FillSkills</title>

	<link media="all" rel="stylesheet" href="css/jackedup.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script src="js/jquery-1.8.3.min.js"><\/script>')</script>
	<script type="text/javascript" src="js/humane.min.js"></script>
	<script type="text/javascript" src="js/jquery.a-tools-1.4.1.js"></script>
	<script type="text/javascript" src="js/jquery.asuggest.js"></script>
	<script type="text/javascript" src="js/dropzone.min.js"></script>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<link media="all" rel="stylesheet" href="css/all.css">
	<link media="all" rel="stylesheet" href="css/dz-basic.css">
	<link media="all" rel="stylesheet" href="css/dropzone.css">

	<!-- <script>(function(){var uv=document.createElement('script');uv.type='text/javascript';uv.async=true;uv.src='//widget.uservoice.com/nyMJniTehAhgN1jvDkD44g.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(uv,s)})()</script>
	<script>
	UserVoice = window.UserVoice || [];
	UserVoice.push(['showTab', 'classic_widget', {
		mode: 'feedback',
		primary_color: '#cc6d00',
		link_color: '#007dbf',
		forum_id: 226405,
		tab_label: 'Feedback',
		tab_color: '#cc6d00',
		tab_position: 'middle-right',
		tab_inverted: false
	}]);
	</script> -->
	<!-- <script type="text/javascript" src="js/jquery.main.js"></script> -->
	<!--[if IE]><script type="text/javascript" src="js/ie.js"></script><![endif]-->
	<!-- <script type="text/javascript">
	var heap=heap||[];heap.load=function(a){window._heapid=a;var b=document.createElement("script");b.type="text/javascript",b.async=!0,b.src=("https:"===document.location.protocol?"https:":"http:")+"//cdn.heapanalytics.com/js/heap.js";var c=document.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c);var d=function(a){return function(){heap.push([a].concat(Array.prototype.slice.call(arguments,0)))}},e=["identify","track"];for(var f=0;f<e.length;f++)heap[e[f]]=d(e[f])};
	heap.load("812388706");
</script> -->
<script type="text/javascript">


</script>
</head>
<body>
	
	<div id="wrapper">
		<header id="header">
			<div class="holder">
				<div class="frame">
					<strong class="logo"><a href="#">FillSkills: Helping you land your dream job</a></strong>
					<nav id="nav">
						<a class="home active" href="#">1.Enter skills</a>
						<!-- <a class="results" href="#">Results</a>
						<a class="courses" href="#">Courses</a>
						<a class="skills" href="#">Skills</a>
						<a class="contact" href="#">Contact</a> -->
						<a class="logout" href="logout.php">Logout</a>
					</nav>
				</div>
			</div>
		</header>
		<div id="main">
			<div class="upload-block">
				<p></p>
				<div class="block">
					<h1>Drop your resume here</h1>
					<form class="drag-box dropzone" id="uiDZResume" action="ParseAndSaveResume.php">
						<div class="dropzone-previews"></div>
						<!-- <img src="images/img01.gif" width="527" height="243" alt="image description" /> -->
					</form>
				</div>
				<div class="block">
					<h1>Add your skills here</h1>
					<div class="drag-box">
						<textarea id="txtskill" placeholder="and/or enter your skills here" style="margin: 2px; min-height: 235px; min-width: 517px; resize: none;"></textarea>
					</div>
				</div>
				
				<?php
				$resultsallmissingskills = $widgetJobs->get_all_skillnames();
				echo '<script type="text/javascript">',
				'var suggests =' . $resultsallmissingskills . ';',
				'</script>';
				?>
			</div>
			<section class="section gray greenbg">
				<article class="holder">
					<div class="text-holder">
						<a href="#" id="btnupload" class="btn">SET GOAL ></a>
					</div>
				</article>
			</section>
			<!-- <section class="section blue">
				<div class="holder">
					<div class="frame">
						<h1>How FillSkills <strong>Works</strong></h1>
						<div class="item">
							<div class="ico-box"><a href="#"><img src="images/ico01.gif" width="230" height="230" alt="image description"></a></div>
							<h2><a href="#">Acquired Skills</a></h2>
							<p>Learn more about your current skills. Check out the current trends on your skills. Find out how you can improve on them.    </p>
						</div>
						<div class="item">
							<div class="ico-box"><a href="#"><img src="images/ico02.gif" width="230" height="230" alt="image description"></a></div>
							<h2><a href="#">Missing Skills</a></h2>
							<p>Compare your current resume against the job market to find out which new skill to learn and where to learn it.    </p>
						</div>
						<div class="item">
							<div class="ico-box"><a href="#"><img src="images/ico03.gif" width="230" height="230" alt="image description"></a></div>
							<h2><a href="#">Available Courses</a></h2>
							<p>What are the best courses for the skill you want to learn?"</p>
						</div>
						<div class="item">
							<div class="ico-box"><a href="#"><img src="images/ico04.gif" width="230" height="230" alt="image description"></a></div>
							<h2><a href="#">Available Jobs</a></h2>
							<p>Check out the best jobs in the market for your resume.</p>
						</div>
					</div>
				</div>
			</section> -->
			<section class="section gray">
				<article class="holder">
					<img src="images/img03.png" width="478" height="271" alt="image description">
					<div class="text-holder">
						<h1>About Us</h1>
						<p class="intro">Find which skills are in demand in the market <br>and then quickly take the best courses that help you catch up. </p>
						<p>As the American economy tumbled in 2008, we saw a disconnect between growing numbers of unemployed and a large pool of jobs available. The missing link was skills required to apply for these jobs. Our concerns led us to create FillSkills - a bridge leading people to their dream jobs. </p>
						<a href="#" class="btn">Click here to find out more about us</a>
					</div>
				</article>
			</section>
			<section class="section contact">
				<div class="holder">
					<div class="address-box">
						<address>
							<span>1134 Somewhere Street<br />Chino Hills, CA 91709</span>
							<span>
								Phone: 999-999-9999
							</span>
						</address>
						<ul class="sociable">
							<li><a class="twitter" href="#"></a></li>
							<li><a class="facebook" href="#"></a></li>
							<li><a class="google-plus" href="#"></a></li>
						</ul>
					</div>
					<form action="#" class="contact-form">
						<fieldset>
							<div class="textarea-holder">
								<textarea cols="30" rows="10" placeholder="Message"></textarea>
							</div>
							<div class="text-row">
								<input type="text" placeholder="Name" />
							</div>
							<div class="text-row">
								<input type="email" placeholder="E-mail" />
							</div>
							<div class="btn-row">
								<input type="submit" value="Send Message" />
							</div>
						</fieldset>
					</form>
				</div>
			</section>
		</div>
		<footer id="footer">
			<div class="holder">
				<p class="copy">&copy; Copyright 2013 Fillskills</p>
				<form action="#" class="subscribe-form">
					<fieldset>
						<label for="subscribe-field">Get our FillSkills Newslvetter</label>
						<div class="input-row">
							<input id="subscribe-field" type="text" placeholder="Your E-mail Address" />
						</div>
					</fieldset>
				</form>
				<ul class="footer-menu">
					<li><a href="#">BLOG</a></li>
					<li><a href="#">TERMS</a></li>
					<li><a href="#">privacY</a></li>
				</ul>
			</div>
			
		</footer>
	</div>

	<script type="text/javascript">
	$( document ).ready(function() {
		//humane.log("Hey there, welcome. <br> Start by entering your skills.<br", {timeout:1500});

		
		$("#txtskill").asuggest(suggests, {
			'endingSymbols': ', '
		});
	});


	$('#btnupload').click(function () {
		//alert(uiDZResume.getAcceptedFiles().count);
		//console.log($('#txtskill').val());
		$.ajax({ url: 'ParseAndSaveSkills.php',
         // data: {action: 'get_missingskills_job'},
         data: { skillstring: $('#txtskill').val() },
         type: 'POST',
         success: function(output) {
                      //SWITCH TO OTHER PAGE
                      //alert(output);
                      window.location.replace("target.php");
                      //$('#naslov b').html(output);
                  }
              });
	});

	$(function() {
		Dropzone.options.uiDZResume = {
			autoProcessQueue: true,
			uploadMultiple: true,
			parallelUploads: 100,
			maxFiles: 1,
			acceptedFiles: ".pdf,.doc,.docx"
			, init: function() {
				this.on("addedfile", function(file) { 
					//alert("Added file."); 
				});
			},
			success: function(file, response){
				//alert(response);
			}
		};
	});
	</script>
</body>
</html>