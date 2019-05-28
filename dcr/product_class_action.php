<?php
require_once("../include/common.inc.php");
session_start();
require_once(WEB_CLASS . "/class.product.php");
require_once("adminyz.php");

header('cache-control:no-cache;must-revalidate');
$cls_pro = new cls_product();

//提示信息开始
$error_msg = array();//错误信息
$back = array('产品分类列表'=>'product_class_list.php');
//提示信息结束

//本页为操作新闻的页面
if($action=='add' || $action=='add_ajax')
{
	$iserror = false;
	if(strlen($classname) == 0)
	{
		$error_msg[] = '请填写产品分类名';
		$iserror = true;
	}
	if($iserror)
	{
		if($action == 'add')
		{
			show_msg($error_msg, 2, $back);	
		}elseif($action == 'add_ajax')
		{
			echo implode(',',$error_msg);
		}
	}else{
		//没有错误
		if($action == 'add_ajax')
		{
			$classname = iconv('utf-8', 'gb2312', urldecode($classname));
			$classdescription = iconv('utf-8', 'gb2312', urldecode($classdescription));
		}
		$rid = $cls_pro->add_class(array('classname'=>$classname,
								  'parentid'=>(int)$parentid,
								  'orderid'=>(int)$orderid,
					   		 'classdescription'=>$classdescription
							 )
					   );
		if(!$rid)
		{
			$error_msg[] = '添加产品分类失败';
			if($action == 'add')
			{
				show_msg($error_msg, 2, $back);
			}else if($action='add_ajax')
			{
				echo implode(',', $error_msg) . $classname;
			}
		}else
		{
			$error_msg[] = '添加产品分类成功';
			if($action == 'add')
			{
				$back['继续添加'] = 'product_class_edit.php?action=add';
				show_msg($error_msg, 1, $back);	
			}else if($action='add_ajax')
			{
				echo implode(',', $error_msg);
			}
		}
	}
}else if($action == 'getlist_ajax')
{
	$proclasslist = $cls_pro->get_class_list();
	for($i=0; $i<count($proclasslist); $i++)
	{
		$proclasslist[$i]['classname'] = urlencode(iconv('gb2312', 'utf-8', $proclasslist[$i]['classname']));
	}
	//echo iconv('gb2312','utf-8',$proclasslist[0]['classname']);
	echo json_encode($proclasslist);	
}else if($action == 'modify')
{
	if($cls_pro->update_class($id, array('classname'=>$classname,
								  'parentid'=>(int)$parentid,
								  'orderid'=>(int)$orderid,
					   		 'classdescription'=>$classdescription
							 )))
	{
		$error_msg[] = '更新产品分类成功';
		show_msg($error_msg, 1, $back);
	}else
	{
		$error_msg[] = '更新产品分类失败';
		show_msg($error_msg, 2, $back);
	}	
}else if($action == 'delproductclass')
{
	$r_id = $cls_pro->delete_class($classid);
	//echo $cls_pro->get_last_sql();
	if($r_id == 2)
	{
		$error_msg[] = '删除数据失败：请先删除这个类的子类';
		show_msg($error_msg, 2, $back);
	}else if($r_id == 3)
	{
		$error_msg[] = '删除数据失败';
		show_msg($error_msg, 2, $back);
	}elseif($r_id == 1)
	{
		$error_msg[] = '删除数据成功';
		show_msg($error_msg, 1, $back);
	}
}else if($action == 'order')
{
	if($orderid)
	{
		foreach($orderid as $key=>$value)
		{
			$cls_pro->update_class($key, array('orderid'=>$value));
		}
	}
	$error_msg[] = '更新排序成功';
	show_msg($error_msg, 1, $back);
}else
{
	show_msg('非法参数', 2, $back);
}
?>