<?php
// autogenerated file 17.11.2006 13:29
// $Id: ExternalProductCodeType.php,v 1.1.1.1 2006/12/22 14:37:46 gswkaiser Exp $
// $Log: ExternalProductCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:46  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class ExternalProductCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $ISBN
	var $ISBN = 'ISBN';
	// @var string $UPC
	var $UPC = 'UPC';
	// @var string $ProductID
	var $ProductID = 'ProductID';
	// @var string $EAN
	var $EAN = 'EAN';
	// @var string $Keywords
	var $Keywords = 'Keywords';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function ExternalProductCodeType()
	{
		$this->EbatNs_FacetType('ExternalProductCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_ExternalProductCodeType = new ExternalProductCodeType();

?>
