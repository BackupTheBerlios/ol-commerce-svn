<?php
// autogenerated file 17.11.2006 13:29
// $Id: DisputeSortTypeCodeType.php,v 1.1.1.1 2006/12/22 14:37:29 gswkaiser Exp $
// $Log: DisputeSortTypeCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:29  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class DisputeSortTypeCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $None
	var $None = 'None';
	// @var string $DisputeCreatedTimeAscending
	var $DisputeCreatedTimeAscending = 'DisputeCreatedTimeAscending';
	// @var string $DisputeCreatedTimeDescending
	var $DisputeCreatedTimeDescending = 'DisputeCreatedTimeDescending';
	// @var string $DisputeStatusAscending
	var $DisputeStatusAscending = 'DisputeStatusAscending';
	// @var string $DisputeStatusDescending
	var $DisputeStatusDescending = 'DisputeStatusDescending';
	// @var string $DisputeCreditEligibilityAscending
	var $DisputeCreditEligibilityAscending = 'DisputeCreditEligibilityAscending';
	// @var string $DisputeCreditEligibilityDescending
	var $DisputeCreditEligibilityDescending = 'DisputeCreditEligibilityDescending';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function DisputeSortTypeCodeType()
	{
		$this->EbatNs_FacetType('DisputeSortTypeCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_DisputeSortTypeCodeType = new DisputeSortTypeCodeType();

?>
