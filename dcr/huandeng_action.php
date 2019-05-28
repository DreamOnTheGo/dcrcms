<?php
require_once("../include/common.inc.php");
session_start();
require_once("adminyz.php");

require_once(WEB_CLASS . '/class.data.php');
$huandeng_data = new cls_data('{tablepre}huandeng');

$error_msg = array();//错误信息
$back = array('幻灯列表'=>'huandeng_list.php');

//本页为操作新闻的页面
if($action == 'add')
{
		require_once(WEB_CLASS . "/class.upload.php");
		$cls_upload = new cls_upload('logo');
		$file_info = $cls_upload->upload(WEB_DR . "/uploads/huandeng/");
		
		$logo = $file_info['filename'];
		$info = array(
					   		'logo'=>$logo,
							'url'=>$url,
							'add_time'=>time(),
							'update_time'=>time()
							);
		$aid = $huandeng_data->insert($info);
		if(!$aid)
		{
			show_msg('添加幻灯失败'.mysql_error(), 2, $back);	
		}else{
			$back['继续添加'] = 'huandeng_edit.php?action=add';
			show_msg('添加幻灯成功', 1, $back);
		}
		//echo mysql_error();
}else if($action == 'edit')
{
		$info = array(
						'url'=>$url,
						'update_time'=>time()
						);
		require_once(WEB_CLASS . "/class.upload.php");
		$cls_upload = new cls_upload('logo');
		$file_info = $cls_upload->upload(WEB_DR . "/uploads/huandeng/");
		$logo = $file_info['filename'];
		if(strlen($logo)>0)
		{
			$old_info = $huandeng_data->select_one(array('col'=> 'logo', 'where'=> "id=$id"));
			$old_info = current($old_info);
			@unlink('../uploads/huandeng/' . $old_info['logo']);
			
			$info['logo'] = basename($logo);
		}
		if($huandeng_data-> update($info, "id=$id"))
		{
			show_msg('更新链接成功', 1, $back);
		}else
		{
			show_msg('更新链接失败', 2, $back);
		}
}
else if($action=='del')
{
	$info = $huandeng_data->select_one_ex(array('col'=> 'logo', 'where'=> "id=$id"));
	@unlink('../uploads/huandeng/'.$info['logo']);
	if($huandeng_data-> delete($id))
	{
		show_msg('删除数据成功', 1, $back);
	}else
	{
		show_msg('删除数据失败', 2, $back);
	}
}else
{
	show_msg('非法操作', 2, $back);
}
?>