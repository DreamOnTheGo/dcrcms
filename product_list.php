<?php
require_once("include/common.inc.php");
include WEB_DR . "/common.php";//模板通用文件 初始化模板类及载入通用变量之类的

$classid = intval($classid);

//产品
$totalPage = 0;//总页数
$page = isset($page) ? (int)$page : 1;
$start = ($page-1) * $list_product_count;

$pro_list = $cls_pro->get_list( $classid, array( 'col'=> 'id,title,logo', 'limit'=> "$start,$list_product_count", 'order'=> 'istop desc,id desc'), true );
$tpl->assign('pro_list', $pro_list);

if($classid == 0)
{
	$classname = "产品中心";
	$position = '首页>>产品中心';
}else
{
	$class_info = $cls_pro->get_class_info($classid);
	$classname = $class_info['classname'];
	$position = $class_info['position'];
}
$tpl->assign('classname', $classname);
$tpl->assign('position', $position);

//分页
require_once(WEB_CLASS . "/class.page.php");
$page_num = $cls_pro->get_list_count($classid, $where, 1);
$total_page = ceil($page_num / $list_product_count);//总页数

$cls_page = new cls_page($page, $total_page);
$fenye = $cls_page->show_page();
$tpl->assign('fenye', $fenye);

$tpl->display('product_list.html');

?>