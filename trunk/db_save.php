<?php
// Bitte hier Ihre Daten eintragen
//MySQL 5 Production

$subdir = "DB_backup";
$path = getenv('DOCUMENT_ROOT')."/".$subdir;
$file_id=$_GET['file_id'];
if (strlen($file_id)>0) $file_id="_".$file_id;
$db_id=$_GET['db_id'];
if ($db_id<>2)
{
	//MySQL 5 Production
	$host= 'db537.1und1.de';
	$user= 'dbo156226853';
	$pass= 'wGVfBngk';
	$db=   'db156226853';
}
else
{
	//MySQL 5.0 - Backup
	$host= 'db560.1und1.de';
	$user= 'dbo159454236';
	$pass= 'WJEtNWFQ';
	$db=   'db159454236';
}
$name = "dumpDB".$file_id.".sql.gz";
// Befehl ausführen und in Zipfile speichern

$command = sprintf(
'mysqldump --opt -h%s -u%s -p%s %s | gzip > %s/' . $name,
$host,
$user,
$pass,
$db,
$path
);
//Execute dump
system($command);
//Download dump-file
$err_message="Dump-Datei '" . $path . "' kann nicht geöffnet werden!";
header('Expires: 0');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
{
	//Handling for IE
	if($file = fopen($path, 'rb'))
	{

		fclose($file);
		header("Location: ".$name);						// Just point to file as new URL
	}
	else
	{
		die($err_message);
	}
}
else
{
	$path.="/".$name;
	$buffer=file_get_contents($path);
	if($buffer!='')
	{
		Header('Content-Type: application/octet-stream');
		header('Content-Length: '.strlen($buffer));
		Header('Content-disposition: attachment; filename='.basename($path));
		echo $buffer;
	}
	else
	{
		die($err_message);
	}
}
?>