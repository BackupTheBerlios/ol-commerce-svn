<?php
/* --------------------------------------------------------------
$Id: upload.php,v 1.1.1.1.2.1 2007/04/08 07:16:42 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(upload.php,v 1.1 2003/03/22); www.oscommerce.com
(c) 2003	    nextcommerce (upload.php,v 1.7 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

class upload {
	var $file, $filename, $destination, $permissions, $extensions, $tmp_filename;

	function upload($file = '', $destination = '', $permissions = '777', $extensions = '')
	{
		$this->set_file($file);
		$this->set_destination($destination);
		$this->set_permissions($permissions);
		$this->set_extensions($extensions);
		$return=false;
		if (olc_not_null($this->file))
		{
			if (olc_not_null($this->destination))
			{
				if ($this->parse() == true)
				{
					$return=$this->save() == true;
				}
			}
		}
		return $return;
	}

	function parse() {
		global $messageStack;
		if (isset($_FILES[$this->file]))
		{
			$file = array(
			'name' => $_FILES[$this->file]['name'],
			'type' => $_FILES[$this->file]['type'],
			'size' => $_FILES[$this->file]['size'],
			'tmp_name' => $_FILES[$this->file]['tmp_name']);
		} else {
			$file = array(
			'name' => $GLOBALS[$this->file . '_name'],
			'type' => $GLOBALS[$this->file . '_type'],
			'size' => $GLOBALS[$this->file . '_size'],
			'tmp_name' => $GLOBALS[$this->file]);
		}
		$tmp_file=$file['tmp_name'];
		if ( olc_not_null($tmp_file) && ($tmp_file != 'none') && is_uploaded_file($tmp_file) ) {
			if (sizeof($this->extensions) > 0) {
				if (!in_array(strtolower(substr($file['name'], strrpos($file['name'], DOT)+1)), $this->extensions)) {
					$messageStack->add_session(ERROR_FILETYPE_NOT_ALLOWED, 'error');
					return false;
				}
			}
			$this->set_file($file);
			$this->set_filename($file['name']);
			$this->set_tmp_filename($tmp_file);
			return $this->check_destination();
		} else {
			//$messageStack->add_session(WARNING_NO_FILE_UPLOADED, 'warning');
			return false;
		}
	}

	function save()
	{
		global $messageStack;

		if (substr($this->destination, -1) != SLASH) $this->destination .= SLASH;
		if (move_uploaded_file($this->file['tmp_name'], $this->destination . $this->filename)) {
			chmod($this->destination . $this->filename, $this->permissions);
			$messageStack->add_session(SUCCESS_FILE_SAVED_SUCCESSFULLY, 'success');
			return true;
		} else {
			$messageStack->add_session(ERROR_FILE_NOT_SAVED, 'error');
			return false;
		}
	}

	function set_file($file) {
		$this->file = $file;
	}

	function set_destination($destination) {
		$this->destination = $destination;
	}

	function set_permissions($permissions) {
		$this->permissions = octdec($permissions);
	}

	function set_filename($filename) {
		$this->filename = $filename;
	}

	function set_tmp_filename($filename) {
		$this->tmp_filename = $filename;
	}

	function set_extensions($extensions) {
		if (olc_not_null($extensions)) {
			if (is_array($extensions)) {
				$this->extensions = $extensions;
			} else {
				$this->extensions = array($extensions);
			}
		} else {
			$this->extensions = array();
		}
	}

	function check_destination()
	{
		global $messageStack;

		if (is_writeable($this->destination))
		{
			return true;
		} else {
			if (is_dir($this->destination))
			{
				$error=ERROR_DESTINATION_NOT_WRITEABLE;
			} else {
				$error=ERROR_DESTINATION_DOES_NOT_EXIST;
			}
			$messageStack->add_session(sprintf($error, $this->destination), 'error');
			return false;
		}
	}
}
?>