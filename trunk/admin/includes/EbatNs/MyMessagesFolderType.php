<?php
// autogenerated file 17.11.2006 13:29
// $Id: MyMessagesFolderType.php,v 1.1.1.1 2006/12/22 14:38:22 gswkaiser Exp $
// $Log: MyMessagesFolderType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:22  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class MyMessagesFolderType extends EbatNs_ComplexType
{
	// start props
	// @var long $FolderID
	var $FolderID;
	// @var string $FolderName
	var $FolderName;
	// end props

/**
 *

 * @return long
 */
	function getFolderID()
	{
		return $this->FolderID;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setFolderID($value)
	{
		$this->FolderID = $value;
	}
/**
 *

 * @return string
 */
	function getFolderName()
	{
		return $this->FolderName;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setFolderName($value)
	{
		$this->FolderName = $value;
	}
/**
 *

 * @return 
 */
	function MyMessagesFolderType()
	{
		$this->EbatNs_ComplexType('MyMessagesFolderType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'FolderID' =>
				array(
					'required' => false,
					'type' => 'long',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'FolderName' =>
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
