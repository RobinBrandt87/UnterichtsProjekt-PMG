<?php
  error_reporting(E_ALL);
  // $mydebug = true; besser als Konstante => global
	define( "MYDEBUG", true);

  ini_set( "session.use_cookies" , 0);
	session_name("pmg");
	session_start();

  include_once "./src/php_funcs.php";
  include_once "./src/db_funcs.php";
	include_once "./src/html_funcs.php";
  include_once "./src/Semesterleistung2_php_funcs.php";
  include_once "./src/Semesterleistung2_db_funcs.php";
	include_once "./src/Semesterleistung2_html_funcs.php";  
  

  Check_LoggedIn();
	DebugArr($_SESSION);
  

	// Datenbankzugriff
	$dbconn = dbconnect("pmg_dummyuser");  
  $userdaten = GetUserdatenByUID( $dbconn, $_SESSION['login']['uid']);
  
	$anrede = $userdaten['Anrede']." ".$userdaten['Vorname']. 
	          " " . $userdaten['Nachname'];
  // Gibt es eine anfrage nach informationen          
  $Info="";            
  if(isset($_POST['submit_auswahl']))
  
    $Info= Get_PMG_Infos($dbconn, $_POST['submit_auswahl']);
    $_SESSION['info']= $Info;
    
//	$anrede =  htmlentities(utf8_encode( $anrede ) );
	$anrede =  utf8_encode( $anrede ) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
  <title>PMG - Willkommensseite</title>
  <meta http-equiv="content-type" 
               content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="pmg.css" />
</head>
<body>
<div id="header">
  <h1>Intranet des Peter-Mustermann-Gymnasiums</h1>
</div>
<div id="center">
  <h2>Willkommen im Intranet des PMG</h2>

  <p>
    Willkommen <?php echo $anrede;?> 
		um <?php echo date("H:i"); ?> Uhr im Intranet des Peter-Mustermann-Gymnasiums.
  </p>

	<p>
	  Sie können jetzt folgende Informationen über unsere
		Schule einsehen:
	</p>

	<div id="auswahl">
	  <form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".SID;?>">
	    <input type="hidden" name ="<?php echo session_name();?>" 
			                     value="<?php echo session_id();?>" />
	    <input type="submit" name="submit_auswahl" value="Alle Lehrer" />
	  </form>
	  
	  <form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".SID;?>">
	    <input type="hidden" name ="<?php echo session_name();?>" 
			                     value="<?php echo session_id();?>" />
	    <input type="submit" name="submit_auswahl" value="Alle Fächer" />
	  </form>
		
	  <form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".SID;?>">
	    <input type="hidden" name ="<?php echo session_name();?>" 
			                     value="<?php echo session_id();?>" />
	    <input type="submit" name="submit_auswahl" value="Wer unterrichtet was" />
	  </form>
    <div class="clear_l">
    </div>  
    <?php echo $Info ?>
    

	</div>
</div>
<div id="footer">
  <a href="">Infos</a> &mdash;
  <a href="">Admin</a> &mdash;
  <a href="">Startseite</a>
</div>
</body>
</html>