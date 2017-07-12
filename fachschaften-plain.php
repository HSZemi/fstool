<?php

include 'lib/config.php';
include 'lib/db.php';

$fullnames = false;
if(isset($_GET['fullnames'])){
	$fullnames = true;
}

?>
<!DOCTYPE html>
<html lang="de">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>fstool - Fachschaften - Plaintext</title>
  </head>
  <body>
  
<h1>Liste der Fachschaften der RFWU Bonn mit zugeordneten <abbr title='Fach-Abschluss-Kombinationen'>FAKs</abbr></h1>


<?php

$link = db_connect();


$query = "SELECT ID, name FROM ".DB_PREF."fachschaften ORDER BY name ASC;";
$result = mysql_query($query) or die("get_all_fachschaften: Anfrage fehlgeschlagen: " . mysql_error());
while($row = mysql_fetch_array($result)){
      $id		= $row['ID'];
      $name		= $row['name'];
      
	echo "<h2>$name</h2>\n<ul>\n";
	
	$fsen = get_studiengaenge_for_fs($id);
	if(!$fsen){
		echo "<li>Diese Fachschaft vertritt keine <abbr title='Fach-Abschluss-Kombination'>FAK</abbr>.</li>\n";
	} else {
		foreach($fsen as $row){
			if($fullnames){
				echo "<li>".$row['fullname']."</li>\n";
			} else {
				echo "<li>".$row['name']."</li>\n";
			}
		}
	}
	echo "</ul>\n\n";
}
	
db_close($link);
?>
</body>
</html>