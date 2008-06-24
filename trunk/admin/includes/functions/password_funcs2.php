<?php
  function olc_validate_password_enc($enc, $enc_org){
  	if (olc_not_null($enc) && olc_not_null($enc_org)) {
		$stack = explode(':', $enc_org);
		if($enc == $stack[0]){
			return true;
		}else{
			return false;
		}		
	}
	
	return false;	
  }

  function olc_encrypt_password_to_mail($plain, $enc_org){
	$password = '';
	$stack = explode(':', $enc_org);
	$password = md5($stack[1] . $plain);
	return $password;
  }
?>