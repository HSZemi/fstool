<?php

include 'lib/config.php';
include 'lib/db.php';

$id = -1;
if(isset($_GET['id'])){
	$id = intval($_GET['id']);
}

$link = db_connect();

if(isset($_POST['assign'])){
	// Fachschaft zuweisen
	$fsid = intval($_POST['new_fsid']);
	assign_fs_to_studiengang($fsid, $id);
	
} elseif(isset($_POST['rename'])) {
	// Studiengang umbenennen
	$newname = validate_string_for_mysql_html($_POST['inputNewname']);
	rename_studiengang($id, $newname);
	
} elseif(isset($_POST['delete'])){
	// Studiengang löschen
	echo 'delete!';
}



$studiengang = get_studiengang_by_id($id);

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
              <li><a href="index.php">Fachschaften</a></li>
              <li class="active"><a href="studiengaenge.php">Studiengänge</a></li>
              <li><a href="probleme.php">Probleme</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class=""><a href="./">Einstellungen</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
      
      <div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $studiengang; ?></h3>
		</div>
		<div class="panel-body">
			<ul class="list-group">
				<li class="list-group-item list-group-item-info"><b>Fachschaft</b></li>
				
            
			<?php 
				$fsen = get_fs_for_studiengang($id);
				if(!$fsen){
					echo '<li class="list-group-item">Dieser Studiengang ist keiner Fachschaft zugeordnet.</li>
				';
				} else {
					foreach($fsen as $row){
						echo '<li class="list-group-item">'.$row['name'].' <button class="close" title="Diese Fachschaft entfernen">&times;</button></li>
						';
					}
				}
			?>
		</ul>
		
		<form class="form-inline" role="form" id="studiengangform" action="studiengang.php?id=<?php echo $id; ?>" method="post">
			<div class="col-lg-5">
				<div class="input-group">
					<select class="form-control" name="new_fsid">
						<?php print_fs_select_list(); ?>
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
      
      
      <?php
      db_close($link);
      ?>

    </div> <!-- /container -->


  </body>
</html>
 
