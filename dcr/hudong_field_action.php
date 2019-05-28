<?php
require_once("../include/common.inc.php");
session_start();
require_once(WEB_CLASS . "/class.hudong.php");
require_once("adminyz.php");

$cls_hudong=new cls_hudong();

$error_msg = array();//错误信息
$back = array('信息字段列表'=>'hudong_field_list.php');

//本页为操作新闻的页面
if($action == 'add')
{
	if(checkinput())
	{
		show_msg($error_msg, 2, $back);	
	}else
	{
		$hudong_field_info = array(
						 'itemname'=>$itemname,
						 'fieldname'=>$fieldname,
						 'dtype'=>$dtype,
						 'vdefault'=>$vdefault,
						 'maxlength'=>$maxlength
						 );
		if($cls_hudong-> add_field($hudong_field_info))
		{
			$back['继续添加'] = 'hudong_field_edit.php?action=add';
			show_msg('添加信息字段成功', 1, $back);
		}else
		{
			$error_msg[] = '添加信息字段失败,可能的原因有：表中原来有这个字段';
			show_msg($error_msg, 2, $back);
		}
	}
}else if($action == 'modify')
{
	if(checkinput())
	{
		show_msg($error_msg, 2, $back);	
	}else{
		$hudong_field_info = array(
						 'itemname'=>$itemname,
						 'fieldname'=>$fieldname,
						 'dtype'=>$dtype,
						 'vdefault'=>$vdefault,
						 'maxlength'=>$maxlength
						 );
						 
		if($cls_hudong->update_field($id, $hudong_field_info))
		{
			show_msg('更改字段成功', 1, $back);
		}else{
			show_msg('更改字段失败', 2, $back);
		}
	}
}else if($action == 'delfield')
{
	if($cls_hudong->delete_field($id))
	{
		show_msg('删除字段成功', 1, $back);
	}else
	{
		show_msg('删除字段失败', 2, $back);
	}
}else if($action=='order')
{
	$id_list = $cls_hudong->get_filed_list(array('col'=>'id'));
	
	foreach($id_list as $value)
	{
		$sql = "update {tablepre}hudong_field set orderid=".$orderid[$value['id']]." where id=".$value['id'];
		//echo $sql;
		$cls_hudong->execute_none_query($sql);
	}
	show_msg('更新字段排序成功');
}
function checkinput()
{
	global $error_msg, $itemname, $fieldname, $dtype, $vdefault;
	if(strlen($itemname) == 0)
	{
		$error_msg[] = '请填写表单提示文字';
		$iserror = true;
	}
	if(strlen($fieldname)==0)
	{
		$error_msg[] = '请填写表单字段名称';
		$iserror = true;
	}
	if(in_array($dtype,array('select','radio','checkbox')))
	{
		if(empty($vdefault))
		{
			$error_msg[] = "你设定了字段为 {$dtype} 类型，必须在默认值中指定元素列表，如：'a,b,c' ";
			$iserror = true;
		}
	}
	
	return $iserror;
}
?>