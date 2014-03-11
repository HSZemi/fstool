<?php

include 'lib/config.php';
include 'lib/db.php';


$link = db_connect();

$fs_count = -1;
$studiengaenge_count = -1;

$query = "SELECT COUNT(ID) AS count FROM ".DB_PREF."fachschaften;";
$result = mysql_query($query) or die("count_fachschaften: Anfrage fehlgeschlagen: " . mysql_error());
if($row = mysql_fetch_array($result)){
	$fs_count	= intval($row['count']);
}

$query = "SELECT COUNT(ID) AS count FROM ".DB_PREF."studiengaenge;";
$result = mysql_query($query) or die("count_studiengaenge: Anfrage fehlgeschlagen: " . mysql_error());
if($row = mysql_fetch_array($result)){
	$studiengaenge_count	= intval($row['count']);
}

 db_close($link);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>fstool - Index</title>
	
	<style>
	body {
		padding-top: 20px;
		padding-bottom: 20px;
	}
	.navbar {
		margin-bottom: 20px;
	}
	</style>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
  </head>
  <body>
	<div class="container">

      <!-- Static navbar -->
      <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">fstool</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="fachschaften.php">Fachschaften</a></li>
              <li><a href="studiengaenge.php">Studiengänge</a></li>
              <li><a href="probleme.php">Probleme</a></li>
            </ul>
			
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Markdown <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="md-fachschaften.php" target="_blank">Fachschaften</a></li>
					<li><a href="md-studiengaenge.php" target="_blank">Studiengänge</a></li>
				</ul>
			</li>
		</ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
      
      <div class="container">

	<!-- Main component for a primary marketing message or call to action -->
	<div class="jumbotron">
	
	
		<h1>fstool <small>Übersicht</small></h1>
		<p>fstool ist ein Tool zur Verwaltung von Fachschaften der RFWU Bonn.</p>
		
		<div id="alert"></div>

       
		<?php echo "<p>Derzeit sind <a href='fachschaften.php' class='btn btn-info'><span class='badge'>$fs_count</span> Fachschaften</a> und <a href='studiengaenge.php' class='btn btn-success'><span class='badge'>$studiengaenge_count</span> Studiengänge</a> eingetragen.</p>"; ?>

	</div>

	</div> <!-- /container -->

    </div> <!-- /container -->


  </body>
</html>
 
