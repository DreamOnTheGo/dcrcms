<?php
session_start();
include "../include/common.inc.php";
include WEB_CLASS."/config_class.php";
include "adminyz.php";

$config=new Config();

$msg=array();//信息

//本页为操作新闻的页面
if($action == 'sitemap_baidu'){
	if( empty($web_master_email_new) )ShowMsg('请输入网站管理员Email',2);
	
	$web_sitemap_baidu_news_count_new==0 && $web_sitemap_baidu_news_count_new=50;
	$web_sitemap_baidu_product_count_new==0 && $web_sitemap_baidu_product_count_new=50;
	
	//开始生成地图 地图生成在根目录
	$sitemap_txt = '<?xml version="1.0" encoding="'.$web_code.'"?>'."\r\n";
	$sitemap_txt .= '<document xmlns:bbs =" http://www.baidu.com/search/bbs_sitemap.xsd">'."\r\n";
	$sitemap_txt .= '<webSite>'.$web_url.'</webSite>'."\r\n";
	$sitemap_txt .= '<webMaster>'.$web_master_email_new.'</webMaster>'."\r\n";
	$sitemap_txt .= '<updatePeri>24</updatePeri>'."\r\n";
	$sitemap_txt .= '<updatetime>'.date('Y-m-d H:i:s').'</updatetime>'."\r\n";
	$sitemap_txt .= '<version>1.0</version>'."\r\n";
	//产品条目
	$pro=APP::GetProduct();
	$list_pro=$pro->GetList(0,array('id','title'),0,$web_sitemap_baidu_product_count_new,'id desc','',1);
	if($list_pro)
	{
		foreach($list_pro as $product)
		{
			$sitemap_txt .= '<item>'."\r\n";
			$sitemap_txt .= "\t".'<link>'.$web_url.'/'.$product['url'].'</link>'."\r\n";
			$sitemap_txt .= "\t".'<title>'.$product['title'].'</title>'."\r\n";
			$sitemap_txt .= '</item>'."\r\n";
		}
	}
	//新闻条目
	$cls_news=APP::GetNews();
	$list_news=$cls_news->GetList(0,array('id','title'),0,$web_sitemap_baidu_news_count_new);
	if($list_news)
	{
		foreach($list_news as $news)
		{
			$sitemap_txt .= '<item>'."\r\n";
			$sitemap_txt .= "\t".'<link>'.$web_url.'/'.$news['url'].'</link>'."\r\n";
			$sitemap_txt .= "\t".'<title>'.$news['title'].'</title>'."\r\n";
			$sitemap_txt .= '</item>'."\r\n";
		}
	}
	
	$sitemap_txt .='</document>';	
	
	include_once(WEB_CLASS.'f_class.php');
	$f=new FClass();
	$file_name = WEB_DR.'sitemap_baidu.xml';	
	$f->setText($sitemap_txt);
	$result = $f->saveToFile($file_name);
	
	if('r1' == $result || 'r2' == $result)
	{
		ShowMsg('在根目录下生成百度地图失败,地图文件不能创建或不能修改！请检查在根目录下操作文件的权限',2);
	}
	
	$configArr=array(
					 'web_sitemap_baidu_news_count'=>$web_sitemap_baidu_news_count_new,
					 'web_sitemap_baidu_product_count'=>$web_sitemap_baidu_product_count_new,
					 'web_master_email'=>$web_master_email_new
					 );
	$rs=$config->UpdateConfig($configArr);
	
	ShowMsg('生成百度地图成功');
}
?>