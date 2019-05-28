<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";//模板通用文件 初始化模板类及载入通用变量之类的

//搜索
$totalPage=0;//总页数
$page=isset($page)?(int)$page:1;
$start=($page-1)*$list_product_count;
$where="title like '%$k%'";
$web_url_module=1;//搜索的 不要伪静态
if($s_type==1){
	//产品
	
	//这里搜索tag
	if(!empty($tag))
	{		
		$k='tag:'.$tag;
		$art_taglist=APP::GetArticle('{tablepre}taglist');
		$id_list=$art_taglist->GetList(array('aid'),'','',"tag='$tag'");
		$id_in_list=array();
		if($id_list)
		{
			foreach($id_list as $t_id)
			{
				$id_in_list[]=$t_id['aid'];
			}
		}
		if($id_in_list)
		{
			$id_in_list=implode(',',$id_in_list);
			$where="id in($id_in_list)";
		}
	}
	
	
	$pro=new Product();
	$prolist=$pro->GetList(0,array('id','title','logo'),$start,$list_product_count,'istop desc,id desc',$where);
	$tpl->assign('prolist',$prolist);
		
	$tpl->assign('classname',"[$k]_搜索结果");
	
	//分页
	include WEB_CLASS."/page_class.php";
	$sqlNum="select id from {tablepre}product where $where";
	$db->Execute($sqlNum);
	$pageNum=$db->GetRsNum();
	$totalPage=ceil($pageNum/$list_product_count);//总页数
	
	$page=new PageClass($page,$totalPage);
	$fenye=$page->showPage();
	$tpl->assign('fenye',$fenye);
	
	$tpl->display('product_list.html');
}else{
	//新闻
	
	$newslist=$news->GetList(0,array('id','title','addtime'),$start,$list_news_count,'',$where);
	$tpl->assign('newslist',$newslist);
	//新闻栏目
	$tpl->assign('classname',"[$k]_搜索结果");
	
	//分页
	include WEB_CLASS."/page_class.php";
	$rsTotal=$news->GetListCount($where);
	$totalPage=ceil($rsTotal/$list_news_count);//总页数
	$page=new PageClass($page,$totalPage);
	$fenye=$page->showPage();
	$tpl->assign('fenye',$fenye);
	
	$tpl->display('news_list.html');
}
?>