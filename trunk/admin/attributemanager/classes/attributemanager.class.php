<?php
/*
$Id: attributemanager.class.php,v 1.1.1.1 2006/12/22 13:37:19 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Released under the GNU General Public License

Web Development
http://www.kangaroopartners.com
*/


/*
For backwards compatibility i couldn't use any PHP5 features.
An interface states a contract between classes. In this instance, it is saying 'for this class to be valid, it must contain the methods declared within
the interface'. Why do this? Because i wanted to access methods from the child classes which arn't present in the abstract parent class.
Without being able to force relationship there is nothing to say that some of the methods i am using will be available.
In PHP4 I cant force it, but i wan't to! so i have put this here so that people don't think i haven't realised!

interface attributeManagerInterface {
function getAllProductOptionsAndValues();
}
*/

/*abstract*/ class attributemanager /*implements attributeManagerInterface*/ {

	/**
	 * Holds all of the options in the database
	 * @access private
	 */
	var $arrAllOptions = array();

	/**
	 * Holds all of the option values in the database
	 * @access private
	 */
	var $arrAllOptionValues = array();

	/**
	 * Holds all of the options and their values where they are releated to each other
	 * @access private
	 */
	var $arrAllOptionsAndValues = array();


	/**
	 * Holds all of the current products options and option values
	 * @access protected
	 */
	var $arrAllProductOptionsAndValues = array();

	/**
	 * Holder for an instance of the DB class
	 * @var $objDB DB
	 * @access private
	 */
	var $objDB;

	/**
	 * Current language id
	 * @todo make multilingual
	 * @access private
	 */
	var $intLanguageId;

	/**
	 * __construct()- Creates a new instance of the DB class and assigns the language id
	 * @access protected
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @return void
	 */
	function attributemanager() {
		//$this->objDB =& new DB();
		$this->objDB = new DB();
		$this->intLanguageId = AM_LANGUAGE_ID;
	}

	/**
	 * Gets all of the options in the database
	 * @access protected
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @return array
	 */
	function getAllOptions() {
		if(0 === count($this->arrAllOptions)) {
			$query = $this->objDB->query("select * from ".TABLE_PRODUCTS_OPTIONS.
			" where language_id='".$this->objDB->input($this->intLanguageId).APOS);
			while($res = $this->objDB->fetchArray($query))
			$this->arrAllOptions[$res['products_options_id']] = $res['products_options_name'];
		}

		return $this->arrAllOptions;
	}

	/**
	 * Gets all of the option values in the database
	 * @access protected
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @return array
	 */
	function getAllOptionValues() {
		if(0 === count($this->arrAllOptionValues)) {
			$query = $this->objDB->query("select * from ".TABLE_PRODUCTS_OPTIONS_VALUES);
			while($res = $this->objDB->fetchArray($query))
			$this->arrAllOptionValues[$res['products_options_values_id']] = $res['products_options_values_name'];
		}
		return $this->arrAllOptionValues;
	}

	/**
	 * Returns an array of options with their related option values
	 * @access protected
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @return array
	 */
	function getAllOptionsAndValues() {
		if(0 === count($this->arrAllOptionsAndValues)){

			$allOptions = $this->getAllOptions();
			$allOptionValues = $this->getAllOptionValues();

			$query = $this->objDB->query("select * from ".TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS);

			$optionsId = null;
			while($res = $this->objDB->fetchArray($query)) {
				if($res['products_options_id'] != $optionsId) {
					$optionsId = $res['products_options_id'];
					$this->arrAllOptionsAndValues[$optionsId]['name'] = $allOptions[$optionsId];
				}
				$this->arrAllOptionsAndValues[$optionsId]['values'][$res['products_options_values_id']] =
				$allOptionValues[$res['products_options_values_id']];
			}

			// add any options that are not yet assigned to the tpovtpo table
			foreach($allOptions as $optionId => $option)
			if(!array_key_exists($optionId, $this->arrAllOptionsAndValues))
			$this->arrAllOptionsAndValues[$optionId]['name'] = $allOptions[$optionId];

		}
		//	$this->debugOutput($this->arrAllOptionsAndValues);

		return $this->arrAllOptionsAndValues;
	}

	/**
	 * Adds a new option to the database
	 * @access public
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @return new id
	 */
	function addOption($name) {
		$id = $this->objDB->getNextAutoValue(TABLE_PRODUCTS_OPTIONS,'products_options_id');
		$arrData = array (
		'products_options_id' => $id,
		'language_id' => $this->intLanguageId,
		'products_options_name' => $this->objDB->input($name)
		);
		$this->objDB->perform(TABLE_PRODUCTS_OPTIONS,$arrData);
		return $id;
	}

	/**
	 * Adds a new option value to the database
	 * @access public
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @param $name - string -  the name for the new option value
	 * @return newId
	 */
	function addOptionValue($optionId, $optionName) {
		$id = $this->objDB->getNextAutoValue(TABLE_PRODUCTS_OPTIONS_VALUES,'products_options_values_id');
		$ovData = array (
		'products_options_values_id' => $id,
		'language_id' => $this->intLanguageId,
		'products_options_values_name' => $this->objDB->input($optionName)
		);
		$this->objDB->perform(TABLE_PRODUCTS_OPTIONS_VALUES,$ovData);
		$ov2oData = array(
		'products_options_id' => $this->objDB->input($optionId),
		'products_options_values_id' => $id
		);

		$this->objDB->perform(TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS,$ov2oData);
		return $id;
	}


	/**
	 * takes an array of key => value and formats them for the olc_draw_pull_down function
	 * @access private
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @return array(array('id'=>$key,'text'=>$value))
	 */
	function formatArrayForDropDown($array) {
		$arrReturn = array();
		foreach($array as $key => $value)
		$arrReturn[] = array('id' => $key, 'text' => $value);
		if(0 === count($arrReturn))
		return array(array('id' => '0', 'text' => '----'));

		return $arrReturn;
	}

	/**
	 * Builds an array for a drop down of available options
	 * @access public
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @param $subtract bol - if true it will subtract the options that are already assigned to the product
	 * @makes array( array key(id) => value(text),.+)
	 * @return array formated for the osc dropdown box function array(array('id'=>$key,'text'=>$value))
	 */
	function buildOptionDropDown($subtract = true) {

		$allOptionsAndValues = $this->getAllOptionsAndValues();
		$allProductsOptionsAndValues = $this->getAllProductOptionsAndValues();

		$returnArray = array();

		foreach($allOptionsAndValues as $optionId => $optionValues)
		$returnArray[$optionId] = $optionValues['name'];

		// remove any already assigned
		if($subtract)
		{

			if(0 !== count($allProductsOptionsAndValues)){
				// get all of the option ids from the return array that arn't already assigned to the product
				$nonAssignedIds = array_diff(array_keys($returnArray),
				array_keys($this->getAllProductOptionsAndValues()));

				$tRetrurnArray = $returnArray;

				$returnArray = array();

				// rebuild the array
				if(is_array($nonAssignedIds))
				foreach($nonAssignedIds as $id)
				$returnArray[$id] = $tRetrurnArray[$id];
			}
		}

		/**
		 * Sort the keys of the array alpha
		 * @todo make it case insensitive
		 */
		asort($returnArray);

		return $this->formatArrayForDropDown($returnArray);
	}

	/**
	 * Builds an array for a drop down of available option values
	 * @access public
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @param $optionId int - if defined, will limit the option values to only ones that are below an option. Otherwise it will return all
	 * @param $subtract bol - if true it will subtract option values that are already assigned to this product with this option
	 * @makes array( array key(id) => value(text),.+)
	 * @return array formated for the osc dropdown box function array(array('id'=>$key,'text'=>$value))
	 */
	function buildOptionValueDropDown($optionId = null, $subtract = true) {

		$allOptionsAndValues = $this->getAllOptionsAndValues();

		$returnArray = array();

		// get all the values
		if(null === $optionId) {
			foreach($allOptionsAndValues as $option)
			if(is_array($option['values']))
			foreach($option['values'] as $optionValueId => $optionValueText)
			$returnArray[$optionValueId] = $optionValueText;
		}
		// just get the values for the specified option id
		else
		{
			if(array_key_exists($optionId,$allOptionsAndValues))
			if(is_array($allOptionsAndValues[$optionId]['values']))
			foreach($allOptionsAndValues[$optionId]['values'] as $optionValueId => $optionValueText)
			$returnArray[$optionValueId] = $optionValueText;
		}
		// get rid of any already specified
		if(true === $subtract) {

			$allProductsOptionsAndValues = $this->getAllProductOptionsAndValues();

			// get all of the values
			if(null === $optionId) {
				$tAll = array();

				foreach($allProductsOptionsAndValues as $optionId => $details)
				if(is_array($details['values']))
				foreach($details['values'] as $optionValueId => $optionValueText)
				if(!array_key_exists($optionValueId,$tAll)) // stop duplicates - there shouldn't be any, but you never know
				$tAll[$optionValueId] = $optionValueText;

				$allProductsOptionsAndValues = $tAll;
			}
			// if an option id is specified only return the values for that option id to compare
			else {
				$allProductsOptionsAndValues = $allProductsOptionsAndValues[$optionId]['values'];
			}

			// make sure that the product actually has one of the values for the current option to subtract, if not do
			if(0 !== count($allProductsOptionsAndValues)){

				// get all of the option value ids from the return array that arn't already assigned to the product
				$nonAssignedIds = array_diff(array_keys($returnArray),array_keys($allProductsOptionsAndValues));

				$tRetrurnArray = $returnArray;

				$returnArray = array();

				// rebuild the array
				if(is_array($nonAssignedIds))
				foreach($nonAssignedIds as $id)
				$returnArray[$id] = $tRetrurnArray[$id];
			}
		}

		/**
		 * Sort the keys of the array alpha
		 * @todo make it case insensitive
		 */
		asort($returnArray);


		return $this->formatArrayForDropDown($returnArray);
	}

	/**
	 * Nothing todo with the script just outputs stuff to browser used for debelopment
	 * @access protected
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @return void
	 *
	 */
	function debugOutput($ent) {
		echo (is_array($ent) || is_object($ent)) ? '<pre style="text-align:left">'.print_r($ent, true).'</pre>' : $ent;
	}

}
?>