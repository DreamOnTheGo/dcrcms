<?php
include "../include/common.inc.php";
session_start();
include WEB_CLASS . "/class.config.php";
include "adminyz.php";

$config = new cls_config();

$msg = array();//信息

//本页为操作新闻的页面
if($action == 'sitemap_google')
{
    $web_sitemap_google_news_count_new == 0 && $web_sitemap_google_news_count_new = 50;
    $web_sitemap_google_product_count_new == 0 && $web_sitemap_google_product_count_new = 50;
   
    //开始生成地图 地图生成在根目录
    $sitemap_txt = '<?xml version="1.0" encoding="UTF-8"?>'."\r\n";
    $sitemap_txt .= '<urlset'."\r\n";
    $sitemap_txt .= "\t" . 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\r\n";
    $sitemap_txt .= "\t" . 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' . "\r\n";
    $sitemap_txt .= "\t" . 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9' . "\r\n";
    $sitemap_txt .= "\t" . 'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\r\n";
   
    //产品条目
    $cls_pro= cls_app :: get_product();
    $list_pro = $cls_pro->get_list( 0, array( 'col'=>'id,title', 'limit'=>"0,$web_sitemap_google_product_count_new", 'order'=>'id desc' ), 1 );
    if($list_pro)
    {
        foreach($list_pro as $product)
        {
            $sitemap_txt .= '<url>' . "\r\n";
            $sitemap_txt .= "\t" . '<loc>' . $web_url . '/' . $product['url'] . '</loc>' . "\r\n";
            $sitemap_txt .= '<url>' . "\r\n";
        }
    }
    //新闻条目
    $cls_news = cls_app :: get_news();
    $list_news = $cls_news-> get_list( 0, array( 'col'=>'id,title', 'limit'=>"0,$web_sitemap_google_news_count_new" ) );
    if($list_news)
    {
        foreach($list_news as $news)
        {
            $sitemap_txt .= '<url>'."\r\n";
            $sitemap_txt .= "\t" . '<loc>' . $web_url . '/' . $news['url'] . '</loc>' . "\r\n";
            $sitemap_txt .= '</url>' . "\r\n";
        }
    }
   
    $sitemap_txt .= '</urlset>';   
   
    require_once( WEB_CLASS . '/class.file.php' );
    $file_name = WEB_DR . '/sitemap_google.xml';
    $cls_file = new cls_file($file_name);
    $cls_file-> set_text($sitemap_txt);
    $result = $cls_file->write();
   
    if('r1' == $result || 'r2' == $result)
    {
        show_msg('在根目录下生成Google地图失败,地图文件不能创建或不能修改！请检查在根目录下操作文件的权限',2);
    }
   
    $configArr = array(
                     'web_sitemap_google_news_count'=>$web_sitemap_google_news_count_new,
                     'web_sitemap_google_product_count'=>$web_sitemap_google_product_count_new,
                     'web_master_email'=>$web_master_email_new
                     );
    $rs=$config->modify($configArr);
   
    show_msg('生成Google地图成功');
}
?>