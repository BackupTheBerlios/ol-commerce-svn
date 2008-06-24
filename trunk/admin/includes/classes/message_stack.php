<?php
/* --------------------------------------------------------------
$Id: message_stack.php,v 1.1.1.1.2.1 2007/04/08 07:16:41 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(message_stack.php,v 1.5 2002/11/22); www.oscommerce.com
(c) 2003	    nextcommerce (message_stack.php,v 1.6 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License

Example usage:

$messageStack = new messageStack();
$messageStack->add('Error: Error 1', 'error');
$messageStack->add('Error: Error 2', 'warning');
if ($messageStack->size > 0) echo $messageStack->output();

--------------------------------------------------------------*/

class messageStack extends tableBlock {
	var $size = 0;
	var $messageToStack='messageToStack';

	function messageStack() {

		$this->errors = array();

		if (isset($_SESSION[$this->messageToStack])) {
			for ($i = 0, $n = sizeof($_SESSION[$this->messageToStack]); $i < $n; $i++) {
				$this->add($_SESSION[$this->messageToStack][$i]['text'], $_SESSION[$this->messageToStack][$i]['type']);
			}
			unset($_SESSION[$this->messageToStack]);
		}
	}

	function add($message, $type = 'error') {
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
		$this->errors[] = array('params' => 'class="messageStack'.$message_type.'"',
		'class' => $class, 'text' => olc_image(DIR_WS_ICONS . strtolower($message_type).'.gif',
		$icon_type,'','','align="middle"') . HTML_NBSP . $message);
		$this->size++;
	}

	function add_session($message, $type = 'error') {
		if (!isset($_SESSION[$this->messageToStack])) {
			$_SESSION[$this->messageToStack] = array();
		}

		$_SESSION[$this->messageToStack][] = array('text' => $message, 'type' => $type);
	}

	function reset() {
		$this->errors = array();
		$this->size = 0;
	}

	function output()
	{
		$this->table_parameters='id="messageStack_messageBox"';
		$this->table_data_parameters = 'class="messageBox"';
		return $this->tableBlock($this->errors);
	}
}
?>