<?php
// W. Kaiser BOF: Down for Maintenance except for admin ip or admin password
// Check for "Down for Maintenance" and allow processing or not

if (DOWN_FOR_MAINTENANCE == TRUE_STRING_S)
{
	$allowmaintenance_text='allowmaintenance';
	if (!$_SESSION[$allowmaintenance_text])
	{
		$allowmaintenance=$_GET[$allowmaintenance_text];
		// set the WARN_BEFORE_DOWN_FOR_MAINTENANCE to false if DOWN_FOR_MAINTENANCE = true
		if (WARN_BEFORE_DOWN_FOR_MAINTENANCE == TRUE_STRING_S)
		{
			olc_db_query(SQL_UPDATE . TABLE_CONFIGURATION .
			" set configuration_value = false, last_modified = 'now()'
				where configuration_key = 'WARN_BEFORE_DOWN_FOR_MAINTENANCE'");
		}
		//Check if user is allowed to work
		$RemoteAdress=getenv('REMOTE_ADDR');
		$valid=true;
		if (EXCLUDE_ADMIN_IP_FOR_MAINTENANCE==$RemoteAdress)
		{
			// ADMIN_IP --> Allow working
		}
		elseif ($allowmaintenance == ADMIN_PASSWORD_FOR_MAINTENANCE)
		{
			// "allowmaintenance"-password --> Allow working
		}
		/*
		elseif (false and $RemoteAdress == "127.0.0.1")
		{
		// Local system --> Allow working
		$RemoteAdress=$RemoteAdress;
		}
		*/
		else
		{
			if ($allowmaintenance)
			{
				//Check password vs. admin-password
				$check_customer_query =
				"select customers_password from ".TABLE_CUSTOMERS." where customers_id = 1";
				$check_customer_query = olc_db_query($check_customer_query);
				if (olc_db_num_rows($check_customer_query))
				{
					$check_customer = olc_db_fetch_array($check_customer_query);
					require_once(DIR_FS_INC.'olc_validate_password.inc.php');
					$valid=olc_validate_password($allowmaintenance, $check_customer['customers_password']);
				}
			}
			else
			{
				$valid=false;
			}
		}
		if ($valid)
		{
			// "allowmaintenance"-password --> Allow working
			$_SESSION[$allowmaintenance_text]=true;
		}
		else
		{
			require_once(DIR_FS_INC.'olc_href_link.inc.php');
			olc_redirect(olc_href_link(ADMIN_PATH_PREFIX.FILENAME_DOWN_FOR_MAINTENANCE,'pop_up=true',NONSSL,false,false,false));
		}
	}
}
elseif (WARN_BEFORE_DOWN_FOR_MAINTENANCE == TRUE_STRING_S)
{
	$ErrorMessage = TEXT_BEFORE_DOWN_FOR_MAINTENANCE;
}
if ($ErrorMessage != EMPTY_STRING)
{
	if (NOT_USE_AJAX || IS_AJAX_PROCESSING)
	{
		if (PERIOD_DOWN_FOR_MAINTENANCE != EMPTY_STRING)
		{
			$ErrorMessage .=ltrim(PERIOD_DOWN_FOR_MAINTENANCE);
		}
		require_once(DIR_FS_INC.'olc_image.inc.php');
		if ($IsAdminFunction or USE_AJAX)
		{
			global $messageStack;
			if (!is_object($messageStack))
			{
				// initialize the message stack for output messages
				if (IS_ADMIN_FUNCTION)
				{
					$file='table_block';
				}
				else
				{
					$file='boxes';
				}
				require_once(DIR_WS_CLASSES .$file.PHP);
				require_once(DIR_WS_CLASSES . 'message_stack.php');
				$messageStack = new messageStack;
			}
			if ($IsAdminFunction)
			{
				$messageStack->add($ErrorMessage,'warning');
			}
			else
			{
				$messageStack->add('maintenance',$ErrorMessage,'warning');
			}
		}
		else
		{
			require_once(DIR_FS_INC.'olc_output_warning.inc.php');
			require_once(DIR_WS_CLASSES.'boxes.php');
			olc_output_warning($ErrorMessage,true);
		}
	}
}

//  W. Kaiser EOF: WebMakers.com Added: Down for Maintenance
?>
