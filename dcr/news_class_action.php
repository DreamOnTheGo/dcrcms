<?php
require_once("../include/common.inc.php");
session_start();
require_once("adminyz.php");
require_once(WEB_CLASS . "/class.news.php");

header('cache-control:no-cache;must-revalidate');
$cls_news = new cls_news();

$error_msg = array();//错误信息
$back = array('新闻分类列表'=> 'news_class_list.php');

if( $action == 'add' || $action == 'add_ajax' )
{
	$error_msg = '';
	$iserror = false;
	if(checkinput())
	{
		if($action == 'add')
		{
			show_msg($error_msg, 2, $back);	
		}else if($action == 'add_ajax')
		{
			echo implode(',', $error_msg);
		}
	}else{
		//没有错误
		if($action == 'add_ajax')
		{
			$classname = iconv( 'utf-8', $web_code, urldecode( $classname ) );
			$classdescription = iconv('utf-8', $web_code, urldecode( $classdescription ) );
		}
		$rid = $cls_news->add_class(
									array(
											'classname'=>$classname,
					   		 				'classdescription'=>$classdescription,
											'parentid'=>(int)$parentid,
											'orderid'=>(int)$orderid,
							 			  )
					  				);
		if( ! $rid )
		{
			$error_msg[] = '添加新闻分类失败';
			if($action == 'add')
			{
				show_msg($error_msg, 2, $back);	
			}else if($action == 'add_ajax')
			{
				echo implode(',', $error_msg) . $classname;
			}
		}else
		{
			$error_msg[] = '添加新闻分类成功';
			if($action == 'add')
			{
				$back['继续添加'] = 'news_class_edit.php?action=add';
				show_msg($error_msg, 1, $back);
			}else if($action == 'add_ajax')
			{
				echo implode(',',$error_msg);
			}
		}
	}
}else if($action == 'getlist_ajax')
{
	$class_list = $cls_news-> get_class_list(array('col'=>'id,classname'));
	for($i=0; $i<count($class_list); $i++){
		$class_list[$i]['classname'] = urlencode(iconv('gb2312', 'utf-8', $class_list[$i]['classname']));
	}
	//echo iconv('gb2312','utf-8',$proclass_list[0]['classname']);
	echo json_encode($class_list);	
}else if( $action == 'modify' )
{
	if( checkinput() )
	{
		show_msg( $error_msg, 2, $back );
	}else
	{
		$class_info = array(
							'classname'=> $classname,
							'parentid'=> (int)$parentid,
							'orderid'=> (int)$orderid,
					   		'classdescription'=> $classdescription,
								 	);
		if( $cls_news->update_class( $id, $class_info ) )
		{
			$error_msg[] = '更新新闻分类成功';
			show_msg($error_msg, 1, $back);
		}else
		{
			$error_msg[] = '更新新闻分类失败';
			show_msg($error_msg, 2, $back);
		}
	}
}else if($action == 'del_news_class')
{
	$r_id = $cls_news->delete_class( $classid );
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
	if( $orderid )
	{
		foreach( $orderid as $key=> $value )
		{
			$cls_news->update_class( $key, array( 'orderid'=> $value ) );
		}
	}
	$error_msg[] = '更新排序成功';
	show_msg( $error_msg, 1, $back );
}else
{
	show_msg('非法参数', 2, $back);
}
function checkinput(){
	global $error_msg, $classname;
	if( strlen( $classname ) == 0 )
	{
		$error_msg[] = '请填写新闻分类名';
		$iserror = true;
	}
	return $iserror;
}
?>