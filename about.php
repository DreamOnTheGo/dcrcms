<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";

$aid = 1; //文章的ID 为：（公司资料>下面的文章的ID）
if($aid==0){
	ShowNext('没有当前ID的文章','index.php');
}

include WEB_CLASS."/single_class.php";
$single=new Single();
//$single->UpdateClick($aid);
$art=$single->GetInfo($aid);
$tpl->assign('art',$art);

$tpl->display('article.html');
?>