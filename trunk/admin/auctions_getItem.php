<?php
/*auctions_getItem.php*/

require('includes/application_top.php');
// include needed functions
require_once $ebatns_dir.'EbatNs_ServiceProxy.php';
require_once $ebatns_dir.'EbatNs_Logger.php';
require_once $ebatns_dir.'GetItemRequestType.php';
require_once $ebatns_dir.'ItemType.php';

$session=create_ebay_session();
if ($session)
{

	$cs = new EbatNs_ServiceProxy($session);
	$cs->setHandler('ItemType', 'handleItem');

	$logger = new EbatNs_Logger(true);
	// $logger->_debugXmlBeautify = true;
	// $logger->_debugSecureLogging = false;

	$cs->attachLogger($logger);

	$req = new GetItemRequestType();
	$req->setItemID($_GET['itemId']);
	$req->setDetailLevel($Facet_DetailLevelCodeType->ReturnAll);

	$res = $cs->GetItem($req);
	echo "<pre>";
	if ($res->getAck() != $Facet_AckCodeType->Success)
	{
		echo "we got a failure<br/>";
		foreach ($res->getErrors() as $error)
		{
			echo "#" . $error->getErrorCode() . " " . htmlentities($error->getShortMessage()) . "/" . htmlentities($error->getLongMessage()) . HTML_BR;
		}
	}
	else
	{
		//#type $item ItemType
		$item = $res->getItem();
		echo "ShippingTerms : " . $item->getShippingTerms() . HTML_BR;

		print_r($item);
	}

	$page_header_subtitle=AUCTIONS_TEXT_SUB_HEADER_AUCTION;

	require(PROGRAM_FRAME);
}

function handleItem($type, & $data)
{
	echo "Hello Item<pre><br/>";
	// print_r($data);
	return false;
}
?>