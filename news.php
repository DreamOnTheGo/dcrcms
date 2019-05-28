<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";

$aid = isset($id) && is_numeric($id) ? $id : 0;//当前页
if($aid == 0)
{
	show_next('没有当前ID的文章','news_list.'.$web_url_surfix);
}

$cls_news-> update_click($aid);
$art = $cls_news->get_info($aid);
//p_r($art);
$art['artclass'] = $cls_news->get_class_name($art['classid']);
$tpl->assign('art', $art);

$tpl->display('news.html');
?>