<?php
/* --------------------------------------------------------------
$Id: import.php,v 1.1.1.1 2006/12/22 13:37:44 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com,http://www.seifenparadies.de

Copyright (c) 2007 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de,info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2003      XT - Commerce;www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/


include_once(DIR_FS_INC.'olc_precision.inc.php');
include(DIR_FS_INC.'olc_get_currency_parameters.inc.php');

define('CAT_DEPTH',6);		//Max. number of sub-categorie levels to consider!
define('CAT_SEP','|');

define('C','categories_');
define('CAT_ID',C.'id');
define('CAT_NAME',C.'name');
define('CAT_ID_EQUAL',CAT_ID.EQUAL);
define('LANG_ID','language_id');
define('LANG_ID_EQUAL',LANG_ID.EQUAL);
define('PARENT_ID','parent_id');
define('M_ID','manufacturers_id');
define('M_NAME','manufacturers_name');
define('M_URL','manufacturers_url');

define('P','products_');

define('P_BASEPRICE_SHOW',P.'baseprice_show');
define('P_BASEPRICE_VALUE',P.'baseprice_value');
define('P_DESC',P.'description');
define('P_DISC',P.'discount_allowed');
define('P_EAN',P.'ean');
define('P_FSK18',P.'fsk18');
define('P_ID',P.'id');
define('P_ID_EQUAL',P_ID.EQUAL);
define('P_IMAGE',P.'image');
define('P_KEYWORDS',P.'keywords');
define('P_MANUFACTURER',M_ID);
define('P_META_DESC',P.'meta_description');
define('P_META_KEY',P.'meta_keywords');
define('P_META_TITLE',P.'meta_title');
define('P_MIN_ORDER_QUANTITY',P.'min_order_quantity');
define('P_MIN_ORDER_VPE',P.'min_order_vpe');
define('P_MODEL',P.'model');
define('P_NAME',P.'name');
define('P_OPTTPL','options_template');
define('P_PRICENOTAX',P.'price');
define('P_SHIPPING',P.'shippingtime');
define('P_SHORTDESC',P.'short_description');
define('P_SORTING',P.'sort');
define('P_STATUS',P.'status');
define('P_STOCK',P.'quantity');
define('P_TAX',P.'tax_class_id');
define('P_TAX_VALUE',P.'tax_class_value');
define('P_TPL','product_template');
define('P_URL',P.'url');
define('P_UVPNOTAX',P.'uvp');
define('P_VPE',P.'vpe');
define('P_VPE_STATUS',P.'vpe_status');
define('P_VPE_VALUE',P.'vpe_value');
define('P_WEIGHT',P.'weight');

define('C_IMAGE',C.'image');
define('C_HEADING_TITLE',C.'heading_title');
define('C_DESCRIPTION',C.'description');
define('C_META_TITLE',C.'meta_title');
define('C_META_DESCRIPTION',C.'meta_description');
define('C_META_KEYWORDS',C.'meta_keywords');

define('M_IMAGE','manufacturers_image');

define('WHERE_P_ID_EQUAL',SQL_WHERE.P_ID_EQUAL);

define('DO_GROUP_CHECK',GROUP_CHECK==TRUE_STRING_S);
$string_delim=EQUAL.APOS.HASH.APOS;
define('MAN_QUERY',SELECT.M_ID.SQL_FROM.TABLE_MANUFACTURERS.SQL_WHERE.M_NAME.$string_delim);
define('PRODUCTS_ID_QUERY',SELECT.P_ID.SQL_FROM.TABLE_PRODUCTS.SQL_WHERE.P_MODEL.$string_delim);
define('P2C_QUERY_I',SELECT.CAT_ID.SQL_FROM.TABLE_PRODUCTS_TO_CATEGORIES);
$from_cat=SQL_FROM.TABLE_CATEGORIES.SQL_WHERE.CAT_ID_EQUAL;
define('CAT_IMAGE_QUERY',SELECT.C_IMAGE.$from_cat);
define('CAT_DESC_QUERY',SELECT_ALL.TABLE_CATEGORIES_DESCRIPTION.
SQL_WHERE.CAT_ID_EQUAL.HASH.SQL_AND.LANG_ID_EQUAL.ATSIGN);
define('CAT_PARENT_QUERY',SELECT.PARENT_ID.$from_cat);
define('P2C_QUERY',SELECT_ALL.TABLE_PRODUCTS_TO_CATEGORIES.SQL_WHERE.CAT_ID_EQUAL);
define('P2C_QUERY_AND',SQL_AND.P_ID.EQUAL);
define('IMAGE_QUERY',SELECT."image_id".SQL_FROM.TABLE_PRODUCTS_IMAGES.WHERE_P_ID_EQUAL);
define('IMAGE_QUERY_AND',SQL_AND."image_nr".EQUAL);
define('CATEGORIES_QUERY',SELECT.CAT_ID.SQL_FROM.TABLE_CATEGORIES);

define('DELETE_PERSONAL_OFFERS',DELETE_FROM.TABLE_PERSONAL_OFFERS_BY);

$p_cat='p_cat';
define('CAT',$p_cat.DOT);
$p_cat.=UNDERSCORE;
define('CAT_IMAGE',$p_cat.'image');
define('CAT_HEADING_TITLE',$p_cat.'heading_title');
define('CAT_DESCRIPTION',$p_cat.'description');
define('CAT_META_TITLE',$p_cat.'meta_title');
define('CAT_META_DESCRIPTION',$p_cat.'meta_description');
define('CAT_META_KEYWORDS',$p_cat.'meta_keywords');

define('CAT_0',CAT.ZERO_STRING);
define('BASEPRICE_SHOW','p_baseprice_show');
define('BASEPRICE_VALUE','p_baseprice_value');
define('DESC','p_desc'.DOT);
define('DISC','p_disc');
define('EAN','p_ean');
define('FSK18','p_fsk18');
define('GROUPACC','p_groupAcc'.DOT);
define('IMAGE','p_image');
define('IMAGE_DOT',IMAGE.DOT);
define('KEYWORDS','p_keywords'.DOT);
define('MANUFACTURER','p_manufacturer');
define('MANUFACTURER_IMAGE',MANUFACTURER.UNDERSCORE.'image');
define('MANUFACTURER_URL',MANUFACTURER.UNDERSCORE.'url');

define('META_DESC','p_meta_desc'.DOT);
define('META_KEY','p_meta_key'.DOT);
define('META_TITLE','p_meta_title'.DOT);
define('MIN_ORDER_QUANTITY','p_min_order_quantity');
define('MIN_ORDER_VPE','p_min_order_vpe');
define('MODEL','p_model');
define('NAME','p_name'.DOT);
define('OPTTPL','p_opttpl');
define('PRICENOTAX','p_priceNoTax');
define('PRICENOTAX_DOT',PRICENOTAX.DOT);
define('SHIPPING','p_shipping');
define('SHORTDESC','p_shortdesc'.DOT);
define('SORTING','p_sorting');
define('STATUS','p_status');
define('STOCK','p_stock');
define('TAX','p_tax');
define('TAX_VALUE','p_tax_value');
define('TPL','p_tpl');
define('URL','p_url'.DOT);
define('UVPNOTAX','p_uvpNoTax');
define('VPE','p_vpe');
define('VPE_STATUS','p_vpe_status');
define('VPE_VALUE','p_vpe_value');
define('WEIGHT','p_weight');

define('GROUP_PERMISSION','group_permission_');
define('GROUP_ID','c_#_group');
define('GROUP_IDS','group_ids');
define('ALL','all');
define('ID','id');
define('CODE','code');
define('TWO_BLANK',BLANK.BLANK);
define('TWO_COLON',COLON.COLON);
define('THREE_COLON',TWO_COLON.COLON);
define('NOW','now()');

define('DO_PRICE_IS_BRUTTO',PRICE_IS_BRUTTO==TRUE_STRING_S);

define('PARENT_CAT_QUERY',
SELECT.'
	cd.categories_name,c.parent_id'.
SQL_FROM.
TABLE_CATEGORIES . " c, " .
TABLE_CATEGORIES_DESCRIPTION . " cd
	where
	c.categories_id=# and
	c.categories_id= cd.categories_id and
	cd.language_id=".SESSION_LANGUAGE_ID);

function get_parent_categories(&$categories_names,$cat_id)
{
	$parent_categories_query = olc_db_query(str_replace(HASH,$cat_id,PARENT_CAT_QUERY));
	while ($parent_categories = olc_db_fetch_array($parent_categories_query))
	{
		$parent_id=$parent_categories[PARENT_ID];
		$categories_names[]=$parent_categories[CAT_NAME];
		/*
		if ($parent_id != $cat_id)
		{
		*/
		if ($parent_id==0)
		{
			return true;
		}
		else
		{
			get_parent_categories($categories_names,$parent_id);
		}
		//}
	}
}

class olcImport
{
	function olcImport($filename,$map_filename,$user_filter,$user_filter_file)
	{
		$this->init($filename,$map_filename);
		if ($user_filter)
		{
			if ($user_filter_file)
			{
				include_once($user_filter_file);
			}
			$user_filter=function_exists('user_filter');
		}
		$this->user_filter=$user_filter;
		$this->categorie_data=
		array(
		PARENT_ID=>0,
		'categories_status'=>1,
		'date_added'=>NOW,
		'last_modified'=>NOW);
		if (DO_GROUP_CHECK)
		{
			$group_ids=EMPTY_STRING;
			if (IS_XTC)
			{
				$this->cat_permission_array=array(GROUP_PERMISSION=>1);
			}
			else
			{
				$this->cat_permission_array=array();
			}
			for ($i=0;$i<GROUPS;$i++)
			{
				//$id=$this->Groups[$i+1][ID];
				$id=$i;
				if (IS_XTC)
				{
					$this->cat_permission_array[GROUP_PERMISSION.$id]=1;
				}
				else
				{
					if ($group_ids)
					{
						$group_ids.=COMMA;
					}
					$group_ids.=str_replace(HASH,$id,GROUP_ID);
				}
			}
			if (NOT_IS_XTC)
			{
				$this->cat_permission_array[GROUP_IDS]=str_replace(HASH,ALL,GROUP_ID).COMMA.$group_ids;
			}
		}
		$this->import();
	}

	function create_field_associations()
	{
		//Associate CSV-names to DB-names!
		$this->fields_assoc=array(
		MODEL=>P_MODEL,
		EAN=>P_EAN,
		STOCK=>P_STOCK,
		PRICENOTAX=>P_PRICENOTAX,
		WEIGHT=>P_WEIGHT,
		STATUS=>P_STATUS,
		IMAGE=>P_IMAGE,
		DISC=>P_DISC,
		TAX=>P_TAX,
		TAX_VALUE=>P_TAX_VALUE,
		OPTTPL=>P_OPTTPL,
		FSK18=>P_FSK18,
		TPL=>P_TPL,
		VPE=>P_VPE,
		VPE_STATUS=>P_VPE_STATUS,
		VPE_VALUE=>P_VPE_VALUE,
		SHIPPING=>P_SHIPPING,
		SORTING=>P_SORTING,
		MANUFACTURER=>M_ID,
		MANUFACTURER_IMAGE=>M_IMAGE,
		MANUFACTURER_URL=>M_URL,
		CAT_IMAGE=>C_IMAGE,
		CAT_HEADING_TITLE=>C_HEADING_TITLE,
		CAT_DESCRIPTION=>C_DESCRIPTION,
		CAT_META_TITLE=>C_META_TITLE,
		CAT_META_DESCRIPTION=>C_META_DESCRIPTION,
		CAT_META_KEYWORDS=>C_META_KEYWORDS
		);
		if (OL_COMMERCE)
		{
			$this->fields_assoc=array_merge($this->fields_assoc,array(
			BASEPRICE_SHOW=>P_BASEPRICE_SHOW,
			BASEPRICE_VALUE=>P_BASEPRICE_VALUE,
			MIN_ORDER_QUANTITY=>P_MIN_ORDER_QUANTITY,
			MIN_ORDER_VPE=>P_MIN_ORDER_VPE,
			UVPNOTAX=>P_UVPNOTAX));
		}
		// add lang fields
		for ($i=0;$i<LANGUAGES;$i++)
		{
			$lang_code=$this->languages[$i][CODE];
			$this->fields_assoc=array_merge($this->fields_assoc,
			array(
			NAME.$lang_code=>P_NAME,
			DESC.$lang_code=>P_DESC,
			SHORTDESC.$lang_code=>P_SHORTDESC,
			META_TITLE.$lang_code=>P_META_TITLE,
			META_DESC.$lang_code=>P_META_DESC,
			META_KEY.$lang_code=>P_META_KEY,
			KEYWORDS.$lang_code=>P_KEYWORDS,
			URL.$lang_code=>P_URL));
		}
		// add categorie fields
		for ($i=0;$i<CAT_DEPTH;$i++)
		{
			$this->fields_assoc[CAT.$i]=EMPTY_STRING;
		}
		// Group Prices
		for ($i=0;$i<GROUPS;$i++)
		{
			//$id=$this->Groups[$i+1][ID];
			$id=$i+1;
			$this->fields_assoc[PRICENOTAX_DOT.$id]=EMPTY_STRING;
		}
		if (DO_GROUP_CHECK)
		{
			for ($i=0;$i<GROUPS;$i++)
			{
				//$id=$this->Groups[$i+1][ID];
				$id=$i+1;
				$this->fields_assoc[GROUPACC.$id]=EMPTY_STRING;
			}
		}
		// product images
		for ($i=1;$i<=MO_PICS;$i++)
		{
			$this->fields_assoc[IMAGE_DOT.$i]='image_name';
		}
		//Build array to associate CSV-names to index in real import data array
		while (list($key,)=each($this->fields_assoc))
		{
			$this->field_index[$key]=false;				//Assume field not available
		}
		return $this->fields_assoc;
	}

	function adjust_price_from_net(&$price,$tax_class_id)
	{
		$tax_rate=$this->tax_rates[$tax_class_id];
		$price=$price*((100+$tax_rate)/100);
	}

	function adjust_price_to_net_import(&$price,$tax_class_id)
	{
		$tax_rate=$this->tax_rates[$tax_class_id];
		$price=$price/((100+$tax_rate)/100);
	}

	function adjust_price_to_net(&$price)
	{
		global $export_data;

		$tax_rate=$this->tax_rates[$export_data[P_TAX]];
		$price=$price/((100+$tax_rate)/100);
	}

	/**
	*   generating mapping layout for importfile
	*   @param array $mapping standard fields
	*   @return array
	*/
	function map_file($line_content)
	{
		$this->map_data=array();
		$open_file=$this->map_filename<>EMPTY_STRING;
		if ($open_file)
		{
			$file=$this->map_filename;
			$open_file=file_exists($file);
		}
		if ($open_file)
		{
			//Assign CSV-names to import-names
			$map_file_content=file($file);
			for ($j=0,$m=sizeof($map_file_content);$j<$m;$j++)
			{
				$line=trim($map_file_content[$j]);
				$line=explode(EQUAL,$line);
				$s=trim($line[1]);
				if ($s)
				{
					$this->map_data[$line[0]]=$s;
				}
			}
		}
		else
		{
			reset($this->fields_assoc);
			while (list($key,$value)=each($this->fields_assoc))
			{
				$this->map_data[$key]=$key;
			}
		}
		if ($line_content)
		{
			//Remove text-delimiter from field-names of import file
			for ($j=0,$m=sizeof($line_content);$j<$m;$j++)
			{
				$data=$line_content[$j];
				if (substr($data,-1)==CSV_TEXTSIGN)
				{
					$line_content[$j]=substr($data,1,strlen($data)-2);
				}
			}
			$low_val0=ord('a');
			//Find numerical index position of each field in input record
			while (list($key,$field_name)=each($this->map_data))
			{
				if (strlen($field_name)<=2)
				{
					//No field-name but cell-name!
					$field_name=strtolower($field_name);
					$low_val=ord($field_name[0])-$low_val0;
					$hi_val=$field_name[1];
					if ($hi_val)
					{
						$index=($low_val+1)*26+ord($hi_val)-$low_val0;
					}
					else
					{
						$index=$low_val;
					}
					$index=array_search($field_name,$line_content);								//Find field-name in import file field-names,
				}
				else
				{
					$index=array_search($field_name,$line_content);								//Find field-name in import file field-names,
				}
				if ($index!==false)
				{
					$this->field_index[$key]=$index;															//If found,assign its numerical index position
				}
			}
			$index=$this->field_index[MODEL];
		}
		else
		{
			$index=true;
		}
		return $index!==false;
	}

	/**
	*   Init some data
	*   @return array
	*/

	function init($filename,$map_filename)
	{
		$this->filename=$filename;
		$this->map_filename=$map_filename;
		$this->languages=$this->get_lang();
		define('LANGUAGES',count($this->languages));
		define('LANGUAGE_0',$this->languages[0][ID]);
		define('CAT_1_QUERY',SELECT."c.categories_id".
		SQL_FROM.
		TABLE_CATEGORIES." c,".
		TABLE_CATEGORIES_DESCRIPTION." cd
			WHERE
			cd.categories_name='#' and
			cd.language_id=".SESSION_LANGUAGE_ID." and
			cd.categories_id=c.categories_id and
			parent_id=@");
		$this->tax_rates=$this->getTaxRates();
		$this->mfn=$this->get_mfn();
		$this->errorlog=array();
		$this->Groups=olc_get_customers_statuses();
		define('GROUPS',count($this->Groups));
		$this->prod_desc_fields_array=array(NAME,DESC,SHORTDESC,META_TITLE,META_DESC,META_KEY,URL);
		if (IS_XTC)
		{
			$this->prod_desc_fields_array[]=KEYWORDS;
		}
		define('PROD_DESC_FIELDS',count($this->prod_desc_fields_array));

		$this->prod_fields_array=
		array(
		0=>MODEL,
		1=>EAN,
		2=>STOCK,
		3=>WEIGHT,
		4=>STATUS,
		5=>IMAGE,
		6=>DISC,
		7=>TAX,
		8=>TAX_VALUE,
		9=>PRICENOTAX,
		10=>OPTTPL,
		11=>FSK18,
		12=>TPL,
		13=>VPE,
		14=>VPE_STATUS,
		15=>VPE_VALUE,
		16=>SHIPPING,
		17=>SORTING
		);
		$this->prod_fields_is_text=array(
		0=>true,
		1=>true,
		2=>false,
		3=>false,
		4=>false,
		5=>true,
		6=>false,
		7=>false,
		8=>true,
		9=>false,
		10=>true,
		11=>false,
		12=>true,
		13=>false,
		14=>false,
		15=>false,
		16=>false,
		17=>false
		);
		if (OL_COMMERCE)
		{
			$this->prod_fields_array=array_merge($this->prod_fields_array,
			array(
			0=>BASEPRICE_SHOW,
			1=>BASEPRICE_VALUE,
			2=>MIN_ORDER_QUANTITY,
			3=>MIN_ORDER_VPE,
			4=>UVPNOTAX)
			);
			$this->prod_fields_is_text=array_merge($this->prod_fields_array,
			array(
			0=>true,
			1=>true,
			2=>true,
			3=>true,
			4=>true)
			);
		}
		define('PROD_FIELDS',count($this->prod_fields_array));

		$this->cat_fields_array=array(
		0=>CAT_HEADING_TITLE,
		1=>CAT_DESCRIPTION,
		2=>CAT_META_TITLE,
		3=>CAT_META_DESCRIPTION,
		4=>CAT_META_KEYWORDS);
		define('CAT_FIELDS',count($this->cat_fields_array));
		define('CAT_FIELDS_2',CAT_FIELDS+2);

		$this->field_index=array();
		$this->new_lines_array=array("\n\r","\r\n","\n","\r",chr(10),chr(13),chr(10).chr(13),chr(13).chr(10));
		$this->fields_assoc=$this->create_field_associations();
		$this->build_CatTree();
		$this->time_start=time();
	}

	/**
	*   Get installed languages
	*   @return array
	*/
	function get_lang()
	{
		$languages_query=olc_db_query("select languages_id,name,code,image,directory from ".
		TABLE_LANGUAGES.SQL_ORDER_BY."sort_order");
		$languages_array=array();
		while ($languages=olc_db_fetch_array($languages_query))
		{
			$languages_array[]=array(
			ID=>$languages['languages_id'],
			CODE=>$languages[CODE]);
		}
		return $languages_array;
	}

	function import()
	{
		// open file
		$file=$this->filename;
		$fp=fopen($file,"r");
		if ($fp)
		{
			if (!feof($fp))
			{
				$line_data=trim(fgets($fp,100000));		//Get first line
				$csv_separator="\t";
				if (strpos($line_data,$csv_separator)===false)
				{
					$csv_separator='§';
					if (strpos($line_data,$csv_separator)===false)
					{
						$csv_separator=SEMI_COLON;
						if (strpos($line_data,$csv_separator)===false)
						{
							$csv_separator=EMPTY_STRING;
						}
					}
				}
				if ($csv_separator)
				{
					$line_content=explode($csv_separator,$line_data);
					if ($this->map_file($line_content))
					{
						// walk through file data
						$line_count=1;
						while (!feof($fp))
						{
							// get line content
							$line_count++;
							$line_data=trim(fgets($fp,100000));
							if ($line_data)
							{
								$line_data=html_entity_decode($line_data,ENT_QUOTES);
/*
$GLOBALS['line_count']=$line_count;
$GLOBALS['line_data']=$line_data;
*/
								$this->dataArray=explode($csv_separator,$line_data);
								for ($j=0,$m=sizeof($this->dataArray);$j<$m;$j++)
								{
									$data=$this->dataArray[$j];
									if (substr($data,-1)==CSV_TEXTSIGN)
									{
										$this->dataArray[$j]=substr($data,1,strlen($data)-2);
									}
								}
								$error=EMPTY_STRING;
								$index=$this->field_index[MODEL];
								$model=$this->dataArray[$index];
								if ($model)
								{
if ($model=='PS20475')
{
	$j=$j;
}
									$cat0_index=$this->field_index[CAT_0];
									$no_cat_0=$cat0_index===false;
									//if (this->dataArray[$cat0_index] || $no_cat_0)
									//allow product allocation in Top-category
									if (true)
									{
										$products_id=$this->checkModel($model);
										if ($products_id)
										{
											$perform_text=UPDATE;
											//$error=TEXT_DOUBLE_MODEL.QUOTE.$model.QUOTE;
										}
										else
										{
											$perform_text=INSERT;
										}
										if (!$error)
										{
											$this->insertProduct($perform_text,$products_id,!$no_cat_0);
										}
									}
									else
									{
										$error=TEXT_NO_CAT;
									}
								}
								else
								{
									$error=TEXT_NO_MODEL;
								}
								if ($error)
								{
									$this->errorLog[]=sprintf(TEXT_ERROR,$error,$line_count);		//.$line_data
									$error=EMPTY_STRING;
								}
							}
						}
						fclose($fp);
					}
					else
					{
						$this->errorLog[]=sprintf(TEXT_ERROR,TEXT_NO_MODEL,$line_count);		//.$line_data
					}
				}
				else
				{
					$this->errorLog[]=sprintf(TEXT_ERROR,TEXT_NO_VALID_SEPARATOR,$line_count);		//.$line_data
				}
			}
			else
			{
				$file_error=TEXT_FILE_NO_DATA;
			}
		}
		else
		{
			$file_error=TEXT_FILE_ERROR_OPEN;
		}
		if ($file_error)
		{
			$this->errorLog[]=sprintf(TEXT_ERROR_FILE,$file_error);
		}
		$this->result=array($this->counter,$this->errorLog,$this->calcElapsedTime($this->time_start));
	}

	/**
	*   Check if a product exists in database,query for model number
	*   @param string $model products modelnumber
	*   @return boolean
	*/
	function checkModel($model)
	{
		$model_query=olc_db_query(str_replace(HASH,addslashes($model),PRODUCTS_ID_QUERY));
		if (olc_db_num_rows($model_query)>0)
		{
			$model_query=olc_db_fetch_array($model_query);
			return $model_query[P_ID];
		}
		else
		{
			return false;
		}
	}

	/**
	*   Check if a image exists
	*   @param string $model products modelnumber
	*   @return boolean
	*/
	function checkImage($imgID,$pID)
	{
		$img_query=olc_db_query(IMAGE_QUERY.$pID.IMAGE_QUERY_AND.$imgID);
		return olc_db_num_rows($img_query)>0;
	}

	/**
	*   Get/create manufacturers ID for a given Name
	*   @param String $manufacturer Manufacturers name
	*   @return int manufacturers ID
	*/
	function getMAN($manufacturer)
	{
		if ($manufacturer)
		{
			$manufacturer_id=$this->mfn[$manufacturer];
			$update=$manufacturer_id>0;
			$adjust=!$update;
			$manufacturers_array=array();
			//Check for manufacturers image
			$index=$this->field_index[MANUFACTURER_IMAGE];
			if ($index!==false)
			{
				$manufacturer_image=$this->dataArray($index);
				if ($manufacturer_image)
				{
					$manufacturers_array[M_IMAGE]=$manufacturer_image;
					$adjust=true;
				}
			}
			if ($adjust)
			{
				if ($update)
				{
					$mod_id='last_modified';
					$action=UPDATE;
					$where='manufacturers_id='.$manufacturer_id;
				}
				else
				{
					$mod_id='date_added';
					$action=INSERT;
					$where=EMPTY_STRING;
					$manufacturers_array[M_NAME]=$manufacturer;
				}
				$manufacturers_array[$mod_id]=NOW;
				olc_db_perform(TABLE_MANUFACTURERS,$manufacturers_array,$action,$where);
				if (!$update)
				{
					$manufacturer_id=mysql_insert_id();
					$this->mfn[$manufacturer]=$manufacturer_id;
				}
			}
		}
		return $manufacturer_id;
	}

	function insert_product($field_name)
	{
		$index=$this->field_index[$field_name];
		if ($index!==false)
		{
			$real_field_name=$this->fields_assoc[$field_name];
			//'P_TAX_VALUE' is not part of the database!!!!
			if ($real_field_name<>P_TAX_VALUE)
			{
				$this->products_array[$real_field_name]=$this->dataArray[$index];
			}
		}
	}

	function insert_product_manufacturer($field_name)
	{
		$index=$this->field_index[$field_name];
		if ($index!==false)
		{
			$real_field_name=$this->fields_assoc[$field_name];
			$this->products_array[$real_field_name]=$this->getMAN(trim($this->dataArray[$index]));
		}
	}

	function insert_product_description($field_name)
	{
		global $lang_code;
		$field_name.=$lang_code;

		$index=$this->field_index[$field_name];
		if ($index!==false)
		{
			$real_field_name=$this->fields_assoc[$field_name];
			$this->prod_desc_array[$real_field_name]=$this->dataArray[$index];
		}
	}

	/**
	*   Insert a new product into Database
	*   @param array $this->dataArray Linedata
	*   @param string $mode insert or update flag
	*/
	function insertProduct($mode=INSERT,$products_id,$touchCat=false)
	{
		global $lang_code;

		if ($this->user_filter)
		{
			user_filter($this);				//Allow user-specific filtering of input data
		}
		//Allow tax-class or tax-rate input!
		$index=$this->field_index[TAX];
		if ($index===false)
		{
			$tax_class_id=1;
		}
		else
		{
			$tax_class_id=$this->dataArray[$index];
		}
		if (!$tax_class_id)
		{
			//Tax-class not available. Try tax-value and convert to class.
			$index=$this->field_index[TAX_VALUE];
			if ($index!==false)
			{
				$tax_class_id=array_keys($this->tax_rates,(float)$this->dataArray[$index]);
				if ($tax_class_id!==false)
				{
					$tax_class_id++;
				}
			}
			if (!$tax_class_id)
			{
				$tax_class_id=1;
			}
			$this->dataArray[$index]=$tax_class_id;
		}
		if (DO_PRICE_IS_BRUTTO)
		{
			$index=$this->field_index[PRICENOTAX];
			if ($index!==false)
			{
				$this->adjust_price_from_net($this->dataArray[$index],$tax_class_id);
			}
			if (OL_COMMERCE)
			{
				$index=$this->field_index[UVPNOTAX];
				if ($index!==false)
				{
					$this->adjust_price_from_net($this->dataArray[$index],$tax_class_id);
				}
			}
		}

		$this->products_array=array();
		for ($i=0;$i<PROD_FIELDS;$i++)
		{
			$this->insert_product($this->prod_fields_array[$i]);
		}
		$this->insert_product_manufacturer(MANUFACTURER);
		$update=$mode<>INSERT;
		if ($update)
		{
			$this->counter['prod_upd']++;
			olc_db_perform(TABLE_PRODUCTS,$this->products_array,UPDATE,P_ID_EQUAL.$products_id);
		}
		else
		{
			$this->counter['prod_new']++;
			olc_db_perform(TABLE_PRODUCTS,$this->products_array);
			$products_id=mysql_insert_id();
		}
		$where_products_id=WHERE_P_ID_EQUAL.$products_id;
		$this->products_array=array();
		// Insert Group Prices.
		for ($i=0;$i<GROUPS;$i++)
		{
			$id=$i;
			$p_priceNoTax=PRICENOTAX_DOT.($id+1);
			$index=$this->field_index[$p_priceNoTax];
			if ($index!==false)
			{
				$p_priceNoTax=$this->dataArray[$index];
				if ($p_priceNoTax)
				{
					if ($update)
					{
						$truncate_query=DELETE_PERSONAL_OFFERS.$id.$where_products_id;
						olc_db_query($truncate_query);
					}
					// seperate string ::
					$prices=explode(TWO_COLON,$p_priceNoTax);
					for ($ii=0,$m=count($prices);$ii<$m;$ii++)
					{
						$price=$prices[$ii];
						if ($price)
						{
							$values=explode(COLON,$price);
							$price=$values[1];
							if (DO_PRICE_IS_BRUTTO)
							{
								$this->adjust_price_from_net($price,$tax_class_id);
							}
							$group_array=array(
							P_ID=>$products_id,
							'quantity'=>$values[0],
							'personal_offer'=>$values[1]);
							olc_db_perform(TABLE_PERSONAL_OFFERS_BY.$id,$group_array);
						}
					}
				}
			}
		}
		$products_id_par=P_ID_EQUAL.$products_id;
		if (DO_GROUP_CHECK)
		{
			// Insert Group Permissions.
			$group_ids=EMPTY_STRING;
			$all_groups=true;
			$any_group=false;
			for ($i=0;$i<GROUPS;$i++)
			{
				$id=$i;
				$p_groupAcc=GROUPACC.($id+1);
				$index=$this->field_index[$p_groupAcc];
				if ($index!==false)
				{
					$p_groupAcc=$this->dataArray[$index];
					if (isset($p_groupAcc))
					{
						$any_group=true;
						if (IS_XTC)
						{
							$insert_array=array(GROUP_PERMISSION.$i=>$id);
							olc_db_perform(TABLE_PRODUCTS,$insert_array,UPDATE,$products_id_par);
						}
						else
						{
							if ($group_ids)
							{
								$group_ids.=COMMA;
							}
							$group_ids.=str_replace(HASH,$i,GROUP_ID);
						}
					}
					else
					{
						$all_groups=false;
					}
				}
			}
			if (!$any_group)
			{
				//No Group ID available. Make it available for all groups
				if (IS_XTC)
				{
					for ($i=0;$i<GROUPS;$i++)
					{
						//$id=$this->Groups[$i+1][ID];
						$id=$i;
						$insert_array=array(GROUP_PERMISSION.$id=>$id);
						olc_db_perform(TABLE_PRODUCTS,$insert_array,UPDATE,$products_id_par);
					}
				}
				else
				{
					$insert_array=$this->cat_permission_array;
					olc_db_perform(TABLE_PRODUCTS,$insert_array,UPDATE,$products_id_par);
				}
			}
			elseif (NOT_IS_XTC)
			{
				if ($all_groups)
				{
					$group_ids=str_replace(HASH,ALL,GROUP_ID).COMMA.$group_ids;
				}
				$insert_array=array(GROUP_IDS=>$group_ids);
				olc_db_perform(TABLE_PRODUCTS,$insert_array,UPDATE,$products_id_par);
			}
		}
		$products_id_par.=SQL_AND;
		// insert images
		for ($i=1;$i<=MO_PICS;$i++)
		{
			$p_image=IMAGE_DOT.$i;
			$index=$this->field_index[$p_image];
			if ($index!==false)
			{
				$p_image=$this->dataArray[$index];
				if (isset($p_image))
				{
					if ($p_image)
					{
						$p_image=basename($p_image);
						// check if entry exists
						$insert_array=array('image_name'=>$p_image);
						if ($this->checkImage($i,$products_id))
						{
							olc_db_perform(TABLE_PRODUCTS_IMAGES,$insert_array,UPDATE,
							$products_id_par."image_nr='".$i.APOS);
						}
						else
						{
							$insert_array['image_nr']=$i;
							$insert_array[P_ID]=$products_id;
							olc_db_perform(TABLE_PRODUCTS_IMAGES,$insert_array);
						}
					}
				}
			}
		}
		for ($j=0;$j<LANGUAGES;$j++)
		{
			$this->prod_desc_array[P_ID]=$products_id;

			$lang_id=$this->languages[$j][ID];
			$this->prod_desc_array[LANG_ID]=$lang_id;

			$lang_code=$this->languages[$j][CODE];
			for ($k=0;$k<PROD_DESC_FIELDS;$k++)
			{
				$this->insert_product_description($this->prod_desc_fields_array[$k]);
			}
			if ($update)
			{
				olc_db_perform(TABLE_PRODUCTS_DESCRIPTION,$this->prod_desc_array,UPDATE,
				$products_id_par.LANG_ID_EQUAL.$lang_id);
			}
			else
			{
				olc_db_perform(TABLE_PRODUCTS_DESCRIPTION,$this->prod_desc_array);
			}
		}
		if ($touchCat)
		{
			if (!$update)
			{
				$this->insertCategory($products_id);
			}
		}
	}

	/**
	*   Match and insert Categories
	*   @param array $this->dataArray data array
	*   @param string $mode insert mode
	*   @param int $pID  products ID
	*/
	function insertCategory($pID)
	{
		$cat=array();
		for ($cat_level=0;$cat_level<CAT_DEPTH;$cat_level++)
		{
			$p_cat=CAT.$cat_level;
			$index=$this->field_index[$p_cat];
			if ($index!==false)
			{
				$p_cat=trim($this->dataArray[$index]);
				if ($p_cat)
				{
					$p_cat=addslashes($p_cat);
					$cat[$cat_level]=$p_cat;
				}
				else
				{
					break;
				}
			}
			else
			{
				break;
			}
		}
		$cat_0=$cat[0];
		if (strpos($cat_0,CAT_SEP)!==false)
		{
			//Cats are separated by CAT_SEP!!!! (1&1 shop export)
			$cat=explode(CAT_SEP,$cat_0);
			$cat_level=sizeof($cat);
		}
		if ($cat)
		{
			$catTree=implode($cat,TILDE);
		}
		else
		{
			$catTree=ZERO_STRING;
		}
		$cat_id=$this->CatTreeId[$catTree];
		if (!isset($cat_id))
		{
			$cat_levels=$cat_level-1;
			$catTree=EMPTY_STRING;
			$parent=0;
			$cat_id=0;
			for ($cat_level=0;$cat_level<=$cat_levels;$cat_level++)
			{
				$cat_name=$cat[$cat_level];
				if ($catTree)
				{
					$catTree.=TILDE;
				}
				$catTree.=$cat_name;
				$cat_id=$this->CatTreeId[$catTree];
				if (isset($cat_id))
				{
					$this->counter['cat_touched']++;
				}
				else
				{
					// insert categorie
					$this->counter['cat_new']++;
					$this->categorie_data[PARENT_ID]=$parent;
					if (DO_GROUP_CHECK)
					{
						//Allow category access for all groups
						$this->categorie_data=array_merge($this->categorie_data, $this->cat_permission_array);
					}
					if ($cat_level==$cat_levels)
					{
						//On last cat level, check if cat-description is defined
						//If yes, add all categories info
						$index=$this->field_index[CAT_DESCRIPTION];
						if ($index!==false)
						{
							for ($i=0;$i<CAT_FIELDS;$i++)
							{
								$field_name=$this->cat_fields_array[$i];
								$index=$this->field_index[$field_name];
								if ($index!==false)
								{
									$real_field_name=$this->fields_assoc[$field_name];
									$this->categorie_data[$real_field_name]=$this->dataArray[$index];
								}
							}
						}
					}
					olc_db_perform(TABLE_CATEGORIES,$this->categorie_data);
					$cat_id=mysql_insert_id();
					for ($lang=0;$lang<LANGUAGES;$lang++)
					{
						$categorie_data=
						array(
						LANG_ID=>$this->languages[$lang][ID],
						CAT_ID=>$cat_id,
						CAT_NAME=>stripslashes($cat[$cat_level]));
						olc_db_perform(TABLE_CATEGORIES_DESCRIPTION,$categorie_data);
					}
					$this->CatTreeId[$catTree]=$cat_id;
				}
				$parent=$cat_id;
				$parTree=$catTree;
			}
		}
		olc_db_perform(TABLE_PRODUCTS_TO_CATEGORIES,array(P_ID=>$pID,CAT_ID=>$cat_id));
	}

	/**
	*   Calculate Elapsed time from 2 given Timestamps
	*   @param int $time old timestamp
	*   @return String elapsed time
	*/
	function calcElapsedTime($time)
	{

		// calculate elapsed time (in seconds!)
		$diff=time()-$time;

		$daysDiff=0;
		$hrsDiff=0;
		$minsDiff=0;
		$secsDiff=0;

		$sec_in_a_day=60 * 60 * 24;
		while ($diff >=$sec_in_a_day)
		{
			$daysDiff++;
			$diff-=$sec_in_a_day;
		}
		$sec_in_an_hour=60 * 60;
		while ($diff >=$sec_in_an_hour)
		{
			$hrsDiff++;
			$diff-=$sec_in_an_hour;
		}
		$sec_in_a_min=60;
		while ($diff >=$sec_in_a_min)
		{
			$minsDiff++;
			$diff-=$sec_in_a_min;
		}
		$secsDiff=$diff;
		if ($hrsDiff)
		{
			$diff=$hrsDiff.TEXT_EXECUTION_TIME_HOUR;
		}
		else
		{
			$diff=EMPTY_STRING;
		}
		if ($minsDiff)
		{
			$diff.=$minsDiff.TEXT_EXECUTION_TIME_MINUTE;
		}
		if ($secsDiff)
		{
			$diff.=$secsDiff.TEXT_EXECUTION_TIME_SECOND;
		}
		return TEXT_EXECUTION_TIME.trim($diff);
	}

	/**
	*   Get manufacturers
	*   @return array
	*/
	function get_mfn()
	{
		$mfn_query=olc_db_query(SELECT.M_ID.COMMA_BLANK.M_NAME.SQL_FROM.TABLE_MANUFACTURERS);
		while ($mfn=olc_db_fetch_array($mfn_query))
		{
			$index=$mfn[M_NAME];
			$mfn_array[$index]=$mfn[M_ID];
			$this->mfn_image[$index]=false;
		}
		return $mfn_array;
	}

	/**
	*   Get the tax_class_id to a given %rate
	*   @return array
	*/
	function getTaxRates() // must be optimized (pre caching array)
	{
		$tax="
		select
    tr.tax_class_id,
    tr.tax_rate,
    ztz.geo_zone_id
    FROM ".
		TABLE_TAX_RATES." tr,".
		TABLE_ZONES_TO_GEO_ZONES." ztz
    WHERE
    ztz.zone_country_id=".STORE_COUNTRY." and
    tr.tax_zone_id=ztz.geo_zone_id";
		$tax_query=olc_db_query($tax);
		$tax=array();
		while ($tax_data=olc_db_fetch_array($tax_query))
		{
			$tax[$tax_data['tax_class_id']]=$tax_data['tax_rate'];
		}
		return $tax;
	}

	function build_CatTree()
	{
		$cat_select=olc_db_query(CATEGORIES_QUERY);
		if (olc_db_num_rows($cat_select))
		{
			$this->CatTreeId=array(ZERO_STRING=>0);
			while ($current_cat=olc_db_fetch_array($cat_select))
			{
				$cat_id=$current_cat[CAT_ID];
				$categories_names=array();
				get_parent_categories($categories_names,$cat_id);
				$catTree=EMPTY_STRING;
				for ($i=count($categories_names)-1;$i>=0;$i--)
				{
					$cat_name=addslashes(stripslashes(($categories_names[$i])));
					if ($catTree)
					{
						$catTree.=TILDE;
					}
					$catTree.=$cat_name;
				}
				$this->CatTreeId[$catTree]=$cat_id;
			}
		}
	}
}

// EXPORT

class olcExport extends olcImport
{
	function olcExport($map_filename)
	{
		$this->init('export'.date('_Y_m_d').'.csv',$map_filename);
		$this->ExportDir=DIR_FS_CATALOG.'export/';
		$this->cat=array();
		$this->parent=array();
		$this->counter=array('prod_exp'=>0);
		if ($this->map_file($line_content))
		{
			$this->export();
		}
	}

	function add_header_field($field_name)
	{
		global $heading;

		$field_name_mapped=$this->map_data[$field_name];
		if ($field_name_mapped==EMPTY_STRING)
		{
			$field_name_mapped=$field_name;
		}
		$heading.=$field_name_mapped.CSV_SEPARATOR;
	}

	function add_header_field_desc($field_name)
	{
		global $heading,$lang_code;

		$full_field_name=$field_name.$lang_code;
		$field_name_mapped=$this->map_data[$full_field_name];
		if ($field_name_mapped==EMPTY_STRING)
		{
			$field_name_mapped=$full_field_name;
		}
		$heading.=$field_name_mapped.CSV_SEPARATOR;
	}

	function add_product_field($field_name,$is_text=true)
	{
		global $line,$export_data;
		$field_name=$this->fields_assoc[$field_name];
		$data=$export_data[$field_name];
		if ($is_text)
		{
			$line.=CSV_TEXTSIGN.$data.CSV_TERM;
		}
		else
		{
			$line.=$data.CSV_SEPARATOR;
		}
	}

	function add_product_man_field($field_name)
	{
		global $line,$export_data;
		$field_name=$this->fields_assoc[$field_name];
		$index=$this->mfn[$export_data[$field_name]];
		$line.=CSV_TEXTSIGN.$index.CSV_TERM;
		if ($this->mfn_image[$index])
		{
			$line.=CSV_EMPTY_FIELD;
		}
		else
		{
			$this->add_product_man_field(MANUFACTURER_IMAGE);
		}
	}

	function add_product_desc_field($field_name)
	{
		global $line,$desc_data,$lang_code;

		$field_name=$this->fields_assoc[$field_name.$lang_code];
		$line.=CSV_TEXTSIGN.stripslashes($desc_data[$field_name]).CSV_TERM;
	}

	function export()
	{
		global $heading,$lang_code,$export_data,$desc_data,$line,$cat_data;

		$this->filename=$this->ExportDir.$this->filename;
		$fp=fopen($this->filename,"w+");
		$heading=EMPTY_STRING;
		for ($i=0;$i<PROD_FIELDS;$i++)
		{
			$this->add_header_field($this->prod_fields_array[$i]);
		}
		for ($i=0;$i<GROUPS;$i++)
		{
			$this->add_header_field(PRICENOTAX_DOT.($i+1));
		}
		if (DO_GROUP_CHECK)
		{
			for ($i=0;$i<GROUPS;$i++)
			{
				$this->add_header_field(GROUPACC.($i+1));
			}
		}
		// product additional images
		for ($i=1;$i<MO_PICS+ 1;$i++)
		{
			$this->add_header_field(IMAGE_DOT.$i);
		}
		// add lang fields
		for ($i=0;$i<LANGUAGES;$i++)
		{
			$lang_code=$this->languages[$i][CODE];
			for ($k=0;$k<PROD_DESC_FIELDS;$k++)
			{
				$this->add_header_field_desc($this->prod_desc_fields_array[$k]);
			}
		}
		// add categorie info fields
		for ($i=0;$i<CAT_DEPTH;$i++)
		{
			$this->add_header_field(CAT.$i);
		}
		$this->add_header_field(CAT_IMAGE);
		for ($i=0;$i<CAT_FIELDS;$i++)
		{
			$this->add_header_field($this->cat_fields_array[$i]);
		}
		$heading.=NEW_LINE;
		//print_r($heading);
		fputs($fp,$heading);
		// content
		$export_query=olc_db_query(SELECT_ALL.TABLE_PRODUCTS);		//.' ORDER BY `products_model` ASC'
		while ($export_data=olc_db_fetch_array($export_query))
		{
			$this->counter['prod_exp']++;

			$products_id=$export_data[P_ID];
			$where_products_id=WHERE_P_ID_EQUAL.$products_id;
			if (DO_PRICE_IS_BRUTTO)
			{
				$this->adjust_price_to_net($export_data[P_PRICENOTAX]);
			}
			//Export tax-rate
			$export_data[P_TAX_VALUE]=olc_round($this->tax_rates[$export_data[P_TAX]],1);
			//Export tax-rate
			$line=EMPTY_STRING;
			for ($i=0;$i<PROD_FIELDS;$i++)
			{
				$this->add_product_field($this->prod_fields_array[$i],$this->prod_fields_is_text[$i]);
			}
			$price_query0=SELECT_ALL.TABLE_PERSONAL_OFFERS_BY.HASH.$where_products_id.SQL_ORDER_BY."quantity";
			// group prices  Quantity:Price::Quantity:Price
			for ($i=0;$i<GROUPS;$i++)
			{
				$price_query_sql=str_replace(HASH,$i,$price_query0);
				$price_query=olc_db_query($price_query_sql);
				$groupPrice=EMPTY_STRING;
				while ($price_data=olc_db_fetch_array($price_query))
				{
					$price_personal_offer=$price_data['personal_offer'];
					if ($price_personal_offer>0)
					{
						if (DO_PRICE_IS_BRUTTO)
						{
							$this->adjust_price_to_net($price_personal_offer);
						}
						$groupPrice.=$price_data['quantity'].COLON.$price_personal_offer.TWO_COLON;
					}
				}
				if ($groupPrice)
				{
					$groupPrice.=COLON;
					$groupPrice=str_replace(THREE_COLON,EMPTY_STRING,$groupPrice);
					if ($groupPrice==COLON)
					{
						$groupPrice=EMPTY_STRING;
					}
				}
				$line.=CSV_TEXTSIGN.$groupPrice.CSV_TERM;
			}
			// group permissions
			if (DO_GROUP_CHECK)
			{
				if (IS_XTC)
				{
					for ($i=0;$i<GROUPS;$i++)
					{
						//$line.=CSV_TEXTSIGN.$export_data[GROUP_PERMISSION.$this->Groups[$i+1][ID]].CSV_TERM;
						$line.=CSV_TEXTSIGN.$export_data[GROUP_PERMISSION.($i+1)].CSV_TERM;
					}
				}
				else
				{
					$permissions=$export_data[GROUP_IDS];
					for ($i=0;$i<GROUPS;$i++)
					{
						if (strpos($permissions,str_replace(HASH,$i,GROUP_ID))===false)
						{
							$s=ZERO_STRING;
						}
						else
						{
							$s=ONE_STRING;
						}
						$line.=CSV_TEXTSIGN.$s.CSV_TERM;
					}
				}
			}
			if (MO_PICS>0)
			{
				$mo_query=SELECT_ALL.TABLE_PRODUCTS_IMAGES.$where_products_id;
				$mo_query=olc_db_query($mo_query);
				$img=array();
				while ($mo_data=olc_db_fetch_array($mo_query))
				{
					$img[$mo_data['image_nr']]=$mo_data['image_name'];
				}
				// product images
				for ($i=1;$i<=MO_PICS;$i++)
				{
					$line.=CSV_TEXTSIGN.$img[$i].CSV_TERM;
				}
			}
			$desc_sql0=SELECT_ALL.TABLE_PRODUCTS_DESCRIPTION.$where_products_id.SQL_AND.LANG_ID_EQUAL.HASH;
			for ($i=0;$i<LANGUAGES;$i++)
			{
				$lang_id=$this->languages[$i][ID];
				$desc_sql=str_replace(HASH,$lang_id,$desc_sql0);
				$desc_query=olc_db_query($desc_sql);
				$desc_data=olc_db_fetch_array($desc_query);
				$desc_data[P_DESC]=str_replace($this->new_lines_array,BLANK,$desc_data[P_DESC]);
				$desc_data[P_SHORTDESC]=str_replace($this->new_lines_array,BLANK,$desc_data[P_SHORTDESC]);
				$lang_code=$this->languages[$i][CODE];
				for ($k=0;$k<PROD_DESC_FIELDS;$k++)
				{
					$this->add_product_desc_field($this->prod_desc_fields_array[$k]);
				}
			}
			$cat_query=olc_db_query(P2C_QUERY_I.$where_products_id);
			$cat_links=olc_db_num_rows($cat_query);
			$multi_cat=$cat_links>1;
			if ($cat_links>0)
			{
				if ($multi_cat)
				{
					//Save products data
					$line_save=$line;
				}
				while ($cat_data=olc_db_fetch_array($cat_query))
				{
					$line.=$this->buildCAT($cat_data[CAT_ID]);
					if ($multi_cat)
					{
						$line.=CSV_EOL;
						fputs($fp,$line);
						//Restore products data
						$line=$line_save;
					}
				}
			}
			if (!$multi_cat)
			{
				$line.=CSV_EOL;
				fputs($fp,$line);
			}
		}
		fclose($fp);
		/*
		if (COMPRESS_EXPORT==TRUE_STRING_S)
		{
		$backup_file=$this->filename;
		$this->filename=$backup_file . '.zip';
		exec(LOCAL_EXE_ZIP . ' -j '.$this->filename.BLANK.$backup_file);
		@unlink($backup_file);
		}
		*/
		$this->result=array($this->counter,EMPTY_STRING,$this->calcElapsedTime($this->time_start));
	}

	function buildCAT($catID)
	{
		$cat=$this->cat[$catID];
		if ($cat)
		{
			return $cat;
		}
		else
		{
			global $export_data;

			//Find index for cat_id
			$index=array_keys($this->CatTreeId,$catID);
			$cat=explode(TILDE,$index[0]);
			$cat_count=count($cat);
			$catStr=EMPTY_STRING;
			for ($i=0,$n=$cat_count;$i<$n;$i++)
			{
				$catStr.=CSV_TEXTSIGN.$cat[$i].CSV_TERM;
			}
			$i=CAT_DEPTH-$cat_count;
			if ($i)
			{
				$catStr.=str_repeat(CSV_EMPTY_FIELD,$i);
			}
			$cat_desc_query=olc_db_query(CAT_IMAGE_QUERY.$catID);
			$cat_desc_data=olc_db_fetch_array($cat_desc_query);
			$real_field_name=$this->fields_assoc[CAT_IMAGE];
			$catStr_add=CSV_TEXTSIGN.$cat_desc_data[$real_field_name].CSV_TERM;

			$cat_desc_sql=str_replace(HASH,$catID,CAT_DESC_QUERY);
			$cat_desc_sql=str_replace(ATSIGN,SESSION_LANGUAGE_ID,$cat_desc_sql);
			$cat_desc_query=olc_db_query($cat_desc_sql);
			$cat_desc_data=olc_db_fetch_array($cat_desc_query);
			for ($i=0;$i<CAT_FIELDS;$i++)
			{
				$field_name=$this->cat_fields_array[$i];
				$real_field_name=$this->fields_assoc[$field_name];
				$cat_elem=trim(str_replace($this->new_lines_array,BLANK,$cat_desc_data[$real_field_name]));
				$catStr_add.=CSV_TEXTSIGN.$cat_elem.CSV_TERM;
			}
			$catStr_add.=CSV_TEXTSIGN;
			if ($export_cat_data_always)
			{
				$catStr_empty=$catStr_add;
			}
			else
			{
				$catStr_empty=str_repeat(CSV_EMPTY_FIELD,CAT_FIELDS_2).CSV_TEXTSIGN;
			}
			$this->cat[$catID]=$catStr.$catStr_empty;
			return $catStr.$catStr_add;
		}
	}

	/**
	*   Return Parent ID for a given categories id
	*   @return int
	*/
	function getParent($catID)
	{
		$parent_id=$this->parent[$catID];
		if (!$parent_id)
		{
			$parent_sql=CAT_PARENT_QUERY.$catID;
			$parent_query=olc_db_query($parent_sql);
			$parent_data=olc_db_fetch_array($parent_query);
			$parent_id=$parent_data[PARENT_ID];
			$this->parent[$catID]=$parent_id;
		}
		return $parent_id;
	}
}
?>