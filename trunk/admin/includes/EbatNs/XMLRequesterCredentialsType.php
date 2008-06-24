<?php
// autogenerated file 17.11.2006 13:29
// $Id: XMLRequesterCredentialsType.php,v 1.1.1.1 2006/12/22 14:38:58 gswkaiser Exp $
// $Log: XMLRequesterCredentialsType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:58  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';

class XMLRequesterCredentialsType extends EbatNs_ComplexType
{
	// start props
	// @var string $Username
	var $Username;
	// @var string $Password
	var $Password;
	// @var string $eBayAuthToken
	var $eBayAuthToken;
	// end props

/**
 *

 * @return string
 */
	function getUsername()
	{
		return $this->Username;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setUsername($value)
	{
		$this->Username = $value;
	}
/**
 *

 * @return string
 */
	function getPassword()
	{
		return $this->Password;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPassword($value)
	{
		$this->Password = $value;
	}
/**
 *

 * @return string
 */
	function geteBayAuthToken()
	{
		return $this->eBayAuthToken;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function seteBayAuthToken($value)
	{
		$this->eBayAuthToken = $value;
	}
/**
 *

 * @return 
 */
	function XMLRequesterCredentialsType()
	{
		$this->EbatNs_ComplexType('XMLRequesterCredentialsType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'Username' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Password' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'eBayAuthToken' =>
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
