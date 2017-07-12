<?php

include 'lib/config.php';
include 'lib/db.php';


header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=faks.csv");

$link = db_connect();


$query = "SELECT ID, name, fullname FROM ".DB_PREF."studiengaenge ORDER BY name ASC;";
$result = mysql_query($query) or die("get_all_studiengaenge: Anfrage fehlgeschlagen: " . mysql_error());
while($row = mysql_fetch_array($result)){
      $id		= $row['ID'];
      $name		= $row['name'];
      $fullname	= $row['fullname'];
      
	$fsen = get_fs_for_studiengang($id);
	if(!$fsen){
		echo "$fullname;NULL\n";
	} else {
		foreach($fsen as $row){
			echo "$fullname;{$row['name']}\n";
		}
	}
}
	
db_close($link);
?>