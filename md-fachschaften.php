<?php

include 'lib/config.php';
include 'lib/db.php';


function underline($string, $char){
	echo $string;
	echo "<br>\n";
	for($i = 0; $i < strlen($string); $i += 1){
		echo $char;
	}
	echo "<br>\n";
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>fstool - Fachschaften - Markdown</title>
  </head>
  <body>
  
Liste der Fachschaften der RFWU Bonn mit zugeordneten Studiengängen<br>
===================================================================<br><br>


<?php

$link = db_connect();


$query = "SELECT ID, name FROM ".DB_PREF."fachschaften ORDER BY name ASC;";
$result = mysql_query($query) or die("get_all_fachschaften: Anfrage fehlgeschlagen: " . mysql_error());
while($row = mysql_fetch_array($result)){
      $id		= $row['ID'];
      $name		= $row['name'];
      
	underline($name, '-');
	
	$fsen = get_studiengaenge_for_fs($id);
	if(!$fsen){
		echo "Diese Fachschaft vertritt keinen Studiengang.<br>\n<br>\n";
	} else {
		foreach($fsen as $row){
			echo "  * ".$row['name']."<br>\n";
		}
		echo "<br>\n";
	}
}
	
db_close($link);
?>
</body>
</html>