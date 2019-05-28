<?php
if( !file_exists(dirname(__FILE__) . "/include/config.db.php") )
{
    header("Location:install/index.php");
    exit();
}
require_once( "include/common.inc.php" );
require_once( WEB_DR."/common.php" );//模板通用文件 初始化模板类及载入通用变量之类的

//最新新闻
$newslist = $cls_news->get_list( 0, array( 'col'=>'id,title,addtime', 'limit'=>"0,$index_news_count" ) );
$tpl->assign( 'newslist',$newslist );
unset($newslist);

//图片新闻
$tw_news_list = $cls_news->get_list( 0, array( 'col'=>'id,title,logo', 'limit'=>'0,5', 'order'=>'istop desc,id desc','where'=>"logo<>''" ) );
$tpl->assign('tw_news_list',$tw_news_list);
unset($tw_news_list);

//最新产品
require_once(WEB_CLASS . "/class.product.php");
$cls_pro = new cls_product();
$pro_list = $cls_pro->get_list( 0, array( 'col'=> 'id,title,logo', 'order'=>'id desc', 'limit'=> "0,$index_product_count" ) );
$tpl->assign('pro_list',$pro_list);

$tpl->display('index.html');

?>