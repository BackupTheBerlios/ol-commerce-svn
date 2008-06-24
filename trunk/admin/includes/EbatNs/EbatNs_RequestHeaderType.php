<?php 
// $Id: EbatNs_RequestHeaderType.php,v 1.1.1.1 2006/12/22 14:37:42 gswkaiser Exp $
/* $Log: EbatNs_RequestHeaderType.php,v $
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

	class EbatNs_RequestHeaderType extends EbatNs_ComplexType
	{
		var $RequesterCredentials;
		
		function EbatNs_RequestHeaderType()
		{
			$this->EbatNs_ComplexType('EbatNs_RequestHeaderType', 'urn:ebay:apis:eBLBaseComponents');
			$this->_elements = array_merge($this->_elements,
				array(
					'RequesterCredentials' =>
					array(
						'required' => true,
						'type' => 'EbatNs_RequesterCredentialType',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema'
					)
				));	
		}
	}
?>