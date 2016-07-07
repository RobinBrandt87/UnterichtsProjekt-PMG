<?php
/* Gibt ein Array pre-formatiert aus */
function my_r( $arr, $out = 1 )
{
  if ( $out )
  {
    echo "<pre>";
    print_r( $arr );
    echo "</pre>";
  }
}

/* Diese Funktion überprüft ein hochgeladenes Bild:

  1. sauber angekommen
  2. ist es ein Bild
  3. vom richtigen Dateityp (Bildformat)

  Parameter: Das Unterarray der Datei aus $_FILES

  Rückgabewerte: keiner - schlägt eine Bedingung fehl, erfolgt eine
                          Umlenkung mit Fehlernummer
*/
function check_picfile( $file_arr )
{
  // 1. Check: Datei korrekt angekommen?
  if ( $file_arr['error'] != 0 )
    // Fehler beim Upload
    header("Location: ".$_SERVER['PHP_SELF']."?err=".$file_arr['error']);

  $pic_orig = $file_arr['tmp_name'];

  // 2. Ist diese Datei ein Bild?
  if ( !$pic_arr = GetImageSize($pic_orig) )
    header("Location: ".$_SERVER['PHP_SELF']."?err=10");
  my_r($pic_arr);

}

/*  Formatierte Fehlerausgabe für den Bildupload

    Parameter: $err - eine Fehlernummer

    Rückgabewert: keiner
*/
function html_errordiv( $errno )
{
  switch ( $errno )
  {
   case  1 :  
   case  2 : 
     $err_title = "Datei zu groß";  
     $err_desc = "Ihre Datei überschreitet die maximale Größe von 30MB.".
        " Bitte laden Sie eine kleinere Datei hoch.";
     break;  
   case  3 : 
     $err_title = "Datei nicht vollständig geladen";  
     $err_desc = "Bitte laden Sie Ihre Datei erneut hoch.";
     break;
   case  4 : 
     $err_title = "Keine Datei ausgewählt";  
     $err_desc = "Bitte wählen Sie über den Button \"Durchsuchen ...\" ".
       "eine Datei aus.";
     break;
   case 10 : 
     $err_title = "Datei ist kein Bild";  
     $err_desc = "Bitte wählen Sie ein Bild aus.";
     break;

   default :  
     $err_title = "Unbekannter Fehler";  
     $err_desc = "Sorry - das hätte nicht passieren dürfen.";
     break;

  }

  echo "\n<div class=\"error\">\n".
       "<h3>".$err_title."</h3>\n".
       "<p>".$err_desc."</p></div>\n";
}
/*create_pngFiles($picoreg) 
  Diese Funktion überprüft ob ein hochgeladenes Bild vom richtigen dateityp(Bildformat) ist
  Wenn ja werden png datein im richtigen Format an einer festen stelle erzeugt 
  
  Parameter  $pigoreg 
  
  Rückgabewert keine bei falschen datentyp erfolgt eine umlenkung mit fehlernummer 


*/
function create_pngFiles($_FILES['picture']['tmp_name'])
{
    //überprüfung dieser datei ein Bild 
    $pic
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
  <title>Upload eines Bildes</title> 
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>Upload eines Bildes</h1>

<?php if ( isset($_GET['err']) ) html_errordiv($_GET['err']); ?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"
      enctype="multipart/form-data"  >
  <label> Bilddatei:
    <input type="file" name="picture" />
  </label>

  <div class="buttonrow">
    <input type="submit" name="submit" value="Hochladen" />
    <input type="reset" value="Vergiss es" />
  </div>
</form>

<?php
if ( isset($_POST['submit']) )
{
  my_r( $_FILES, 1 );

  check_picfile($_FILES['picture']);
  // wenn bis hier hin irgend etwas schief gegangangen ist dann wurden wir schon mit einer fehlermeldung umgeleitet 
  // ergo: $_FILES['picture']['tmp_name'] ist ein Bild 
  create_pngFiles($_FILES['picture']['tmp_name']);
}
?>


</body>
</html>