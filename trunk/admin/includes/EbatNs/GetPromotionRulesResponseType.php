<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetPromotionRulesResponseType.php,v 1.1.1.1 2006/12/22 14:38:04 gswkaiser Exp $
// $Log: GetPromotionRulesResponseType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:04  gswkaiser
// no message
//
//
require_once 'PromotionRuleArrayType.php';
require_once 'AbstractResponseType.php';

class GetPromotionRulesResponseType extends AbstractResponseType
{
	// start props
	// @var PromotionRuleArrayType $PromotionRuleArray
	var $PromotionRuleArray;
	// end props

/**
 *

 * @return PromotionRuleArrayType
 */
	function getPromotionRuleArray()
	{
		return $this->PromotionRuleArray;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPromotionRuleArray($value)
	{
		$this->PromotionRuleArray = $value;
	}
/**
 *

 * @return 
 */
	function GetPromotionRulesResponseType()
	{
		$this->AbstractResponseType('GetPromotionRulesResponseType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'PromotionRuleArray' =>
				array(
					'required' => false,
					'type' => 'PromotionRuleArrayType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
