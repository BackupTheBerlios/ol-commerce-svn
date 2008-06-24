<?php
// autogenerated file 17.11.2006 13:29
// $Id: AddToWatchListResponseType.php,v 1.1.1.1 2006/12/22 14:37:16 gswkaiser Exp $
// $Log: AddToWatchListResponseType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:16  gswkaiser
// no message
//
//
require_once 'AbstractResponseType.php';

class AddToWatchListResponseType extends AbstractResponseType
{
	// start props
	// @var int $WatchListCount
	var $WatchListCount;
	// @var int $WatchListMaximum
	var $WatchListMaximum;
	// end props

/**
 *

 * @return int
 */
	function getWatchListCount()
	{
		return $this->WatchListCount;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setWatchListCount($value)
	{
		$this->WatchListCount = $value;
	}
/**
 *

 * @return int
 */
	function getWatchListMaximum()
	{
		return $this->WatchListMaximum;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setWatchListMaximum($value)
	{
		$this->WatchListMaximum = $value;
	}
/**
 *

 * @return 
 */
	function AddToWatchListResponseType()
	{
		$this->AbstractResponseType('AddToWatchListResponseType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'WatchListCount' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'WatchListMaximum' =>
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
