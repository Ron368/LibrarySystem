<?php 
require_once dirname(__DIR__, 2) . '/include/initialize.php';
 if (!isset($_SESSION['USERID'])){
  redirect(web_root."admin/login.php");
 } 

$content='home.php';
$view = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : '';
switch ($view) {  
	default :
	  $content    = 'home.php';
}
require_once("themes/templates.php");
?>
