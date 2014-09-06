<?php

include 'lib/config.php';
include 'lib/db.php';


?>
<!DOCTYPE html>
<html lang="de">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>fstool - Fachschaften - Plaintext</title>
	<style>body{font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.42857143;}</style>
  </head>
  <body>
  
<h1>Kontaktdaten der Fachschaften der RFWU Bonn</h1>


<?php

$link = db_connect();


$query = "SELECT ID, name, email, telefon, adresse, www FROM ".DB_PREF."fachschaften ORDER BY name ASC;";
$result = mysql_query($query) or die("get_all_fachschaften: Anfrage fehlgeschlagen: " . mysql_error());
while($row = mysql_fetch_array($result)){
      $id		= $row['ID'];
      $name		= $row['name'];
      $email	= $row['email'];
      $telefon	= $row['telefon'];
      $adresse	= $row['adresse'];
      $www		= $row['www'];
      
	echo "<h2>$name</h2>\n<ul>\n";
	
	echo "<li><b>E-Mail-Adresse:</b> ".$row['email']."</li>\n";
	echo "<li><b>Telefonnummer:</b> ".$row['telefon']."</li>\n";
	echo "<li><b>Adresse: </b> ".$row['adresse']."</li>\n";
	echo "<li><b>Webseite: </b> ".$row['www']."</li>\n";
	
	echo "</ul>\n\n";
}
	
db_close($link);
?>
</body>
</html>