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
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<!-- <link media="all" rel="stylesheet" href="css/twittermaks.css"> -->
	<link media="all" rel="stylesheet" href="css/all.css">
	<!-- <script type="text/javascript" src="js/jquery.main.js"></script> -->
	<!--[if IE]><script type="text/javascript" src="js/ie.js"></script><![endif]-->
	<!-- <script type="text/javascript">
	var heap=heap||[];heap.load=function(a){window._heapid=a;var b=document.createElement("script");b.type="text/javascript",b.async=!0,b.src=("https:"===document.location.protocol?"https:":"http:")+"//cdn.heapanalytics.com/js/heap.js";var c=document.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c);var d=function(a){return function(){heap.push([a].concat(Array.prototype.slice.call(arguments,0)))}},e=["identify","track"];for(var f=0;f<e.length;f++)heap[e[f]]=d(e[f])};
	heap.load("812388706");
</script> -->
</head>
<body>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="flip-container">
					<div class="front">
						<!-- front content -->
						<form accept-charset="utf-8" style="margin:0;" id="loginform" method="POST" action="login.php">
								<fieldset>
									<legend>Please sign in</legend>
									<input placeholder="Username" class="input-block-level" id="username" type="text" name="username"> <br/> 				    
									<input placeholder="Password" class="input-block-level" id="password" type="password" name="password">  				    <!--<a class="pull-right" href="">Forgot password?</a>-->
									<label class="checkbox"><input name="remember" type="checkbox" value="Remember Me"> Remember Me</label>
									<input class="btn btn-large btn-info btn-block" type="submit" value="Login">  				  	<br>
									<p class="text-center flipfrontlink"><a href="#" id="register-btn" class="cbutton">Request an Invite?</a></p>
								</fieldset>
							</form>
					</form>
				</div>
				<div class="back">
					<!-- back content -->
					<div>
						<div>
							<form action="BetaRequest.php" method="post" id="registerform"> 
							<fieldset>
								<legend>Request an invite</legend>	
								<!-- <input placeholder="Username" type="text" name="username" value="" /> <br/> -->
								<input placeholder="Your email" type="text" name="email" id="email" value="" /> <br/>
								<!-- <input placeholder="Password" type="password" name="password" value="" />  -->
								<input class="btn btn-large btn-info btn-block" type="submit" value="Request an invite" /> 
							</fieldset>
						</form>
						<p class="text-center"><a class="edit-submit flipbacklink" href="#">Login?</a></p>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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
		<div class="upload-block">
			<p>Upload your resume or skills and we will guide you to <br />the right course for you to find the perfect job!</p>
			<div class="block">
				<h1>Drop your resume here</h1>
				<form class="drag-box"><img src="images/img01.gif" width="527" height="243" alt="image description" /></form>
			</div>
			<div class="block">
				<h1>Add your skills here</h1>
				<div class="drag-box">
					<textarea id="txtskill" style="margin: 2px; min-height: 235px; min-width: 517px; resize: none;"></textarea>
				</div>
			</div>
			
			
		</div>
		<section class="section gray greenbg">
			<article class="holder">
				<div class="text-holder">
					<a href="#" id="btnupload" class="btn">SUBMIT</a>
				</div>
			</article>
		</section>
		<section class="section blue">
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
		</section>
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
		// humane.log("Hi, welcome. <br> You can start by entering your skills (comma seperated) into the text box below.<br> <br>Then press Submit"
		// 	, {waitForMove:true, timeout:2500});

$('#myModal').modal({
	backdrop: 'static',
	keyboard: false
})
$("#txtskill").asuggest(suggests, {
	'endingSymbols': ', '
});
});


$('.flipfrontlink').click(function () {
	$('.flip-container').addClass('flip');
});
$('.flipbacklink').click(function () {
	$('.flip-container').removeClass('flip');
});

</script>
</body>
</html>