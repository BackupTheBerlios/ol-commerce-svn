<?php
// autogenerated file 17.11.2006 13:29
// $Id: GallerySortFilterCodeType.php,v 1.1.1.1 2006/12/22 14:37:50 gswkaiser Exp $
// $Log: GallerySortFilterCodeType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:50  gswkaiser
// no message
//
//
require_once 'EbatNs_FacetType.php';

class GallerySortFilterCodeType extends EbatNs_FacetType
{
	// start props
	// @var string $ShowAnyItems
	var $ShowAnyItems = 'ShowAnyItems';
	// @var string $ShowItemsWithGalleryImagesFirst
	var $ShowItemsWithGalleryImagesFirst = 'ShowItemsWithGalleryImagesFirst';
	// @var string $ShowOnlyItemsWithGalleryImages
	var $ShowOnlyItemsWithGalleryImages = 'ShowOnlyItemsWithGalleryImages';
	// @var string $CustomCode
	var $CustomCode = 'CustomCode';
	// end props

/**
 *

 * @return 
 */
	function GallerySortFilterCodeType()
	{
		$this->EbatNs_FacetType('GallerySortFilterCodeType', 'urn:ebay:apis:eBLBaseComponents');

	}
}

$Facet_GallerySortFilterCodeType = new GallerySortFilterCodeType();

?>
