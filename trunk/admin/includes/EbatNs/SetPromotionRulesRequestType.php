<?php
// autogenerated file 17.11.2006 13:29
// $Id: SetPromotionRulesRequestType.php,v 1.1.1.1 2006/12/22 14:38:40 gswkaiser Exp $
// $Log: SetPromotionRulesRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:40  gswkaiser
// no message
//
//
require_once 'PromotionRuleArrayType.php';
require_once 'OperationTypeCodeType.php';
require_once 'AbstractRequestType.php';

class SetPromotionRulesRequestType extends AbstractRequestType
{
	// start props
	// @var OperationTypeCodeType $OperationType
	var $OperationType;
	// @var PromotionRuleArrayType $PromotionRuleArray
	var $PromotionRuleArray;
	// end props

/**
 *

 * @return OperationTypeCodeType
 */
	function getOperationType()
	{
		return $this->OperationType;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setOperationType($value)
	{
		$this->OperationType = $value;
	}
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
	function SetPromotionRulesRequestType()
	{
		$this->AbstractRequestType('SetPromotionRulesRequestType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'OperationType' =>
				array(
					'required' => false,
					'type' => 'OperationTypeCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
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