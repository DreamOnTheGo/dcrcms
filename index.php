<?php
if(!file_exists(dirname(__FILE__) . "/include/config_db.php"))
{
    header("Location:install/index.php");
    exit();
}
require_once("include/common.inc.php");
include WEB_DR."/common.php";//ģ��ͨ���ļ� ��ʼ��ģ���༰����ͨ�ñ���֮���

//��������
include_once WEB_CLASS."/news_class.php";
$n=new News();
$newslist=$n->GetList(0,array('id','title','addtime'),0,$index_news_count,'addtime desc');
$tpl->assign('newslist',$newslist);

//ҵ��Χ
include_once WEB_CLASS."/product_class.php";
$pro=new Product();
$prolist=$pro->GetList(0,array('id','title','logo'),0,$index_product_count);
$tpl->assign('prolist',$prolist);

$tpl->display('index.html');

?>