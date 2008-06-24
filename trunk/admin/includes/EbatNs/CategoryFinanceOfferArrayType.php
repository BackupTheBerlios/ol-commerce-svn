<?php
// autogenerated file 17.11.2006 13:29
// $Id: CategoryFinanceOfferArrayType.php,v 1.1.1.1 2006/12/22 14:37:22 gswkaiser Exp $
// $Log: CategoryFinanceOfferArrayType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:22  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'CategoryFinanceOfferType.php';

class CategoryFinanceOfferArrayType extends EbatNs_ComplexType
{
	// start props
	// @var CategoryFinanceOfferType $CategoryFinanceOffer
	var $CategoryFinanceOffer;
	// end props

/**
 *

 * @return CategoryFinanceOfferType
 * @param  $index 
 */
	function getCategoryFinanceOffer($index = null)
	{
		if ($index) {
		return $this->CategoryFinanceOffer[$index];
	} else {
		return $this->CategoryFinanceOffer;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setCategoryFinanceOffer($value, $index = null)
	{
		if ($index) {
	$this->CategoryFinanceOffer[$index] = $value;
	} else {
	$this->CategoryFinanceOffer = $value;
	}

	}
/**
 *

 * @return 
 */
	function CategoryFinanceOfferArrayType()
	{
		$this->EbatNs_ComplexType('CategoryFinanceOfferArrayType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'CategoryFinanceOffer' =>
				array(
					'required' => false,
					'type' => 'CategoryFinanceOfferType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>
