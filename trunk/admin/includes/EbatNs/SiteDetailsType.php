<?php
// autogenerated file 17.11.2006 13:29
// $Id: SiteDetailsType.php,v 1.1.1.1 2006/12/22 14:38:47 gswkaiser Exp $
// $Log: SiteDetailsType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:47  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'SiteCodeType.php';

class SiteDetailsType extends EbatNs_ComplexType
{
	// start props
	// @var SiteCodeType $Site
	var $Site;
	// @var int $SiteID
	var $SiteID;
	// end props

/**
 *

 * @return SiteCodeType
 */
	function getSite()
	{
		return $this->Site;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setSite($value)
	{
		$this->Site = $value;
	}
/**
 *

 * @return int
 */
	function getSiteID()
	{
		return $this->SiteID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setSiteID($value)
	{
		$this->SiteID = $value;
	}
/**
 *

 * @return 
 */
	function SiteDetailsType()
	{
		$this->EbatNs_ComplexType('SiteDetailsType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'Site' =>
				array(
					'required' => false,
					'type' => 'SiteCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'SiteID' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
