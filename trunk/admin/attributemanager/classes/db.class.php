<?php
/*
  $Id: db.class.php,v 1.1.1.1 2006/12/22 13:37:20 gswkaiser Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
  
  Web Development
  http://www.kangaroopartners.com
*/

/**
 * OSC Database functions wrapper - just in case they decide to release ms3 the moment i release this - he he
 */
class DB {
	
	function query($strQuery) {
		return olc_db_query($strQuery);
	}
	
	function fetchArray($ref) {
		return olc_db_fetch_array($ref);
	}
	
	function numRows($ref) {
		return olc_db_num_rows($ref);
	}
	
	function perform($strTable,$arrData,$strAction='insert',$strParams='') {
		return olc_db_perform($strTable,$arrData,$strAction,$strParams);
	}
	
	function getOne($strQuery) {
		$res = $this->query($strQuery);
		if ($res && $this->numRows($res)) 
			return mysql_result($res,0,0);
		return false;
	}
	
	function getAll($strQuery) {
		$res = $this->query($strQuery);
		$results = array();
		while($row = $this->fetchArray($res))
			$results[] = $row;
		return $results;
	}
	
	function input($str) {
		return olc_db_input($str);
	}
	
	function getNextAutoValue($strTable,$strField) {
		return (int)$this->getOne("select max($strField) + 1 as next from $strTable limit 1");
	}
	/**
	 * Some contributions such as the Ultimate SEO URLs have there own 
	 * database functions. This can cause the internal, last insert id to be 
	 * wrong if the link id isn't included in the mysql_insert_id statement.
	 * For this reason i have not used the default osc function for this one as for some
	 * reason they haven't put the link in their wrapper function.
	 */
	function insertId($link = 'db_link' ) {
		global $$link;
		return mysql_insert_id($$link);
	}
}

?>