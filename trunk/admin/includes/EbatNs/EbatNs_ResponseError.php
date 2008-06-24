<?php 
// $Id: EbatNs_ResponseError.php,v 1.1.1.1 2006/12/22 14:37:42 gswkaiser Exp $
/* $Log: EbatNs_ResponseError.php,v $
/* Revision 1.1.1.1  2006/12/22 14:37:42  gswkaiser
/* no message
/*
 * 
 * 3     3.02.06 10:44 Mcoslar
 * 
 * 2     30.01.06 16:44 Mcoslar
 * nderungen eingefgt
 */
	require_once 'AbstractResponseType.php';

	class EbatNs_ResponseError extends AbstractResponseType
	{
		function EbatNs_ResponseError()
		{
			$this->AbstractResponseType();
			$this->Errors = array();
			$this->Ack = 'Failure';
		}
		
		function raise($msg, $code, $severity = 'Error', $errClass = 'SystemError')
		{
			$err = new ErrorType();
			$err->ErrorCode = $code;
			$err->SeverityCode = $severity;
			$err->LongMessage = htmlentities($msg);
			$err->ErrorClassification = $errClass;
			$this->_reduceElement($err);
			
			$this->Errors[] = $err;
		}
		
		function getErrors()
		{
			return $this->Errors;
		}
		
		function isGood($onlyErrors = true)
		{
			if ($onlyErrors)
			{
				if (count($this->Errors))
					foreach($this->Errors as $error)
					{
						if ($error['severity'] == 'Error')
							return false;
					}
				return true;
			}
			else
				return (count($this->Errors) == 0);
		}
		
		function _reduceElement(& $element)
		{
			foreach (get_object_vars($element) as $member => $value)
				if ($member[0] == '_' || ($value === null))
					unset($element->{$member});
			return count(get_object_vars($element)) > 0;
		}
	}
?>