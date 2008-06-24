<?php
// autogenerated file 17.11.2006 13:29
// $Id: SiteHostedPictureType.php,v 1.1.1.1 2006/12/22 14:38:47 gswkaiser Exp $
// $Log: SiteHostedPictureType.php,v $
// Revision 1.1.1.1  2006/12/22 14:38:47  gswkaiser
// no message
//
//
require_once 'GalleryTypeCodeType.php';
require_once 'EbatNs_ComplexType.php';
require_once 'PictureSourceCodeType.php';
require_once 'PhotoDisplayCodeType.php';

class SiteHostedPictureType extends EbatNs_ComplexType
{
	// start props
	// @var anyURI $PictureURL
	var $PictureURL;
	// @var PhotoDisplayCodeType $PhotoDisplay
	var $PhotoDisplay;
	// @var GalleryTypeCodeType $GalleryType
	var $GalleryType;
	// @var anyURI $GalleryURL
	var $GalleryURL;
	// @var PictureSourceCodeType $PictureSource
	var $PictureSource;
	// end props

/**
 *

 * @return anyURI
 * @param  $index 
 */
	function getPictureURL($index = null)
	{
		if ($index) {
		return $this->PictureURL[$index];
	} else {
		return $this->PictureURL;
	}

	}
/**
 *

 * @return void
 * @param  $value 
 * @param  $index 
 */
	function setPictureURL($value, $index = null)
	{
		if ($index) {
	$this->PictureURL[$index] = $value;
	} else {
	$this->PictureURL = $value;
	}

	}
/**
 *

 * @return PhotoDisplayCodeType
 */
	function getPhotoDisplay()
	{
		return $this->PhotoDisplay;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPhotoDisplay($value)
	{
		$this->PhotoDisplay = $value;
	}
/**
 *

 * @return GalleryTypeCodeType
 */
	function getGalleryType()
	{
		return $this->GalleryType;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setGalleryType($value)
	{
		$this->GalleryType = $value;
	}
/**
 *

 * @return anyURI
 */
	function getGalleryURL()
	{
		return $this->GalleryURL;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setGalleryURL($value)
	{
		$this->GalleryURL = $value;
	}
/**
 *

 * @return PictureSourceCodeType
 */
	function getPictureSource()
	{
		return $this->PictureSource;
	}
/**
 *

 * @return void
 * @param  $value 
 */
	function setPictureSource($value)
	{
		$this->PictureSource = $value;
	}
/**
 *

 * @return 
 */
	function SiteHostedPictureType()
	{
		$this->EbatNs_ComplexType('SiteHostedPictureType', 'urn:ebay:apis:eBLBaseComponents');
		$this->_elements = array_merge($this->_elements,
			array(
				'PictureURL' =>
				array(
					'required' => false,
					'type' => 'anyURI',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => true,
					'cardinality' => '0..*'
				),
				'PhotoDisplay' =>
				array(
					'required' => false,
					'type' => 'PhotoDisplayCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'GalleryType' =>
				array(
					'required' => false,
					'type' => 'GalleryTypeCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				),
				'GalleryURL' =>
				array(
					'required' => false,
					'type' => 'anyURI',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'PictureSource' =>
				array(
					'required' => false,
					'type' => 'PictureSourceCodeType',
					'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
					'array' => false,
					'cardinality' => '0..1'
				)
			));

	}
}
?>