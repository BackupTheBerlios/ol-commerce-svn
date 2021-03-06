<?php
// autogenerated file 17.11.2006 13:29
// $Id: CategoryFinanceOfferType.php,v 1.1.1.1 2006/12/22 14:37:22 gswkaiser Exp $
// $Log: CategoryFinanceOfferType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:22  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class CategoryFinanceOfferType extends EbatNs_ComplexType
{
	// start props
	// @var string $FinanceOfferID
	var $FinanceOfferID;
	// @var string $CategoryID
	var $CategoryID;
	// end props

/**
 *

 * @return string
 * @param  $index 
 */
	function getFinanceOfferID($index = null)
	{
		if ($index) {
		return $this->FinanceOfferID[$index];
	} else {
		return $this->FinanceOfferID;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setFinanceOfferID($value, $index = null)
	{
		if ($index) {
	$this->FinanceOfferID[$index] = $value;
	} else {
	$this->FinanceOfferID = $value;
	}

	}
/**
 *

 * @return string
 */
	function getCategoryID()
	{
		return $this->CategoryID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCategoryID($value)
	{
		$this->CategoryID = $value;
	}
/**
 *

 * @return 
 */
	function CategoryFinanceOfferType()
	{
		$this->EbatNs_ComplexType('CategoryFinanceOfferType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'FinanceOfferID' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => true,
					'cardinality' => '0..*'
				),
				'CategoryID' =>
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
