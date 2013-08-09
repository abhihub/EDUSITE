<?php
require 'ProceduresToJson.php';
$widgetJobs = new ProcedureToJson();
$widgetJobs->init();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name = "format-detection" content = "telephone=no" />
	<title>FillSkills</title>
	<link media="all" rel="stylesheet" href="css/all.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script src="js/jquery-1.8.3.min.js"><\/script>')</script>
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<!--[if IE]><script type="text/javascript" src="js/ie.js"></script><![endif]-->
</head>
<body>
	<div id="wrapper">
		<header id="header">
			<div class="holder">
				<div class="frame">
					<strong class="logo"><a href="#">FillSkills Helping you for the perfect job</a></strong>
					<nav id="nav">
						<a class="home active" href="#">Home</a>
						<a class="results" href="#">Results</a>
						<a class="courses" href="#">Courses</a>
						<a class="skills" href="#">Skills</a>
						<a class="contact" href="#">Contact</a>
					</nav>
				</div>
			</div>
		</header>
		<div id="main">
			<!-- <form action="#" class="search-form">
				<fieldset>
					<div class="input-box">
						<input type="text" placeholder="Add a skill" />
					</div>
					<div class="input-box">
						<input type="text" placeholder="Search a course" />
					</div>
					<div class="input-box">
						<input type="text" placeholder="Search a job" />
					</div>
					<div class="input-box">
						<input type="text" placeholder="Search a State" />
					</div>
					<div class="input-box">
						<input type="text" placeholder="Search a City" />
					</div>
					<div class="input-box">
						<input type="text" placeholder="Search" />
					</div>
				</fieldset>
			</form> -->
			<section class="info-columns columns-holder">
				<article class="col personal">
					<header class="title">
						<h1>Personal Skills</h1>
					</header>
					<div class="box column">
						<div class="btn-holder">
							<div class="holder">
								<?php
								$resultsusersskills = $widgetJobs->get_users_skills('1');
								foreach($resultsusersskills as $result)
								{
									echo '<a href="#" class="button">' . $result[skillname] . '</a>';
								}
								?>
							<!-- <a href="#" class="button">jQuery</a>
							<a href="#" class="button">MVC</a>
							<a href="#" class="button">PHPUnit</a>
							<a href="#" class="button">jUnit</a>
							<a href="#" class="button">QUnit</a>
							<a href="#" class="button">PHP</a>
							<a href="#" class="button">Java</a>
							<a href="#" class="button">Rubi</a>
							<a href="#" class="button">Python</a>
							<a href="#" class="button">.NET</a>
							<a href="#" class="button">HTML/CSS</a>
							<a href="#" class="button">JAXB</a>
							<a href="#" class="button">JDOM</a> -->
						</div>
					</div>
					<div class="text-holder">
						<p>Strong understanding of object oriented JavaScript Designed and documented front-end projects of various scope. Developed and maintained the presentation layer of company's site. Participated in code reviews of other developers' work. Provided technical assistance to engineers, designers, managers. </p>
						<p>Coordinated with 3rd parties on technical designs and issues. Presented technical issues and their business impact to management. Coordinated projects, and communicated technical issues using non-technical language.  </p>
					</div>
				</div>
			</article>
			<article class="col missing">
				<header class="title">
					<h1>Missing Skills</h1>
				</header>
				<div class="box column">
					<div class="btn-holder">
						<div class="holder">
							<?php
							$resultsallmissingskills = $widgetJobs->get_top_missing_skills('1');
							foreach($resultsallmissingskills as $result)
							{
								echo '<a href="#" class="button">' . $result[skillname] . '</a>';
							}
							?>
							<!-- <a href="#" class="button">IOS</a>
							<a href="#" class="button">RUBI</a>
							<a href="#" class="button">Dojo</a>
							<a href="#" class="button">Yahoo</a>
							<a href="#" class="button">Prototype</a>
							<a href="#" class="button">Adobe</a>
							<a href="#" class="button">Mootool</a>
							<a href="#" class="button">TableKit</a> -->
						</div>
					</div>
					<div class="courses-block">
						<h2>Available Courses</h2>
						<ul class="list columns-holder">
							<li>
								<div class="holder column">
									<h3>TableKit Class</h3>
									<p>The civil Emperor, before the Mikado, the spiritual Emperor, absorbed his office in his own.  The Carnatic anchored att the quay near the custom-house, in the midst of a crowd of ships</p>
									<div class="btn-row">
										<a href="#" class="details">Details</a>
										<a href="#" class="delete">Delete</a>
									</div>
								</div>
							</li>
							<li>
								<div class="holder column">
									<h3>RUBI Class</h3>
									<p>The civil Emperor, before the Mikado, the spiritual Emperor, absorbed his office in his own.  The Carnatic anchored att the quay near the custom-house, in the midst of a crowd of ships</p>
									<div class="btn-row">
										<a href="#" class="details">Details</a>
										<a href="#" class="delete">Delete</a>
									</div>
								</div>
							</li>
							<li>
								<div class="holder column">
									<h3>Mastering IOS</h3>
									<p>The civil Emperor, before the Mikado, the spiritual Emperor, absorbed his office in his own.  The Carnatic anchored att the quay near the custom-house, in the midst of a crowd of ships</p>
									<div class="btn-row">
										<a href="#" class="details">Details</a>
										<a href="#" class="delete">Delete</a>
									</div>
								</div>
							</li>
							<li>
								<div class="holder column">
									<h3>Adobe Suite</h3>
									<p>The civil Emperor, before the Mikado, the spiritual Emperor, absorbed his office in his own.  The Carnatic anchored att the quay near the custom-house, in the midst of a crowd of ships</p>
									<div class="btn-row">
										<a href="#" class="details">Details</a>
										<a href="#" class="delete">Delete</a>
									</div>
								</div>
							</li>
							<li>
								<div class="holder column">
									<h3>Mootool Class</h3>
									<p>The civil Emperor, before the Mikado, the spiritual Emperor, absorbed his office in his own.  The Carnatic anchored att the quay near the custom-house, in the midst of a crowd of ships</p>
									<div class="btn-row">
										<a href="#" class="details">Details</a>
										<a href="#" class="delete">Delete</a>
									</div>
								</div>
							</li>
							<li>
								<div class="holder column">
									<h3>TableKit Class</h3>
									<p>The civil Emperor, before the Mikado, the spiritual Emperor, absorbed his office in his own.  The Carnatic anchored att the quay near the custom-house, in the midst of a crowd of ships</p>
									<div class="btn-row">
										<a href="#" class="details">Details</a>
										<a href="#" class="delete">Delete</a>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</article>
			<div class="col available">
				<header class="title">
					<h1>Available Jobs</h1>
				</header>
				<ul class="jobs-list">
					<?php
					$results = $widgetJobs->get_bestmatch_jobs('1');
					foreach($results as $result)
					{
						echo '
						<li style="position:relative;">
						<div style="z-index: 5; position: relative; background-color: white; ">
						<p class="jobtitle">' . $result[jobtitle] . '</p>
						<p>' . $result[location] . '</p>
						<div class="progress">
						<span class="progress-bar">
						<span class="progress-in" style="width:' . $result[numberofskills]*10 . '%;"></span>
						</span>
						</div>
						<div>
						<div class="btndetails details">Details</div>
						<a href="" class="delete">Delete</a>
						</div>
						<div class="floatclear"></div>
						<p style="display:none;" class="jobid">' . $result[jobid] . '</p>
						</div>
						<div class="jobdetails" style="z-index: 0; position: absolute; top: 26; background-color:white; width:311px;">
										<a href="#" class="button">IOS</a>
										<a href="#" class="button">RUBI</a>
										<a href="#" class="button">Dojo</a>
										<a href="#" class="button">Yahoo</a>
										<a href="#" class="button">Prototype</a>
										<a href="#" class="button">Adobe</a>
						</div>
						</li>
						';
					}
					?>

					<!-- <li>
						<p>Javascript Developer </p>
						<p>Long Beach, CA </p>
						<div class="progress">
							<span class="progress-bar">
								<span class="progress-in" style="width:260px;"></span>
							</span>
						</div>
						<a href="#" class="details">Details</a>
						<a href="#" class="delete">Delete</a>
					</li>
					<li>
						<p>Javascript Developer </p>
						<p>Long Beach, CA </p>
						<div class="progress">
							<span class="progress-bar">
								<span class="progress-in" style="width:214px;"></span>
							</span>
						</div>
						<a href="#" class="details">Details</a>
						<a href="#" class="delete">Delete</a>
					</li>
					<li>
						<p>Javascript Developer </p>
						<p>Long Beach, CA </p>
						<div class="progress">
							<span class="progress-bar">
								<span class="progress-in" style="width:144px;"></span>
							</span>
						</div>
						<a href="#" class="details">Details</a>
						<a href="#" class="delete">Delete</a>
					</li>
					<li>
						<p>Javascript Developer </p>
						<p>Long Beach, CA </p>
						<div class="progress">
							<span class="progress-bar">
								<span class="progress-in" style="width:260px;"></span>
							</span>
						</div>
						<a href="#" class="details">Details</a>
						<a href="#" class="delete">Delete</a>
					</li>
					<li class="green">
						<p>Javascript Developer </p>
						<p>Long Beach, CA </p>
						<div class="progress">
							<span class="progress-bar">
								<span class="progress-in" style="width:277px;"></span>
							</span>
						</div>
						<a href="#" class="details">Details</a>
						<a href="#" class="delete">Delete</a>
					</li> -->
				</ul>
			</div>
		</section>
		<section class="section blue">
			<div class="items-block columns-holder">
				<div class="holder">
					<article class="item course">
						<div class="holder column">
							<header><h1>IOS Advanced Class</h1></header>
							<p>The civil Emperor, before the Mikado, the spiritual Emperor, absorbed his office in his own.  The Carnatic anchored at the quay near the custom-house, in the</p>
							<a href="#" class="all">Check out this course</a>
						</div>
					</article>
					<article class="item course">
						<div class="holder column">
							<header><h1>Learning Dojo</h1></header>
							<p>The civil Emperor, before the Mikado, the spiritual Emperor, absorbed his office in his own.  The Carnatic anchored at the quay near the custom-house, in the</p>
							<a href="#" class="all">Check out this course</a>
						</div>
					</article>
					<article class="item course">
						<div class="holder column">
							<header><h1>IOS Advanced Class</h1></header>
							<p>The civil Emperor, before the Mikado, the spiritual Emperor, absorbed his office in his own.  The Carnatic anchored at the quay near the custom-house, in the</p>
							<a href="#" class="all">Check out this course</a>
						</div>
					</article>
					<article class="item career">
						<div class="holder column">
							<header><h1>Graphic Designer</h1></header>
							<p>The civil Emperor, before the Mikado, the spiritual Emperor, absorbed his office in his own.  The Carnatic anchored at the quay near the custom-house, in the</p>
							<a href="#" class="all">Check out this career</a>
						</div>
					</article>
				</div>
			</div>
		</section>
		<section class="section gray">
			<div class="progress-block">
				<h1>Skills</h1>
				<div class="progress">
					<span class="title photoshop">PHotoshop — <span class="progress-val">90%</span></span>
					<span class="progress-bar">
						<span class="progress-in" style="width:997px;"></span>
					</span>
				</div>
				<div class="progress">
					<span class="title development">iOS DEvelopment — <span class="progress-val">60%</span></span>
					<span class="progress-bar">
						<span class="progress-in" style="width:674px;"></span>
					</span>
				</div>
				<div class="progress">
					<span class="title video">VIDEO EDITING —<span class="progress-val">70%</span></span>
					<span class="progress-bar">
						<span class="progress-in" style="width:775px;"></span>
					</span>
				</div>
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
$('.btndetails').toggle( 
    function() {
    	$(this).html("Close");
        event.stopImmediatePropagation();
		$(this).closest('li').find('.jobdetails').animate({ top: 126 }, 'slow', function() {
        });
        $(this).closest('li').animate({ height: 180 }, 'slow', function() {
        });
    }, 
    function() {
    	$(this).html("Details");
        event.stopImmediatePropagation();
		$(this).closest('li').find('.jobdetails').animate({ top: 26 }, 'slow', function() {
        });
        $(this).closest('li').animate({ height: 106 }, 'slow', function() {
        });
    }
);

$('.jobs-list li').click(function () {
	console.log($(this).find('.jobid').text());
	$('.jobs-list li').removeClass( "green" );
	$(this).addClass( "green" );
        // $.ajax({ url: 'get_missingskills_job.php',
        //  // data: {action: 'get_missingskills_job'},
        //  data: { jobID_missingskills_perjob: $(this).find('.jobid').text() },
        //  type: 'POST',
        //  success: function(output) {
        //               //alert(output);
        //               $('#naslov b').html(output);
        //           }
        // });
});
</script>
</body>
</html>