<?php

include 'lib/config.php';
include 'lib/db.php';


$link = db_connect();
$alert = '';

if(isset($_POST['fsid'])){
	$fsid = intval($_POST['fsid']);


	if(isset($_POST['assign'])){
		// Fachschaft zuweisen
		$studiengang_id = intval($_POST['new_studiengangid']);
		if(assign_fs_to_studiengang($fsid, $studiengang_id)){
			$alert = "		<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			Die Fachschaft wurde erfolgreich zugeordnet.
		</div>";
		} else {
			$alert = "		<div class='alert alert-danger alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<strong>Fehler!</strong> Die Fachschaft mit der ID '$fsid' konnte nicht dem Studiengang mit der ID '$studiengang_id' zugeordnet werden. Besteht diese Zuordnung evtl. bereits?
		</div>";
		}
		
	} elseif(isset($_POST['rename'])) {
		// Studiengang umbenennen
		$newname = validate_string_for_mysql_html($_POST['inputNewname']);
		if(rename_fs($fsid, $newname)){
			$alert = "		<div class='alert alert-warning alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			Die Fachschaft wurde in <strong>$newname</strong> umbenannt.
		</div>";
		} else {
			$alert = "		<div class='alert alert-danger alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<strong>Fehler!</strong> Die Fachschaft konnte nicht in '$newname' umbenannt werden. Eventuell existiert bereits eine Fachschaft mit diesem Namen?
		</div>";
		}
		
	} elseif(isset($_POST['update'])){
		// Telefon, Adresse und E-Mail aktualisieren
		$phone = validate_string_for_mysql_html($_POST['inputPhone']);
		$address = validate_string_for_mysql_html($_POST['inputAddress']);
		$email = validate_string_for_mysql_html($_POST['inputEmail']);
		
		if(set_fs_contactdata($fsid, $phone, $address, $email)){
			$alert = "		<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			Die Kontaktdaten der Fachschaft wurden aktualisiert.
		</div>";
		} else {
			$alert = "		<div class='alert alert-danger alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<strong>Fehler!</strong> Die Kontaktdaten der Fachschaft konnten nicht aktualisiert werden.
		</div>";
		}
		
	} elseif(isset($_POST['delete'])){
		// Studiengang löschen
		if(delete_fs($fsid)){
			$alert = "		<div class='alert alert-warning alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			Die Fachschaft mit der ID <strong>$fsid</strong> wurde gelöscht.
		</div>";
		} else {
			$alert = "		<div class='alert alert-danger alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<strong>Fehler!</strong> Die Fachschaft mit der ID '$fsid' konnte nicht gelöscht werden. Möglicherweise ist ihr noch ein Studiengang zugeordnet?
		</div>";
		}
	} elseif(isset($_POST['studiengang_to_delete'])){
		// Studiengang entfernen
		$studiengang_id = intval($_POST['studiengang_to_delete']);
		if(unjoin_fs_and_studiengang($fsid, $studiengang_id)){
			$alert = "		<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			Die Zuordnung wurde erfolgreich aufgehoben.
		</div>";
		} else {
			$alert = "		<div class='alert alert-danger alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<strong>Fehler!</strong> Die Zuordnung von der Fachschaft mit der ID '$fsid' zum Studiengang mit der ID '$studiengang_id' konnte nicht aufgehoben werden.
		</div>";
		}
	}
} elseif(isset($_POST['add_fs'])){
	$fsname = validate_string_for_mysql_html($_POST['inputFSName']);
	if(add_fs($fsname)){
		$alert = "		<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			Neue Fachschaft <strong>$fsname</strong> wurde angelegt.
		</div>";
	} else {
		$alert = "		<div class='alert alert-danger alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<strong>Fehler!</strong> Fachschaft '$fsname' konnte nicht angelegt werden. Möglicherweise existiert bereits eine Fachschaft mit diesem Namen?
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
	<title>fstool - Fachschaften</title>
	
	<style>
	body {
		padding-top: 20px;
		padding-bottom: 20px;
	}
	.navbar {
		margin-bottom: 20px;
	}
	.show-edit-area {
		cursor: pointer;
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
            <a class="navbar-brand" href="index.php">fstool</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="fachschaften.php">Fachschaften</a></li>
              <li><a href="studiengaenge.php">Studiengänge</a></li>
              <li><a href="probleme.php">Probleme</a></li>
            </ul>
            
		<form class="navbar-form navbar-left" role="form" id="newfsform" action="fachschaften.php" method="post">
			<div class="form-group">
				<input type="text" class="form-control" name="inputFSName" placeholder="Neue Fachschaft">
			<button type="submit" name="add_fs" class="btn btn-default">Hinzufügen</button>
			</div>
		</form>
			
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Export <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="fachschaften-plain.php" target="_blank">Fachschaften plain</a></li>
					<li><a href="studiengaenge-plain.php" target="_blank">Studiengänge plain</a></li>
					<li><a href="fachschaften-plain.php?fullnames" target="_blank">Fachschaften plain (fullnames)</a></li>
					<li><a href="studiengaenge-plain.php?fullnames" target="_blank">Studiengänge plain (fullnames)</a></li>
					<li class="divider"></li>
					<li><a href="fachschaften-md.php">Fachschaften Markdown</a></li>
					<li><a href="studiengaenge-md.php">Studiengänge Markdown</a></li>
					<li><a href="fachschaften-md.php?fullnames">Fachschaften Markdown (fullnames)</a></li>
					<li><a href="studiengaenge-md.php?fullnames">Studiengänge Markdown (fullnames)</a></li>
				</ul>
			</li>
		</ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
      
      <?php 
      
	echo $alert;
	
      
      $studiengang_select_list = get_studiengang_select_list();
      
      $query = "SELECT ID, name, satzung, email, telefon, adresse FROM ".DB_PREF."fachschaften ORDER BY name ASC;";
      $result = mysql_query($query) or die("get_all_fs: Anfrage fehlgeschlagen: " . mysql_error());
      while($row = mysql_fetch_array($result)){
            $fsid		= $row['ID'];
            $fsname	= $row['name'];
            $satzung	= $row['satzung'];
            $email	= $row['email'];
            $telefon	= $row['telefon'];
            $adresse	= $row['adresse'];
            
            echo '	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title" id="'.$fsid.'"><a href="#'.$fsid.'"><span class="glyphicon glyphicon-tag"></span>
</a> '.$fsname.'</h3>
		</div>
		<div class="panel-body">
		';
		
		
		echo '		<form class="" role="form" action="fachschaften.php#'.$fsid.'" method="post">
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
		</form>';
		
		echo '<form class="form-inline" role="form" action="fachschaften.php#'.$fsid.'" method="post">
			<input type="hidden" name="fsid" value="'.$fsid.'" />
		
		<div class="row">
			<div class="col-md-6">';
		
		if(is_null($satzung)){
			echo '	<p><a class="btn btn-warning" disabled="disabled" href="#">Keine Satzung vorhanden</a></p>
		';
		} else {
			echo '	<p><a class="btn btn-success" href="'.$satzung.'">Fachschaftssatzung</a></p>
		';
		}
		
		echo '</div>
		<div class="col-md-6">';
		
		if(is_null($email)){
			$email = '';
		}
		
		echo '	<div class="input-group">
			<span class="input-group-addon">';
		if($email != ''){
			echo '<a href="mailto:'.$email.'"><span class="glyphicon glyphicon-envelope"></span></a>';
		} else {
			echo '<span class="glyphicon glyphicon-envelope"></span>';
		}
		echo '</span>
			<input type="text" class="form-control" placeholder="E-Mail-Adresse hier eingeben..." name="inputEmail" value="'.$email.'">
		</div>
		';
		
		echo '</div>
		</div>';
		
		echo '<div class="row">
			<div class="col-md-6">';
		
		if(is_null($adresse)){
			$adresse = '';
		}
		
		echo '	<div class="input-group">
					<span class="input-group-addon">';
		if($adresse != ''){
			echo '<a href="https://maps.google.de/maps?q='.$adresse.'" title="In Google Maps suchen" target="_blank"><span class="glyphicon glyphicon-home"></span></a>';
		} else {
			echo '<span class="glyphicon glyphicon-home"></span>';
		}
		echo '</span>
					<input type="text" class="form-control" placeholder="Adresse hier eingeben..." name="inputAddress" value="'.$adresse.'">
				</div>
		';
		
		
		echo '</div>
		<div class="col-md-6">';
		

		if(is_null($telefon)){
			$telefon = '';
		}
		
		echo '	<div class="input-group">
			<span class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></span>
			<input type="text" class="form-control" placeholder="Telefonnummer hier eingeben..." name="inputPhone" value="'.$telefon.'">
		</div>
		';
		
		
		echo '</div>
		</div>
		
		<hr style="margin-bottom:2px;"/>';
		
		echo '
		<span class="show-edit-area pull-right" style="padding-top:0px;">bearbeiten</span>
		
		<div class="edit-area">
			<div class="row" style="margin-top:5px;">
				<div class="col-lg-2">
					<button type="submit" class="btn btn-danger btn-block" name="delete">Fachschaft Löschen</button>
				</div>
				<div class="col-lg-offset-8 col-lg-2">
					<button type="submit" class="btn btn-primary btn-block" name="update">Daten aktualisieren</button>
				</div>
			</div>
			
			<div class="row" style="margin-top:5px;">
			
			<div class="col-lg-6">
				<div class="input-group">
					<select class="form-control select-studiengang" name="new_studiengangid">
						<option>hahaha</option>
					</select>
					<span class="input-group-btn">
						<button class="btn btn-default" type="submit" name="assign">Zuweisen</button>
					</span>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="input-group">
					<label class="sr-only" for="inputNewname">Umbenennen</label>
					<input type="text" class="form-control" id="inputNewname" name="inputNewname" placeholder="Neuer Name">
					<span class="input-group-btn">
						<button class="btn btn-default" type="submit" name="rename">Umbenennen</button>
					</span>
				</div><!-- /input-group -->
			</div>
			
			</div>
			
		</form>
		</div>
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
	$('.edit-area').hide();
	$('.select-studiengang').html("<?php echo $studiengang_select_list;?>");
	$('.show-edit-area').click(function() {
		$(this).hide();
		$(this).next('.edit-area').show();
	});
    </script>


  </body>
</html>
 
