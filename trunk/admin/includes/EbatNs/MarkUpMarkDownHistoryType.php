<?php
// autogenerated file 17.11.2006 13:29
// $Id: MarkUpMarkDownHistoryType.php,v 1.1.1.1 2006/12/22 14:38:19 gswkaiser Exp $
// $Log: MarkUpMarkDownHistoryType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:19  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'MarkUpMarkDownEventType.php';

class MarkUpMarkDownHistoryType extends EbatNs_ComplexType
{
	// start props
	// @var MarkUpMarkDownEventType $MarkUpMarkDownEvent
	var $MarkUpMarkDownEvent;
	// end props

/**
 *

 * @return MarkUpMarkDownEventType
 * @param  $index 
 */
	function getMarkUpMarkDownEvent($index = null)
	{
		if ($index) {
		return $this->MarkUpMarkDownEvent[$index];
	} else {
		return $this->MarkUpMarkDownEvent;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setMarkUpMarkDownEvent($value, $index = null)
	{
		if ($index) {
	$this->MarkUpMarkDownEvent[$index] = $value;
	} else {
	$this->MarkUpMarkDownEvent = $value;
	}

	}
/**
 *

 * @return 
 */
	function MarkUpMarkDownHistoryType()
	{
		$this->EbatNs_ComplexType('MarkUpMarkDownHistoryType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'MarkUpMarkDownEvent' =>
				array(
					'required' => false,
					'type' => 'MarkUpMarkDownEventType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>