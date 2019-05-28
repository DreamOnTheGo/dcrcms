<?php
//本页的配置值都要用''包括起来
require_once('config_db.php');

$web_url = 'http://localhost'; //网址
$web_dir = '';//网站目录 以/开头 如:/dcr
$web_name = '我的网站';//网站标题

//编辑器目录
$web_editor = 'kindeditor';
//模板设置
$prologowidth = '160';//产品缩略图大小
$prologoheight = '120';

$newslogowidth = '305';//文章缩略图大小
$newslogoheight = '240';

$flinklogowidth = '100';//产品缩略图大小
$flinklogoheight = '50';

$tpl_dir = 'default';   //模板目录
$web_cache_time = '0';   //模板缓存时间

$index_news_count = '22'; //首页新闻条数
$index_product_count = '6'; //首页产品条数

$list_news_count = '10';//新闻列表页每页数
$list_product_count = '9';//产品列表页每页数

$web_tiaoshi = '0';//网站在调试阶段 1为是 0为否

$web_url_module = '1'; //全站网址模式1为动态 2为伪静态

$web_url_surfix='php'; //文件名后缀. 动态为php 静态为html
if($web_url_module=='1'){
	$web_url_surfix='php';
}elseif($web_url_module=='2'){
	$web_url_surfix='html';
}

//初始化weburl
if(!empty($web_dir))$web_url=$web_url.$web_dir;
?>