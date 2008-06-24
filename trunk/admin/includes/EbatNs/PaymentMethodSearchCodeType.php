<?php
// autogenerated file 17.11.2006 13:29
// $Id: PaymentMethodSearchCodeType.php,v 1.1.1.1 2006/12/22 14:38:26 gswkaiser Exp $
// $Log: PaymentMethodSearchCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:26  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class PaymentMethodSearchCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $PayPal
	var $PayPal = 'PayPal';
	// @var string $PaisaPay
	var $PaisaPay = 'PaisaPay';
	// @var string $PayPalOrPaisaPay
	var $PayPalOrPaisaPay = 'PayPalOrPaisaPay';
	// end props

/**
 *

 * @return 
 */
	function PaymentMethodSearchCodeType()
	{
		$this->EbatNs_FacetType('PaymentMethodSearchCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_PaymentMethodSearchCodeType = new PaymentMethodSearchCodeType();

?>
