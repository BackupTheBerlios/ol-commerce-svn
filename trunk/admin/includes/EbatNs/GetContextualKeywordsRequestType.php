<?php
// autogenerated file 17.11.2006 13:29
// $Id: GetContextualKeywordsRequestType.php,v 1.1.1.1 2006/12/22 14:37:55 gswkaiser Exp $
// $Log: GetContextualKeywordsRequestType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:55  gswkaiser
// no message
//
//
require_once 'AbstractRequestType.php';

class GetContextualKeywordsRequestType extends AbstractRequestType
{
	// start props
	// @var anyURI $URL
	var $URL;
	// @var string $Encoding
	var $Encoding;
	// @var string $CategoryID
	var $CategoryID;
	// end props

/**
 *

 * @return anyURI
 */
	function getURL()
	{
		return $this->URL;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setURL($value)
	{
		$this->URL = $value;
	}
/**
 *

 * @return string
 */
	function getEncoding()
	{
		return $this->Encoding;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setEncoding($value)
	{
		$this->Encoding = $value;
	}
/**
 *

 * @return string
 * @param  $index 
 */
	function getCategoryID($index = null)
	{
		if ($index) {
		return $this->CategoryID[$index];
	} else {
		return $this->CategoryID;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setCategoryID($value, $index = null)
	{
		if ($index) {
	$this->CategoryID[$index] = $value;
	} else {
	$this->CategoryID = $value;
	}

	}
/**
 *

 * @return 
 */
	function GetContextualKeywordsRequestType()
	{
		$this->AbstractRequestType('GetContextualKeywordsRequestType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'URL' =>
				array(
					'required' => false,
					'type' => 'anyURI',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Encoding' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'CategoryID' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => true,
					'cardinality' => '0..*'
				)
			));

	}
}
?>
