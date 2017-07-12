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
	<title>fstool - Studiengänge - Markdown</title>
  </head>
  <body>
  
Liste der Studiengänge der RFWU Bonn mit zugeordneten Fachschaften<br>
==================================================================<br><br>


<?php

$link = db_connect();


$query = "SELECT ID, name FROM ".DB_PREF."studiengaenge ORDER BY name ASC;";
$result = mysql_query($query) or die("get_all_studiengaenge: Anfrage fehlgeschlagen: " . mysql_error());
while($row = mysql_fetch_array($result)){
      $id		= $row['ID'];
      $name		= $row['name'];
      
	underline($name, '-');
	
	$fsen = get_fs_for_studiengang($id);
	if(!$fsen){
		echo "Dieser Studiengang ist keiner Fachschaft zugeordnet.<br>\n<br>\n";
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