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
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery.min.js"></script>
	<!-- encryption js -->
	<script type="text/javascript" src="js/aes.js"></script> 
	<script type="text/javascript" src="js/iban.js"></script> 
	<style>body{font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.42857143;}</style>
  </head>
  <body>
  
  <button type="button" class="" onclick="decryptIban()" id="ibanbutton">IBAN entschlüsseln</button>
  
<h1>Kontaktdaten der Fachschaften der RFWU Bonn</h1>


<?php

$link = db_connect();


$query = "SELECT ID, name, email, telefon, adresse, www, iban FROM ".DB_PREF."fachschaften ORDER BY name ASC;";
$result = mysql_query($query) or die("get_all_fachschaften: Anfrage fehlgeschlagen: " . mysql_error());
while($row = mysql_fetch_array($result)){
      $id		= $row['ID'];
      $name		= $row['name'];
      $email	= $row['email'];
      $telefon	= $row['telefon'];
      $adresse	= $row['adresse'];
      $www		= $row['www'];
      $iban		= $row['iban'];
      
	echo "<h2>$name</h2>\n<ul>\n";
	
	echo "<li><b>E-Mail-Adresse:</b> $email</li>\n";
	echo "<li><b>Telefonnummer:</b> $telefon</li>\n";
	echo "<li><b>Adresse: </b> $adresse</li>\n";
	echo "<li><b>Webseite: </b> $www</li>\n";
	echo "<li><b>IBAN: </b> <span class='iban'>$iban</span></li>\n";
	
	echo "</ul>\n\n";
}
	
db_close($link);
?>
<script type="text/javascript">
	var ibanpassword = '';
	var ibanlocked = true;
</script>
</body>
</html>