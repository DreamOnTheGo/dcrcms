<?php
require_once("include/common.inc.php");
if( 1 == $s_type )
{
	$mod = 'product_search';
}elseif( 2 == $s_type )
{
	$mod = 'news_search';
}
$cls_tpl = cls_app:: get_template( $mod );
$cls_tpl->display();
exit;
?>