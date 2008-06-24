<?php
// $Id: EbatNs_Client.php,v 1.1.1.1.2.1 2007/04/08 07:16:39 gswkaiser Exp $
/* $Log: EbatNs_Client.php,v $
/* Revision 1.1.1.1.2.1  2007/04/08 07:16:39  gswkaiser
/* olcommerce_2_0_0
/*
/* Update
/*
/* Revision 1.1.1.1  2006/12/22 14:37:35  gswkaiser
/* no message
/*
 * 
 * 5     29.05.06 9:59 Charnisch
 * 
 * 4     11.02.06 16:58 Charnisch
/* Revision 1.1  2006/02/03 10:52:01  michael
/* initial checkin
/*
*/
require_once 'UserIdPasswordType.php';

require_once 'EbatNs_RequesterCredentialType.php';
require_once 'EbatNs_RequestHeaderType.php';
require_once 'EbatNs_ResponseError.php';
require_once 'EbatNs_ResponseParser.php';

require_once 'EbatNs_DataConverter.php';

class EbatNs_Client
{ 
	// endpoint for call
	var $_ep;
	var $_session;
	var $_currentResult;
	var $_parser = null; 
	// callback-methods/functions for data-handling
	var $_hasCallbacks = false;
	var $_callbacks = null; 
	// EbatNs_DataConverter object
	var $_dataConverter = null;

	var $_logger = null;
	var $_parserOptions = null;
	
	var $_paginationElementCounter = 0;
	var $_paginationMaxElements = -1;
	
	var $_transportOptions = array();
	var $_loggingOptions   = array();
	var $_callUsage = array();
	
	function EbatNs_Client( $session, $converter = 'EbatNs_DataConverterIso' )
	{
		$this->_session = $session;
		if ($converter)
			$this->_dataConverter = new $converter();
		$this->_parser = null;
		
		$timeout = $session->getRequestTimeout();
		if (!$timeout)
			$timeout = 300;
		$httpCompress = $session->getUseHttpCompression();	
		
		$this->setTransportOptions(
			array(
				'HTTP_TIMEOUT'  => $timeout, 
				'HTTP_COMPRESS' => $httpCompress));
	} 

	function resetPaginationCounter($maxElements = -1)
	{
		$this->_paginationElementCounter = 0;
		if ($maxElements > 0)
			$this->_paginationMaxElements = $maxElements;
		else
			$this->_paginationMaxElements = -1;
	}
	
	function incrementPaginationCounter()
	{
		$this->_paginationElementCounter++;
		
		if ($this->_paginationMaxElements > 0 && ($this->_paginationElementCounter > $this->_paginationMaxElements))
			return false;
		else
			return true;
	}
	
	function getPaginationCounter()
	{
		return $this->_paginationElementCounter;
	}
	
	function setParserOption($name, $value = true)
	{
		$this->_parserOptions[$name] = $value;
	}

	function log( $msg, $subject = null )
	{
		if ( $this->_logger )
			$this->_logger->log( $msg, $subject );
	} 

	function logXml( $xmlMsg, $subject = null )
	{
		if ( $this->_logger )
			$this->_logger->logXml( $xmlMsg, $subject );
	} 
	
	function attachLogger(& $logger)
	{
		$this->_logger = $logger;
	}
	
	// HTTP_TIMEOUT: default 300 s
	// HTTP_COMPRESS: default true
	function setTransportOptions($options)
	{
		$this->_transportOptions = array_merge($this->_transportOptions, $options);
	}
	
	// LOG_TIMEPOINTS: true/false
	// LOG_API_USAGE: true/false
	function setLoggingOptions($options)
	{
		$this->_loggingOptions = array_merge($this->_loggingOptions, $options);
	}
	
	//
	// timepoint-tracing
	//
	var $_timePoints = null;
	var $_timePointsSEQ = null;
	
	function _getMicroseconds()
	{
		list( $ms, $s ) = explode( ' ', microtime() );
		return floor( $ms * 1000 ) + 1000 * $s;
	} 

	function _getElapsed( $start )
	{
		return $this->_getMicroseconds() - $start;
	} 

	function _startTp( $key )
	{
		if (!$this->_loggingOptions['LOG_TIMEPOINTS'])
			return;
			
		if ( isset( $this->_timePoints[$key] ) )
			$tp = $this->_timePoints[$key];

		$tp['start_tp'] = time();

		$tp['start'] = $this->_getMicroseconds();
		$this->_timePoints[$key] = $tp;
	} 

	function _stopTp( $key )
	{
		if (!$this->_loggingOptions['LOG_TIMEPOINTS'])
			return;

		if ( isset( $this->_timePoints[$key]['start'] ) )
		{
			$tp = $this->_timePoints[$key];
			$tp['duration'] = $this->_getElapsed( $tp['start'] ) . 'ms';
			unset( $tp['start'] );
			$this->_timePoints[$key] = $tp;
		} 
	} 
	
	function _logTp()
	{
		if (!$this->_loggingOptions['LOG_TIMEPOINTS'])
			return;

		// log the timepoint-information
		ob_start();
		echo "<pre><br/>\n";
		print_r($this->_timePoints);
		print_r("</pre><br/>\n");
		$msg = ob_get_clean();
		$this->log($msg, '_EBATNS_TIMEPOINTS');
	}
	
	//
	// end timepoint-tracing
	//
	
	// callusage
	function _incrementApiUsage($apiCall)
	{
		if (!$this->_loggingOptions['LOG_API_USAGE'])	
			return;
		
		$this->_callUsage[$apiCall] = $this->_callUsage[$apiCall] + 1;
	}
	
	function getApiUsage()
	{
		return $this->_callUsage;
	}
	
	function & getParser($tns = 'urn:ebay:apis:eBLBaseComponents', $parserOptions = null, $recreate = true)
	{
		if ($recreate)
			$this->_parser = null;
			
		if (!$this->_parser)
		{
			if ($parserOptions)
				$this->_parserOptions = $parserOptions;
			$this->_parser = &new EbatNs_ResponseParser( &$this, $tns, $this->_parserOptions );
		}
		return ($t = &$this->_parser);
	}
	
	// should return true if the data should NOT be included to the
	// response-object !
	function _handleDataType( $typeName, &$value, $mapName )
	{
		if ( $this->_hasCallbacks )
		{
			if (isset($this->_callbacks[strtolower( $typeName )]))
				$callback = $this->_callbacks[strtolower( $typeName )];
			else
				$callback = null;
			if ( $callback )
			{
				if ( is_object( $callback['object'] ) )
				{
					return call_user_method( $callback['method'], $callback['object'], $typeName, & $value, $mapName, & $this );
				} 
				else
				{
					return call_user_func( $callback['method'], $typeName, & $value, $mapName, & $this );
				} 
			} 
		} 
		return false;
	} 
	
	// $typeName as defined in Schema
	// $method (callback, either string or array with object/method)
	function setHandler( $typeName, $method )
	{
		$this->_hasCallbacks = true;
		if ( is_array( $method ) )
		{
			$callback['object'] = &$method[0];
			$callback['method'] = $method[1];
		} 
		else
		{
			$callback['object'] = null;
			$callback['method'] = $method;
		} 

		$this->_callbacks[strtolower( $typeName )] = $callback;
	} 

	function _makeSessionHeader()
	{
		$cred = new UserIdPasswordType();
		$cred->AppId = $this->_session->getAppId();
		$cred->DevId = $this->_session->getDevId();
		$cred->AuthCert = $this->_session->getCertId();
		if ( $this->_session->getTokenMode() == 0 )
		{
			$cred->Username = $this->_session->getRequestUser();
			$cred->Password = $this->_session->getRequestPassword();
		} 
		$reqCred = new EbatNs_RequesterCredentialType();
		$reqCred->Credentials = $cred;

		if ( $this->_session->getTokenMode() == 1 )
		{
			$this->_session->ReadTokenFile();
			$reqCred->eBayAuthToken = $this->_session->getRequestToken();
		} 

		$header = new EbatNs_RequestHeaderType();
		$header->RequesterCredentials = $reqCred;

		return $header;
	} 

	function call( $method, $request, $ignoreWarnings = true )
	{
		$this->_startTp('API call ' . $method);
		$this->_incrementApiUsage($method);
		
		$this->_startTp('Encoding SOAP Message');

		$body = $this->encodeMessage( $method, $request );
		$header = $this->_makeSessionHeader();

		$message = $this->buildMessage( $body, $header );
		
		$ep = $this->_session->getApiUrl();
		$ep .= '?callname=' . $method;
		$ep .= '&siteid=' . $this->_session->getSiteId();
		$ep .= '&appid=' . $this->_session->getAppId();
		$ep .= '&version=' . $request->getVersion();
		$ep .= '&routing=default';
		$this->_ep = $ep;

		$this->_stopTp('Encoding SOAP Message');
		$this->_startTp('Sending SOAP Message');

		$responseMsg = $this->sendMessage( $message );

		$this->_stopTp('Sending SOAP Message');

		if ( $responseMsg )
		{
			$this->_startTp('Decoding SOAP Message');
			$ret = & $this->decodeMessage( $method, $responseMsg, $ignoreWarnings );
			$this->_stopTp('Decoding SOAP Message');
		}
		else
		{
			$ret = & $this->_currentResult;
		}
		
		$this->_stopTp('API call ' . $method);
		$this->_logTp();
		
		return $ret;
	} 
	
	// should return a serialized XML of the outgoing message
	function encodeMessage( $method, $request )
	{
		return $request->serialize( $method . 'Request', $request, null, true, null, $this->_dataConverter );
	} 
	// should transform the response (body) to a PHP object structure
	function &decodeMessage( $method, &$msg, $ignoreWarnings )
	{
		$this->_parser = &new EbatNs_ResponseParser( &$this, 'urn:ebay:apis:eBLBaseComponents', $this->_parserOptions );
		return $this->_parser->decode( $method . 'Response', $msg, $ignoreWarnings );
	} 
	// should generate a complete SOAP-envelope for the request
	function buildMessage( $body, $header )
	{
		$soap = '<?xml version="1.0" encoding="utf-8"?>';
		$soap .= '<soap:Envelope';
		$soap .= ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
		$soap .= ' xmlns:xsd="http://www.w3.org/2001/XMLSchema"';
		$soap .= ' xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"';
		$soap .= ' encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"';
		$soap .= ' xmlns="urn:ebay:apis:eBLBaseComponents"';
		$soap .= ' >';

		if ( $header )
			$soap .= $header->serialize( 'soap:Header', $header, null, true, null, $t = null );

		$soap .= '<soap:Body>';
		$soap .= $body;
		$soap .= '</soap:Body>';
		$soap .= '</soap:Envelope>';
		return $soap;
	}
	
	// this method will generate a notification-style message body
	// out of a response from a call
	function _buildNotificationMessage($response, $simulatedMessageName, $tns, $addData = null)
	{
		if ($addData)
		{
			foreach($addData as $key => $value)
			{
				$response->{$key} = $value;
			}
		}		
		$response->setTypeAttribute('xmlns', $tns);
		$msgBody = $response->serialize( $simulatedMessageName, $response, isset($response->attributeValues) ? $response->attributeValues : null, true, null, $this->_dataConverter );
		
		$soap = '<?xml version="1.0" encoding="utf-8"?>';
		$soap .= '<soapenv:Envelope';
		$soap .= ' xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"';
		$soap .= ' xmlns:xsd="http://www.w3.org/2001/XMLSchema"';
		$soap .= ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
		$soap .= '>';
		$soap .= '<soapenv:Header>';
		$soap .= '<ebl:RequesterCredentials soapenv:mustUnderstand="0" xmlns:ns="urn:ebay:apis:eBLBaseComponents" xmlns:ebl="urn:ebay:apis:eBLBaseComponents">';
		$soap .= '<ebl:NotificationSignature xmlns:ebl="urn:ebay:apis:eBLBaseComponents">invalid_simulation</ebl:NotificationSignature>';
		$soap .= '</ebl:RequesterCredentials>';
		$soap .= '</soapenv:Header>';
		$soap .= '<soapenv:Body>';
		$soap .= $msgBody;
		$soap .= '</soapenv:Body>';
		$soap .= '</soapenv:Envelope>';
		
		return $soap;
	}
	 
	// should send the message to the endpoint
	// the result should be parsed out of the envelope and return as the plain
	// response-body.
	function sendMessage( $message )
	{
		$this->logXml( $message, 'Request' );
		
		$this->_currentResult = null;
		
		$this->log( $this->_ep );

		$timeout = $this->_transportOptions['HTTP_TIMEOUT'];
		if (!$timeout || $timeout <= 0)
			$timeout = 300;
			
		$soapaction = 'dummy';

		$ch = curl_init();
		$reqHeaders[] = 'Content-Type: text/xml;charset=utf-8';
		if ($this->_transportOptions['HTTP_COMPRESS'])
		{
			$reqHeaders[] = 'Accept-Encoding: gzip, deflate';
	        curl_setopt( $ch, CURLOPT_ENCODING, "gzip");
	        curl_setopt( $ch, CURLOPT_ENCODING, "deflate");
		}
		$reqHeaders[] = 'SOAPAction: "' . $soapaction . '"';
        
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $reqHeaders );
		curl_setopt( $ch, CURLOPT_USERAGENT, 'ebatns;1.0' );
		curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $message );
		curl_setopt( $ch, CURLOPT_URL, $this->_ep );
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_FAILONERROR, 0 );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_HEADER, 1 );
		curl_setopt( $ch, CURLOPT_HTTP_VERSION, 1 );
		
		if ($this->_transportOptions['HTTP_VERBOSE'])
		{
			curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
			ob_start();
		}
		
		$responseRaw = curl_exec( $ch );

		if ( !$responseRaw )
		{
			$this->_currentResult = new EbatNs_ResponseError();
			$this->_currentResult->raise( 'curl_error ' . curl_errno( $ch ) . ' ' . curl_error( $ch ), 80000 + 1, EBAT_SEVERITY_ERROR );
			curl_close( $ch );
			
			return null;
		} 
		else
		{
			curl_close( $ch );

			$responseBody = null;
			if ( preg_match( "/^(.*?)\r?\n\r?\n(.*)/s", $responseRaw, $match ) )
			{
				$responseBody = $match[2];
				$headerLines = split( "\r?\n", $match[1] );
				foreach ( $headerLines as $line )
				{
					if ( strpos( $line, ':' ) === false )
					{
						$responseHeaders[0] = $line;
						continue;
					} 
					list( $key, $value ) = split( ':', $line );
					$responseHeaders[strtolower( $key )] = trim( $value );
				} 
			} 
			
			if (!$$responseBody)
				$this->logXml( $responseBody, 'Response' );
			else
				$this->logXml( $responseRaw, 'ResponseRaw' );
		} 

		return $responseBody;
	} 
} 
?>
