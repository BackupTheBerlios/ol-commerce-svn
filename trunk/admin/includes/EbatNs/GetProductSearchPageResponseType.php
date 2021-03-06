<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetProductSearchPageResponseType.php,v 1.1.1.1 2006/12/22 14:38:04 gswkaiser Exp $
// $Log: GetProductSearchPageResponseType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:04  gswkaiser
// no message
//
//
require_once 'ProductSearchPageType.php';
require_once 'AbstractResponseType.php';

class GetProductSearchPageResponseType extends AbstractResponseType
{
	// start props
	// @var string $AttributeSystemVersion
	var $AttributeSystemVersion;
	// @var ProductSearchPageType $ProductSearchPage
	var $ProductSearchPage;
	// end props

/**
 *

 * @return string
 */
	function getAttributeSystemVersion()
	{
		return $this->AttributeSystemVersion;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setAttributeSystemVersion($value)
	{
		$this->AttributeSystemVersion = $value;
	}
/**
 *

 * @return ProductSearchPageType
 * @param  $index 
 */
	function getProductSearchPage($index = null)
	{
		if ($index) {
		return $this->ProductSearchPage[$index];
	} else {
		return $this->ProductSearchPage;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setProductSearchPage($value, $index = null)
	{
		if ($index) {
	$this->ProductSearchPage[$index] = $value;
	} else {
	$this->ProductSearchPage = $value;
	}

	}
/**
 *

 * @return 
 */
	function GetProductSearchPageResponseType()
	{
		$this->AbstractResponseType('GetProductSearchPageResponseType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'AttributeSystemVersion' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'ProductSearchPage' =>
				array(
					'required' => false,
					'type' => 'ProductSearchPageType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>
