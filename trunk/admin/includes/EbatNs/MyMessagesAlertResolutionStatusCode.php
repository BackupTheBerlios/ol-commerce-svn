<?php
// autogenerated file 17.11.2006 13:29
// $Id: MyMessagesAlertResolutionStatusCode.php,v 1.1.1.1 2006/12/22 14:38:21 gswkaiser Exp $
// $Log: MyMessagesAlertResolutionStatusCode.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:21  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class MyMessagesAlertResolutionStatusCode extends EbatNs_FacetType
{
	// start props
	// @var string $Unresolved
	var $Unresolved = 'Unresolved';
	// @var string $ResolvedByAutoResolution
	var $ResolvedByAutoResolution = 'ResolvedByAutoResolution';
	// @var string $ResolvedByUser
	var $ResolvedByUser = 'ResolvedByUser';
	// end props

/**
 *

 * @return 
 */
	function MyMessagesAlertResolutionStatusCode()
	{
		$this->EbatNs_FacetType('MyMessagesAlertResolutionStatusCode', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_MyMessagesAlertResolutionStatusCode = new MyMessagesAlertResolutionStatusCode();

?>
