<?php

require_once("include/common.inc.php");
require_once(WEB_DR . "/common.php");

$id = intval($id);
if($id > 0)
{
}else
{
	//提示信息开始
	$msg = array();
	$back = array('产品列表'=> 'product_list.php', '首页'=>'index.' . $web_url_surfix);
	//提示信息结束

	$msg[] = '不存在这个产品信息！';
	show_msg($msg, 2, $back);
}

$pro = $cls_pro->get_info($id);
if(!$pro)
{
	//提示信息开始
	$msg = array();
	$back = array('产品列表'=>'product_list.php', '首页'=>'index.' . $web_url_surfix);
	//提示信息结束

	$msg[] = '不存在这个产品信息！';
	show_msg($msg, 2, $back);
}
$tpl->assign('pro', $pro);

$tpl->display('product.html');

?>