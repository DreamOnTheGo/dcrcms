<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";

$aid = 1; //���µ�ID Ϊ������˾����>��������µ�ID��
if($aid==0){
	ShowNext('û�е�ǰID������','index.php');
}

include WEB_CLASS."/single_class.php";
$single=new Single();
//$single->UpdateClick($aid);
$art=$single->GetInfo($aid);
$tpl->assign('art',$art);

$tpl->display('article.html');
?>