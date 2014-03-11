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
$lastmessage = '<p>fstool wurde erfolgreich installiert. Du kannst jetzt <a href="index.php">loslegen</a>!</p>
<p><a href="install_studiengaenge.php" class="btn btn-default">Studiengänge installieren</a> <a href="install_fachschaften.php" class="btn btn-default">Fachschaften installieren</a></p>';

if(file_exists($configfile)){
	include 'lib/config.php';
	$dbname = DB_NAME;
	$dbuser = DB_USER;
	$dbpass = DB_PASS;
	$dbpref = DB_PREF;
}

if(isset($_POST['dbname']) and isset($_POST['dbuser']) and isset($_POST['dbpass']) and isset($_POST['dbpref'])){
	$step = 2;
	
	$stat_1 = '';
	$lgi_1 = '';
	$stat_2 = '';
	$lgi_2 = '';
	$stat_3 = '';
	$lgi_3 = '';
	$stat_4 = '';
	$lgi_4 = '';
	$stat_5 = '';
	$lgi_5 = '';
	$stat_6 = '';
	$lgi_6 = '';
	$stat_7 = '';
	$lgi_7 = '';
	
	$dbname = $_POST['dbname'];
	$dbuser = $_POST['dbuser'];
	$dbpass = $_POST['dbpass'];
	$dbpref = $_POST['dbpref'];
	$dbpref = mysql_real_escape_string(htmlspecialchars($dbpref, ENT_QUOTES | ENT_HTML401));
	
	$config = "<?php 

!defined('DB_NAME')	? define('DB_NAME', '".$dbname."') : '';
!defined('DB_USER')	? define('DB_USER', '".$dbuser."') : '';
!defined('DB_PASS')	? define('DB_PASS', '".$dbpass."') : '';
!defined('DB_PREF')	? define('DB_PREF', '".$dbpref."') : '';

?>";
	
/*
 * Konfigurationsdatei lib/config.php schreiben
 */
	if(is_writable($configfile) or (is_writable(dirname($configfile)) and !file_exists($configfile))){
		$handle = fopen($configfile, 'w');
		if (!fwrite($handle, $config)) {
			//error
			$stat_1 = $badge_error;
			$lgi_1 = $lgi_error;
			$error_occured = true;
		} else {
			$stat_1 = $badge_ok;
			$lgi_1 = $lgi_ok;
		}
		fclose($handle);
	} else {
		// error
		$stat_1 = $badge_error;
		$lgi_1 = $lgi_error;
		$error_occured = true;
	}
	
/*
 * DB-Verbindung öffnen
 */

	if(!$error_occured){
		// establish connection with the database
		$link = mysql_connect("localhost", $dbuser, $dbpass);
		if(!$link){
			$stat_2 = $badge_error;
			$lgi_2 = $lgi_error;
			$error_occured = true;
		}
	}

	if(!$error_occured){
		if(!mysql_select_db($dbname)){
			$stat_2 = $badge_error;
			$lgi_2 = $lgi_error;
			$error_occured = true;
		}
	}

	if(!$error_occured){
		// UTF8 ist cool!
		$query = "set names 'utf8';";
		$result = mysql_query($query);
		if(!$result){
			$stat_2 = $badge_error;
			$lgi_2 = $lgi_error;
			$error_occured = true;
		} else {
			$stat_2 = $badge_ok;
			$lgi_2 = $lgi_ok;
		}
	}

/*
 * Alte Tabellen entfernen
 */
	if(!$error_occured){
		$query = "DROP TABLE IF EXISTS 
		".$dbpref."zuordnung,
		".$dbpref."fachschaften,
		".$dbpref."studiengaenge;";
		$result = mysql_query($query);
		if(!$result){
			$stat_3 = $badge_error;
			$lgi_3 = $lgi_error;
			$error_occured = true;
		} else {
			$stat_3 = $badge_ok;
			$lgi_3 = $lgi_ok;
		}
	}


/*
 * FS-Tabelle anlegen
 */
	if(!$error_occured){
		$query = "CREATE TABLE ".$dbpref."fachschaften (
			id		int			AUTO_INCREMENT,
			name		VARCHAR(255)	UNIQUE,
			satzung	VARCHAR(255),
			
			PRIMARY KEY (id)
		) DEFAULT COLLATE utf8_unicode_ci;";
		$result = mysql_query($query);
		if(!$result){
			$stat_4 = $badge_error;
			$lgi_4 = $lgi_error;
			$error_occured = true;
		} else {
			$stat_4 = $badge_ok;
			$lgi_4 = $lgi_ok;
		}
	}

/*
 * Studiengangstabelle anlegen
 */
	if(!$error_occured){
		$query = "CREATE TABLE ".$dbpref."studiengaenge (
			id		int			AUTO_INCREMENT,
			name		VARCHAR(255)	UNIQUE,
			
			PRIMARY KEY (id)
		) DEFAULT COLLATE utf8_unicode_ci;";
		$result = mysql_query($query);
		if(!$result){
			$stat_5 = $badge_error;
			$lgi_5 = $lgi_error;
			$error_occured = true;
		} else {
			$stat_5 = $badge_ok;
			$lgi_5 = $lgi_ok;
		}
	}

/*
 * Zuordnungstabelle anlegen
 */
	if(!$error_occured){
		$query = "CREATE TABLE ".$dbpref."zuordnung (
			fachschaft		int,
			studiengang		int,
			
			FOREIGN KEY (fachschaft) REFERENCES ".$dbpref."fachschaften(id),
			FOREIGN KEY (studiengang) REFERENCES ".$dbpref."studiengaenge(id),
			UNIQUE(fachschaft, studiengang)
		) DEFAULT COLLATE utf8_unicode_ci;";
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

/*
 * DB-Verbindung schließen
 */
	if(isset($link) and $link){
		if(mysql_close($link)){
			$stat_7 = $badge_ok;
			$lgi_7 = $lgi_ok;
		} else {
			$stat_7 = $badge_error;
			$lgi_7 = $lgi_error;
			$error_occured = true;
		}
	}

	if($error_occured){
		$lastmessage = "<p>Fehler sind aufgetreten.</p>\n<a class='btn btn-default' href='install.php'>Installation neu starten</a>";
	}
	
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
  
	<?php if($step==1){ ?>
  
	<div class="container">

	<!-- Main component for a primary marketing message or call to action -->
	<div class="jumbotron">
	
	
		<h1>fstool - Installation <small>Schritt 1</small></h1>
		<p>Bitte füllen die folgende Felder für den Zugriff auf die Datenbank aus:</p>
		
		<div id="alert"></div>

       
		<form role="form" id="installform" action="install.php" method="post">
			<div class="form-group" id="dbnamegroup">
				<label class="control-label" for="inputDBNAME">Datenbankname</label>
				<input type="text" class="form-control" id="inputDBNAME" name="dbname" value="<?php echo $dbname; ?>" placeholder="Datenbankname">
			</div>
			<div class="form-group" id="dbusergroup">
				<label class="control-label" for="inputDBUSER">Benutzername</label>
				<input type="text" class="form-control" id="inputDBUSER" name="dbuser" value="<?php echo $dbuser; ?>" placeholder="Benutzername">
			</div>
			<div class="form-group" id="dbpassgroup">
				<label class="control-label" for="inputDBPASS">Passwort</label>
				<input type="password" class="form-control" id="inputDBPASS" name="dbpass" value="<?php echo $dbpass; ?>" placeholder="Passwort">
			</div>
			<div class="form-group" id="dbprefgroup">
				<label class="control-label" for="inputDBPREF">Datenbankpräfix</label>
				<input type="text" class="form-control" id="inputDBPREF" name="dbpref" value="<?php echo $dbpref; ?>" placeholder="fstool_">
			</div>
			
		</form>
		
			<button id="installbutton" class="btn btn-default btn-primary">Installieren</button>

	</div>

	</div> <!-- /container -->

	<script type="text/javascript">
		function check(){
			success = true;
			if($('#inputDBNAME').val() == ''){
				$('#dbnamegroup').addClass('has-error');
				error = false;
			}
			if($('#inputDBUSER').val() == ''){
				$('#dbusergroup').addClass('has-error');
				error = false;
			}
			if($('#inputDBPASS').val() == ''){
				$('#dbpassgroup').addClass('has-error');
				error = false;
			}
			if($('#inputDBPREF').val() == ''){
				$('#inputDBPREF').val('fstool_');
			}
			return success;
		}
	
		$('#installbutton').click(function(){
			if(check()){
				$('#installform').submit();
			} else {
				$('#alert').html('<div class="alert alert-danger alert-dismissable">\n			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>\n			<strong>Fehler</strong> Bitte fülle alle markierten Felder aus.\n		</div>');
			}
		})
	</script>
	
	<?php } elseif($step==2){ ?>
	
	<div class="container">

	<!-- Main component for a primary marketing message or call to action -->
	<div class="jumbotron">
	
	
		<h1>fstool - Installation <small>Schritt 2</small></h1>
		
		<ul class="list-group">
		<li class="list-group-item<?php echo $lgi_1; ?>">Lege config.php an... <?php echo $stat_1; ?></li>
		<li class="list-group-item<?php echo $lgi_2; ?>">Stelle Verbindung zur Datenbank her... <?php echo $stat_2; ?></li>
		<li class="list-group-item<?php echo $lgi_3; ?>">Lösche vorhandene Tabellen... <?php echo $stat_3; ?></li>
		<li class="list-group-item<?php echo $lgi_4; ?>">Lege Tabelle der Fachschaften an... <?php echo $stat_4; ?></li>
		<li class="list-group-item<?php echo $lgi_5; ?>">Lege Tabelle der Studiengänge an... <?php echo $stat_5; ?></li>
		<li class="list-group-item<?php echo $lgi_6; ?>">Lege Zuordnungstabelle an... <?php echo $stat_6; ?></li>
		<li class="list-group-item<?php echo $lgi_7; ?>">Schließe Datenbankverbindung... <?php echo $stat_7; ?></li>
		</ul>
		
		
		<?php echo $lastmessage;?>
		
	</div>
	
	
	<?php } else { ?>
	
	<h1>Fehler bei der Installation: $step = <?php echo intval($step); ?></h1>
	
	<?php } ?>

  </body>
</html>
 
