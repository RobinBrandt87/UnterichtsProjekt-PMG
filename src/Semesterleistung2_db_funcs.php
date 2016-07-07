<?php
/*######################################################################################
Get_LehrerFächer($dbconn);

Diese Funktion holt aller alle Lehrer und die Faecher die sie unterichten aus der Datenbank


Paramet		$dbconn:		mysqli verbindung

Rückgabewert: 2 Diemensionales Array aller Lehrer mit den fächern die Sie unterrichten

######################################################################################*/
function Get_LehrerFächer($dbconn)
{
	$SQLstring="SELECT `lehrkraft`.`Titel`,`lehrkraft`.`Vorname`,`lehrkraft`.`Nachname`, `faecher`.`Bezeichnung` "
	          ."FROM `lehrkraft`,`bietetan`,`faecher` "
			  ."WHERE `lehrkraft`.`Pers_ID`=`bietetan`.`Pers_ID` AND `bietetan`.`Fach_ID`=`faecher`.`ID`"; 
			//$dbconn->query("SET NAMES utf8");
		$result = $dbconn->query($SQLstring);

		if ( $result==false )
		{
			echo "<div><b>SQL-Fehler:</b> in : ".$SQLstring."<br />".$dbconn->error."</div>";
			
			// im Echtbetrieb: Umlenkung auf eine eigene Fehlerseite
			die("Das war's - CIAO");
		}
		return $result->fetch_all(MYSQLI_ASSOC);
	  
}
?>