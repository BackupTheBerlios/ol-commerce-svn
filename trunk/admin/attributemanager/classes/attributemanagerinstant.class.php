<?php
/*
  $Id: attributemanagerinstant.class.php,v 1.1.1.1.2.1 2007/04/08 07:16:34 gswkaiser Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License

  Web Development
  http://www.kangaroopartners.com
*/

class attributeManagerInstant extends attributemanager {

	/**
	 * @access private
	 */
	var $intPID;

	/**
	 * __construct() assigns pid and calls parent __constrct()
	 * @access public
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @param $intPID int
	 * @return void
	 */
	function attributeManagerInstant($intPID) {
		$this->attributemanager();
		$this->intPID = (int)$intPID;
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
		$this->objDB->query(DELETE_FROM.TABLE_PRODUCTS_ATTRIBUTES." where options_id = '".$this->objDB->input($optionId)."' and options_values_id = '".$this->objDB->input($optionValueId)."' and products_id = '$this->intPID'");
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
		$this->objDB->query(DELETE_FROM.TABLE_PRODUCTS_ATTRIBUTES." where options_id = '".$this->objDB->input($optionId)."' and products_id = '$this->intPID'");
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
		$data = array(
			'products_id' => $this->intPID,
			'options_id' => $this->objDB->input($optionId),
			'options_values_id' => $this->objDB->input($optionValueId),
			'options_values_price' => $this->objDB->input($price),
			'price_prefix' => $this->objDB->input($prefix)
		);
		$this->objDB->perform(TABLE_PRODUCTS_ATTRIBUTES, $data);
	}

	/**
	 * Returns all or the options and values in the database
	 * @access public
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @return array
	 */
	function getAllProductOptionsAndValues() {
		if(0 === count($this->arrAllProductOptionsAndValues)) {

			$allOptionsAndValues = $this->getAllOptionsAndValues();

			$query = $this->objDB->query("select * from ".TABLE_PRODUCTS_ATTRIBUTES.
				" where products_id = '$this->intPID' order by options_id");

			$optionsId = null;
			while($res = $this->objDB->fetchArray($query)) {
				if($res['options_id'] != $optionsId) {
					$optionsId = $res['options_id'];
					$this->arrAllProductOptionsAndValues[$optionsId]['name'] = $allOptionsAndValues[$optionsId]['name'];
				}
				$this->arrAllProductOptionsAndValues[$optionsId]['values'][$res['options_values_id']]['name'] =
				$allOptionsAndValues[$optionsId]['values'][$res['options_values_id']];
				$this->arrAllProductOptionsAndValues[$optionsId]['values'][$res['options_values_id']]['price'] =
				$res['options_values_price'];
				$this->arrAllProductOptionsAndValues[$optionsId]['values'][$res['options_values_id']]['prefix'] =
				$res['price_prefix'];
			}
		}
		//$this->debugOutput($this->arrAllProductOptionsAndValues);
		return $this->arrAllProductOptionsAndValues;
	}

	/**
	 * Updates the price and prefix in the products attribute table
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
		$data = array(
			'options_values_price' => $this->objDB->input($price),
			'price_prefix' => $this->objDB->input($prefix)
		);
		$this->objDB->perform(TABLE_PRODUCTS_ATTRIBUTES,$data, 'update',"products_id='$this->intPID' and options_id='".$this->objDB->input($optionId)."' and options_values_id='".$this->objDB->input($optionValueId).APOS);

	}

	/**
	 * Adds a new option value to the database then to the product
	 * @version 1
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