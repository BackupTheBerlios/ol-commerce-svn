<?php
// autogenerated file 17.11.2006 13:29
// $Id: NotificationRoleCodeType.php,v 1.1.1.1 2006/12/22 14:38:24 gswkaiser Exp $
// $Log: NotificationRoleCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:24  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class NotificationRoleCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Application
	var $Application = 'Application';
	// @var string $User
	var $User = 'User';
	// @var string $UserData
	var $UserData = 'UserData';
	// @var string $Event
	var $Event = 'Event';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function NotificationRoleCodeType()
	{
		$this->EbatNs_FacetType('NotificationRoleCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_NotificationRoleCodeType = new NotificationRoleCodeType();

?>