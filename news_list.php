<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";

$page = isset($page) && is_numeric($page) ? $page : 1;//当前页
$classid= isset($classid) && is_numeric($classid) ? $classid : 0;//当前栏目ID

$start=($page-1)*$list_news_count;

//新闻列表
$newslist=$news->GetList($classid,array('id','title','addtime'),$start,$list_news_count);
$tpl->assign('newslist',$newslist);
//新闻栏目
$classname=isset($id)?$n->GetClassName($classid).'_新闻中心':'新闻中心';
$tpl->assign('classname',$classname);

//分页
include WEB_CLASS."/page_class.php";
$rsTotal=$news->GetNewsCount($classid);
$totalPage=ceil($rsTotal/$list_news_count);//总页数
$page=new PageClass($page,$totalPage);
$fenye=$page->showPage();
$tpl->assign('fenye',$fenye);

$tpl->display('news_list.html');
?>