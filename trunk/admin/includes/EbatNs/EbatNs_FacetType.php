<?php
// $Id: EbatNs_FacetType.php,v 1.1.1.1 2006/12/22 14:37:36 gswkaiser Exp $
/* $Log: EbatNs_FacetType.php,v $
/* Revision 1.1.1.1  2006/12/22 14:37:36  gswkaiser
/* no message
/*
 * 
 * 2     3.02.06 10:44 Mcoslar
 * 
 * 1     30.01.06 12:11 Charnisch
 */
	require_once 'EbatNs_SimpleType.php';
	
	class EbatNs_FacetType extends EbatNs_SimpleType
	{
		function EbatNs_FacetType($name, $nsURI)
		{
			$this->EbatNs_SimpleType($name, $nsURI);
		}
	}
?>