<?php
// autogenerated file 17.11.2006 13:29
// $Id: DescriptionTemplateCodeType.php,v 1.1.1.1 2006/12/22 14:37:27 gswkaiser Exp $
// $Log: DescriptionTemplateCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:27  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class DescriptionTemplateCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Layout
	var $Layout = 'Layout';
	// @var string $Theme
	var $Theme = 'Theme';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function DescriptionTemplateCodeType()
	{
		$this->EbatNs_FacetType('DescriptionTemplateCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_DescriptionTemplateCodeType = new DescriptionTemplateCodeType();

?>
