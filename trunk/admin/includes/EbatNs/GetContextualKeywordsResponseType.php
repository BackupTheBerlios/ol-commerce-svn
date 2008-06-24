<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetContextualKeywordsResponseType.php,v 1.1.1.1 2006/12/22 14:37:55 gswkaiser Exp $
// $Log: GetContextualKeywordsResponseType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:55  gswkaiser
// no message
//
//
require_once 'ContextSearchAssetType.php';
require_once 'AbstractResponseType.php';

class GetContextualKeywordsResponseType extends AbstractResponseType
{
	// start props
	// @var ContextSearchAssetType $ContextSearchAsset
	var $ContextSearchAsset;
	// end props

/**
 *

 * @return ContextSearchAssetType
 * @param  $index 
 */
	function getContextSearchAsset($index = null)
	{
		if ($index) {
		return $this->ContextSearchAsset[$index];
	} else {
		return $this->ContextSearchAsset;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setContextSearchAsset($value, $index = null)
	{
		if ($index) {
	$this->ContextSearchAsset[$index] = $value;
	} else {
	$this->ContextSearchAsset = $value;
	}

	}
/**
 *

 * @return 
 */
	function GetContextualKeywordsResponseType()
	{
		$this->AbstractResponseType('GetContextualKeywordsResponseType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'ContextSearchAsset' =>
				array(
					'required' => false,
					'type' => 'ContextSearchAssetType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>