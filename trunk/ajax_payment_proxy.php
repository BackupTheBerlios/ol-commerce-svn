<?PHP
/*
OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
ajax_payment_proxy.php v1.0

As we cannot access an URL on another server via AJAX, we need to employ a proxy program, which does this on our behalf!!

This Program receives (via POST!) the parameters
	"target_url", which is the address to call
	and
	"response_wait", which indicates, if the answer has to bee fed back to the caller.

It then has to collect all other "POST"-variables, in order to send them to the payment processor.

It also has to send an AJAX "NO_DATA"-message back to AJAX, because otherwise the AJAX-Framework would time-out.

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function PostToHost($url,$post_data_to_send,$wait_for_response=false)
{
//$url = 'https://www.paypal.com/de/cgi-bin/webscr';
	$timeout=9;
	$url_parts=parse_url($url);
	$host=$url_parts['host'];
	$path=$url_parts['path'];
	/*
	$query=$url_parts['query'];
	$scheme=$url_parts['scheme'];
	$port=$url_parts['port'];
	$user=$url_parts['user'];
	$pass=$url_parts['pass'];
	$fragment=$url_parts['fragment'];
	*/
	if ($_SERVER['HTTP_HOST']<>'localhost')
	{
		$use_ssl=!(strpos($url,"https")===false);
	}
	if ($use_ssl)
	{
		$fp = pfsockopen("ssl://".$host, 443, $errno, $errstr ,$timeout);
	}
	else
	{
		$fp = fsockopen($host, 80, $errno, $errstr ,$timeout);
	}
	if ($fp)
	{
		fputs($fp, "POST $path HTTP/1.1\r\n");
		fputs($fp, "Host: $host\r\n");
		fputs($fp, "Referer: $referer\r\n");
		fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
		fputs($fp, "Content-length: ". strlen($post_data_to_send) ."\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		fputs($fp, $post_data_to_send);
		if ($wait_for_response)
		{
			while(!feof($fp)) {
				$res .= fgets($fp, 128);
			}
			return $res;
		}
		else
		{
			echo 'AJAX_NODATA';
		}
		fclose($fp);
	}
	else
	{
		include_once(DIR_FS_INC."ajax_error.inc.php");
		ajax_error(sprintf(PAYMENT_PROBLEM,$$_SESSION['payment']->title));
	}
}

include_once('includes/application_top.php');
include(DIR_FS_INC.'olc_t_and_c_accepted.inc.php');
// load selected payment module
require_once(DIR_WS_CLASSES . 'payment.php');
if (isset($_SESSION['credit_covers']))
{
	$_SESSION['payment']=EMPTY_STRING; //ICW added for CREDIT CLASS
}
$payment_modules = new payment($$_SESSION['payment']);
// load the before_process function from the payment modules
$payment_modules->before_process();
//Collect all POST data
$post_data = EMPTY_STRING;
while (list($key, $value) = each($_POST))
{
	if ($key=='target_url')
	{
		$target_url=$value;
	}
	elseif ($key=='response_wait')
	{
		$response_wait=$value;
	}
	else
	{
		if (strlen($post_data)>0)
		{
			$post_data .= HTML_AMP;
		}
		$post_data .= $key.EQUAL.$value;
	}
}
$x = PostToHost($target_url,$post_data,$response_wait);
?>