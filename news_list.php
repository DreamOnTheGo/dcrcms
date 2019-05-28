<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";

$page = isset($page) && is_numeric($page) ? $page : 1;//��ǰҳ
$classid= isset($id) && is_numeric($id) ? $id : 1;//��ǰ��ĿID

$start=($page-1)*$list_news_count;
//�����б�
include WEB_CLASS."/news_class.php";
$n=new News();
$newslist=$n->GetList($classid,array('id','title','addtime'),$start,$list_news_count);
$tpl->assign('newslist',$newslist);
//������Ŀ
$classname=$n->GetClassName($classid);
$tpl->assign('classname',$classname);

//��ҳ
include WEB_CLASS."/page_class.php";
$rsTotal=$n->GetNewsCount($classid);
$totalPage=ceil($rsTotal/$list_news_count);//��ҳ��
$page=new PageClass($page,$totalPage);
$fenye=$page->showPage();
$tpl->assign('fenye',$fenye);

$tpl->display('news_list.html');
?>