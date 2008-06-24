<?php
// autogenerated file 17.11.2006 13:29
// $Id: CharitySellerStatusCodeType.php,v 1.1.1.1 2006/12/22 14:37:24 gswkaiser Exp $
// $Log: CharitySellerStatusCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:24  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class CharitySellerStatusCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Suspended
	var $Suspended = 'Suspended';
	// @var string $Registered
	var $Registered = 'Registered';
	// @var string $Closed
	var $Closed = 'Closed';
	// @var string $CreditCardExpired
	var $CreditCardExpired = 'CreditCardExpired';
	// @var string $TokenExpired
	var $TokenExpired = 'TokenExpired';
	// @var string $CreditCardAboutToExpire
	var $CreditCardAboutToExpire = 'CreditCardAboutToExpire';
	// @var string $RegisteredNoCreditCard
	var $RegisteredNoCreditCard = 'RegisteredNoCreditCard';
	// @var string $NotRegisteredLostDirectSellerStatus
	var $NotRegisteredLostDirectSellerStatus = 'NotRegisteredLostDirectSellerStatus';
	// @var string $DirectDebitRejected
	var $DirectDebitRejected = 'DirectDebitRejected';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function CharitySellerStatusCodeType()
	{
		$this->EbatNs_FacetType('CharitySellerStatusCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_CharitySellerStatusCodeType = new CharitySellerStatusCodeType();

?>