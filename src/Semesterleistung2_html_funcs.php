<?php
/*#####################################################################################
	Print_LehrerFaecherTab($lehrerfaecherarr);
	
	Diese Funktion erzeugt ein gültiges XHTML DIV mit einer gültigen HTML Tabelle mit allen Lehrern die mindestens ein Fächern unterrichten
	
	Parameter 
	
	$lehrerfaecherarr		 Ein Zweidiemensianalen assioziatives array aller Lehrer die mindestens ein Fach unterrichten
	
	rückgabe		 		 das fertige html Div als String 
	
	#####################################################################################*/
	function Print_LehrerFaecherTab($faecherarr)
	{
/*	$lehrerfaechertab=" <table> 
							<tr> 
								<th>Anrede</th> 
								<th>Vorname</th>
								<th>Nachname</th>
								<th>Fach</th> 							
							</tr> 
							<tr> 
								<td> </td> 
								<td> </td>
								<td> </td>
								<td>Fach</td> 																 
							</tr>
                            ... 
							<tr> 
								<td>Anrede</td> 
								<td>Vorname</td>
								<td>Nachname</td>
								<td>Fach</td> 										 								 
							</tr>
                            ...
						</table>";
*/
		$Vergleicher1 ="";
		$Vergleicher2 ="";
			$leherfaechertab = 
	"<div id=LehrerFächer>
	<table>
		<tr> 
			<th>Anrede</th> 
			<th>Vorname</th>
			<th>Nachname</th>
			<th>Fach</th> 								
		</tr>";
	 // Hier kommen in einer Schleife alle tabelenzeilen hin n mal 
	 $dbconn = dbconnect("pmg_dummyuser");  
	 $resultarr=Get_LehrerFächer($dbconn);
	 foreach($resultarr AS $result)//Nicht mit dem $leherfaechertabSTRING verwenden 
		{
        $Vergleicher1 = $result['Vorname'];
            if($Vergleicher1 != $Vergleicher2)
                {
                // $result ist immernoch ein eindimensionale assoziatives array
              $leherfaechertab =$leherfaechertab."<tr>"
                                                ."<td>".$result['Titel']."</td>"
                                                ."<td>".$result['Vorname']."</td>"
                                                ."<td>".$result['Nachname']."</td>"
                                                ."<td>".$result['Bezeichnung']."</td>"
                                                ."</tr>";
                                                $Vergleicher2 = $result['Vorname'];
                }
                else 
                {
              $leherfaechertab =$leherfaechertab."<tr>"
                                                ."<td> </td>"
                                                ."<td> </td>"
                                                ."<td> </td>"
                                                ."<td>".$result['Bezeichnung']."</td>"
                                                ."</tr>"; 
                }                                  

                
            }
		$leherfaechertab =$leherfaechertab."</table></div>";
	return $leherfaechertab;
	
	}	
