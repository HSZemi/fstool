<?php

/*
 * The first two methods defined in this file are required to manage a connection
 * with the database. 
 */
 
include 'config.php';


function db_connect(){
	// establish connection with the database
	$link = mysql_connect("localhost", DB_USER, DB_PASS)
	or die("Keine Verbindung möglich: " . mysql_error());

	mysql_select_db(DB_NAME) or die("Auswahl der Datenbank fehlgeschlagen</br>");
	
	// UTF8 ist cool!
	$query = "set names 'utf8';";
      $result = mysql_query($query);
      if(!$result){
            echo "create_post: Anfrage fehlgeschlagen: " . mysql_error() . "<br/>";
      }
	
	
	return $link;
}

function db_close($link){
	mysql_close($link);
}


function validate_string_for_mysql_html($string){
      return mysql_real_escape_string(htmlspecialchars($string, ENT_QUOTES | ENT_HTML401));
	//return mysql_real_escape_string($string);
}

/*
 *  helper functions
 */
 
function get_studiengang_by_id($id){
	$id = intval($id);
	$query = "SELECT ID, name FROM ".DB_PREF."studiengaenge WHERE ID = ".$id.";";
	$result = mysql_query($query) or die("get_studiengang_by_id: Anfrage fehlgeschlagen: " . mysql_error());
	if($row = mysql_fetch_array($result)){
		return $row['name'];
	} else {
		return '';
	}
}

function get_fs_for_studiengang($id){
	$id = intval($id);
	$fsen = Array();
	$query = "SELECT ID, name FROM ".DB_PREF."fachschaften 
		JOIN ".DB_PREF."zuordnung ON ".DB_PREF."zuordnung.fachschaft = ".DB_PREF."fachschaften.ID 
		WHERE ".DB_PREF."zuordnung.studiengang = ".$id." ORDER BY name ASC;";
	$result = mysql_query($query) or die("get_fs_for_studiengang: Anfrage fehlgeschlagen: " . mysql_error());
	while($row = mysql_fetch_array($result)){
		$fsen[] = $row;
	}
	if(sizeof($fsen)==0){
		return false;
	} else {
		return $fsen;
	}
}

function get_studiengaenge_for_fs($id){
	$id = intval($id);
	$studiengaenge = Array();
	$query = "SELECT ID, name FROM ".DB_PREF."studiengaenge 
		JOIN ".DB_PREF."zuordnung ON ".DB_PREF."zuordnung.studiengang = ".DB_PREF."studiengaenge.ID 
		WHERE ".DB_PREF."zuordnung.fachschaft = ".$id." ORDER BY name ASC;";
	$result = mysql_query($query) or die("get_studiengaenge_for_fs: Anfrage fehlgeschlagen: " . mysql_error());
	while($row = mysql_fetch_array($result)){
		$studiengaenge[] = $row;
	}
	if(sizeof($studiengaenge)==0){
		return false;
	} else {
		return $studiengaenge;
	}
}

function print_fs_select_list(){
	$query = "SELECT ID, name FROM ".DB_PREF."fachschaften ORDER BY name ASC;";
	$result = mysql_query($query) or die("print_fs_select_list: Anfrage fehlgeschlagen: " . mysql_error());
	while($row = mysql_fetch_array($result)){
		$id		= $row['ID'];
		$name		= $row['name'];
		echo "<option value='".$id."'>".$name."</option>\n";
	}
}

function get_fs_select_list(){
	$list = '';
	$query = "SELECT ID, name FROM ".DB_PREF."fachschaften ORDER BY name ASC;";
	$result = mysql_query($query) or die("get_fs_select_list: Anfrage fehlgeschlagen: " . mysql_error());
	while($row = mysql_fetch_array($result)){
		$id		= $row['ID'];
		$name		= $row['name'];
		$list .= "<option value='".$id."'>".$name."</option>\n";
	}
	return $list;
}

function get_studiengang_select_list(){
	$list = '';
	$query = "SELECT ID, name FROM ".DB_PREF."studiengaenge ORDER BY name ASC;";
	$result = mysql_query($query) or die("get_studiengang_select_list: Anfrage fehlgeschlagen: " . mysql_error());
	while($row = mysql_fetch_array($result)){
		$id		= $row['ID'];
		$name		= $row['name'];
		$list .= "<option value='".$id."'>".$name."</option>\n";
	}
	return $list;
}

function assign_fs_to_studiengang($fsid, $studiengang_id){
	$fsid = intval($fsid);
	$studiengang_id = intval($studiengang_id);
	$query = "INSERT INTO ".DB_PREF."zuordnung(fachschaft, studiengang) VALUES ($fsid, $studiengang_id);";
	$result = mysql_query($query);
	if($result){
		return true;
	} else {
		return false;
		
	}
}

function rename_studiengang($id, $newname){
	$id = intval($id);
	$query = "UPDATE ".DB_PREF."studiengaenge SET name='$newname' WHERE ID = $id;";
	$result = mysql_query($query);
	if($result){
		return true;
	} else {
		return false;
	}
}

function rename_fs($fsid, $newname){
	$fsid = intval($fsid);
	$query = "UPDATE ".DB_PREF."fachschaften SET name='$newname' WHERE ID = $fsid;";
	$result = mysql_query($query);
	if($result){
		return true;
	} else {
		return false;
	}
}

function unjoin_fs_and_studiengang($fsid, $studiengang_id){
	$fsid = intval($fsid);
	$studiengang_id = intval($studiengang_id);
	$query = "DELETE FROM ".DB_PREF."zuordnung WHERE fachschaft=$fsid and studiengang=$studiengang_id;";
	$result = mysql_query($query);
	if($result){
		return true;
	} else {
		return false;
		
	}
}

function add_fs($name){
	$query = "INSERT INTO ".DB_PREF."fachschaften(name) VALUES ('$name')";
	$result = mysql_query($query);
	if($result){
		return true;
	} else {
		return false;
		
	}
}

function add_studiengang($name){
	$query = "INSERT INTO ".DB_PREF."studiengaenge(name) VALUES ('$name')";
	$result = mysql_query($query);
	if($result){
		return true;
	} else {
		return false;
		
	}
}

function delete_studiengang($id){
	$id = intval($id);
	$query = "SELECT fachschaft FROM ".DB_PREF."zuordnung WHERE studiengang = $id;";
	$result = mysql_query($query);
	if(mysql_fetch_array($result)){
		return false;
	}
	$query = "DELETE FROM ".DB_PREF."studiengaenge WHERE ID = $id;";
	$result = mysql_query($query);
	if($result){
		return true;
	} else {
		return false;
	}
}

function delete_fs($id){
	$id = intval($id);
	$query = "SELECT studiengang FROM ".DB_PREF."zuordnung WHERE fachschaft = $id;";
	$result = mysql_query($query);
	if(mysql_fetch_array($result)){
		return false;
	}
	$query = "DELETE FROM ".DB_PREF."fachschaften WHERE ID = $id;";
	$result = mysql_query($query);
	if($result){
		return true;
	} else {
		return false;
	}
}

?>