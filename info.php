<?php
require_once("include/common.inc.php");
require_once(WEB_DR . "/common.php");

$aid = $id;
if($aid == 0)
{
	show_msg('没有当前ID的文章', 2);
}

require_once(WEB_CLASS . "/class.single.php");
$cls_single = new cls_single();
//$single->UpdateClick($aid);
$art = $cls_single->get_info($aid);
$tpl->assign('art',$art);

$tpl->display('article.html');
?>