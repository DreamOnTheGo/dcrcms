<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";

$aid = isset($id) && is_numeric($id) ? $id : 0;//��ǰҳ
if($aid==0){
	ShowNext('û�е�ǰID������','news_list.php');
}

include WEB_CLASS."/news_class.php";
$art=new News(0);
$art->UpdateClick($aid);
$art=$art->GetInfo($aid,$newsColList);
$tpl->assign('art',$art);

$tpl->display('news.html');
?>