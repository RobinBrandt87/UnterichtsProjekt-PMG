<?php
/* ****************************************************************
function PrintErrorDiv( $errno );

Diese Funktion erzeugt ein gültiges HTML-Div der Klasse error
mit formatierter Fehlerbeschreibung

Parameter:     $errno : eine Fehlernummer 
												bisher vergeben: siehe Switch-Case

Rückgabewerte: Das fertige HTML-Div als String

******************************************************************* */
function PrintErrorDiv( $errno )
{
  switch ( $errno )
	{
    case 10 : 
			$title = "Falsche Anmeldedaten";
			$desc  = "Diese Kombination aus Benutzername und Passwort ist ungültig. Bitte geben Sie Ihre korrekten Daten erneut ein.";
			break;
		case 11 : 
			$title = "Fehlende Anmeldedaten";
			$desc  = "Um sich im Intranet anzumelden müssen ".
					"Sie <span class=\"wichtig\">alle</span> Felder im Formular ".
					"ausfüllen.";
			break;
		case 12 : 
			$title = "Fehlende Anmeldung";
			$desc  = "Um unser Internet zu betreten, müssen Sie sich vorher anmelden. Bitte benutzen Sie zukünftig immer diese Anmeldesite als Startseite.";
			break;
		default : 
			$title = "Unbekannte Fehlernummer";
			$desc  = "Sorry - Dieser Fall hätte nicht passieren dürfen...";
	}

	// Fehlermeldung: 
	$errmsg = 
		"\n<div class=\"error\">".
		"\n\t<div class=\"title\">".$title."</div>".
		"\n\t<div class=\"desc\">".$desc."</div>".
		"\n</div>";

	return $errmsg;
}
	/*#####################################################################################
	Print_LehrerTable($lehrerarr);
	
	Diese Funktion erzeugt ein gültiges XHTML DIV mit einer gültigen HTML Tabelle mit alle Lehrerdaten
	
	Parameter 
	
	$lehrerarr		 Ein Zweidiemensianalen assioziatives array aller lehrerdaten
	
	rückgabe 		 das fertige html Div als String 
	
	#####################################################################################*/
	function Print_LehrerTable($lehrerarr)
	{
		/*
		<table id="lehrertab">
		<thead>
			<tr>
				<th>Anrede</th>
				<th>Titel</th>
				<th>Vorname</th>
				<th>Nachname</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Herr</td>
				<td>Dr.</td>
				<td>Peter</td>
				<td>Mustermann</td>
			</tr>			
		</tbody>
		</table>	
		*/
		
		// der tabenlenkopf
		$table = 
	"\n<table id=\"lehrertab\">
	 \n	<thead>
	 \n		<tr>
	 \n			<th>Anrede</th>
	 \n			<th>Titel</th>
	 \n			<th>Vorname</th>
	 \n			<th>Nachname</th>
	 \n		</tr>
	 \n	</thead>
	 \n	<tbody>";
	 // Hier kommen in einer Schleife alle tabelenzeilen hin n mal 
	foreach($lehrerarr AS $lehrer)
	{
	// $lehrer ist immernoch ein eindimensionale assoziatives array
	$table.=
			"\n<tr>".
			"\n	<td>".$lehrer['Anrede']."</td>".
			"\n	<td>".$lehrer['Titel']."</td>".
			"\n	<td>".$lehrer['Vorname']."</td>".
			"\n	<td>".$lehrer['Nachname']."</td>".
			"\n  </tr>";
	}
	
	// der tabellenfuß 1 mal 
	$table .="\n	<tbody> \n</table>";
	return $table;
	}
	
/*#####################################################################################
	Print_FaecherList($faecherarr);
	
	Diese Funktion erzeugt ein gültiges XHTML DIV mit einer gültigen HTML List mit alle Fächern
	
	Parameter 
	
	$faecherarr		 Ein Zweidiemensianalen assioziatives array aller Fächer
	
	rückgabe 		 das fertige html Div als String 
	
	#####################################################################################*/
	function Print_FaecherList($faecherarr)
	{
		/*
 <h2>Alle Fächer</h2>
 <ol start="1"> 
	<li>Fach1</li> 
	<li>Fach2</li> 
	<li>Fach3</li> 
	<li>usw</li> 
 </ol> 	
		*/
		
		// der tabenlenkopf
		$faecherlist = 
	"<div id=Fächer>
	<h3>Alle Fächer</h3>
 	 <ol start=\"1\"> ";
	 // Hier kommen in einer Schleife alle tabelenzeilen hin n mal 
	foreach($faecherarr AS $faecher)//Nicht mit dem Fächerstring verwenden 
	{
	// $faecher ist immernoch ein eindimensionale assoziatives array
	$faecherlist =$faecherlist."<li>".$faecher['Bezeichnung']."(".$faecher['Kuerzel'].")</li>";
	}
	
	// das Listenende 1 mal 
	$faecherlist .="</ol></div>";
	return $faecherlist;
	}	

?>