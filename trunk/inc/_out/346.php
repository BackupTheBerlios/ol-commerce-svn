<?PHP
/* -----------------------------------------------------------------------------------------
$Id: olc_get_ip_info.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:30 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com
(c) 2003	    nextcommerce (xsell_products.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contribution:
olc_get_ip_info				Autor: Winfried Kaiser, w.kaiser@fortune.de

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
*/

//W. Kaiser - AJAX

function olc_get_ip_info(&$smarty)
{
	if (SHOW_IP_LOG==TRUE_STRING_S)
	{
		$customers_ip_text='CUSTOMERS_IP';
		$ip=$_SESSION[$customers_ip_text];
		if (!isset($ip))
		{
			$ip=$_SERVER['REMOTE_ADDR'];
			if (strlen($ip)>0)
			{
				if (function_exists("gethostbyaddr"))
				{
					//Get host-name for IP by built-in PHP-function
					$host=gethostbyaddr($ip);
				}
				if (strlen($host)==0)
				{
					//"gethostbyaddr" does not work always, so try "Net_DNS" first
					define('FILENAME_NET_DNS','"Net/DNS.php');
					if (file_exists(FILENAME_NET_DNS))
					{
						require_once(FILENAME_NET_DNS);
						$res = new Net_DNS_Resolver();
						$ans = $res->search($ip, "MX");
						if ($ans)
						{
							$host=$ans->answer[0]->ptrdname;
						}
					}
				}
				if (strlen($host)>0)
				{
					if ($host<>$ip)
					{
						$ip.=LPAREN.$host.RPAREN;
					}
				}
				$ip.=' -- Datum: ' . date("d.m.Y H:i:s");
				$_SESSION[$customers_ip_text]=$ip;
			}
		}
		if ($smarty)
		{
			$smarty->assign('IP_LOG',true);
			$smarty->assign($customers_ip_text,$ip);
		}
	}
}
//W. Kaiser - AJAX
?>
