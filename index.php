<?php

include 'lib/config.php';
include 'lib/db.php';


$link = db_connect();

if(isset($_POST['fsid'])){
	$fsid = intval($_POST['fsid']);


	if(isset($_POST['assign'])){
		// Fachschaft zuweisen
		$studiengang_id = intval($_POST['new_studiengangid']);
		assign_fs_to_studiengang($fsid, $studiengang_id);
		
	} elseif(isset($_POST['rename'])) {
		// Studiengang umbenennen
		$newname = validate_string_for_mysql_html($_POST['inputNewname']);
		rename_fs($fsid, $newname);
		
	} elseif(isset($_POST['delete'])){
		// Studiengang löschen
		delete_fs($fsid);
	} elseif(isset($_POST['studiengang_to_delete'])){
		// Studiengang entfernen
		$studiengang_id = intval($_POST['studiengang_to_delete']);
		unjoin_fs_and_studiengang($fsid, $studiengang_id);
	}
} elseif(isset($_POST['add_fs'])){
	$fsname = validate_string_for_mysql_html($_POST['inputFSName']);
	add_fs($fsname);
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>fstool - Index</title>
	
	<style>
	body {
		padding-top: 20px;
		padding-bottom: 20px;
	}
	.navbar {
		margin-bottom: 20px;
	}
	</style>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
  </head>
  <body>
	<div class="container">

      <!-- Static navbar -->
      <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">fstool</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="index.php">Fachschaften</a></li>
              <li><a href="studiengaenge.php">Studiengänge</a></li>
              <li><a href="probleme.php">Probleme</a></li>
            </ul>
            
		<form class="navbar-form navbar-left" role="form" id="newfsform" action="index.php" method="post">
			<div class="form-group">
				<input type="text" class="form-control" name="inputFSName" placeholder="Neue Fachschaft">
			<button type="submit" name="add_fs" class="btn btn-default">Hinzufügen</button>
			</div>
		</form>
			
            <ul class="nav navbar-nav navbar-right">
              <li class=""><a href="./">Einstellungen</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
      
      <?php 
      
      $studiengang_select_list = get_studiengang_select_list();
      
      $query = "SELECT ID, name, satzung FROM ".DB_PREF."fachschaften ORDER BY name ASC;";
      $result = mysql_query($query) or die("get_all_fs: Anfrage fehlgeschlagen: " . mysql_error());
      while($row = mysql_fetch_array($result)){
            $fsid		= $row['ID'];
            $fsname	= $row['name'];
            $satzung	= $row['satzung'];
            
            echo '	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title" id="'.$fsid.'"><a href="#'.$fsid.'"><span class="glyphicon glyphicon-tag"></span>
</a> '.$fsname.'</h3>
		</div>
		<div class="panel-body">
		';
		
		/*if($satzung != ''){
			echo '	<p><a class="btn btn-success" href="'.$satzung.'">Satzung herunterladen</a></p>
		';
		} else {
			echo '	<p><a class="btn btn-warning" disabled="disabled" href="#">keine Satzung vorhanden</a></p>
		';
		}*/
		
		echo '		<form class="" role="form" action="index.php#'.$fsid.'" method="post">
			<input type="hidden" name="fsid" value="'.$fsid.'" />
			<div class="list-group">
				';
            
            $studiengaenge = get_studiengaenge_for_fs($fsid);
		if(!$studiengaenge){
		echo '<a class="list-group-item list-group-item-warning"">Diese Fachschaft vertritt keinen Studiengang.</a>
		';
		} else {
			echo '<a class="list-group-item list-group-item-success"><b>Studiengänge</b></a>
			';
			foreach($studiengaenge as $row){
				echo '<a class="list-group-item" href="studiengaenge.php#'.$row['ID'].'">'.$row['name'].' <button class="close" type="submit" name="studiengang_to_delete" value="'.$row['ID'].'" title="Diesen Studiengang entfernen">&times;</button></a>
				';
			}
		}
		echo '</div>
		</form>
		<form class="form-inline" role="form" action="index.php#'.$fsid.'" method="post">
			<input type="hidden" name="fsid" value="'.$fsid.'" />
			<div class="col-lg-5">
				<div class="input-group">
					<select class="form-control" name="new_studiengangid">
						'.$studiengang_select_list.'
					</select>
					<span class="input-group-btn">
						<button class="btn btn-default" type="submit" name="assign">Zuweisen</button>
					</span>
				</div>
			</div>
			<div class="col-lg-5">
				<div class="input-group">
					<label class="sr-only" for="inputNewname">Umbenennen</label>
					<input type="text" class="form-control" id="inputNewname" name="inputNewname" placeholder="Neuer Name">
					<span class="input-group-btn">
						<button class="btn btn-default" type="submit" name="rename">Umbenennen</button>
					</span>
				</div><!-- /input-group -->
			</div>
			<button type="submit" class="btn btn-danger" name="delete">Fachschaft Löschen</button>
		</form>
		</div>
	</div>
	
	';
      }
      
      
      ?>
      
      
      <?php
      db_close($link);
      ?>

    </div> <!-- /container -->


  </body>
</html>
 
