<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";

$page = isset($page) && is_numeric($page) ? $page : 1;//��ǰҳ
$classid= isset($classid) && is_numeric($classid) ? $classid : 0;//��ǰ��ĿID

$start=($page-1)*$list_news_count;

//�����б�
$newslist=$news->GetList($classid,array('id','title','addtime'),$start,$list_news_count);
$tpl->assign('newslist',$newslist);
//������Ŀ
$classname=isset($id)?$n->GetClassName($classid).'_��������':'��������';
$tpl->assign('classname',$classname);

//��ҳ
include WEB_CLASS."/page_class.php";
$rsTotal=$news->GetNewsCount($classid);
$totalPage=ceil($rsTotal/$list_news_count);//��ҳ��
$page=new PageClass($page,$totalPage);
$fenye=$page->showPage();
$tpl->assign('fenye',$fenye);

$tpl->display('news_list.html');
?>