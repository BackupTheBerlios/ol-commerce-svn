<?php
// $Id: EbatNs_Logger.php,v 1.1.1.1.2.1 2007/04/08 07:16:39 gswkaiser Exp $
/* $Log: EbatNs_Logger.php,v $
/* Revision 1.1.1.1.2.1  2007/04/08 07:16:39  gswkaiser
/* olcommerce_2_0_0
/*
/* Update
/*
/* Revision 1.1.1.1  2006/12/22 14:37:37  gswkaiser
/* no message
/*
 * 
 * 3     3.02.06 10:44 Mcoslar
 * 
 * 2     30.01.06 16:44 Mcoslar
 * nderungen eingefgt
 */
	class EbatNs_Logger
	{
		// debugging options
		var $_debugXmlBeautify = true;
		var $_debugLogDestination = 'stdout';
		var $_debugSecureLogging = true;
		var $_debugHtml = true;
		
		function EbatNs_Logger($beautfyXml = false, $destination = 'stdout', $asHtml = true, $SecureLogging = true)
		{
			$this->_debugLogDestination = $destination;
			$this->_debugXmlBeautify = $beautfyXml;
			$this->_debugHtml = $asHtml;
			$this->_debugSecureLogging = $SecureLogging;
		}
		
		function log($msg, $subject = null)
		{
			if ($this->_debugLogDestination)
			{
				if ($this->_debugLogDestination == 'stdout')
				{
					if ($this->_debugHtml)
					{
						print_r("<pre>");
						if ($subject)
							print_r("$subject :<br/>");				
						print_r(htmlentities($msg) . "\r\n");
						print_r("</pre>");
					}
					else
					{
						if ($subject)
							print_r($subject . ' : ' . "\r\n"); 
						print_r($msg . "\r\n");
					}
				}
				else
				{
					ob_start();
					echo date('r') . "\t" . $subject . "\t";
					print_r($msg);
					echo "\r\n";
					error_log(ob_get_clean(), 3, $this->_debugLogDestination);
				}			
			}
		}
		
		function logXml($xmlMsg, $subject = null)
		{
			if ($this->_debugSecureLogging)
			{
				$xmlMsg = preg_replace("/<eBayAuthToken>.*<\/eBayAuthToken>/", "<eBayAuthToken>...</eBayAuthToken>", $xmlMsg);
				$xmlMsg = preg_replace("/<AuthCert>.*<\/AuthCert>/", "<AuthCert>...</AuthCert>", $xmlMsg);
			}

			if ($this->_debugXmlBeautify)
			{
		        if (is_object($xmlMsg))
					$this->log($xmlMsg);
				else
				{
					require_once 'XML/Beautifier.php';
					$xmlb = new XML_Beautifier();
					$this->log($xmlb->formatString($xmlMsg), $subject);
				}
				
				return;
			}
			
			$this->log($xmlMsg, $subject);
		}
	}

?>