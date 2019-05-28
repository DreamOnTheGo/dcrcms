<?php
if(!file_exists(dirname(__FILE__) . "/include/config_db.php"))
{
    header("Location:install/index.php");
    exit();
}
require_once("include/common.inc.php");
include WEB_DR."/common.php";//模板通用文件 初始化模板类及载入通用变量之类的

//最新新闻
$newslist=$news->GetList(0,array('id','title','addtime'),0,$index_news_count);
$tpl->assign('newslist',$newslist);
unset($newslist);

//图片新闻
$tw_news_list=$news->GetList(0,array('id','title','logo'),0,5,'istop desc,id desc',"logo<>''");
$tpl->assign('tw_news_list',$tw_news_list);
unset($tw_news_list);

//最新产品
include_once WEB_CLASS."/product_class.php";
$pro=new Product();
$prolist=$pro->GetList(0,array('id','title','logo'),0,$index_product_count);
$tpl->assign('prolist',$prolist);

$tpl->display('index.html');

?>