<?php

include 'lib/config.php';
include 'lib/db.php';

$fullnames = false;
if(isset($_GET['fullnames'])){
	$fullnames = true;
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
  
<h1>Liste der Studiengänge der RFWU Bonn mit zugeordneten Fachschaften</h1>


<?php

$link = db_connect();


$query = "SELECT ID, name, fullname FROM ".DB_PREF."studiengaenge ORDER BY name ASC;";
$result = mysql_query($query) or die("get_all_studiengaenge: Anfrage fehlgeschlagen: " . mysql_error());
while($row = mysql_fetch_array($result)){
      $id		= $row['ID'];
      $name		= $row['name'];
      $fullname	= $row['fullname'];
      
      if($fullnames){
		echo "<h2>$fullname</h2>\n<ul>\n";
	} else {
		echo "<h2>$name</h2>\n<ul>\n";
	}
	
	$fsen = get_fs_for_studiengang($id);
	if(!$fsen){
		echo "<li>Dieser Studiengang ist keiner Fachschaft zugeordnet.</li>\n";
	} else {
		foreach($fsen as $row){
			echo "<li>".$row['name']."</li>\n";
		}
		echo "</ul>\n\n";
	}
}
	
db_close($link);
?>
</body>
</html>