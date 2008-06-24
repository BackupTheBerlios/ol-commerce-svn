<?php 
// $Id: EbatNs_Defines.php,v 1.1.1.1 2006/12/22 14:37:36 gswkaiser Exp $
/*$Log: EbatNs_Defines.php,v $
/*Revision 1.1.1.1  2006/12/22 14:37:36  gswkaiser
/*no message
/*
 * 
 * 3     3.02.06 10:44 Mcoslar
 * 
 * 2     30.01.06 16:44 Mcoslar
 * nderungen eingefgt
*/
// ebay PHP at defines
DEFINE("EBAY_NOTHING", null);
DEFINE("EBAY_REMOVE_ACTION", '__DO_REMOVE_ACTION__');
DEFINE("EBAY_ERR_SUCCESS", "0");
DEFINE("EBAY_ERR_ERROR", "1");
DEFINE("EBAY_ERR_WARNING", "2");
// this are defines for cURL
// a few are not documented, but the names should be
// rather descriptive
DEFINE('CURLOPT_PROXYTYPE', 101);
// DEFINE( 'CURLOPT_PROXYUSERPWD', 6 );
// DEFINE( 'CURLOPT_HTTPPROXYTUNNEL', 61 );
DEFINE('CURLAUTH_NONE', 0);
DEFINE('CURLPROXY_HTTP', 0);
DEFINE('CURLPROXY_SOCKS4', 4);
DEFINE('CURLPROXY_SOCKS5', 5);
DEFINE('CURLOPT_BUFFERSIZE', 98);
?>