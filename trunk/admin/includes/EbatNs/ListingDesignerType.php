<?php
// autogenerated file 17.11.2006 13:29
// $Id: ListingDesignerType.php,v 1.1.1.1 2006/12/22 14:38:16 gswkaiser Exp $
// $Log: ListingDesignerType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:16  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class ListingDesignerType extends EbatNs_ComplexType
{
	// start props
	// @var int $LayoutID
	var $LayoutID;
	// @var boolean $OptimalPictureSize
	var $OptimalPictureSize;
	// @var int $ThemeID
	var $ThemeID;
	// end props

/**
 *

 * @return int
 */
	function getLayoutID()
	{
		return $this->LayoutID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setLayoutID($value)
	{
		$this->LayoutID = $value;
	}
/**
 *

 * @return boolean
 */
	function getOptimalPictureSize()
	{
		return $this->OptimalPictureSize;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setOptimalPictureSize($value)
	{
		$this->OptimalPictureSize = $value;
	}
/**
 *

 * @return int
 */
	function getThemeID()
	{
		return $this->ThemeID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setThemeID($value)
	{
		$this->ThemeID = $value;
	}
/**
 *

 * @return 
 */
	function ListingDesignerType()
	{
		$this->EbatNs_ComplexType('ListingDesignerType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'LayoutID' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'OptimalPictureSize' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ThemeID' =>
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