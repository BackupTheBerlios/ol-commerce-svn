<?php 
// $Id: EbatNs_RequesterCredentialType.php,v 1.1.1.1 2006/12/22 14:37:42 gswkaiser Exp $
/* $Log: EbatNs_RequesterCredentialType.php,v $
/* Revision 1.1.1.1  2006/12/22 14:37:42  gswkaiser
/* no message
/*
 * 
 * 3     3.02.06 10:44 Mcoslar
 * 
 * 2     30.01.06 16:44 Mcoslar
 * nderungen eingefgt
 */
	require_once 'EbatNs_ComplexType.php';

	class EbatNs_RequesterCredentialType extends EbatNs_ComplexType
	{
		// @var string $eBayAuthToken
		var $eBayAuthToken;
		// @var CredentialType $Credentials
		var $Credentials;
		var $_attributeValues;
		
		function EbatNs_RequesterCredentialType()
		{
			$this->_attributeValues['soap:actor'] = '';
			$this->_attributeValues['soap:mustUnderstand'] = '0';
			$this->_attributeValues['xmlns'] = 'urn:ebay:apis:eBLBaseComponents';		
			
			$this->EbatNs_ComplexType('EbatNs_RequesterCredentialType', 'urn:ebay:apis:eBLBaseComponents');
			$this->_elements = array_merge($this->_elements,
				array(
					
					'eBayAuthToken' =>
					array(
						'required' => false,
						'type' => 'string',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema'
					),
					'Credentials' =>
					array(
						'required' => false,
						'type' => 'CredentialType',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema'
					)
				));
		}
	}
?>