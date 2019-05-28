<?php
session_start();
include "../include/common.inc.php";
include WEB_CLASS."/config_class.php";
include "adminyz.php";

$config=new Config();

$msg=array();//信息

//本页为操作新闻的页面
if($action == 'sitemap_google'){	
	$web_sitemap_google_news_count_new==0 && $web_sitemap_google_news_count_new=50;
	$web_sitemap_google_product_count_new==0 && $web_sitemap_google_product_count_new=50;
	
	//开始生成地图 地图生成在根目录
	$sitemap_txt = '<?xml version="1.0" encoding="UTF-8"?>'."\r\n";
	$sitemap_txt .= '<urlset'."\r\n";
	$sitemap_txt .= "\t" . 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\r\n";
	$sitemap_txt .= "\t" . 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' . "\r\n";
	$sitemap_txt .= "\t" . 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9' . "\r\n";
	$sitemap_txt .= "\t" . 'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\r\n";
	
	//产品条目
	$pro=APP::GetProduct();
	$list_pro=$pro->GetList(0,array('id','title'),0,$web_sitemap_google_product_count_new,'id desc','',1);
	if($list_pro)
	{
		foreach($list_pro as $product)
		{
			$sitemap_txt .= '<url>'."\r\n";
			$sitemap_txt .= "\t".'<loc>'.$web_url.'/'.$product['url'].'</loc>'."\r\n";
			$sitemap_txt .= '<url>'."\r\n";
		}
	}
	//新闻条目
	$cls_news=APP::GetNews();
	$list_news=$cls_news->GetList(0,array('id','title'),0,$web_sitemap_google_news_count_new);
	if($list_news)
	{
		foreach($list_news as $news)
		{
			$sitemap_txt .= '<url>'."\r\n";
			$sitemap_txt .= "\t".'<loc>'.$web_url.'/'.$news['url'].'</loc>'."\r\n";
			$sitemap_txt .= '</url>'."\r\n";
		}
	}
	
	$sitemap_txt .='</urlset>';	
	
	include_once(WEB_CLASS.'f_class.php');
	$f=new FClass();
	$file_name = WEB_DR.'sitemap_google.xml';	
	$f->setText($sitemap_txt);
	$result = $f->saveToFile($file_name);
	
	if('r1' == $result || 'r2' == $result)
	{
		ShowMsg('在根目录下生成Google地图失败,地图文件不能创建或不能修改！请检查在根目录下操作文件的权限',2);
	}
	
	$configArr=array(
					 'web_sitemap_google_news_count'=>$web_sitemap_google_news_count_new,
					 'web_sitemap_google_product_count'=>$web_sitemap_google_product_count_new,
					 'web_master_email'=>$web_master_email_new
					 );
	$rs=$config->UpdateConfig($configArr);
	
	ShowMsg('生成Google地图成功');
}
?>