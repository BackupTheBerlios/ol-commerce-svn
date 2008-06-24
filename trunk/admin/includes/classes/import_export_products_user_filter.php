<?php
global $strip_terminators;

$strip_terminators=array('LIEFERBAR','ANGEBOT','Beschreibung:','Ampel.gif');
define('STRIP_TERMINATORS',sizeof($strip_terminators));

define('LINE_BREAK','\\r\\n');
define('BIG_FONT','<FONT');
define('SMALL_FONT','<font');
define('BIG_P','<P');
define('SMALL_P','<p');

/*
define('IMPORT_FROM','Ab ');
define('IMPORT_PIECE','Stk.');
define('IMPORT_PIECE_SEP',SESSION_CURRENCY.' / '.IMPORT_PIECE);
define('IMPORT_PIECE_LEN',strlen(IMPORT_PIECE));
*/

function user_filter(&$import)
{
	global $strip_terminators;
	//Strip image-file-name
	$index=$import->field_index[IMAGE];
	$import->dataArray[$index]=basename($import->dataArray[$index]);
	for ($i=0;$i<LANGUAGES;$i++)
	{
		$lang_code=$import->languages[$i][CODE];
		//filter short description
		filter_description($import,$lang_code,SHORTDESC,$index);
		$import->dataArray[$index]=trim(strip_tags($import->dataArray[$index]));
		//filter description
		filter_description($import,$lang_code,DESC,$index);
	}
	//adjust shipping
	$index=$import->field_index[SHIPPING];
	if ($index!==false)
	{
		$import->dataArray[$index]=1;
	}
	//adjust status
	$index=$import->field_index[STATUS];
	if ($index!==false)
	{
		$import->dataArray[$index]=$import->dataArray[$index]==0;
	}
	//adjust tax
	$index=$import->field_index[TAX];
	if ($index!==false)
	{
		if ($import->dataArray[$index]==7)
		{
			$data=2;
		}
		else
		{
			$data=1;
		}
		$import->dataArray[$index]=$data;
	}

	//adjust price
	$index=$import->field_index[PRICENOTAX];
	if ($index!==false)
	{
		$price=$import->dataArray[$index];
		if ($price)
		{
			$price=str_replace(CURRENCY_THOUSANDS_POINT,EMPTY_STRING,$price);
			$price=str_replace(CURRENCY_DECIMAL_POINT,DOT,$price);
			if (DO_PRICE_IS_BRUTTO)
			{
				$import->adjust_price_to_net_import($price,$data);
			}
			$import->dataArray[$index]=$price;
		}
	}
	/*
	$index=$import->field_index[PRICENOTAX_DOT.ONE_STRING];
	if ($index!==false)
	{
		$price=$import->dataArray[$index];
		if ($price)
		{
			$price=trim(strip_tags($price));
			//$price=str_replace(SESSION_CURRENCY,EMPTY_STRING,$price);
			$sep='|';
			$pos=strpos($price,$sep);
			if ($pos===false)
			{
				$sep=IMPORT_PIECE_SEP;
				$pos=strpos($price,$sep);
			}
			else
			{
				$price=str_replace(SESSION_CURRENCY,EMPTY_STRING,$price);
			}
			if ($pos)
			{
				$rabatte=explode($sep,$price);
				$graduated_price=EMPTY_STRING;
				for ($i=0,$n=sizeof($rabatte)-1;$i<$n;$i++)
				{
					$price=str_replace(IMPORT_FROM,EMPTY_STRING,$rabatte[$i]);
					$qty=(int)$price;
					$pos=strpos($price,IMPORT_PIECE);
					if ($pos)
					{
						$price=substr($price,$pos+IMPORT_PIECE_LEN);
					}
					$price=trim($price);
					for ($j=strlen($price)-1;$j>=0;$j--)
					{
						$decimals_sep=$price[$j];
						if (!is_numeric($decimals_sep))
						{
							break;
						}
					}
					if ($j>=0)
					{
						if ($decimals_sep<>DOT)
						{
							$price=str_replace(CURRENCY_THOUSANDS_POINT,EMPTY_STRING,$price);
							$price=str_replace(CURRENCY_DECIMAL_POINT,DOT,$price);
						}
					}
					if (DO_PRICE_IS_BRUTTO)
					{
						$import->adjust_price_to_net_import($price,$data);
					}
					if ($graduated_price)
					{
						$graduated_price.=TWO_COLON;
					}
					$graduated_price.=$qty.COLON.$price;
				}
				$i=$i;
				for ($i=1;$i<GROUPS;$i++)
				{
					$p_priceNoTax=PRICENOTAX_DOT.$i;
					$import->dataArray[$p_priceNoTax]=$graduated_price;
				}
			}
		}
	}
	*/
}

function filter_description(&$import,$lang_code,$field_name,&$index)
{
	global $strip_terminators;

	$index=$import->field_index[$field_name.$lang_code];
	if ($index!==false)
	{
		$data=trim($import->dataArray[$index]);
		if ($data)
		{
			$pos=0;
			for ($i=0;$i<STRIP_TERMINATORS;$i++)
			{
				$pos_i=strpos($data,$strip_terminators[$i]);
				if ($pos_i!==false)
				{
					$pos=max($pos,$pos_i);
				}
			}
			if ($pos)
			{
				$data=str_replace(BIG_FONT,SMALL_FONT,$data);
				$pos_i=strpos($data,SMALL_FONT,$pos);
				if (!$pos_i)
				{
					$data=str_replace(BIG_P,SMALL_P,$data);
					$pos=strpos($data,SMALL_P,$pos);
				}
				else
				{
					$pos=$pos_i;
				}
				if ($pos)
				{
					$data=substr($data,$pos);
				}
			}
			$data=str_replace(LINE_BREAK,BLANK,$data);
			$data=str_replace(TWO_BLANK,BLANK,$data);
			$import->dataArray[$index]=trim($data);
		}
	}
}
?>
