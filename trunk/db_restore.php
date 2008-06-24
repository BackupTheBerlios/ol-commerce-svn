<?
if(!isset($upload)) {
	$upload = "";
}
define('PAGE_FRAME', '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>
      Restaurierung der Online-Datenbank aus einer Dump-Datei
    </title>
		<script type="text/javascript">
		function getfilename()
		{
			if (navigator.cookieEnabled)
			{
				alert(document.file.value +", "+ document.cookie);
				document.file.value = document.cookie;
			}
		}

		function setfilename()
		{
			if (navigator.cookieEnabled)
			{
				document.cookie = document.file.value;
				alert(document.file.value +", "+ document.cookie);
			}
		}
		</script>
  </head>
  <body style="font-family: Verdana; font-size: 8pt;" onload="getfilename()" onsubmit="setfilename()">
    <center>
      <table border="0"
             cellpadding="0"
             cellspacing="0"
             style="border-collapse: collapse"
             width="694"
             id="AutoNumber1">
        <tr>
          <td height="50">
            <p align="center">
              <FONT COLOR="#FF0000">
              <font size="2"><b>Restaurierung der Online-Datenbank aus einer Dump-Datei</b></font>
            	</FONT>
            </p>
          </td>
        </tr>
        <tr>
          <td>
			#content#
          </td>
        </tr>
     </table>
   </center>
 </body>
</html>
');

switch($upload) {
	default:
	echo str_replace('#content#',
	'
<font size="2">Es gelten die folgenden Einschr&auml;nkungen:</font>
<ul type="square">
<li>
  <font size="2">Die Datei-Erweiterung <b>muss</b> \'<font color="#FF0000"><b>.gz</b></font>\' sein</font>
</li>
<li>
  <font size="2">Es sind keine Leerzeichen im Dateinamen zul&auml;ssig</font>
</li>
<li>
  <font size="2">Der Dateiname darf keine unzul&auml;ssigen Zeichen (/,*,\,usw.) enthalten</font>
</li>
</ul>
<p>
	<font size="2">Wenn Sie <FONT COLOR="#0000FF"> <b>keine lokale Datei</b></FONT> zum
	Hochladen ausw&auml;hlen ("Durchsuchen..."), dann
	wird die <FONT COLOR="#0000FF"><B>letzte Sicherung auf dem Server</B></FONT>
	verwendet.</font>
</p>
<p>
	<FONT SIZE="2">Andernfalls wird die lokale Datei auf den Server
	hochgeladen, und als Basis der Restaurierung verwendet.</FONT></p>
	<form method="post"
	    action="db_restore.php?upload=doupload"
	    enctype="multipart/form-data">
			<p align="center">
			  <input type="file"
			     name="file" SIZE="62">
			  <br />
			  <br />
			  <button name="submit" type="submit">Hochladen und/oder Restaurierung starten</button>
			</p>
	</form>
'
	, PAGE_FRAME);
	break;
	case "doupload":
//	echo "file_name	-- " . $file_name . ", file -- " . $file . "<br><br>";

	if ($file_name == "") {
		$file_name = "dumpDB.sql.gz";
	}else{
		$file_name = strtolower($file_name);
		$ext = strrchr($file_name,'.');
		if ($ext <> ".gz") {
			$endresult = "Die Datei hat eine falsche Erweiterung '".$ext.APOS;
		}else{
			@copy($file, "$file_name") or $endresult = "Die Datei konnte nicht zum Server kopiert werden";
		}
	}
	if (file_exists($file_name)) {
		$endresult = 'Datenbank-Restaurierung ist abgeschlossen';
		// Bitte hier Ihre Daten eintragen
		$host= '';
		$user= '';
		$pass= '';
		$db=   '';

		if (false) {
			// GZip entpacken und in die Datenbank einlesen
			$command = sprintf(
			'gunzip -c %s/' . $file_name . ' | mysql -h %s -u %s -p%s %s',
			getenv('DOCUMENT_ROOT'),
			$host,
			$user,
			$pass,
			$db
			);
		}else{
			// GZip entpacken

			$command = sprintf(
			'gunzip -v %s/' . $file_name,
			getenv('DOCUMENT_ROOT'),
			$host,
			$user,
			$pass,
			$db
			);
		}
		echo $command."<br>";
		system($command);							//Execute command
	}else{
		$endresult = "Die Datei '$file_name' existiert nicht";
	}
	$endresult = '<font size="2">'. $endresult . '</font>';
	echo str_replace('#content#',
	'
		      <center> ' . $endresult . ' </center>
		'
	, PAGE_FRAME);
	break;
}
?>
