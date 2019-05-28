<?php
//本页的配置值都要用''包括起来
require_once('config_db.php');

$web_url = 'http://1.com:81'; //网址

$web_name = '我的网站';//网站标题

//模板设置
$prologowidth = '160';//产品缩略图大小
$prologoheight = '120';

$tpl_dir = 'default';   //模板目录
$web_cache_time = '0';   //模板缓存时间

$index_news_count = '12'; //首页新闻条数
$index_product_count = '6'; //首页产品条数

$list_news_count = '10';//新闻列表页每页数
$list_product_count = '9';//产品列表页每页数
?>