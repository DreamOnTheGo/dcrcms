<?php

defined('IN_DCR') or exit('No permission.'); 

//本页的配置值都要用''包括起来
require_once(WEB_INCLUDE . '/config.db.php');

$web_url = 'http://localhost'; //网址
$web_dir = '';//网站目录 以/开头 如:/dcr
$web_name = '我的网站';//网站标题
$web_keywords = '网站关键字';//网站关键字
$web_description = '网站简介';//网站简介

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

//邮件相关
$web_send_email = '0';//留言是否发送邮件
$web_email_server = '';//email server
$web_email_usrename = '';//email username
$web_email_password = '';//email password
$web_email_port = '25';//email port

//baidu sitemap,google sitemap
$web_master_email = '';//管理员email
$web_sitemap_baidu_news_count = '50';//百度地图中新闻数
$web_sitemap_baidu_product_count = '50';//百度地图中产品数
$web_sitemap_google_news_count = '50';//GG地图中新闻数
$web_sitemap_google_product_count = '50';//GG地图中产品数

//水印设置
$web_watermark_type = '0';//水印类型
$web_watermark_txt = '';//水印文字
$web_watermark_weizhi = '4';//水印位置

$web_url_surfix = 'php'; //文件名后缀. 动态为php 静态为html
if($web_url_module == '1')
{
	$web_url_surfix = 'php';
}elseif($web_url_module == '2')
{
	$web_url_surfix = 'html';
}

//初始化weburl
if(!empty($web_dir))
{
	$web_url = $web_url.$web_dir;
}

?>