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

	DebugArr( $_POST );

// Beginn des Hauptprogrammes

  // leere Fehlermeldung initialisieren
	$errmsg = "";

	if ( isset($_SESSION['err'] ) )
	{
	  $errmsg=PrintErrorDiv( $_SESSION['err']['errno'] );
		unset($_SESSION['err']);
	}

	// nicht zum 1. Mal hier?
	if ( isset($_POST['submit']) )
	{
    // Alle Felder ausgefüllt?
		if ( PflichtfelderOK() )
		{
		  // Datenbankzugriff
			$dbconn = dbconnect("pmg_dummyuser");
			$uid = GetUidByLogin( $dbconn, $_POST['login'], $_POST['passwd'] );

			// Anmeldung korrekt?
			if ( !($uid === false) ) // funktioniert jetzt auch bei der uid 0 !
			{ // uid in der SESSION aufheben
				$_SESSION['login']['uid']= $uid;
				$_SESSION['login']['time']=date("d.m.y H:i:s");
				$_SESSION['login']['IP']=$_SERVER['REMOTE_ADDR'];
				$_SESSION['test']['bla']="blubber";
				$_SESSION['test']['senf']="quark";
				//$ziel="./welcome.php?".session_name()."=".session_id();
				$ziel="./welcome.php?".SID;
				// Umlenkung nach welcome.php mit einer Session
				header("Location: $ziel");
			}
			else
			{ // Fehlermeldung: Falsche Anmeldedaten
				$errmsg = PrintErrorDiv( 10 );
			}
		}
	  else
		{ // Fehlermeldung: Fehlende Anmeldedaten
			$errmsg = PrintErrorDiv( 11 );
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
  <title>PMG - Anmeldung</title>
  <meta http-equiv="content-type" 
        content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="pmg.css" />
</head>
<body>
<div id="header">
  <h1>Intranet des Peter-Mustermann-Gymnasiums</h1>
</div>
<div id="center">
  <h2>Anmeldung im Intranet des PMG</h2>

  <p>
    Um unser Intranet zu betreten, müssen Sie in folgendem Formular 
    alle Felder ausfüllen.
  </p>
  <?php echo $errmsg; ?>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>"
	      method="post">
    <div>
      <input  type="hidden" 
              name="<?php echo session_name();?>" 
              value="<?php echo session_id();?>" />
    </div>
    <div class="input">
      <label for="login">Benutzername:</label> 
      <input type="text" name="login" id="login" />
    </div>
    <div class="input">
      <label for="passwd">Passwort:</label> 
      <input type="password" name="passwd" id="passwd" />
    </div>

    <div class="buttonrow">
      <input type="submit" name="submit" value="Anmelden" />
      <input type="reset" value="Zurücksetzen" />
    </div>
  </form>

</div>
<div id="footer">
  <a href="">Infos</a> &mdash;
  <a href="">Admin</a> &mdash;
  <a href="">Startseite</a>
</div>
</body>
</html>