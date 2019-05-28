<?php
require_once("include/common.inc.php");
require_once(WEB_DR . "/common.php");

//搜索
$total_page = 0;
$page = isset($page) ? (int)$page:1;
$start = ($page-1) * $list_product_count;
$where = "title like '%$k%'";
$web_url_module = 1;
if($s_type==1)
{
	//产品
	
	//这里搜索tag
	if(!empty($tag))
	{		
		$k = 'tag:' . $tag;
		$art_taglist = app:: get_data('{tablepre}taglist');
		$id_list = $art_taglist->select_ex(array('col'=>'aid', 'where'=> "tag='$tag'"));
		$id_list = current($id_list);
		$id_in_list = array();
		if($id_list)
		{
			foreach($id_list as $t_id)
			{
				$id_in_list[] = $t_id['aid'];
			}
		}
		if($id_in_list)
		{
			$id_in_list = implode(',',$id_in_list);
			$where = "id in($id_in_list)";
		}
	}	
	
	$pro_list = $cls_pro->get_list(0,array('col'=>'id,title,logo', 'limit'=> "$start,$list_product_count", 'order'=>'istop desc,id desc', 'where'=>$where));
	$tpl->assign('pro_list',$pro_list);
		
	$tpl->assign('classname', "[$k]_搜索结果");
	
	//分页
	include WEB_CLASS."/class.page.php";
	$page_num = $cls_pro-> get_list_count(0, $where);
	$total_page = ceil($page_num / $list_product_count);//总页数
	
	$cls_page = new cls_page($page,$total_page);
	$fenye = $cls_page->show_page();
	$tpl->assign('fenye',$fenye);
	
	$tpl->display('product_list.html');
}else
{
	//新闻
	
	$newslist = $cls_news-> get_list(0, array('col'=>'id,title,addtime', 'limit'=>"$start,$list_news_count", 'where'=>$where));
	$tpl->assign('newslist',$newslist);
	//新闻栏目
	$tpl->assign('classname',"[$k]_搜索结果");
	
	//分页
	include WEB_CLASS."/class.page.php";
	$rs_total = $cls_news->get_news_count(0, $where);
	$total_page = ceil($rs_total/$list_news_count);//总页数
	$cls_page = new cls_page($page,$total_page);
	$fenye = $cls_page-> show_page();
	$tpl->assign('fenye',$fenye);
	
	$tpl->display('news_list.html');
}
?>