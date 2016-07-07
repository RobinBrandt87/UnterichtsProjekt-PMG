<?php
/* **********************************************************
	function DebugArr( $arr );

  Debugging-Funktion für Arrays innerhalb von PHP. Gibt als
	präformatierten Text ein Array in einem DIV der Klasse debug aus
	Ausgabe erfolgt nur bei einer gesetzten globalen Konstanten namens
	MYDEBUG.

	Parameter: $arr - ein Array

	Rückgabewerte: keine
*********************************************************** */
	function DebugArr( $arr )
	{
		if ( defined('MYDEBUG') && MYDEBUG===true )
		{
			/* Testausgabe: was bekommen wir
				 Ausgabe aller GET-Daten           */
			echo "\n<div class=\"debug\"><pre>";
			print_r( $arr );
			echo "</pre></div>";
		}
		else echo "<b>NO</b>";
	}  // end of function DebugArr( $arr )



/* **********************************************************
	function PflichtfelderOK( );

  Überprüft bei der Anmeldung ob die Felder 'login' und 'passwd'
	ausgefüllt wurden

	Parameter: keine ABER benötigt GET als Übergabemethode!

	Rückgabewerte: 
			true: alles ausgefüllt
			false: sonst
*********************************************************** */
	function PflichtfelderOK( )
	{
    if ( !empty($_POST['login']) &&  // && ist das logische UND (oder: AND)
			   !empty($_POST['passwd'])   )
		{
			return true;
		}
		else
		{
      return false;
		}
	} // end of function PflichtfelderOK( )





/* **********************************************************
	function Check_LoggedIn( );

  Überprüft, ob ein User bereits erfolgreich angemeldet ist.
	Ist keine Anmeldung erfolgt, so wird nach index.php umgelenkt
	mit der Fehlernummer 12.

	Parameter: keine 
	           ABER greift auf $_SESSION['login']['uid'] zu
	Rückgabewerte: keine
*********************************************************** */
function Check_LoggedIn()
{
  // ist der User angemeldet? Wenn ja -> dann existiert in der
	// SESSION die uid
	if ( !isset( $_SESSION['login']['uid'] ) )
	{
    // Fehler merken
		$_SESSION['err']['errno']=12;

		// SESSION-ID aufheben
		$ziel="./index.php?".SID;

		// umlenken
		header("Location: ".$ziel);
		/* alternativ:
		header("Location: ./index.php?".SID);
		*/
	}
}
?>