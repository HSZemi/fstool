<?php

include 'lib/config.php';
include 'lib/db.php';


$link = db_connect();


if(isset($_POST['id'])){
	$studiengang_id = intval($_POST['id']);


	if(isset($_POST['assign'])){
		// Fachschaft zuweisen
		$fsid = intval($_POST['new_fsid']);
		assign_fs_to_studiengang($fsid, $studiengang_id);
		
	} elseif(isset($_POST['rename'])) {
		// Studiengang umbenennen
		$newname = validate_string_for_mysql_html($_POST['inputNewname']);
		rename_studiengang($studiengang_id, $newname);
		
	} elseif(isset($_POST['delete'])){
		// Studiengang löschen
		delete_studiengang($studiengang_id);
	} elseif(isset($_POST['fs_to_delete'])){
		// FS entfernen
		$fsid = intval($_POST['fs_to_delete']);
		unjoin_fs_and_studiengang($fsid, $studiengang_id);
	}
} elseif(isset($_POST['createnewstudiengang'])){
	// neuen Studiengang erstellen
	$name = validate_string_for_mysql_html($_POST['inputStudiengangname']);
	add_studiengang($name);
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>fstool - Index</title>

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
	
	<style>
	body {
		padding-top: 20px;
		padding-bottom: 20px;
	}
	.navbar {
		margin-bottom: 20px;
	}
	
	.panel-primary{
		border-color: #34812c;
	}
	
	.panel-primary > .panel-heading {
		color: #FFF;
		background-color: #34812C;
		border-color: rgb(52, 129, 44);
	}
	</style>
	
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
              <li><a href="index.php">Fachschaften</a></li>
              <li class="active"><a href="studiengaenge.php">Studiengänge</a></li>
              <li><a href="probleme.php">Probleme</a></li>
            </ul>
            
            <form class="navbar-form navbar-left" role="form" id="newfsform" action="studiengaenge.php" method="post">
			<div class="form-group">
				<input type="text" class="form-control" name="inputStudiengangname" placeholder="Neuer Studiengang">
				<button type="submit" name="createnewstudiengang" value="0" class="btn btn-default">Hinzufügen</button>
			</div>
		</form>
            
            <ul class="nav navbar-nav navbar-right">
              <li class=""><a href="./">Einstellungen</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
      
      <?php 
      $fs_select_list = get_fs_select_list();
      
	$query = "SELECT ID, name FROM ".DB_PREF."studiengaenge ORDER BY name ASC;";
      $result = mysql_query($query) or die("get_all_studiengaenge: Anfrage fehlgeschlagen: " . mysql_error());
      while($row = mysql_fetch_array($result)){
            $id		= $row['ID'];
            $name		= $row['name'];
            
            echo '	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title" id="'.$id.'"><a href="#'.$id.'"><span class="glyphicon glyphicon-tag"></span>
</a> '.$name.'</h3>
		</div>
		<div class="panel-body">
		';
		
		echo '		<form class="" role="form" action="studiengaenge.php#'.$id.'" method="post">
			<input type="hidden" name="id" value="'.$id.'" />
			<div class="list-group">
				';
            
            $fsen = get_fs_for_studiengang($id);
		if(!$fsen){
		echo '<a class="list-group-item list-group-item-warning"">Dieser Studiengang ist keiner Fachschaft zugeordnet.</a>
		';
		} else {
			echo '<a class="list-group-item list-group-item-info"><b>Fachschaft</b></a>
			';
			foreach($fsen as $row){
				echo '<a class="list-group-item" href="index.php#'.$row['ID'].'">'.$row['name'].' <button class="close" type="submit" name="fs_to_delete" value="'.$row['ID'].'" title="Diese Fachschaft entfernen">&times;</button></a>
				';
			}
		}
		echo '</div>
		</form>
		<form class="form-inline" role="form" id="studiengangform" action="studiengaenge.php#'.$id.'" method="post">
			<input type="hidden" name="id" value="'.$id.'" />
			<div class="col-lg-5">
				<div class="input-group">
					<select class="form-control" name="new_fsid">
						'.$fs_select_list.'
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
			<button type="submit" class="btn btn-danger" name="delete">Studiengang Löschen</button>
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
 
