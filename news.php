<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";

$aid = isset($id) && is_numeric($id) ? $id : 0;//��ǰҳ
if($aid==0){
	ShowNext('û�е�ǰID������','news_list.php');
}

$news->UpdateClick($aid);
$art=$news->GetInfo($aid,$newsColList);
$art['artclass']=$news->GetClassName($art['classid']);
$tpl->assign('art',$art);

$tpl->display('news.html');
?>