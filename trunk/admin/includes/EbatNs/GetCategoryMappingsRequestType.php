<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetCategoryMappingsRequestType.php,v 1.1.1.1 2006/12/22 14:37:54 gswkaiser Exp $
// $Log: GetCategoryMappingsRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:54  gswkaiser
// no message
//
//
require_once 'AbstractRequestType.php';

class GetCategoryMappingsRequestType extends AbstractRequestType
{
	// start props
	// @var string $CategoryVersion
	var $CategoryVersion;
	// end props

/**
 *

 * @return string
 */
	function getCategoryVersion()
	{
		return $this->CategoryVersion;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCategoryVersion($value)
	{
		$this->CategoryVersion = $value;
	}
/**
 *

 * @return 
 */
	function GetCategoryMappingsRequestType()
	{
		$this->AbstractRequestType('GetCategoryMappingsRequestType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'CategoryVersion' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
