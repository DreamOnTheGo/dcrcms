<?php
if( !file_exists(dirname(__FILE__) . "/include/config.db.php") )
{
    header("Location:install/index.php");
    exit();
}
require_once( "include/common.inc.php" );
$mod = str_replace( '../', '', $mod );

if( empty( $mod ) )
{
	$mod = 'index';
}

$action_file = WEB_INCLUDE . '/action/' . $mod . '.php';
file_exists($action_file) && require_once($action_file);

$cls_tpl = cls_app:: get_template( $mod );
$cls_tpl->display();

?>