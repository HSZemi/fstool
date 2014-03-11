<?php

include 'lib/config.php';
include 'lib/db.php';

$fachschaften = ['Altkatholische Theologie',
'Anglistik',
'Archäologie',
'Biologie',
'Chemie',
'Christliche Archäologie',
'EHW',
'Erziehungswissenschaften',
'Ethnologie',
'Evangelische Theologie',
'Geodäsie',
'Geographie',
'Geologie',
'Germanistik',
'Geschichte',
'Griechische und Lateinische Philologie',
'Informatik',
'Japanologie',
'Jura',
'Katholische Theologie',
'Komparatistik',
'Kommunikationsforschung',
'Kulturwissenschaften',
'Kunstgeschichte',
'Landwirtschaft',
'Lebensmittel',
'Mathematik',
'Medizin Klinik',
'Medizin-Vorklinik',
'Meteorologie',
'Mineralogie',
'Musikwissenschaft',
'Orient Asia',
'Orientalische Kunstgeschichte',
'Pharmazie',
'Philosophie',
'Physik /Astro',
'Politikwissenschaft',
'Psychologie',
'Romanistik',
'Skandinavistik',
'Lehramt',
'Kulturanthropologie'];

$success = Array();

$link = db_connect();

// alle ungenutzten Fachschaften löschen
$query = "DELETE FROM fstool_fachschaften WHERE ID NOT IN (SELECT fachschaft FROM fstool_zuordnung);";
$truncate_success = mysql_query($query);
	
if($truncate_success){
	$i = 0;
	foreach($fachschaften as $item){
		$item = validate_string_for_mysql_html($item);
		$query = "INSERT INTO ".DB_PREF."fachschaften(name) VALUES ('".$item."');";
		$result = mysql_query($query);
		if(!$result){
			$success[$i] = false;
		} else {
			$success[$i] = true;
		}
		
		$i += 1;
	}
}
/*
 * DB-Verbindung schließen
 */
if(isset($link) and $link){
	mysql_close($link);
}


?>
<!DOCTYPE html>
<html lang="de">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>fstool - Installation</title>
	
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

	<!-- Main component for a primary marketing message or call to action -->
	<div class="jumbotron">
	
	
		<h1>fstool - Installation <small>Fachschaften</small></h1>
		
		<ul class="list-group">
		<?php 
		
		if($truncate_success){
			echo '		<li class="list-group-item list-group-item-success">Datenbank leeren... <span class="badge">OK</span></li>
			';
		} else {
			echo '		<li class="list-group-item list-group-item-danger">Datenbank leeren... <span class="badge">Fehler</span></li>
			';
		}
		
		$i = 0;
		foreach($fachschaften as $item){
			$item = validate_string_for_mysql_html($item);
			if(isset($success[$i])){
				if($success[$i]){
					echo '		<li class="list-group-item list-group-item-success">'.$item.' <span class="badge">OK</span></li>
					';
				} else {
					echo '		<li class="list-group-item list-group-item-danger">'.$item.' <span class="badge">Fehler</span></li>
					';
				}
			} else {
				echo '		<li class="list-group-item">'.$item.'</li>
				';
			}
			$i += 1;
		}
		
		?>
		</ul>
		
		
		
	</div>

  </body>
</html>
 
