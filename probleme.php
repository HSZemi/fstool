<?php

include 'lib/config.php';
include 'lib/db.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>fstool - Probleme</title>

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
	
	<style>
	body {
		padding-top: 20px;
		padding-bottom: 20px;
	}
	.navbar {
		margin-bottom: 20px;
	}
	
	.panel-primary{
		border-color: #c02929;
	}
	
	.panel-primary > .panel-heading {
		color: #FFF;
		background-color: #c02929;
		border-color: rgb(192, 41, 41);
	}
	</style>
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
              <li class="active"><a href="probleme.php">Probleme</a></li>
            </ul>
			
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Export <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="fachschaften-plain.php" target="_blank">Fachschaften plain</a></li>
					<li><a href="studiengaenge-plain.php" target="_blank">Studiengänge plain</a></li>
					<li><a href="fachschaften-plain.php?fullnames" target="_blank">Fachschaften plain (fullnames)</a></li>
					<li><a href="studiengaenge-plain.php?fullnames" target="_blank">Studiengänge plain (fullnames)</a></li>
					<li class="divider"></li>
					<li><a href="fachschaften-md.php">Fachschaften Markdown</a></li>
					<li><a href="studiengaenge-md.php">Studiengänge Markdown</a></li>
					<li><a href="fachschaften-md.php?fullnames">Fachschaften Markdown (fullnames)</a></li>
					<li><a href="studiengaenge-md.php?fullnames">Studiengänge Markdown (fullnames)</a></li>
				</ul>
			</li>
		</ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
      
      <?php 
	$link = db_connect();
      ?>
      
      <div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Fachschaften ohne Studiengang</h3>
		</div>
		<div class="panel-body">
			<div class="list-group">
		
		<?php 
			$query = "SELECT ID, name FROM ".DB_PREF."fachschaften 
			WHERE ".DB_PREF."fachschaften.ID NOT IN (SELECT fachschaft FROM ".DB_PREF."zuordnung) ORDER BY name ASC;";
			$result = mysql_query($query) or die("get_fsen_without_studiengang: Anfrage fehlgeschlagen: " . mysql_error());
			while($row = mysql_fetch_array($result)){
				$id		= $row['ID'];
				$name		= $row['name'];
				
				echo '<a class="list-group-item" href="fachschaften.php#'.$id.'">'.$name.'</a>
				';
			}
				
		?>
			</div>
		</div>
	</div>
	
      <div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Studiengänge ohne Fachschaft</h3>
		</div>
		<div class="panel-body">
			<div class="list-group">
		
		<?php 
			$query = "SELECT ID, name FROM ".DB_PREF."studiengaenge 
			WHERE ".DB_PREF."studiengaenge.ID NOT IN (SELECT studiengang FROM ".DB_PREF."zuordnung) ORDER BY name ASC;";
			$result = mysql_query($query) or die("get_studiengaenge_without_fs: Anfrage fehlgeschlagen: " . mysql_error());
			while($row = mysql_fetch_array($result)){
				$id		= $row['ID'];
				$name		= $row['name'];
				
				echo '<a href="studiengaenge.php#'.$id.'" class="list-group-item">'.$name.'</a>
				';
			}
				
		?>
			</div>
		</div>
	</div>
	
      <div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Studiengänge mit mehr als einer Fachschaft</h3>
		</div>
		<div class="panel-body">
			<div class="list-group">
		
		<?php 
			$query = "SELECT ID, name FROM ".DB_PREF."studiengaenge 
			WHERE ".DB_PREF."studiengaenge.ID IN (SELECT T.studiengang FROM (SELECT studiengang, COUNT(fachschaft) AS anzahl FROM ".DB_PREF."zuordnung GROUP BY studiengang) AS T WHERE anzahl > 1) ORDER BY name ASC;";
			$result = mysql_query($query) or die("get_studiengaenge_without_fs: Anfrage fehlgeschlagen: " . mysql_error());
			while($row = mysql_fetch_array($result)){
				$id		= $row['ID'];
				$name		= $row['name'];
				
				echo '<a href="studiengaenge.php#'.$id.'" class="list-group-item">'.$name.'</a>
				';
			}
				
		?>
			</div>
		</div>
	</div>
      
      
      <?php
      db_close($link);
      ?>

    </div> <!-- /container -->


  </body>
</html>
 
