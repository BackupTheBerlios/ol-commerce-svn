<?php
// autogenerated file 17.11.2006 13:29
// $Id: StoreColorSchemeType.php,v 1.1.1.1 2006/12/22 14:38:48 gswkaiser Exp $
// $Log: StoreColorSchemeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:48  gswkaiser
// no message
//
//
require_once 'StoreColorType.php';
require_once 'StoreFontType.php';
require_once 'EbatNs_ComplexType.php';

class StoreColorSchemeType extends EbatNs_ComplexType
{
	// start props
	// @var int $ColorSchemeID
	var $ColorSchemeID;
	// @var string $Name
	var $Name;
	// @var StoreColorType $Color
	var $Color;
	// @var StoreFontType $Font
	var $Font;
	// end props

/**
 *

 * @return int
 */
	function getColorSchemeID()
	{
		return $this->ColorSchemeID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setColorSchemeID($value)
	{
		$this->ColorSchemeID = $value;
	}
/**
 *

 * @return string
 */
	function getName()
	{
		return $this->Name;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setName($value)
	{
		$this->Name = $value;
	}
/**
 *

 * @return StoreColorType
 */
	function getColor()
	{
		return $this->Color;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setColor($value)
	{
		$this->Color = $value;
	}
/**
 *

 * @return StoreFontType
 */
	function getFont()
	{
		return $this->Font;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setFont($value)
	{
		$this->Font = $value;
	}
/**
 *

 * @return 
 */
	function StoreColorSchemeType()
	{
		$this->EbatNs_ComplexType('StoreColorSchemeType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'ColorSchemeID' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Name' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Color' =>
				array(
					'required' => false,
					'type' => 'StoreColorType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Font' =>
				array(
					'required' => false,
					'type' => 'StoreFontType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>