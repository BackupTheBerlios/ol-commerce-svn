<?PHP
//W. Kaiser-AJAX
/* -----------------------------------------------------------------------------------------
$Id: olc_silbentrennung.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:41 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

AJAX=Asynchronous JavaScript and XML
Info: http://de.wikipedia.org/wiki/Ajax_(Programmierung)

Hyphenation routine for german language

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de), w.kaiser@fortune.de

-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(shopping_cart.php,v 1.18 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (shopping_cart.php,v 1.15 2003/08/17); www.nextcommerce.org

Released under the GNU General Public License
---------------------------------------------------------------------------------------
*/

function olc_silbentrennung($current_text)
{
	if (false and IS_LOCAL_HOST)
	{
		$current_text_hyphenated=EMPTY_STRING;
		if ($current_text)
		{
			define('VOKALE','a,e,i,o,u,ä,ü,ö,r,s');
			define('VERBINDUNGEN','sch,ch,ph,ck,pf,br,pl,tr,gr');
			define('TRENNUNGEN','-,/,\,*,#,;,.,+,=,),(,&,!,?,<,>,:,_,~,s');
			define('WORD_BREAK','<wbr />');
			define('SOFT_HYPHEN','&shy;');
			define('LAB','<');
			define('RAB','>');
			$l_current_text=strtolower($current_text);
			$zeichenanzahl=strlen($l_current_text)-1;
			$look_forrab=0;
			$trennpositionen=array();
			$trennpositionen_type=array();
			$trennzeichen=substr(TRENNUNGEN,0,1);
			$allowtrennung=false;
			for ($i=0; $i<=$zeichenanzahl;$i++)
			{
				$currentchar=substr($l_current_text,$i,1);
				if ($currentchar==BLANK)
				{
					$lasttrennzeichenposition=$i;
				}
				elseif ($currentchar==LAB)
				{
					$look_forrab++;
					continue;
				}
				else
				{
					if ($currentchar==RAB)
					{
						$look_forrab--;
						continue;
					}
					if (!$look_forrab)
					{
						if (is_numeric($currentchar))
						{
							$i=$i;
						}
						else
						{
							$is_trennzeichen=$currentchar==$trennzeichen;
							if ($is_trennzeichen && $lastchar<>$trennzeichen)
							{
								$trennposition=$i;
								$lasttrennzeichenposition=$i;
								$allowtrennung=true;
							}
							else
							{
								if (!$trennenerlaubt)
								{
									$trennenerlaubt=strpos(VOKALE, $lastchar)!== false;
								}
								if (!$trennenerlaubt)
								{
									if (!$is_trennzeichen)
									{
										$trennenerlaubt=$currentchar==$lastchar;
									}
								}
								if ($trennenerlaubt)
								{
									$trennenerlaubt=$i>=($lasttrennzeichenposition+2);
								}
								if ($trennenerlaubt)
								{
									$trennenerlaubt=false;
									if ($i < $zeichenanzahl)
									{
										$nextchar=substr($l_current_text, $i+1, 1);
										$v=$lastchar . $currentchar;
										if ($checksch)
										{
											if ($v=="ch")
											{
												if (substr($l_current_text, $i-2, 1)=="s")
												{
													$v="sch";
												}
											}
										}
									}
									if (strpos(VOKALE, $nextchar)!==false)
									{
										if (strpos(VOKALE, $currentchar)===false)
										{
											if (strpos(TRENNUNGEN, $currentchar)===false)
											{
												if (strpos(TRENNUNGEN, $lastchar)===false)
												{
													if (strpos(VERBINDUNGEN, $v)!==false)
													{
														$trennposition=$i-strlen($v);
													}
													else
													{
														$trennposition=$i-1;
													}
												}
												$allowtrennung=true;
											}
										}
									}
								}
							}
							if ($allowtrennung)
							{
								$allowtrennung=false;
								$trennpositionen[]=$trennposition;
								$trennpositionen_type[]=$is_trennzeichen;
								$nr_trennpositionen++;
								$lasttrennzeichenposition=$trennposition;
							}
							$checksch=true;
							$lastchar=$currentchar;
						}
					}
				}
			}
			if ($nr_trennpositionen)
			{
				$lasttrennzeichenposition=0;
				for ($i=0;$i<$nr_trennpositionen;$i++)
				{
					$trennposition=$trennpositionen[$i];
					$is_trennzeichen=$trennpositionen_type[$i];
					if ($is_trennzeichen)
					{
						$trennzeichen=WORD_BREAK;
					}
					else
					{
						$trennzeichen=SOFT_HYPHEN;
					}
					$current_text_hyphenated.=
					substr($current_text,$lasttrennzeichenposition,$trennposition-$lasttrennzeichenposition+1).$trennzeichen;
					$lasttrennzeichenposition=$trennposition+1;
					/*
					if ($is_trennzeichen)
					{
					$lasttrennzeichenposition++;
					}
					*/
				}
				$current_text_hyphenated.=substr($current_text,$lasttrennzeichenposition);
			}
		}
		return $current_text_hyphenated;
	}
	else
	{
		return $current_text;
	}
}
?>