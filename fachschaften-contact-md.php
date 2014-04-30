<?php

include 'lib/config.php';
include 'lib/db.php';

function underline($string, $char){
	echo $string;
	echo "\n";
	for($i = 0; $i < strlen($string); $i += 1){
		echo $char;
	}
	echo "\n";
}

header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=kontaktdaten-fachschaften-2014.md");

?>

Kontaktdaten der Fachschaften der RFWU Bonn
===========================================


<?php

$link = db_connect();


$query = "SELECT ID, name, email, telefon, adresse FROM ".DB_PREF."fachschaften ORDER BY name ASC;";
$result = mysql_query($query) or die("get_all_fachschaften: Anfrage fehlgeschlagen: " . mysql_error());
while($row = mysql_fetch_array($result)){
      $id		= $row['ID'];
      $name		= $row['name'];
      $email	= $row['email'];
      $telefon	= $row['telefon'];
      $adresse	= $row['adresse'];
      
	underline($name, '-');
	
	echo "  * __E-Mail-Adresse:__ ".$row['email']."\n";
	echo "  * __Telefonnummer:__ ".$row['telefon']."\n";
	echo "  * __Adresse:__ ".$row['adresse']."\n";
	echo "\n";

}
	
db_close($link);
?>