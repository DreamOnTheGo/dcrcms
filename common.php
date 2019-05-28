<?php
//获取一个smarty
$tpl = cls_app:: get_tpl();

$templeturl = $web_url . WEB_TplPath; //模板url
$templetdir = $tpl_dir; //模板目录名
$templetpath = WEB_TplPath . '/' . $tpl_dir; //模板路径

$tpl->assign('web_templeturl', $templeturl);
$tpl->assign('web_templetdir', $templetdir);
$tpl->assign('web_templetpath', $templetpath);
$tpl->assign('web_url_surfix', $web_url_surfix);
$tpl->assign('web_url', $web_url);
$tpl->assign('web_name', $web_name);
$tpl->assign('web_keywords', $web_keywords);
$tpl->assign('web_description', $web_description);
$tpl->assign('web_code', $web_code);

//导航条
require_once(WEB_CLASS . "/class.menu.php");
$cls_menu = new cls_menu();
$menu_list = $cls_menu->get_list();
$tpl->assign('menu_list', $menu_list);

//产品类别
$cls_pro = cls_app:: get_product();
$product_class_list = $cls_pro-> get_class_list();
$tpl->assign('product_class_list', $product_class_list);
$pro_class_list_txt = $cls_pro-> get_class_list_ul($product_class_list);
$pro_class_list_txt = $cls_pro-> get_class_list_ul_html();
$tpl->assign('pro_class_list_txt', $pro_class_list_txt);
//p_r($productClassList);

//新闻类别
$cls_news = cls_app:: get_news();
$news_class_list = $cls_news-> get_class_list();
$tpl->assign('news_class_list', $news_class_list);
$news_class_list_txt = $cls_news-> get_class_list_ul($news_class_list);
$news_class_list_txt = $cls_news-> get_class_list_ul_html();
$tpl->assign('news_class_list_txt', $news_class_list_txt);

//友情链接
$flink_data = cls_app:: get_data('{tablepre}flink');
$flink_list = $flink_data-> select_ex(array('order'=>'id desc'));
$tpl->assign('flink_list',$flink_list);
?>