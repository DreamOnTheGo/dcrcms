<?php
require_once("../include/common.inc.php");
session_start();
require_once("adminyz.php");

require_once(WEB_CLASS . "/class.model.php");
$cls_model = new cls_model( $model_id );
$model_info = $cls_model->get_info();
$cls_data = cls_app::get_data('@#@' . $model_info['model_table_name']);

$error_msg = array();//错误信息

//本页为操作新闻的页面
if($action == 'add')
{
	$info = get_req_data( 'id,action' );
	if( $cls_data-> insert( $info ) )
	{
		$back['继续添加'] = 'model_art_edit.php?action=add&?model_id=' . $model_id;
		$back['文章列表'] = 'model_art_list.php?model_id=' . $model_id;
		show_msg('添加信息字段成功', 1, $back);
	}else
	{
		$error_msg[] = '添加信息字段失败' . $cls_data->get_error();
		show_msg($error_msg, 2, $back);
	}
}
else if($action == 'modify')
{
	$info = get_req_data( 'id,action,add_time,model_id' );
	if( $cls_data-> update( $info, "id=$id" ) )
	{
		$back['文章列表'] = 'model_art_list.php?model_id=' . $model_id;
		show_msg('修改成功', 1, $back);
	}else
	{
		$error_msg[] = '修改失败' . $cls_data->get_error();
		show_msg($error_msg, 2, $back);
	}
}
else if($action == 'del')
{
	if( $cls_data-> delete( $id ) )
	{
		$back['文章列表'] = 'model_art_list.php?model_id=' . $model_id;
		show_msg('删除成功', 1, $back);
	}else
	{
		$error_msg[] = '删除失败' . $cls_data->get_error();
		show_msg($error_msg, 2, $back);
	}
}
else
{
	show_msg('非法操作?');
}
?>