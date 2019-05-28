<?php
require_once("../include/common.inc.php");
session_start();
require_once(WEB_CLASS . "/class.model.php");
require_once("adminyz.php");

$cls_model = new cls_model();

$error_msg = array();//错误信息

//本页为操作新闻的页面
if($action == 'add_field')
{
	if(checkinput())
	{
		show_msg($error_msg, 2, $back);	
	}else
	{
		$field_info = get_req_data( 'id,action' );
		if( $cls_model-> add_field( $field_info ) )
		{
			$back['继续添加'] = 'model_field_edit.php?action=add_field&model_id=' . $model_id;
			$back['字段列表'] = 'model_field_list.php?model_id=' . $model_id ;
			show_msg('添加信息字段成功', 1, $back);
		}else
		{
			$error_msg[] = '添加信息字段失败,可能的原因有：表中原来有这个字段';
			show_msg($error_msg, 2, $back);
		}
	}
}
else if($action == 'order_field')
{
	foreach( $order_id as $field_id=>$order_value )
	{
		$sql = "update @#@model_field set order_id={$order_value} where id=$field_id";
		//echo $sql;
		$cls_model->execute_none_query($sql);
	}
	show_msg('更新字段排序成功');
}
else if($action == 'add_model')
{	
	$model_info = get_req_data( 'action' );
	$rid = $cls_model-> add($model_info);
	if( $rid )
	{
		$back['继续添加'] = 'model_edit.php?action=add';
		$back['模型列表'] = 'model_list.php' ;
		show_msg('添加模型成功', 1, $back);
	}else
	{
		$error_msg[] = '添加模型失败' . $cls_model->get_error();
		show_msg($error_msg, 2, $back);
	}
}
else if($action == 'del_model')
{
	$rid = $cls_model-> delete($model_id);
	if( $rid )
	{
		show_msg('删除模型成功', 1, $back);
	}else
	{
		$error_msg[] = '删除模型失败' . $cls_model->get_error();
		show_msg($error_msg, 2, $back);
	}
}
else if($action == 'modify_field')
{
	$model_info = get_req_data( 'action' );
					 
	if( $cls_model-> update_field( $id, $model_info ) )
	{
		show_msg('更改字段成功', 1, $back);
	}else{
		show_msg('更改字段失败', 2, $back);
	}
}else if($action == 'del_field')
{
	if($cls_model->delete_field($id))
	{
		show_msg('删除字段成功', 1, $back);
	}else
	{
		show_msg('删除字段失败', 2, $back);
	}
}else if($action=='order')
{
	$id_list = $cls_model->get_filed_list(array('col'=>'id'));
	
	foreach($id_list as $value)
	{
		$sql = "update {tablepre}hudong_field set orderid=".$orderid[$value['id']]." where id=".$value['id'];
		//echo $sql;
		$cls_model->execute_none_query($sql);
	}
	show_msg('更新字段排序成功');
}
function checkinput()
{
	global $error_msg, $item_name, $field_name, $dtype, $vdefault;
	if( strlen( $item_name ) == 0 )
	{
		$error_msg[] = '请填写表单提示文字';
		$iserror = true;
	}
	if( strlen( $field_name ) == 0 )
	{
		$error_msg[] = '请填写表单字段名称';
		$iserror = true;
	}
	if( in_array( $dtype, array( 'select','radio','checkbox' ) ) )
	{
		if( empty( $vdefault ) )
		{
			$error_msg[] = "你设定了字段为 {$dtype} 类型，必须在默认值中指定元素列表，如：'a,b,c' ";
			$iserror = true;
		}
	}
	
	return $iserror;
}
?>