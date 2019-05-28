<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";

$page = isset($page) && is_numeric($page) ? $page : 1;//当前页
$classid= isset($classid) && is_numeric($classid) ? $classid : 0;//当前栏目ID

$start = ($page-1) * $list_news_count;

$newslist = $cls_news->get_list($classid, array('col'=>'id,title,addtime', 'limit'=>"$start,$list_news_count"));
$tpl->assign('newslist', $newslist);
//新闻栏目
$classname = ($classid!=0) ? $cls_news-> get_class_name($classid) . '_新闻中心' : '新闻中心';
$tpl->assign('classname', $classname);

//分页
include WEB_CLASS."/class.page.php";
$rs_total = $cls_news->get_news_count($classid);
$total_page = ceil($rs_total / $list_news_count);//总页数
$cls_page = new cls_page($page, $total_page);
$fenye = $cls_page->show_page();
$tpl->assign('fenye', $fenye);

$tpl->display('news_list.html');
?>