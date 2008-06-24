<?php
/*
  $Id: attributemanageratomic.class.php,v 1.1.1.1 2006/12/22 13:37:19 gswkaiser Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
  
  Web Development
  http://www.kangaroopartners.com
*/

class attributeManagerAtomic extends attributemanager {
	
	/**
	 * Holder for a reference to the session variable for storing temp data
	 * @access private
	 */
	var $arrSessionVar ;
	
	/**
	 * __constrct - Assigns the session variable and calls the parent __construct
	 * @access public
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @param $arrSessionVar array - passed by Ref
	 * @return void
	 */
	function attributeManagerAtomic(&$arrSessionVar) {
		$this->attributemanager();
		$this->arrSessionVar = &$arrSessionVar;
	}
	
	/**
	 * Removes a specific option value from a the current product
	 * @access public
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @param $optionId int
	 * @param $optionValueId int
	 * @return void
	 */
	function removeOptionValueFromProduct($optionId, $optionValueId) {
		foreach($this->arrSessionVar as $id => $res) {
			if(($res['options_id'] == $optionId) && ($res['options_values_id'] == $optionValueId)) {
				unset($this->arrSessionVar[$id]);
			}
		}
	}
	
	/**
	 * Removes a specific option and its option values from the current product
	 * @access public
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @param $optionId int
	 * @return void
	 */
	function removeOptionFromProduct($optionId) {
		foreach($this->arrSessionVar as $id => $res) {
			if(($res['options_id'] == $optionId)) {
				unset($this->arrSessionVar[$id]);
			}
		}
	}
	
	/**
	 * Adds the selected attribute to the current product
	 * @access public
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @param $optionId int 
	 * @param $optionValueId int 
	 * @param $prefix string
	 * @param $price float
	 * @return void
	 */
	function addAttributeToProduct($optionId,$optionValueId,$price, $prefix) {
		$this->arrSessionVar[] = array(
			'options_id' => $optionId, 
			'options_values_id' => $optionValueId,
			'options_values_price' => $price,
			'price_prefix' => $prefix
		);
	}

	/**
	 * Returns all of the productsoptions and values in the session
	 * @access public
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @return array
	 */
	function getAllProductOptionsAndValues() {
		if(0 === count($this->arrAllProductOptionsAndValues)) {
			
			$allOptionsAndValues = $this->getAllOptionsAndValues();
			
			$optionsId = null;
			foreach($this->arrSessionVar as $id => $res) {
				if($res['options_id'] != $optionsId) {
					$optionsId = $res['options_id'];
					$this->arrAllProductOptionsAndValues[$optionsId]['name'] = $allOptionsAndValues[$optionsId]['name'];
				}
				$this->arrAllProductOptionsAndValues[$optionsId]['values'][$res['options_values_id']]['name'] = $allOptionsAndValues[$optionsId]['values'][$res['options_values_id']];
				$this->arrAllProductOptionsAndValues[$optionsId]['values'][$res['options_values_id']]['price'] = $res['options_values_price'];
				$this->arrAllProductOptionsAndValues[$optionsId]['values'][$res['options_values_id']]['prefix'] = $res['price_prefix'];
			}
		}
		return $this->arrAllProductOptionsAndValues;
	}
	
	/**
	 * Updates the price and prefix in the products attribute table
	 * @access public
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @param $optionId int
	 * @param $optionValueId int
	 * @param $price float
	 * @param $prefix string
	 * @return void
	 */
	function update($optionId, $optionValueId, $price, $prefix) {
		foreach($this->arrSessionVar as $id => $res) {
			if(($res['options_id'] == $optionId) && ($res['options_values_id'] == $optionValueId)) {
				$this->arrSessionVar[$id]['options_values_price'] = $price;
				$this->arrSessionVar[$id]['price_prefix'] = $prefix;
			}
		}
	}
	
	/**
	 * Adds a new option value to the session then to the product
	 * @access public
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @param $optionId int
	 * @param $optionValueName string
	 * @return void
	 */
	function addNewOptionValueToProduct($optionId,$optionValueName) {
		$newOptionValueId = $this->addOptionValue($optionId, $optionValueName);
		$this->addAttributeToProduct($optionId,$newOptionValueId,'','');
	}

}

?>