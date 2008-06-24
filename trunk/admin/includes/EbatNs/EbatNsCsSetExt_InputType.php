<?php
// autogenerated file 03.02.2006 11:21
// $Id: EbatNsCsSetExt_InputType.php,v 1.1.1.1 2006/12/22 14:37:32 gswkaiser Exp $
// $Log: EbatNsCsSetExt_InputType.php,v $
// Revision 1.1.1.1  2006/12/22 14:37:32  gswkaiser
// no message
//
// Revision 1.1  2006/02/03 10:52:01  michael
// initial checkin
//
//
require_once 'EbatNs_ComplexType.php';

class EbatNsCsSetExt_InputType extends EbatNs_ComplexType
{
	// start props
	// end props

/**
 *

 * @return 
 */
	function EbatNsCsSetExt_InputType()
	{
		$this->EbatNs_ComplexType('EbatNsCsSetExt_InputType', 'http://www.intradesys.com/Schemas/ebay/AttributeData_Extension.xsd');
	$this->_attributes = array_merge($this->_attributes,
		array(
			'align' =>
			array(
				'name' => 'align',
				'type' => 'string',
				'use' => 'required'
			),
			'bold' =>
			array(
				'name' => 'bold',
				'type' => 'boolean',
				'use' => 'required'
			),
			'color' =>
			array(
				'name' => 'color',
				'type' => 'string',
				'use' => 'required'
			),
			'columns' =>
			array(
				'name' => 'columns',
				'type' => 'string',
				'use' => 'required'
			),
			'face' =>
			array(
				'name' => 'face',
				'type' => 'string',
				'use' => 'required'
			),
			'size' =>
			array(
				'name' => 'size',
				'type' => 'string',
				'use' => 'required'
			),
			'type' =>
			array(
				'name' => 'type',
				'type' => 'string',
				'use' => 'required'
			)
		));

	}
}
?>