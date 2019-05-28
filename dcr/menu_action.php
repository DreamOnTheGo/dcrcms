<?php
require_once("../include/common.inc.php");
session_start();
require_once("adminyz.php");

require_once(WEB_CLASS . '/class.menu.php');
$cls_menu = new cls_menu();

$error_msg = array();
$back = array('导航列表'=> 'menu_list.php');

//本页为操作新闻的页面
if($action == 'add')
{
	$menu_type = intval($menu_type);
	$info = array('menu_type'=>$menu_type,
				  'menu_text'=>$menu_text,
				  'order_id'=>$order_id,
				  'target'=>$target,
				  'url'=>$url,
				  'addtime'=>time(),
				  'updatetime'=>time()
				  );
	set_id($info);
	$aid = $cls_menu->add($info);
	if(!$aid)
	{
		show_msg('添加失败' . mysql_error(), 2, $back);	
	}else{
		$back['继续添加'] = 'menu_edit.php?action=add';
		show_msg('添加接成功', 1, $back);
	}
	//echo mysql_error();
}else if($action == 'edit')
{
	$info = array('menu_type'=>$menu_type,
				  'menu_text'=>$menu_text,
				  'order_id'=>$order_id,
				  'target'=>$target,
				  'url'=>$url,
				  'updatetime'=>time()
				  );
	set_id($info);
	if($cls_menu-> update($id, $info))
	{
		show_msg('更新成功', 1, $back);
	}else
	{
		show_msg('更新失败', 2, $back);
	}
}
else if($action == 'del')
{
	if($cls_menu-> delete($id))
	{
		show_msg('删除数据成功', 1, $back);
	}else
	{
		show_msg('删除数据失败', 2, $back);
	}
}else if($action == 'order')
{
	if($order_id)
	{
		foreach($order_id as $key=>$value)
		{
			$cls_menu->update($key, array('order_id'=> intval($value) ) );
		}
		$cls_menu->write_cache();
	}
	show_msg('更新排序成功', 1, $back);
}else
{
	show_msg('非法操作', 2, $back);
}

//获取地址 menu_type菜单类型 菜单标题
function set_id($info)
{
	$cls_data = cls_app:: get_data('@#@single');
	global $menu_type, $web_url_module, $web_url_surfix, $news_class_list, $pro_class_list, $single_list, $url, $cls_menu;
	$menu_type_list = $cls_menu->get_menu_type_list();
	switch($menu_type)
	{
		case 1:
			$cls_data->set_table('{tablepre}single');
			$single_info = $cls_data-> select_one(array('col'=>'id','where'=>"title='$single_list'"));
			$single_info = current($single_info);
			$info['single_id'] = $single_info['id'];
			break;
		case 2:
			//新闻
			if($menu_type_list[$menu_type] == $news_class_list)
			{
				$news_class_id = 0;
			}else
			{
				$cls_data->set_table('{tablepre}news_class');
				$news_class_info = $cls_data-> select_one(array('col'=>'id','where'=>"classname='$news_class_list'"));
				$news_class_info = current($news_class_info);
				$news_class_id = $news_class_info['id'];
			}
			$info['news_class_id'] = $news_class_id;
			break;
		case 3:
			//产品
			if($menu_type_list[$menu_type] == $pro_class_list)
			{
				$pro_class_id = 0;
			}else
			{
				$cls_data->set_table('{tablepre}product_class');
				$pro_class_info = $cls_data-> select_one(array('col'=>'id','where'=>"classname='$pro_class_list'"));
				$pro_class_info = current($pro_class_info);
				$pro_class_id = $pro_class_info['id'];
			}
			$info['product_class_id'] = $pro_class_id;
			break;
		case 4:
			break;
		case 5:
			break;
		default:
			break;
	}
}
?>