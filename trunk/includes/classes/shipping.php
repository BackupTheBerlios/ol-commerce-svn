<?php
/* -----------------------------------------------------------------------------------------
$Id: shipping.php,v 1.1.1.1.2.1 2007/04/08 07:17:48 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(shipping.php,v 1.22 2003/05/08); www.oscommerce.com
(c) 2003	    nextcommerce (shipping.php,v 1.9 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

require_once(DIR_FS_INC.'olc_in_array.inc.php');

class shipping
{
	var $modules;

	// class constructor
	function shipping($module = EMPTY_STRING,$really_include_module=true)
	{
		if (defined('MODULE_SHIPPING_INSTALLED'))
		{
			if (olc_not_null(MODULE_SHIPPING_INSTALLED))
			{
				global $PHP_SELF,$include_modules;
				$class_text='class';
				$file_text='file';
				$id_text='id';
				$delivery_zone_text='delivery_zone';
				$this->modules = explode(SEMI_COLON, MODULE_SHIPPING_INSTALLED);
				$include_modules = array();
				if ($module)
				{
					$module_id=$module[$id_text];
					$class_name=substr($module_id, 0, strpos($module_id, UNDERSCORE));
					$module_file=$class_name.PHP;
					$include_module=in_array($module_file, $this->modules);
				}
				else
				{
					$include_module=false;
				}
				if ($include_module)
				{
					$include_modules[] =
					array(
					$class_text => $class_name,
					$file_text => $module_file);
				}
				else
				{
					reset($this->modules);
					while (list(, $value) = each($this->modules))
					{
						$class = substr($value, 0, strrpos($value, DOT));
						$include_modules[] = array($class_text => $class, $file_text => $value);
					}
				}
				if ($really_include_module)
				{
					// load unallowed modules into array
					$unallowed_modules =$_SESSION['customers_status']['customers_status_shipping_unallowed'];
					if ($unallowed_modules )
					{
						$unallowed_modules = explode(COMMA,$unallowed_modules );
						$have_unallowed_modules=true;
					}
					$shipping_module_language_dir=ADMIN_PATH_PREFIX .'lang/' . SESSION_LANGUAGE . '/modules/';
					$delivery_zone=$_SESSION[$delivery_zone_text];
					for ($i = 0, $n = sizeof($include_modules); $i < $n; $i++)
					{
						$shipping_module=$include_modules[$i][$file_text];
						$shipping_module_base=str_replace(PHP, EMPTY_STRING, $shipping_module);
						$include_module=true;
						if ($have_unallowed_modules)
						{
							if (olc_in_array($shipping_module_base, $unallowed_modules))
							{
								// check if zone is alowed to see module
								$constant_allowed=constant('MODULE_SHIPPING_' . strtoupper($shipping_module_base) . '_ALLOWED');
								if ($constant_allowed)
								{
									$allowed_zones = explode(COMMA, $constant_allowed);
									$include_module=in_array($delivery_zone, $allowed_zones) || count($allowed_zones) == 0;
								}
							}
						}
						if ($include_module)
						{
							$shipping_module='shipping/' . $shipping_module;
							include($shipping_module_language_dir . $shipping_module);
							include(ADMIN_PATH_PREFIX.DIR_WS_MODULES . $shipping_module);
							$current_include_module=$include_modules[$i][$class_text];
							$GLOBALS[$current_include_module] = new $current_include_module;
						}
					}
				}
			}
		}
	}

	function quote($method = EMPTY_STRING, $module = EMPTY_STRING) {
		global $order, $total_weight, $shipping_weight, $shipping_quoted, $shipping_num_boxes;

		$quotes_array = array();
		if (is_array($this->modules))
		{
			$shipping_quoted = EMPTY_STRING;
			$shipping_num_boxes = 1;
			$shipping_weight = $total_weight;
			if (SHIPPING_BOX_WEIGHT >= $shipping_weight*SHIPPING_BOX_PADDING/100) {
				$shipping_weight = $shipping_weight+SHIPPING_BOX_WEIGHT;
			} else {
				$shipping_weight = $shipping_weight + ($shipping_weight*SHIPPING_BOX_PADDING/100);
			}

			if ($shipping_weight > SHIPPING_MAX_WEIGHT) { // Split into many boxes
				$shipping_num_boxes = ceil($shipping_weight/SHIPPING_MAX_WEIGHT);
				$shipping_weight = $shipping_weight/$shipping_num_boxes;
			}
			$check_module=olc_not_null($module);
			$include_quotes = array();
			reset($this->modules);
			while (list(, $value) = each($this->modules))
			{
				$class = substr($value, 0, strrpos($value, DOT));
				if ($GLOBALS[$class]->enabled)
				{
					if ($check_module)
					{
						if ($module <> $class)
						{
							continue;
						}
					}
					$include_quotes[] = $class;
				}
			}

			$size = sizeof($include_quotes);
			for ($i=0; $i<$size; $i++)
			{
				$quotes = $GLOBALS[$include_quotes[$i]]->quote($method);
				if (is_array($quotes))
				{
					$quotes_array[] = $quotes;
				}
			}
		}

		return $quotes_array;
	}

	function cheapest()
	{
		if (is_array($this->modules))
		{
			$cost_text='cost';
			$methods_text='methods';
			$id_text='id';
			$title_text='title';
			$module_text='module';
			$lparen=LPAREN;
			$rparen=RPAREN;
			$rates = array();
			reset($this->modules);
			while (list(, $value) = each($this->modules))
			{
				$class = substr($value, 0, strrpos($value, DOT));
				if ($GLOBALS[$class]->enabled)
				{
					$quotes=$GLOBALS[$class]->quotes;
					$size = sizeof($quotes[$methods_text]);
					for ($i=0; $i<$size; $i++)
					{
						$current_quote=$quotes[$methods_text][$i];
						$cost=$current_quote[$cost_text];
						if ($cost)
						{
							$rates[] = array(
							$id_text => $quotes[$id_text] . UNDERSCORE . $current_quote[$id_text],
							$title_text => $quotes[$module_text] . $lparen . $current_quote[$title_text] .$rparen,
							$cost_text => $cost);
						}
					}
				}
			}
			$cheapest = false;
			$size = sizeof($rates);
			for ($i=0; $i<$size; $i++)
			{
				if (is_array($cheapest))
				{
					if ($rates[$i][$cost_text] < $cheapest[$cost_text])
					{
						$cheapest = $rates[$i];
					}
				}
				else
				{
					$cheapest = $rates[$i];
				}
			}
			return $cheapest;
		}
	}
}
?>