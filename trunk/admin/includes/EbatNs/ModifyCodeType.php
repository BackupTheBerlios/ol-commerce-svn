<?php
// autogenerated file 17.11.2006 13:29
// $Id: ModifyCodeType.php,v 1.1.1.1 2006/12/22 14:38:20 gswkaiser Exp $
// $Log: ModifyCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:20  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class ModifyCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Dropped
	var $Dropped = 'Dropped';
	// @var string $Modify
	var $Modify = 'Modify';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function ModifyCodeType()
	{
		$this->EbatNs_FacetType('ModifyCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_ModifyCodeType = new ModifyCodeType();

?>
