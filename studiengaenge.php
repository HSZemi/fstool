<?php

include 'lib/config.php';
include 'lib/db.php';


$link = db_connect();

$alert = '';

if(isset($_POST['id'])){
	$studiengang_id = intval($_POST['id']);


	if(isset($_POST['assign'])){
		// Fachschaft zuweisen
		$fsid = intval($_POST['new_fsid']);
		if(assign_fs_to_studiengang($fsid, $studiengang_id)){
			$alert = "		<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			Die FAK wurde erfolgreich zugeordnet.
		</div>";
		} else {
			$alert = "		<div class='alert alert-danger alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<strong>Fehler!</strong> Die FAK mit der ID '$studiengang_id' konnte nicht der Fachschaft mit der ID '$fsid' zugeordnet werden. Besteht diese Zuordnung evtl. bereits?
		</div>";
		}
		
	} elseif(isset($_POST['rename'])) {
		// FAK umbenennen
		$newname = validate_string_for_mysql_html($_POST['inputNewname']);
		$newfullname = validate_string_for_mysql_html($_POST['inputNewfullname']);
		if(rename_studiengang2($studiengang_id, $newname, $newfullname)){
			$alert = "		<div class='alert alert-warning alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			Die FAK wurde in <strong>$newname/$newfullname</strong> umbenannt.
		</div>";
		} else {
			$alert = "		<div class='alert alert-danger alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<strong>Fehler!</strong> Die FAK konnte nicht in '$newname/$newfullname' umbenannt werden. Eventuell existiert bereits eine FAK mit diesem Namen?
		</div>";
		}
		
	} elseif(isset($_POST['delete'])){
		// FAK löschen
		if(delete_studiengang($studiengang_id)){
			$alert = "		<div class='alert alert-warning alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			Die FAK mit der ID <strong>$studiengang_id</strong> wurde gelöscht.
		</div>";
		} else {
			$alert = "		<div class='alert alert-danger alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<strong>Fehler!</strong> Die FAK mit der ID '$studiengang_id' konnte nicht gelöscht werden. Möglicherweise ist sie noch einer Fachschaft zugeordnet?
		</div>";
		}
	} elseif(isset($_POST['fs_to_delete'])){
		// FS entfernen
		$fsid = intval($_POST['fs_to_delete']);
		if(unjoin_fs_and_studiengang($fsid, $studiengang_id)){
			$alert = "		<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			Die Zuordnung wurde erfolgreich aufgehoben.
		</div>";
		} else {
			$alert = "		<div class='alert alert-danger alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<strong>Fehler!</strong> Die Zuordnung der FAK mit der ID '$studiengang_id' zur Fachschaft mit der ID '$fsid' konnte nicht aufgehoben werden.
		</div>";
		}
	}
} elseif(isset($_POST['createnewstudiengang'])){
	// neuen Studiengang erstellen
	$name = validate_string_for_mysql_html($_POST['inputStudiengangname']);
	$fullname = validate_string_for_mysql_html($_POST['inputStudiengangfullname']);
	if(add_studiengang2($name, $fullname)){
		$alert = "		<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			Neue FAK <strong>$name</strong> wurde angelegt.
		</div>";
	} else {
		$alert = "		<div class='alert alert-danger alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<strong>Fehler!</strong> FAK '$name' konnte nicht angelegt werden. Möglicherweise existiert bereits eine FAK mit diesem Namen?
		</div>";
	}
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>fstool - FAKs</title>

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
            <a class="navbar-brand" href="index.php">fstool</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="fachschaften.php">Fachschaften</a></li>
              <li class="active"><a href="studiengaenge.php"><abbr title='Fach-Abschluss-Kombinationen'>FAKs</abbr></a></li>
              <li><a href="probleme.php">Probleme</a></li>
            </ul>
            
            <form class="navbar-form navbar-left" role="form" id="newfsform" action="studiengaenge.php" method="post">
			<div class="form-group">
				<input type="text" class="form-control" name="inputStudiengangname" placeholder="Kurzname">
				<input type="text" class="form-control" name="inputStudiengangfullname" placeholder="Vollständiger Name">
				<button type="submit" name="createnewstudiengang" value="0" class="btn btn-default">Hinzufügen</button>
			</div>
		</form>
			
		<ul class="nav navbar-nav navbar-right">
              <li><a href="export.php">Exportieren</a></li>
		</ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
      
      
      <?php 
	
	echo $alert;
	
	
      $fs_select_list = get_fs_select_list();
      
	$query = "SELECT ID, name, fullname FROM ".DB_PREF."studiengaenge ORDER BY name ASC;";
      $result = mysql_query($query) or die("get_all_studiengaenge: Anfrage fehlgeschlagen: " . mysql_error());
      while($row = mysql_fetch_array($result)){
            $id		= $row['ID'];
            $name		= $row['name'];
            $fullname		= $row['fullname'];
            
            echo '	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title" id="'.$id.'"><a href="#'.$id.'"><span class="glyphicon glyphicon-tag"></span>
		</a> '.$name.'</h3>
		</div>
		<div class="panel-body">
		';
		
		echo "<p>$fullname</p>";
		
		echo '		<form class="" role="form" action="studiengaenge.php#'.$id.'" method="post">
			<input type="hidden" name="id" value="'.$id.'" />
			<div class="list-group">
				';
            
            $fsen = get_fs_for_studiengang($id);
		if(!$fsen){
		echo '<a class="list-group-item list-group-item-warning"">Diese FAK ist keiner Fachschaft zugeordnet.</a>
		';
		} else {
			echo '<a class="list-group-item list-group-item-info"><b>Fachschaft</b></a>
			';
			foreach($fsen as $row){
				echo '<a class="list-group-item" href="fachschaften.php#'.$row['ID'].'">'.$row['name'].' <button class="close" type="submit" name="fs_to_delete" value="'.$row['ID'].'" title="Diese Fachschaft entfernen">&times;</button></a>
				';
			}
		}
		echo '</div>
		</form>
		<form class="form-inline" role="form" id="studiengangform" action="studiengaenge.php#'.$id.'" method="post">
			<input type="hidden" name="id" value="'.$id.'" />
			<div class="col-lg-5">
				<div class="input-group">
					<select class="form-control select-fs" name="new_fsid">
					</select>
					<span class="input-group-btn">
						<button class="btn btn-default" type="submit" name="assign">Zuweisen</button>
					</span>
				</div>
			</div>
			<div class="col-lg-5">
				<div class="input-group">
					<label class="sr-only" for="inputNewname">Umbenennen</label>
					<input type="text" class="form-control" id="inputNewname" name="inputNewname" placeholder="Neuer Kurzname">
					<input type="text" class="form-control" id="inputNewfullname" name="inputNewfullname" placeholder="Neuer vollst. Name">
					<span class="input-group-btn">
						<button class="btn btn-default" style="height:68px;" type="submit" name="rename">Umbenennen</button>
					</span>
				</div><!-- /input-group -->
			</div>
			<button type="submit" class="btn btn-danger" name="delete">FAK Löschen</button>
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

    <script type="text/javascript">
	$('.select-fs').html("<?php echo $fs_select_list;?>");
    </script>


  </body>
</html>
 
