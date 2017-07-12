<?php

include 'lib/config.php';
include 'lib/db.php';

$fullnames = false;
if(isset($_GET['fullnames'])){
	$fullnames = true;
}

function underline($string, $char){
	echo $string;
	echo "\n";
	for($i = 0; $i < strlen($string); $i += 1){
		echo $char;
	}
	echo "\n";
}

header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=fachschaften-2014.md");

?>

Liste der Fachschaften der RFWU Bonn mit zugeordneten FAKs
===================================================================


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
		echo "Diese Fachschaft vertritt keine FAK.\n\n";
	} else {
		foreach($fsen as $row){
			if($fullnames){
				echo "  * ".$row['fullname']."\n";
			} else {
				echo "  * ".$row['name']."\n";
			}
		}
		echo "\n";
	}
}
	
db_close($link);
?>