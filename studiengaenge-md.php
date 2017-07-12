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
header("Content-Disposition: attachment; filename=studiengaenge-2017.md");

?>

Liste der FAKs der RFWU Bonn mit zugeordneten Fachschaften
==========================================================


<?php

$link = db_connect();


$query = "SELECT ID, name, fullname FROM ".DB_PREF."studiengaenge ORDER BY name ASC;";
$result = mysql_query($query) or die("get_all_studiengaenge: Anfrage fehlgeschlagen: " . mysql_error());
while($row = mysql_fetch_array($result)){
      $id		= $row['ID'];
      $name		= $row['name'];
      $fullname	= $row['fullname'];
      
      if($fullnames){
		underline($fullname, '-');
	} else {
		underline($name, '-');
	}
	
	$fsen = get_fs_for_studiengang($id);
	if(!$fsen){
		echo "Diese FAK ist keiner Fachschaft zugeordnet.\n\n";
	} else {
		foreach($fsen as $row){
			echo "  * ".$row['name']."\n";
		}
		echo "\n";
	}
}
	
db_close($link);
?>
</body>
</html>