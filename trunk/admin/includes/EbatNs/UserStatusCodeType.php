<?php
// autogenerated file 17.11.2006 13:30
// $Id: UserStatusCodeType.php,v 1.1.1.1 2006/12/22 14:38:54 gswkaiser Exp $
// $Log: UserStatusCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:54  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class UserStatusCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $Unknown
	var $Unknown = 'Unknown';
	// @var string $Suspended
	var $Suspended = 'Suspended';
	// @var string $Confirmed
	var $Confirmed = 'Confirmed';
	// @var string $Unconfirmed
	var $Unconfirmed = 'Unconfirmed';
	// @var string $Ghost
	var $Ghost = 'Ghost';
	// @var string $InMaintenance
	var $InMaintenance = 'InMaintenance';
	// @var string $Deleted
	var $Deleted = 'Deleted';
	// @var string $CreditCardVerify
	var $CreditCardVerify = 'CreditCardVerify';
	// @var string $AccountOnHold
	var $AccountOnHold = 'AccountOnHold';
	// @var string $Merged
	var $Merged = 'Merged';
	// @var string $RegistrationCodeMailOut
	var $RegistrationCodeMailOut = 'RegistrationCodeMailOut';
	// @var string $TermPending
	var $TermPending = 'TermPending';
	// @var string $UnconfirmedHalfOptIn
	var $UnconfirmedHalfOptIn = 'UnconfirmedHalfOptIn';
	// @var string $CreditCardVerifyHalfOptIn
	var $CreditCardVerifyHalfOptIn = 'CreditCardVerifyHalfOptIn';
	// @var string $UnconfirmedPassport
	var $UnconfirmedPassport = 'UnconfirmedPassport';
	// @var string $CreditCardVerifyPassport
	var $CreditCardVerifyPassport = 'CreditCardVerifyPassport';
	// @var string $UnconfirmedExpress
	var $UnconfirmedExpress = 'UnconfirmedExpress';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function UserStatusCodeType()
	{
		$this->EbatNs_FacetType('UserStatusCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_UserStatusCodeType = new UserStatusCodeType();

?>
