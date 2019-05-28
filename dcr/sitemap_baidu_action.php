<?php
include "../include/common.inc.php";
session_start();
include WEB_CLASS."/class.config.php";
include "adminyz.php";

$config = new cls_config();

$msg = array();//信息

//本页为操作新闻的页面
if($action == 'sitemap_baidu')
{
	if( empty($web_master_email_new) )show_msg('请输入网站管理员Email',2);
	
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
	$cls_pro= cls_app :: get_product();
	$list_pro = $cls_pro->get_list(0, array('col'=>'id,title', 'limit'=>"0,$web_sitemap_baidu_product_count_new", 'order'=>'id desc'), 1);
	//p_r($list_pro);
	if($list_pro)
	{
		foreach($list_pro as $product)
		{
			$sitemap_txt .= '<item>'."\r\n";
			$sitemap_txt .= "\t".'<link>' . $web_url . '/' . $product['url'] . '</link>'."\r\n";
			$sitemap_txt .= "\t".'<title>' . $product['title'] . '</title>' . "\r\n";
			$sitemap_txt .= '</item>'."\r\n";
		}
	}
	//新闻条目
	$cls_news = cls_app :: get_news();
	$list_news = $cls_news-> get_list( 0, array( 'col'=>'id,title', 'limit'=>"0,$web_sitemap_baidu_news_count_new") );
	if($list_news)
	{
		foreach($list_news as $news)
		{
			$sitemap_txt .= '<item>'."\r\n";
			$sitemap_txt .= "\t".'<link>' . $web_url . '/' . $news['url'] . '</link>' . "\r\n";
			$sitemap_txt .= "\t".'<title>' . $news['title'] . '</title>' . "\r\n";
			$sitemap_txt .= '</item>' . "\r\n";
		}
	}
	
	$sitemap_txt .='</document>';	
	
	require_once(WEB_CLASS . '/class.file.php');
	$file_name = WEB_DR . '/sitemap_baidu.xml';
	$cls_file = new cls_file($file_name);
	$cls_file-> set_text($sitemap_txt);
	$result = $cls_file-> write();
	
	if('r1' == $result || 'r2' == $result)
	{
		show_msg('在根目录下生成百度地图失败,地图文件不能创建或不能修改！请检查在根目录下操作文件的权限',2);
	}
	
	$config_arr = array(
					 'web_sitemap_baidu_news_count'=>$web_sitemap_baidu_news_count_new,
					 'web_sitemap_baidu_product_count'=>$web_sitemap_baidu_product_count_new,
					 'web_master_email'=>$web_master_email_new
					 );
	$rs = $config->modify($config_arr);
	
	show_msg('生成百度地图成功');
}
?>