<?php
/* -----------------------------------------------------------------------------------------
$Id: message_stack.php,v 1.1.1.1.2.1 2007/04/08 07:17:47 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(message_stack.php,v 1.1 2003/05/19); www.oscommerce.com
(c) 2003	    nextcommerce (message_stack.php,v 1.9 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
Example usage:
$messageStack = new messageStack();
$messageStack->add('general', 'Error: Error 1', 'error');
$messageStack->add('general', 'Error: Error 2', 'warning');
if ($messageStack->size('general') > 0) echo $messageStack->output('general');
---------------------------------------------------------------------------------------*/

class messageStack extends tableBox {
	// class constructor

	var $messageToStack='messageToStack';

	function messageStack() {
		$this->messages = array();
		if (isset($_SESSION[$this->messageToStack])) {
			for ($i=0, $n=sizeof($_SESSION[$this->messageToStack]); $i<$n; $i++) {
				$this->add($_SESSION[$this->messageToStack][$i]['class'],
				$_SESSION[$this->messageToStack][$i]['text'], $_SESSION[$this->messageToStack][$i]['type']);
			}
			unset($_SESSION[$this->messageToStack]);
		}
	}

	//W. Kaiser - AJAX
	// class methods
	function add($class, $message, $type = 'error',$use_AJAX_mode=true)
	{
		if ($type == 'warning') {
			$message_type="Warning";
			$icon_type=ICON_WARNING;
			$message_text="Hinweis";
		} elseif ($type == 'success') {
			$message_type="Success";
			$icon_type=ICON_SUCCESS;
			$message_text="Erfolg";
		}else{
			$message_type="Error";
			$icon_type=ICON_ERROR;
			$message_text="Fehler";
		}
		$this->messages[] = array('params' => 'class="messageStack'.$message_type.'"',
		'class' => $class, 'text' => olc_image(DIR_WS_ICONS . strtolower($message_type).'.gif',
		$icon_type,EMPTY_STRING,EMPTY_STRING,'align="middle"') . HTML_NBSP . $message);
	}
	//W. Kaiser - AJAX

	function add_session($class, $message, $type = 'error') {

		if (!isset($_SESSION[$this->messageToStack])) {
			$_SESSION[$this->messageToStack] = array();
		}

		$_SESSION[$this->messageToStack][] = array('class' => $class, 'text' => $message, 'type' => $type);
	}

	function reset() {
		$this->messages = array();
	}

	//W. Kaiser - AJAX
	function output($class)
	{
		$output_all=$class=="*";
		$not_output_all=!$output_all;
		$output_message=$output_all;
		$this->table_parameters='id="messageStack_messageBox"';
		$this->table_data_parameters = 'class="messageBox"';
		$output = array();
		$total_message=EMPTY_STRING;
		for ($i=0, $n=sizeof($this->messages); $i<$n; $i++)
		{
			$current_message=$this->messages[$i];
			if ($not_output_all)
			{
				$output_message = $current_message['class'] == $class;
			}
			if ($output_message)
			{
				$message=$current_message['text'];
				if (IS_AJAX_PROCESSING)
				{
					$message=trim(str_replace(HTML_NBSP,BLANK,strip_tags($message)));
					if (strpos($total_message,$message)===false)
					{
						if ($i>0)
						{
							$message="\n\n".$message;
						}
						$total_message.=$message;
					}
				}
				else
				{
					$output[] = $message;
				}
			}
		}
		if (IS_AJAX_PROCESSING)
		{
			return $total_message;
		}
		else
		{
			return $this->tableBox($output);
		}
	}

	function size($class) {
		$count_all=$class=="*";
		$not_count_all=!$count_all;
		$count_message=$count_all;
		$count = 0;
		for ($i=0, $n=sizeof($this->messages); $i<$n; $i++) {
			if ($not_count_all)
			{
				$count_message = $this->messages[$i]['class'] == $class;
			}
			if ($count_message)
			{
				$count++;
			}
		}
		return $count;
	}
	//W. Kaiser - AJAX

}
?>