<?php
require 'ProceduresToJson.php';
$widgetJobs = new ProcedureToJson();
$widgetJobs->init();
if(empty($_SESSION['user'])) 
{ 
	header("Location: index.php"); 
	die("Redirecting to index.php"); 
} 
else
{
	$userid = $_SESSION['user']['id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name = "format-detection" content = "telephone=no" />
	<title>FillSkills</title>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script src="js/jquery-1.8.3.min.js"><\/script>')</script>
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">
	<link media="all" rel="stylesheet" href="css/target.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<!--[if IE]><script type="text/javascript" src="js/ie.js"></script><![endif]-->
	<script type="text/javascript">
	var heap=heap||[];heap.load=function(a){window._heapid=a;var b=document.createElement("script");b.type="text/javascript",b.async=!0,b.src=("https:"===document.location.protocol?"https:":"http:")+"//cdn.heapanalytics.com/js/heap.js";var c=document.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c);var d=function(a){return function(){heap.push([a].concat(Array.prototype.slice.call(arguments,0)))}},e=["identify","track"];for(var f=0;f<e.length;f++)heap[e[f]]=d(e[f])};
	heap.load("812388706");
	</script>
</head>
<body>
	<div id="wrapper">
		<header id="header">
			<div class="holder">
				<div class="frame">
					<strong class="logo"><a href="index2.php">FillSkills Helping you get your dream job</a></strong>
					<nav id="nav">
						<a class="home" href="index2.php">Enter skills</a>
						<a class="results active" href="#">Set Goal</a>
						<!-- <a class="courses" href="#">Courses</a>
						<a class="skills" href="#">Skills</a>
						<a class="contact" href="#">Contact</a> -->
						<a class="logout" href="logout.php">Logout</a>
					</nav>
				</div>
			</div>
		</header>
		<div id="main">
			<div class="upload-block">
				<p>2. Set your goal</p>
			</div>
			<section class="section info-columns columns-holder">
				<article class="col missing">
					<header class="title">
						<!-- <h1>Target all skillsets<br></br></h1> -->
					</header>
					<div class="box column target-alljobs">
						<div class="courses-block">
							<h2>(Default)</h2>
							<br/>
							<h2>Analyse the entire software job market: </h2>
							<br>
							<p>7,000+ LA software jobs</p>
							<p>350+ skills </p>
							<p>50+ SkillSets </p>
						</div>
						<div>
							<p id="CheckMarkAllJobs" class="CheckAllJobs">&#x2713</p>
						</div>
					</div>
				</article>
				<article class="col personal">
					<div>
						<header class="title">
							<!-- <h1>...or continue on one of your current paths</h1> -->
						</header>
						<div class="box column">
							<div class="courses-block"><h2>We picked up these skillsets from your resume: </h2></div>
							<ul class="jobs-list target-list-current">
								<?php
								$results_skillsetmatches = $widgetJobs->get_skillset_matches($userid);
								foreach($results_skillsetmatches as $result)
								{
									echo '
									<li class="green">
									<p>' . $result[name] . '</p>
									</li>
									';
								}
								?>
								<!-- 
								<li class="green">
									<div class="progress">
										<span class="progress-bar">
											<span class="progress-in" style="width:80%;">
												<p>Oracle Developer </p>
											</span>
										</span>
									</div>
								</li> -->
							</ul>
						</div>
					</div>
				</article>
				<article class="col available">
					<div>
						<header class="title">
							<!-- <h1>...or learn something new<br></br></h1> -->
						</header>
						<div class="box column missing">
							<div class="courses-block"><h2>Software skillsets with the most jobs: </h2></div>
							<ul class="jobs-list target-list-current">
								<?php
								$results_skillsetmatches = $widgetJobs->get_topjobs_skillsets($userid);
								foreach($results_skillsetmatches as $result)
								{
									echo '
									<li class="green" style="overflow:hidden;">
									<p style="float:left;">' . $result[name] . '</p><p style="float:left">' . ' (' .$result[jobcount] . ' jobs)'  . '</p>
									</li>
									';
								}
								?>
								<!-- <li class="green">
									<div class="progress">
										<span class="progress-bar">
											<span class="progress-in" style="width:80%;">
												<p>Javascript Developer </p>
											</span>
										</span>
									</div>
								</li>
								<li class="green">
									<div class="progress">
										<span class="progress-bar">
											<span class="progress-in" style="width:80%;">
												<p>PHP Developer </p>
											</span>
										</span>
									</div>
								</li>
								<li class="green">
									<div class="progress">
										<span class="progress-bar">
											<span class="progress-in" style="width:80%;">
												<p>HTML Developer </p>
											</span>
										</span>
									</div>
								</li>
								<li class="green">
									<div class="progress">
										<span class="progress-bar">
											<span class="progress-in" style="width:80%;">
												<p>C++ Developer </p>
											</span>
										</span>
									</div>
								</li>
								<li class="green">
									<div class="progress">
										<span class="progress-bar">
											<span class="progress-in" style="width:80%;">
												<p>iOS Developer </p>
											</span>
										</span>
									</div>
								</li>
								<li class="green">
									<div class="progress">
										<span class="progress-bar">
											<span class="progress-in" style="width:80%;">
												<p>Oracle Developer </p>
											</span>
										</span>
									</div>
								</li> -->
							</ul>
						</div>
					</div>
				</article>
				
			</section>

			<section class="section gray greenbg">
				<article class="holder">
					<div class="text-holder">
						<form id="PostResults" name="PostResults" method="POST" action="results.php">
							<input type="hidden" id="targetstring" name="targetstring" />
							<input type="submit" id="btnupload" class="btn" value="NEXT >"></input>
						</form>
					</div>
				</article>
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

	
	$( "#PostResults" ).submit(function( event ) {
		//event.preventDefault();
	});

	$('.target-list-current > li').hover(function () {
		$(this).addClass('targetHover');
	});
	$('.target-list-current > li').mouseleave(function () {
		$(this).removeClass('targetHover');
	});
	$('.target-list-top > li').hover(function () {
		$(this).addClass('targetHover');
	});
	$('.target-list-top > li').mouseleave(function () {
		$(this).removeClass('targetHover');
	});
	$('.target-alljobs').hover(function () {
		$(this).addClass('targetHover');
	});
	$('.target-alljobs').mouseleave(function () {
		$(this).removeClass('targetHover');
	});

	$('.target-list-current > li').click(function () {
		if($(this).hasClass('targetSelected'))
		{
			$(this).toggleClass('targetSelected');
			$('#targetstring').val('');	
		}
		else
		{
			$('.target-list-current > li').removeClass('targetSelected');
			$('.target-list-top > li').removeClass('targetSelected');
			$('.target-alljobs').removeClass('targetSelected');
			$('#CheckMarkAllJobs').removeClass('CheckAllJobs');	
			$('#CheckMarkAllJobs').addClass('UnCheckAllJobs');	
			$(this).toggleClass('targetSelected');
			$('#targetstring').val($('li.targetSelected p:first-of-type').text());
		}
	});
	$('.target-list-top > li').click(function () {
		if($(this).hasClass('targetSelected'))
		{
			$(this).toggleClass('targetSelected');	
			$('#targetstring').val('');
		}
		else
		{
			$('.target-list-current > li').removeClass('targetSelected');
			$('.target-list-top > li').removeClass('targetSelected');
			$('.target-alljobs').removeClass('targetSelected');
			$('#CheckMarkAllJobs').removeClass('CheckAllJobs');	
			$('#CheckMarkAllJobs').addClass('UnCheckAllJobs');	
			$(this).toggleClass('targetSelected');
			$('#targetstring').val($('li.targetSelected p:first-of-type').text());
		}	
	});
	$('.target-alljobs').click(function () {
		$('#targetstring').val('');

		if($('#CheckMarkAllJobs').hasClass('CheckAllJobs'))
		{
			$('#CheckMarkAllJobs').removeClass('CheckAllJobs');	
			$('#CheckMarkAllJobs').addClass('UnCheckAllJobs');	
			$('#targetstring').val('');
		}
		else if($('#CheckMarkAllJobs').hasClass('UnCheckAllJobs'))
		{
			$('.target-list-current > li').removeClass('targetSelected');
			$('.target-list-top > li').removeClass('targetSelected');
			$('.target-alljobs').removeClass('targetSelected');
			$('#CheckMarkAllJobs').removeClass('UnCheckAllJobs');
			$('#CheckMarkAllJobs').addClass('CheckAllJobs');
		}
	});

	</script>
</body>
</html>