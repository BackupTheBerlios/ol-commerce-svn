<?php
// autogenerated file 17.11.2006 13:29
// $Id: PromotionRuleArrayType.php,v 1.1.1.1 2006/12/22 14:38:31 gswkaiser Exp $
// $Log: PromotionRuleArrayType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:31  gswkaiser
// no message
//
//
require_once 'PromotionRuleType.php';
require_once 'EbatNs_ComplexType.php';

class PromotionRuleArrayType extends EbatNs_ComplexType
{
	// start props
	// @var PromotionRuleType $PromotionRule
	var $PromotionRule;
	// end props

/**
 *

 * @return PromotionRuleType
 * @param  $index 
 */
	function getPromotionRule($index = null)
	{
		if ($index) {
		return $this->PromotionRule[$index];
	} else {
		return $this->PromotionRule;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setPromotionRule($value, $index = null)
	{
		if ($index) {
	$this->PromotionRule[$index] = $value;
	} else {
	$this->PromotionRule = $value;
	}

	}
/**
 *

 * @return 
 */
	function PromotionRuleArrayType()
	{
		$this->EbatNs_ComplexType('PromotionRuleArrayType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'PromotionRule' =>
				array(
					'required' => false,
					'type' => 'PromotionRuleType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>
