<?php

include 'lib/config.php';
include 'lib/db.php';

$studiengaenge = ['Agrarwissenschaft (LA BA Berufskolleg)',
'Agrarwissenschaften (B.Sc., M.Sc., Diplom, Promotion)',
'Agric. and Food Economics (M.Sc.)',
'Agric.Science Trop/ Subtr. (M.Sc.)',
'Ägyptologie (M.A., Promotion)',
'Allg.Sprachwissenschaft (Promotion)',
'Ält.u.Neu.Germanistik (Promotion)',
'Altam. u. Ethnologie (B.A.)',
'Alt-Amerikanistik (Promotion)',
'Altamerikanistik/ Ethnol. (M.A.)',
'Alte Geschichte (Promotion)',
'Alt-Kath. u. Ökum. Theol. (M.A.)',
'Altkath.-Theologie (Kirchl.Ex.)',
'Angl/ Ameri:Lit.u.Kultwiss (Promotion)',
'Angl/ Amerikan.:Sprachwiss (Promotion)',
'Anglistik II (Promotion)',
'Anglistik/ Amerik.Spr. (Promotion)',
'Anglistik/ Neuere engl.Lit (Promotion)',
'Applied Linguistics (M.A.)',
'Arabistik (Promotion)',
'Archäologien (B.A.)',
'Arzneimittelforschung (M.Sc.)',
'Arzneimittelwiss. (Promotion)',
'Asienwissenschaften (B.A., M.A.)',
'Astronomie/ Astrophysik (Promotion, Promotion o.Ab.Astronomie)',
'Astrophysik (M.Sc.)',
'Biologie (B.Sc., Diplom, Promotion)',
'Biologie (LA BA Gym Ge)',
'Chemie (B.Sc., M.Sc., Diplom, Promotion)',
'Chemie (LA BA Gym Ge)',
'Christl.Archäol. (Promotion)',
'Computational LifeScience (Promotion)',
'Computer Science (M.Sc.)',
'Deutsch (LA BA Gym Ge)',
'Deutsches Recht (Master of Laws)',
'Deutsch-Ital. Studien (B.A., M.A.)',
'Deutschkurs (Sprachpr.)',
'Drug Regulatory Affairs (Master)',
'Dt.-Franz. Studien (B.A., M.A.)',
'Dt.-Italien. Forschungen (Promotion)',
'Dt.Spr.u.ältere dt.Lit. (Promotion)',
'E H W (Diplom, Promotion)',
'Economics (M.Sc.)',
'Ecumenical Studies (M.A.)',
'Englisch (LA BA Gym Ge)',
'Englische Philologie (Promotion)',
'English Lit. and Cultures (M.A.)',
'English Studies (B.A.)',
'Entwicklungsforschung (Promotion)',
'Ernaehrungswiss. (Promotion)',
'Ernährungs- u.Lebmitwiss. (B.Sc., M.Sc., Promotion)',
'Ernährungs-u.Hauswirtwis. (LA BA Berufskolleg)',
'Erziehungswiss. (Promotion)',
'Ethnologie (Promotion)',
'Ethnologie-Altamerikan. (Promotion)',
'European Studies (Master)',
'Ev. Theol. u. Hermeneutik (B.A.)',
'Evaluation (Master)',
'Evang.Theologie (Kirchl.Ex., Magister Theologiae)',
'Evangel. Religionslehre (LA BA Gym Ge)',
'Evangelische Theologie (M.A.)',
'Französisch (LA BA Gym Ge)',
'Französistik (B.A.)',
'Frg.Arch.u.Arch.Röm.Prov. (M.A.)',
'Geodäsie (Promotion)',
'Geodäsie u.Geoinformation (B.Sc., M.Sc., Promotion)',
'Geographie (B.A.)',
'Geographie (B.Sc., M.Sc., Diplom, Promotion)',
'Geographie (LA BA Gym Ge)',
'Geography Environm. Risks (M.Sc.)',
'Geologie/ Paläontologie (Diplom, Promotion)',
'Geophysik (Promotion)',
'Geowissenschaften (B.Sc., M.Sc., Promotion)',
'German/ Comp. Literature (M.A.)',
'Germanistik (B.A., M.A.)',
'Germanistik,Literaturwiss (B.A.)',
'Gesch.Kult.China,Mong.Tib (M.A.)',
'Gesch.Kult.West-.Südasien (M.A.)',
'Geschichte (B.A., M.A., Promotion)',
'Geschichte (LA BA Gym Ge)',
'Gesellsch.,Global.u.Entw. (M.A.)',
'Griech.Lat.Lit in d.Antik (M.A.)',
'Griech.Literatur u.Fortl. (B.A.)',
'Griechisch (LA BA Gym Ge)',
'Hispanistik (B.A.)',
'Histor.Geographie (Promotion)',
'Humanernährung (M.Sc.)',
'Indologie (B.A.)',
'Indologie (Promotion)',
'Informatik (B.Sc., Diplom, Promotion)',
'Informatik (LA BA Gym Ge)',
'Interreligiöse Studien (M.A.)',
'Islamwiss./Nahostsprachen (B.A.)',
'Islamwissenschaft (Promotion)',
'Italianistik (B.A.)',
'Italienisch (LA BA Gym Ge)',
'Japanologie (Promotion)',
'Katastvorsorge u.managem. (Master)',
'Kath.Theologie (Kirchl.Ex., Diplom, Promotion)',
'Kathol. Religionslehre (LA BA Gym Ge)',
'Katholische Theologie (Magister Theologiae)',
'Keltologie (Promotion)',
'Klass.Archaeol. (Promotion)',
'Klass.Phil./Griechisch (Promotion)',
'Klass.Phil./Latein (Promotion)',
'Klassische Archäologie (M.A.)',
'Kommunikationsf.u.Phonet. (Promotion)',
'Kommunikationswiss. (B.A.)',
'Komparatistik (B.A., M.A.)',
'Kulturanthropologie/ Volks (M.A.)',
'Kulturs.zu Lateinamerika (M.A.)',
'Kulturwissenschaft (Promotion)',
'Kunstgeschichte (B.A., M.A., Magister, Promotion)',
'Kunstgeschichte u.Archäo. (B.A.)',
'Latein (LA BA Gym Ge)',
'Latein (Promotion)',
'Latein.Lit. u. ihr Fortl. (B.A.)',
'Lateinam.-u.Altam.studien (B.A.)',
'Law and Economics (Bachelor of Laws)',
'Lebensm.-Technologie (Diplom, Promotion)',
'Lebensmittelchemie (Staatsex., Promotion)',
'Lebensmitteltechnologie (M.Sc.)',
'Life and Medical Sciences (M.Sc.)',
'Life Science Informatics (M.Sc.)',
'Mathematics (M.Sc.)',
'Mathematik (B.Sc., Diplom, Promotion)',
'Mathematik (LA BA Gym Ge)',
'Medienwissenschaft (B.A., M.A., Promotion)',
'Medizin (Staatsex., Promotion)',
'Medizintechnikforschung (Master)',
'Meteorologie (B.Sc., Diplom, Promotion)',
'Mikrobiologie (M.Sc.)',
'Mineralogie (Diplom)',
'Mittelalt.u.neuere Gesch. (Magister, Promotion)',
'Mittelalterstudien (M.A.)',
'Molek. Biotechn. (M.Sc.)',
'Molekulare Biomedizin (B.Sc., Diplom, Promotion)',
'Musikw./ Sound Studies (B.A.)',
'Musikwissenschaft (Magister, Promotion)',
'Neuere deutsche Literatur (Promotion)',
'Neurosciences (M.Sc.)',
'Neurowissenschaften (Promotion)',
'North American Studies (M.A.)',
'Nutzpflanzenwissensch. (M.Sc.)',
'OEP-Biology (M.Sc.)',
'Orient.Kunstgesch. (Promotion)',
'Orient.u.Asiat.Sprachen (M.A.)',
'Osteurop.Geschichte (Promotion)',
'Osteuropastudien (B.A.)',
'Pädagogik (Promotion)',
'Pharmazie (Staatsex., Promotion)',
'Philosophie (B.A., M.A., Magister, Promotion)',
'Philosophie (LA BA Gym Ge)',
'Physik (B.Sc., M.Sc., Diplom, Promotion)',
'Physik (LA BA Gym Ge)',
'Physik d.Erde u. Atmosph. (M.Sc.)',
'Plant Sciences (M.Sc.)',
'Politik u. Gesellschaft (B.A.)',
'Politik und Gesellschaft (B.A.)',
'Politikwissenschaft (M.A.)',
'Politische Wissenschaft (Promotion)',
'Psychologie (B.Sc., M.Sc., Diplom, Promotion)',
'Rechtspsychologie (Master)',
'Rechtsvergleichung (Magister)',
'Rechtswissenschaft (Staatsex., Promotion)',
'Regionalwiss. Japan (M.A.)',
'Regionalwiss. Südostasien (Promotion)',
'Regwiss. Südostasien (M.A.)',
'Relig.u.Kunst i.d.Kult.As (M.A.)',
'Renaissance-Studien (M.A.)',
'Rheinische Landesgesch. (Promotion)',
'Romanische Philol./2 TG (Promotion)',
'Romanistik (B.A., M.A.)',
'Romanistik/Franz.Phil. (Promotion)',
'Romanistik/Iberorom.Phil. (Promotion)',
'Romanistik/Ital.Phil. (Promotion)',
'Sinologie (Promotion)',
'Skandinavistik (B.A., M.A., Promotion)',
'Slavistik (Promotion)',
'Sound Studies (M.A.)',
'Sozialwissenschaften (LA BA Gym Ge)',
'Soziologie (Promotion)',
'Span.Kult.im euro.Kontext (M.A.)',
'Spanisch (LA BA Gym Ge)',
'Spr./Kulturw.Zentr.Asiens (Promotion)',
'Spr.u.Kult.ZA/Mongolistik (Promotion)',
'Spr.u.Kult.ZA/Tibetologie (Promotion)',
'Südostasienwissenschaft (B.A.)',
'Tibetologie (B.A.)',
'Tierwissenschaften (M.Sc.)',
'Übersetzungswissenschaft (Promotion)',
'Verf.Soz.Wirt.Gesch. (Promotion)',
'Vergl. Religionswiss. (B.A.)',
'Vgl.Indogerm.Sprachwiss. (Promotion)',
'Vgl.Literaturwissenschaft (Promotion)',
'Vgl.Religionsw. (Promotion)',
'Volkskunde (Promotion)',
'Volkswirtschaftslehre (B.Sc., Promotion)',
'Vor-u.frühgesch.Archäol. (Promotion)',
'Zahnmedizin (Staatsex., Promotion)'];

$success = Array();

$link = db_connect();

// alle ungenutzten FAKs löschen
$query = "DELETE FROM fstool_studiengaenge WHERE ID NOT IN (SELECT studiengang FROM fstool_zuordnung);";
$truncate_success = mysql_query($query);
	
if($truncate_success){
	$i = 0;
	foreach($studiengaenge as $item){
		$item = validate_string_for_mysql_html($item);
		$query = "INSERT INTO ".DB_PREF."studiengaenge(name) VALUES ('".$item."');";
		$result = mysql_query($query);
		if(!$result){
			$success[$i] = false;
		} else {
			$success[$i] = true;
		}
		
		$i += 1;
	}
}
/*
 * DB-Verbindung schließen
 */
if(isset($link) and $link){
	mysql_close($link);
}


?>
<!DOCTYPE html>
<html lang="de">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>fstool - Installation</title>
	
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

	<!-- Main component for a primary marketing message or call to action -->
	<div class="jumbotron">
	
	
		<h1>fstool - Installation <small><abbr title='Fach-Abschluss-Kombinationen'>FAKs</abbr></small></h1>
		
		<ul class="list-group">
		<?php 
		
		if($truncate_success){
			echo '		<li class="list-group-item list-group-item-success">Datenbank leeren... <span class="badge">OK</span></li>
			';
		} else {
			echo '		<li class="list-group-item list-group-item-danger">Datenbank leeren... <span class="badge">Fehler</span></li>
			';
		}
		
		$i = 0;
		foreach($studiengaenge as $item){
			$item = validate_string_for_mysql_html($item);
			if(isset($success[$i])){
				if($success[$i]){
					echo '		<li class="list-group-item list-group-item-success">'.$item.' <span class="badge">OK</span></li>
					';
				} else {
					echo '		<li class="list-group-item list-group-item-danger">'.$item.' <span class="badge">Fehler</span></li>
					';
				}
			} else {
				echo '		<li class="list-group-item">'.$item.'</li>
				';
			}
			$i += 1;
		}
		
		?>
		</ul>
		
		
		
	</div>

  </body>
</html>
 
