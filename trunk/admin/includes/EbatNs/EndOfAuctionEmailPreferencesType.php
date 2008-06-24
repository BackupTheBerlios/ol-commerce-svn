<?php
// autogenerated file 17.11.2006 13:29
// $Id: EndOfAuctionEmailPreferencesType.php,v 1.1.1.1 2006/12/22 14:37:44 gswkaiser Exp $
// $Log: EndOfAuctionEmailPreferencesType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:44  gswkaiser
// no message
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'EndOfAuctionLogoTypeCodeType.php';

class EndOfAuctionEmailPreferencesType extends EbatNs_ComplexType
{
	// start props
	// @var string $TemplateText
	var $TemplateText;
	// @var anyURI $LogoURL
	var $LogoURL;
	// @var EndOfAuctionLogoTypeCodeType $LogoType
	var $LogoType;
	// @var boolean $EmailCustomized
	var $EmailCustomized;
	// @var boolean $TextCustomized
	var $TextCustomized;
	// @var boolean $LogoCustomized
	var $LogoCustomized;
	// @var boolean $CopyEmail
	var $CopyEmail;
	// end props

/**
 *

 * @return string
 */
	function getTemplateText()
	{
		return $this->TemplateText;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setTemplateText($value)
	{
		$this->TemplateText = $value;
	}
/**
 *

 * @return anyURI
 */
	function getLogoURL()
	{
		return $this->LogoURL;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setLogoURL($value)
	{
		$this->LogoURL = $value;
	}
/**
 *

 * @return EndOfAuctionLogoTypeCodeType
 */
	function getLogoType()
	{
		return $this->LogoType;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setLogoType($value)
	{
		$this->LogoType = $value;
	}
/**
 *

 * @return boolean
 */
	function getEmailCustomized()
	{
		return $this->EmailCustomized;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setEmailCustomized($value)
	{
		$this->EmailCustomized = $value;
	}
/**
 *

 * @return boolean
 */
	function getTextCustomized()
	{
		return $this->TextCustomized;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setTextCustomized($value)
	{
		$this->TextCustomized = $value;
	}
/**
 *

 * @return boolean
 */
	function getLogoCustomized()
	{
		return $this->LogoCustomized;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setLogoCustomized($value)
	{
		$this->LogoCustomized = $value;
	}
/**
 *

 * @return boolean
 */
	function getCopyEmail()
	{
		return $this->CopyEmail;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setCopyEmail($value)
	{
		$this->CopyEmail = $value;
	}
/**
 *

 * @return 
 */
	function EndOfAuctionEmailPreferencesType()
	{
		$this->EbatNs_ComplexType('EndOfAuctionEmailPreferencesType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'TemplateText' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'LogoURL' =>
				array(
					'required' => false,
					'type' => 'anyURI',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'LogoType' =>
				array(
					'required' => false,
					'type' => 'EndOfAuctionLogoTypeCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'EmailCustomized' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'TextCustomized' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'LogoCustomized' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'CopyEmail' =>
				array(
					'required' => false,
					'type' => 'boolean',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>
