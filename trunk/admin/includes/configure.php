<?php
/*
Changed for eliminating the admin config!

As this might be called from other progs (like SPAW) deeper down the directory tree,
we have to adjust the dir to the proper level!
*/
$level='';
$admin='admin';
$dir=getcwd();
$dir_paths=explode('\\',$dir);
if (!$dir_paths)
{
	$dir_paths=explode(SLASH,$dir);
}
if ($dir_paths)
{
	$path_levels=sizeof($dir_paths)-1;
	for ($i=$path_levels;$i>=0;$i--)
	{
		$level.='../';
		if ($dir_paths[$i]==$admin)
		{
			break;
		}
	}
}
$admin.='/';
include($level.'includes/configure.php');
define('DIR_WS_ADMIN', DIR_WS_CATALOG.$admin); 				// absolute path required
define('DIR_FS_ADMIN', DIR_FS_CATALOG.$admin); 				// absolute path required
define('DIR_FS_LANGUAGES', DIR_FS_CATALOG . 'lang/');
define('DIR_FS_CATALOG_IMAGES', ADMIN_PATH_PREFIX.DIR_WS_IMAGES);
define('DIR_WS_CATALOG_IMAGES',DIR_FS_CATALOG_IMAGES);
define('DIR_FS_CATALOG_ORIGINAL_IMAGES', ADMIN_PATH_PREFIX.DIR_WS_ORIGINAL_IMAGES);
define('DIR_FS_CATALOG_THUMBNAIL_IMAGES', ADMIN_PATH_PREFIX.DIR_WS_THUMBNAIL_IMAGES);
define('DIR_FS_CATALOG_INFO_IMAGES', ADMIN_PATH_PREFIX.DIR_WS_INFO_IMAGES);
define('DIR_FS_CATALOG_POPUP_IMAGES',ADMIN_PATH_PREFIX.DIR_WS_POPUP_IMAGES);
define('DIR_WS_CATALOG_ORIGINAL_IMAGES', DIR_FS_CATALOG_ORIGINAL_IMAGES);
define('DIR_WS_CATALOG_THUMBNAIL_IMAGES', DIR_FS_CATALOG_THUMBNAIL_IMAGES);
define('DIR_WS_CATALOG_INFO_IMAGES', DIR_FS_CATALOG_INFO_IMAGES);
define('DIR_WS_CATALOG_POPUP_IMAGES', DIR_FS_CATALOG_INFO_IMAGES);
define('DIR_FS_CATALOG_MODULES', DIR_FS_CATALOG .DIR_WS_MODULES);
define('DIR_FS_BACKUP', DIR_FS_ADMIN . 'backups/');
define('DIR_FS_DOWNLOAD', DIR_FS_CATALOG.'download/');
define('DIR_WS_DOWNLOAD_PUBLIC', DIR_WS_CATALOG.'pub/');
define('DIR_FS_DOWNLOAD_PUBLIC', DIR_FS_CATALOG.'pub/');
?>