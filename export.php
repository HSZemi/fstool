<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>fstool - Exportieren</title>

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
		border-color: #777;
	}
	
	.panel-primary > .panel-heading {
		color: #FFF;
		background-color: #777;
		border-color: rgb(77, 77, 77);
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
              <li><a href="studiengaenge.php"><abbr title='Fach-Abschluss-Kombinationen'>FAKs</abbr></a></li>
              <li><a href="probleme.php">Probleme</a></li>
            </ul>
			
		<ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="export.php">Exportieren</a></li>
		</ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
      
      <div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Daten exportieren</h3>
		</div>
		<div class="panel-body">
			<h4>Kontaktdaten</h4>
			<ul>
				<li><a href="fachschaften-contact-plain.php" target="_blank">Kontaktdaten plain</a></li>
				<li><a href="fachschaften-contact-plain-iban.php" target="_blank">Kontaktdaten plain mit IBAN</a></li>
				<li><a href="fachschaften-contact-md.php" target="_blank">Kontaktdaten Markdown</a></li>
			</ul>
			
			<h4>Liste der Fachschaften <small>(mit <abbr title='Fach-Abschluss-Kombinationen'>FAKs</abbr>)</small></h4>
			<ul>
				<li><a href="fachschaften-plain.php" target="_blank">Fachschaften plain</a></li>
				<li><a href="fachschaften-plain.php?fullnames" target="_blank"><b>Fachschaften plain (fullnames)</b></a></li>
				<li><a href="fachschaften-md.php">Fachschaften Markdown</a></li>
				<li><a href="fachschaften-md.php?fullnames">Fachschaften Markdown (fullnames)</a></li>
			</ul>
			
			<h4>Liste der <abbr title='Fach-Abschluss-Kombinationen'>FAKs</abbr> <small>(mit Fachschaften)</small></h4>
			<ul>
				<li><a href="studiengaenge-plain.php" target="_blank"><abbr title='Fach-Abschluss-Kombinationen'>FAKs</abbr> plain</a></li>
				<li><a href="studiengaenge-plain.php?fullnames" target="_blank"><abbr title='Fach-Abschluss-Kombinationen'>FAKs</abbr> plain (fullnames)</a></li>
				<li><a href="studiengaenge-md.php"><abbr title='Fach-Abschluss-Kombinationen'>FAKs</abbr> Markdown</a></li>
				<li><a href="studiengaenge-md.php?fullnames"><abbr title='Fach-Abschluss-Kombinationen'>FAKs</abbr> Markdown (fullnames)</a></li>
			</ul>
		</div>
	</div>

    </div> <!-- /container -->


  </body>
</html>
 
