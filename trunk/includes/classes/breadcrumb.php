<?php
/* -----------------------------------------------------------------------------------------
$Id: breadcrumb.php,v 1.1.1.1.2.1 2007/04/08 07:17:46 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(breadcrumb.php,v 1.3 2003/02/11); www.oscommerce.com
(c) 2003	    nextcommerce (breadcrumb.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

class breadcrumb {
	var $_trail;

	function breadcrumb() {
		$this->reset();
	}

	function reset() {
		$this->_trail = array();
	}

	function add($title, $link = EMPTY_STRING)
	{
		$this->_trail[] = array('title' => $title, 'link' => $link);
	}

	function trail($separator = ' - ')
	{
		$trail_string = EMPTY_STRING;
		for ($i=0, $n=sizeof($this->_trail); $i<$n; $i++)
		{
			$link=$this->_trail[$i]['link'];
			$title=$this->_trail[$i]['title'];
			if ($trail_string)
			{
				$trail_string .= $separator;
			}
			if ($link)
			{
				$trail_string .= HTML_A_START . $link . '" class="headerNavigation">' . $title . HTML_A_END;
			}
			else
			{
				$trail_string .= $title;
			}
		}
		return '<span class="navtrail">'.$trail_string.'</span>';
	}

	//W. Kaiser - AJAX
	function title_from_trail($separator = ' - ')
	{
		$title_elements=count($this->_trail);
		if ($title_elements==1)
		{
		  $title=TITLE;
		}
		else
		{
			$title=EMPTY_STRING;
			$separator=" - ";
		  for ($i=1; $i<$title_elements; $i++)
		  {
		    if ($i>1) $title .= $separator;
		    $title .= $this->_trail[$i]['title'];
		  }
		}
		return $title;
	}
	//W. Kaiser - AJAX
}
?>