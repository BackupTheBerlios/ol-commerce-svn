<?php
// autogenerated file 17.11.2006 13:29
// $Id: RequestCategoriesType.php,v 1.1.1.1 2006/12/22 14:38:33 gswkaiser Exp $
// $Log: RequestCategoriesType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:33  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class RequestCategoriesType extends EbatNs_ComplexType
{
	// start props
	// @var boolean $CategoriesOnly
	var $CategoriesOnly;
	// @var int $MaxCategories
	var $MaxCategories;
	// @var int $MaxSubcategories
	var $MaxSubcategories;
	// @var int $Levels
	var $Levels;
	// end props

/**
 *

 * @return boolean
 */
	function getCategoriesOnly()
	{
		return $this->CategoriesOnly;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCategoriesOnly($value)
	{
		$this->CategoriesOnly = $value;
	}
/**
 *

 * @return int
 */
	function getMaxCategories()
	{
		return $this->MaxCategories;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setMaxCategories($value)
	{
		$this->MaxCategories = $value;
	}
/**
 *

 * @return int
 */
	function getMaxSubcategories()
	{
		return $this->MaxSubcategories;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setMaxSubcategories($value)
	{
		$this->MaxSubcategories = $value;
	}
/**
 *

 * @return int
 */
	function getLevels()
	{
		return $this->Levels;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setLevels($value)
	{
		$this->Levels = $value;
	}
/**
 *

 * @return 
 */
	function RequestCategoriesType()
	{
		$this->EbatNs_ComplexType('RequestCategoriesType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'CategoriesOnly' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'MaxCategories' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'MaxSubcategories' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Levels' =>
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