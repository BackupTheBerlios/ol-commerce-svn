<?php
// autogenerated file 17.11.2006 13:30
// $Id: UserIDType.php,v 1.1.1.1 2006/12/22 14:38:54 gswkaiser Exp $
// $Log: UserIDType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:54  gswkaiser
// no message
//
//
require_once 'EbatNs_SimpleType.php';

class UserIDType extends EbatNs_SimpleType
{
	// start props
	// end props

/**
 *

 * @return 
 */
	function UserIDType()
	{
		$this->EbatNs_SimpleType('UserIDType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_UserIDType = new UserIDType();

?>
