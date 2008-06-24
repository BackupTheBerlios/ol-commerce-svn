<?php  
  header('Content-Type: application/x-javascript'); 
  
  include 'config/spaw_control.config.php';
  include 'class/util.class.php';

  if (BROWSER_IS_GECKO)
  {
    include 'class/script_gecko.js.php';
  }
  else
  {
    include 'class/script.js.php';
  }
?> 

