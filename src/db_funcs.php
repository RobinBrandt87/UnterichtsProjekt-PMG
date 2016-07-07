<?php


  /*  ***************************************************
  function dbconnect( $user );

	Diese Funktion erstellt eine überprüfte Datenbankverbindung her:
	  DB-Server : localhost
		DB				: pmg_db

	Parameter:
	  $user			: ein erlaubter User für die DB pmg_db

	Rückgabewerte:
	  im ERfolgsfall : ein Objekt der Klasse mysqli
		sonst					 : die() 

	TODO: saubere Umlenkung auf eine eigene Fehlerseite bei Misserfolg

	***************************************************** */
	function dbconnect( $user )
	{
		// Initialisierung aller lokalen Variablen
		$server		= "localhost";
		$db				= "pmg_db";
		$login   	= "";
		$passwort = "";
		$dbconn		= false;

		switch ( $user )
		{
			case "pmg_dummyuser":
				$login		= "pmgdummy";
			  $passwort = "pmgdummy";
				break;
			case "pmg_adminuser":
				$login		= "pmgadmin";
			  $passwort = "pmgdummy";
				break;
			case "root":
			default:
				// im Echtbetrieb: Umlenkung auf eine eigene Fehlerseite
				die("Never ever !");
				break;
		}

		// Schritt 1 und 2: Verbindung zur DB auf einem DB-Server
		$dbconn =new mysqli($server, $login, $passwort, $db );
		
		if ( $dbconn->connect_errno )
		{// Verbindung fehlgeschlagen!
			if ( defined(MYDEBUG) && MYDEBUG )
			{
				echo "<div><b>DB-Verbindung fehlgeschlagen:</b>".
						 $dbconn->connect_error."</div>";
			}

			// im Echtbetrieb: Umlenkung auf eine eigene Fehlerseite
			die("Das war's - CIAO");
		}
		else
		{ // geschwätzige Debugging-Ausgabe
			if ( defined(MYDEBUG) && MYDEBUG )
			{
				echo "<div><b>DB-Verbindung hergestellt:</b>".
						 $dbconn->host_info ."</div>";
			}
		}
		$dbconn->query("SET NAMES utf8");
		return $dbconn;
	}  // end of function dbconnect( $user )



  /*  ***************************************************
  function GetUidByLogin( $dbconn, $login, $passwort );

	Diese Funktion holt aus der DB 'pmg_db' die Pers_ID einer
	Lehrkraft mittels ihres Benutzernamens und Passwortes

	Parameter:
	  $dbconn			: eine gültige DB-Verbindung der Klasse mysqli 
		$login			: Anmeldename einer Lehrkraft
		$passwort		: Passwort einer Lehrkraft

	Rückgabewerte:
	  im Erfolgsfall : eine Pers_ID
		sonst					 : false 

	***************************************************** */
	function GetUidByLogin( $dbconn, $login, $passwort )
	{			// Schritt 3 : SQL-Abfrage zusammenbasteln
/*
		$SQLstring = "SELECT Pers_ID".
			" FROM lehrkraft".
			" WHERE login = '".$login."'".
				" AND passwd = MD5('".$passwort."')";

		// Schritt 4 : Abfrage abschicken und Ergebnis entgegennehmen
		$result = $dbconn->query($SQLstring);
		if ( $result == FALSE )
		{
			echo "<div><b>SQL-Fehler:</b> in : ".$SQLstring."<br />".$dbconn->error."</div>";
			
			// im Echtbetrieb: Umlenkung auf eine eigene Fehlerseite
			die("Das war's - CIAO");
		}

		// Schritt 5 : DS fetch-en
		$ds = $result->fetch_assoc();

		// Schritt 6: Datensatz bekommen? 
		if ( $ds )
			// Ja: Pers_ID herausholen und merken
			$uid = $ds['Pers_ID'];
		else
			// Nein: Misserfolg merken
			$uid = false;
*/
        // Schritt 1: SQL Abfrage 
   $SQLstring = "SELECT Pers_ID".
    			" FROM lehrkraft".
	       		" WHERE login = ?".
				" AND passwd = MD5( ? )";
                
          
        // Schritt 2 ein neues lehres objekt der klasse mysqli_stmt erzeugen 
        
        $prepstmt = $dbconn->stmt_init();
        
        // Schritt 3 Prepaired statment übergeben und ausführen 
        
        if (!$prepstmt->prepare($SQLstring))
		{
			echo "<div><b>SQL-Fehler:</b> in : ".$SQLstring."<br />".$dbconn->error."</div>";
			
			// im Echtbetrieb: Umlenkung auf eine eigene Fehlerseite
			die("Das war's - CIAO");
		}
        
        // Schrit 4 Daten an die Parameter übergeben "binden"
        
        $prepstmt->bind_param( "ss", $login, $passwort );
        
        // Schrit 5 jetzt mit diesen Daten filtern 
        
        $prepstmt->execute();
        
        // Schrit 6 ErgebnisFelder an Variablen binden für jedes ergebnisfeld
        
        $prepstmt->bind_result( $uid );
        
        // Schritt 7 fetchen 
        
        if (!$prepstmt->fetch())
        {
            $uid = false;
        } 
                
        		
		return $uid;
	} // end of function GetUidByLogin( $dbconn, $login, $passwort )


 



  /*  ***************************************************
  function GetUserdatenByUID( $dbconn, $uid );

	Diese Funktion holt alle Userdaten aus der DB pmg_db mittels der ID eines Users

	Parameter:
	  $dbconn			: eine gültige DB-Verbindung der Klasse mysqli 
		$uid				: Die UserID einer Lehrkraft

	Rückgabewerte:
	  im Erfolgsfall : ein Array mit allen Userdaten
		        dies sind: Anrede, Titel, Vorname, Nachname, Geb_Datum
		sonst					 : false 

	***************************************************** */
  function GetUserdatenByUID( $dbconn, $uid )
	{
        /*
		$SQLstring = "SELECT Anrede, Titel, Vorname, Nachname, Geb_Datum".
			" FROM lehrkraft WHERE Pers_ID = ".$uid;

		$result = $dbconn->query($SQLstring);

		if ( $result==false )
		{
			echo "<div><b>SQL-Fehler:</b> in : ".$SQLstring."<br />".$dbconn->error."</div>";
			
			// im Echtbetrieb: Umlenkung auf eine eigene Fehlerseite
			die("Das war's - CIAO");
		}


		// Schritt 5 : DS fetch-en
		$ds = $result->fetch_assoc();

		// Schritt 6: Datensatz bekommen? 
		if ( !$ds )
			$ds = false;
            */
        // Schritt 1: SQL Abfrage 
  $SQLstring = "SELECT Anrede, Titel, Vorname, Nachname, Geb_Datum".
			" FROM lehrkraft WHERE Pers_ID = ?";
                
          
        // Schritt 2 ein neues lehres objekt der klasse mysqli_stmt erzeugen 
        
        $prepstmt = $dbconn->stmt_init();
        
        // Schritt 3 Prepaired statment übergeben und ausführen 
        
        if (!$prepstmt->prepare($SQLstring))
		{
			echo "<div><b>SQL-Fehler:</b> in : ".$SQLstring."<br />".$dbconn->error."</div>";
			
			// im Echtbetrieb: Umlenkung auf eine eigene Fehlerseite
			die("Das war's - CIAO"); 
		}    
        // Schrit 4 Daten an die Parameter übergeben "binden"
        
        $prepstmt->bind_param( "i", $uid );
        
        // Schrit 5 jetzt mit diesen Daten filtern 
        
        $prepstmt->execute();
        
        // Schritt 6 jetzt ohne bind result: dann brauchen wir ein objekt der klasse msqli_result 
        
        $result = $prepstmt->get_result();
        
        // Schritt 7 : DS fetch-en
		$ds = $result->fetch_assoc();

		// Schritt 8: Datensatz bekommen? 
		if ( !$ds )
			$ds = false;
            
    return $ds;
	}
/*#################################################################################

  function Get_PMG_Infos( $dbconn, $auswahl );

	In abhengigkeit von der Auswahl des Users werden Informatione vom Peter Mustermann Gymnasium aus der Datzebnabnk gehol
	und als ein korektes XHTML Div aufgearbeitet und ausgegeben

	Parameter:
	$dbconn					: eine gültige DB-Verbindung der Klasse mysqli 
	$auswahl				: Die gewünschte auwahl des users zz alle lehrer alle fächer wer unterichtet was

	Rückgabewerte:
	  im Erfolgsfall : ein korektes XHTML Div mit allen Informationen als string
		        
		sonst					 : false 

#################################################################################*/	
function Get_PMG_Infos( $dbconn, $auswahl )
{
	switch($auswahl)
	{
		case "Alle Lehrer";
		$lehrerarr = Get_LehrerInfos($dbconn);
		echo DebugArr( $lehrerarr );
		$htmldiv = Print_LehrerTable($lehrerarr);
		//$htmldiv = "<div><b>Hier kommt alle Lehrer</b></div>";
		break;
		case "Alle Fächer";
		$faecherarr = Get_FaecherInfos($dbconn);
		echo DebugArr( $faecherarr );
		//$htmldiv = "<div><b>Hier kommt alle Fächer</b></div>";
		$htmldiv = Print_FaecherList($faecherarr);
		break;
		case "Wer unterrichtet was";
		$lehrerfaecherarr = Get_LehrerFächer($dbconn);
		echo DebugArr($lehrerfaecherarr);
		$htmldiv =Print_LehrerFaecherTab($lehrerfaecherarr);
		break;		
		default: 
		$htmldiv = "<div><b>Ungültige auswahl</b></div>";
	}
	return $htmldiv;
}
/*######################################################################################
Get_LehrerInfos($dbconn);

Diese Funktion holt alle Lehrerdaten aller Lehrer aus der Datenbank

Paramet		$dbconn:		mysqli verbindung

Rückgabewert: 2 Diemensionales Array aller Lehrerdaten

######################################################################################*/
function Get_LehrerInfos($dbconn)
{
	$SQLstring=
	" SELECT"." Anrede, Titel, Vorname, Nachname, Geb_Datum, Pers_ID".
	" FROM"." lehrkraft".
	" ORDER BY Nachname, Vorname, Pers_ID";

		//$dbconn->query("SET NAMES utf8");
		$result = $dbconn->query($SQLstring);

		if ( $result==false )
		{
			echo "<div><b>SQL-Fehler:</b> in : ".$SQLstring."<br />".$dbconn->error."</div>";
			
			// im Echtbetrieb: Umlenkung auf eine eigene Fehlerseite
			die("Das war's - CIAO");
		}
		/*	Kompliezierte Variante
		$lehrerarr=array();
		
		while ($ds = $result->fetch_assoc())
		{
			$lehrerarr[]=$ds;
		}
		*/
		return $result->fetch_all(MYSQLI_ASSOC);
}
/*######################################################################################
Get_FaecherInfos($dbconn);

Diese Funktion holt alle Fächer naller aus der Datenbakn

Paramet		$dbconn:		mysqli verbindung

Rückgabewert: 2 Diemensionales Array aller Lehrerdaten

######################################################################################*/
function Get_FaecherInfos($dbconn)
{
	$SQLstring=
	" SELECT"." *".
	" FROM"." faecher".
	" ORDER BY ID";

		//$dbconn->query("SET NAMES utf8");
		$result = $dbconn->query($SQLstring);

		if ( $result==false )
		{
			echo "<div><b>SQL-Fehler:</b> in : ".$SQLstring."<br />".$dbconn->error."</div>";
			
			// im Echtbetrieb: Umlenkung auf eine eigene Fehlerseite
			die("Das war's - CIAO");
		}
		/*	Kompliezierte Variante
		$lehrerarr=array();
		
		while ($ds = $result->fetch_assoc())
		{
			$lehrerarr[]=$ds;
		}
		*/
		return $result->fetch_all(MYSQLI_ASSOC);
}


?>
