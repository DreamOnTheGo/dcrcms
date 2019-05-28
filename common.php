<?php
//使用smarty模板的通用文件
include WEB_T."/Smarty.class.php";
$tpl =new Smarty();
$tpl->template_dir = WEB_Tpl.'/'.$tpl_dir;
$tpl->compile_dir = WEB_T . "templates_c/";
$tpl->config_dir = WEB_T . "/configs/";
$tpl->cache_dir =WEB_T ."/caches/";
if($web_cache_time>0){
	$tpl->caching=true;
	$web_cache_time=(int)$web_cache_time;
}else{
	$tpl->caching=false;
}
$tpl->cache_lefetime =
$tpl->left_delimiter = '<{';
$tpl->right_delimiter = '}>';

$templeturl=$web_url.WEB_TplPath; //模板url
$templetdir=$tpl_dir; //模板目录名
$templetpath=WEB_TplPath.'/'.$tpl_dir; //模板路径

$tpl->assign('web_templeturl',$templeturl);
$tpl->assign('web_templetdir',$templetdir);
$tpl->assign('web_templetpath',$templetpath);
$tpl->assign('web_url',$web_url);
$tpl->assign('web_name',$web_name);

//产品类别
include WEB_CLASS."/product_class.php";
$pc=new Product(0);
$productClassList=$pc->GetClassList(array('id','classname'));
$tpl->assign('productClassList',$productClassList);
?>