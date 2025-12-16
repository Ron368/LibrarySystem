<?php
defined('server') ? null : define("server", "localhost");
defined('user') ? null : define ("user", "root") ;
defined('pass') ? null : define("pass","");
defined('database_name') ? null : define("database_name", "db_onlinelibrary") ;

$project_root = str_replace('\\', '/', dirname(__DIR__));
$public_root  = $project_root . '/public';

$document_root = '';
if (isset($_SERVER['DOCUMENT_ROOT'])) {
    $document_root = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'], '/'));
}

if (empty($document_root)) {
    $document_root = $public_root;
}

$web_root_relative = trim(str_replace($document_root, '', $public_root), '/');
$web_root = $web_root_relative === '' ? '/' : '/' . $web_root_relative . '/';

define ('web_root' , $web_root);
define('server_root' , $project_root . '/');
?>
