<?php

$configfile = 'lib/config.php';

/*
 * 1 = Neuinstallation
 * 2 = Schritt 2: Configfile anlegen, Datenbank ggf. löschen und neu anlegen
 */
$step = 1;

$dbname = '';
$dbuser = '';
$dbpass = '';
$dbpref = '';

$badge_ok = '<span class="badge">OK</span>';
$badge_error = '<span class="badge">Fehler</span>';
$lgi_ok = ' list-group-item-success';
$lgi_error = ' list-group-item-danger';
$error_occured = false;
$lastmessage = '<p>fstool wurde erfolgreich installiert. Du kannst jetzt <a href="fachschaften.php">loslegen</a>!</p>
<p><a href="install_studiengaenge.php" class="btn btn-default">FAKs installieren</a> <a href="install_fachschaften.php" class="btn btn-default">Fachschaften installieren</a></p>';

if(file_exists($configfile)){
	include 'lib/config.php';
	$dbname = DB_NAME;
	$dbuser = DB_USER;
	$dbpass = DB_PASS;
	$dbpref = DB_PREF;
} else {
	$error_occured = true;
}
	
/*
 * DB-Verbindung öffnen
 */

	if(!$error_occured){
		// establish connection with the database
		$link = mysql_connect("localhost", $dbuser, $dbpass);
		if(!$link){
			$stat_1 = $badge_error;
			$lgi_1 = $lgi_error;
			$error_occured = true;
		}
	}

	if(!$error_occured){
		if(!mysql_select_db($dbname)){
			$stat_1 = $badge_error;
			$lgi_1 = $lgi_error;
			$error_occured = true;
		}
	}

	if(!$error_occured){
		// UTF8 ist cool!
		$query = "set names 'utf8';";
		$result = mysql_query($query);
		if(!$result){
			$stat_1 = $badge_error;
			$lgi_1 = $lgi_error;
			$error_occured = true;
		} else {
			$stat_1 = $badge_ok;
			$lgi_1 = $lgi_ok;
		}
	}

/*
 * FS-Tabelle erweitern
 */
 
	// prüfen, ob FS-Tabelle existiert
	if(!$error_occured){
		$query = "SELECT * from INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$dbpref."fachschaften';";
		$result = mysql_query($query);
		if(!$result){
			$stat_2 = $badge_error;
			$lgi_2 = $lgi_error;
			$error_occured = true;
		} elseif(mysql_num_rows($result) < 1) {
			$stat_2 = $badge_error;
			$lgi_2 = $lgi_error;
			$error_occured = true;
		} else {
			$stat_2 = $badge_ok;
			$lgi_2 = $lgi_ok;
		}
	}
	
	// prüfen, ob email-Feld noch nicht existiert
	if(!$error_occured){
		$query = "SELECT * from INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$dbpref."fachschaften' AND COLUMN_NAME = 'email';";
		$result = mysql_query($query);
		if(!$result){
			$stat_3 = $badge_error;
			$lgi_3 = $lgi_error;
			$error_occured = true;
		} elseif(mysql_num_rows($result) > 0) {
			$stat_3 = $badge_error;
			$lgi_3 = $lgi_error;
			$error_occured = true;
		} else {
			$stat_3 = $badge_ok;
			$lgi_3 = $lgi_ok;
		}
	}
	
	// prüfen, ob telefon-Feld noch nicht existiert
	if(!$error_occured){
		$query = "SELECT * from INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$dbpref."fachschaften' AND COLUMN_NAME = 'telefon';";
		$result = mysql_query($query);
		if(!$result){
			$stat_4 = $badge_error;
			$lgi_4 = $lgi_error;
			$error_occured = true;
		} elseif(mysql_num_rows($result) > 0) {
			$stat_4 = $badge_error;
			$lgi_4 = $lgi_error;
			$error_occured = true;
		} else {
			$stat_4 = $badge_ok;
			$lgi_4 = $lgi_ok;
		}
	}
	
	// prüfen, ob Adressfeld noch nicht existiert
	if(!$error_occured){
		$query = "SELECT * from INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$dbpref."fachschaften' AND COLUMN_NAME = 'adresse';";
		$result = mysql_query($query);
		if(!$result){
			$stat_5 = $badge_error;
			$lgi_5 = $lgi_error;
			$error_occured = true;
		} elseif(mysql_num_rows($result) > 0) {
			$stat_5 = $badge_error;
			$lgi_5 = $lgi_error;
			$error_occured = true;
		} else {
			$stat_5 = $badge_ok;
			$lgi_5 = $lgi_ok;
		}
	}
	
	// füge Felder für E-Mail, Telefon und Adresse ein
	if(!$error_occured){
		$query = "ALTER TABLE ".$dbpref."fachschaften 
			ADD COLUMN 	email		VARCHAR(255),
			ADD COLUMN 	telefon	VARCHAR(255),
			ADD COLUMN 	adresse	text;";
		$result = mysql_query($query);
		if(!$result){
			$stat_6 = $badge_error;
			$lgi_6 = $lgi_error;
			$error_occured = true;
		} else {
			$stat_6 = $badge_ok;
			$lgi_6 = $lgi_ok;
		}
	}
	
	$iban_error_occured = false;
	// prüfen, ob IBAN-Feld noch nicht existiert
	if(!$iban_error_occured){
		$query = "SELECT * from INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$dbpref."fachschaften' AND COLUMN_NAME = 'iban';";
		$result = mysql_query($query);
		if(!$result){
			$stat_7 = $badge_error;
			$lgi_7 = $lgi_error;
			$error_occured = true;
		} elseif(mysql_num_rows($result) > 0) {
			$stat_7 = $badge_error;
			$lgi_7 = $lgi_error;
			$error_occured = true;
		} else {
			$stat_7 = $badge_ok;
			$lgi_7 = $lgi_ok;
		}
	}
	
	// füge Feld für IBAN ein
	if(!$iban_error_occured){
		$query = "ALTER TABLE ".$dbpref."fachschaften 
			ADD COLUMN 	iban		VARCHAR(255)";
		$result = mysql_query($query);
		if(!$result){
			$stat_8 = $badge_error;
			$lgi_8 = $lgi_error;
			$error_occured = true;
		} else {
			$stat_8 = $badge_ok;
			$lgi_8 = $lgi_ok;
		}
	}
	
	$www_error_occured = false;
	// prüfen, ob www-Feld noch nicht existiert
	if(!$www_error_occured){
		$query = "SELECT * from INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$dbpref."fachschaften' AND COLUMN_NAME = 'www';";
		$result = mysql_query($query);
		if(!$result){
			$stat_9 = $badge_error;
			$lgi_9 = $lgi_error;
			$error_occured = true;
		} elseif(mysql_num_rows($result) > 0) {
			$stat_9 = $badge_error;
			$lgi_9 = $lgi_error;
			$error_occured = true;
		} else {
			$stat_9 = $badge_ok;
			$lgi_9 = $lgi_ok;
		}
	}
	
	// füge Feld für WWW ein
	if(!$www_error_occured){
		$query = "ALTER TABLE ".$dbpref."fachschaften 
			ADD COLUMN 	www		VARCHAR(255)";
		$result = mysql_query($query);
		if(!$result){
			$stat_10 = $badge_error;
			$lgi_10 = $lgi_error;
			$error_occured = true;
		} else {
			$stat_10 = $badge_ok;
			$lgi_10 = $lgi_ok;
		}
	}

/*
 * DB-Verbindung schließen
 */
	if(isset($link) and $link){
		if(mysql_close($link)){
			$stat_11 = $badge_ok;
			$lgi_11 = $lgi_ok;
		} else {
			$stat_11 = $badge_error;
			$lgi_11 = $lgi_error;
			$error_occured = true;
		}
	}

	if($error_occured or $iban_error_occured or $www_error_occured){
		$lastmessage = "<p>Fehler sind aufgetreten.</p>\n<a class='btn btn-default' href='upgrade_fscontact.php'>Upgrade neu starten</a>";
	}
	


?>
<!DOCTYPE html>
<html lang="de">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>fstool - Upgrade: Kontaktdaten</title>
	
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
	
	
		<h1>fstool - Installation <small>Schritt 2</small></h1>
		
		<ul class="list-group">
		<li class="list-group-item<?php echo $lgi_1; ?>">Stelle Verbindung zur Datenbank her... <?php echo $stat_1; ?></li>
		<li class="list-group-item<?php echo $lgi_2; ?>">Prüfe, ob Tabelle '<?php echo $dbpref; ?>.fachschaften' existiert... <?php echo $stat_2; ?></li>
		<li class="list-group-item<?php echo $lgi_3; ?>">Prüfe, ob 'email'-Feld noch nicht existiert... <?php echo $stat_3; ?></li>
		<li class="list-group-item<?php echo $lgi_4; ?>">Prüfe, ob 'telefon'-Feld noch nicht existiert... <?php echo $stat_4; ?></li>
		<li class="list-group-item<?php echo $lgi_5; ?>">Prüfe, ob 'adresse'-Feld noch nicht existiert... <?php echo $stat_5; ?></li>
		<li class="list-group-item<?php echo $lgi_6; ?>">Füge Felder für E-Mail, Telefon und Adresse ein... <?php echo $stat_6; ?></li>
		<li class="list-group-item<?php echo $lgi_7; ?>">Prüfe, ob 'iban'-Feld noch nicht existiert... <?php echo $stat_7; ?></li>
		<li class="list-group-item<?php echo $lgi_8; ?>">Füge Feld für IBAN ein... <?php echo $stat_8; ?></li>
		<li class="list-group-item<?php echo $lgi_9; ?>">Prüfe, ob 'www'-Feld noch nicht existiert... <?php echo $stat_9; ?></li>
		<li class="list-group-item<?php echo $lgi_10; ?>">Füge Feld für WWW ein... <?php echo $stat_10; ?></li>
		<li class="list-group-item<?php echo $lgi_11; ?>">Schließe Datenbankverbindung... <?php echo $stat_11; ?></li>
		</ul>
		
		
		<?php echo $lastmessage;?>
		
	</div>

  </body>
</html>
 
