<?php
include "../include/common.inc.php";
session_start();
set_time_limit(0);
include "adminyz.php";
$pdir = WEB_DR.$cpath;
$pdir = pathinfo($pdir);
$pdir = $pdir['dirname'];
//echo $pdir;
//echo substr(WEB_DR,0,strlen(WEB_DR)-1);
if(WEB_DR == WEB_DR . $cpath || WEB_DR == $cpath ||  $pdir == substr(WEB_DR, 0, strlen(WEB_DR) - 1))
{
	$pdir = '';
}else{
	$pdir = str_replace(WEB_DR, '', $pdir);
}
$back = array('文件列表'=> 'fmanage.php?cpath=' . $pdir);
if($action == 'del_dir')
{
	if(empty($cpath))
	{
		show_msg('没有操作的目录',2);
	}
	
	if(!isset($cpath))
	{
		$cpath = WEB_DR;
	}else{
		$cpath = WEB_DR.$cpath;
	}
	require_once(WEB_CLASS . "/class.dir.php");
	$cls_dir = new cls_dir($cpath);
	$cls_dir-> delete_dir();
	show_msg('删除目录成功',1, $back);
	
}else if($action == 'rename')
{
	rename(WEB_DR . $dir_name . DIRECTORY_SEPARATOR . $oldname, WEB_DR . $dir_name . DIRECTORY_SEPARATOR . $newname);
	show_msg('重命名成功', 1, $back);
	
}else if($action == 'del_file')
{
	@unlink(WEB_DR . $cpath);
	show_msg('删除文件成功', 1, $back);
}else if($action=='edit_file')
{
	//编辑文件
	//格式化content
	//如果是sqlite 则要把''换成'
	if($db_type == 1){
		$content = str_replace("''", "'", $content);
	}
	$content = stripslashes($content);
	//var_dump($content);
	//exit;
	require_once(WEB_CLASS . '/class.file.php');
	$cls_file = new cls_file($filepath);
	$cls_file-> set_text($content);
	$r = $cls_file-> write(true);
	if($r == 'r1')
	{
		show_msg('修改文件失败:文件不存在', 2, $back);
	}else if($r == 'r2')
	{
		show_msg('修改文件失败:文件不可写', 2, $back);
	}else if($r == false)
	{
		show_msg('修改文件失败:原因未知', 2, $back);
	}else
	{
		show_msg('修改文件成功', 1, $back);
	}
}else if($action=='zip')
{
	//压缩文件
	if(class_exists('ZipArchive'))
	{
		
		//把目录压缩进压缩文件 写这里是因为这个function通用性不强
		function add_dir_to_zip($path, $zip)
		{
			$handler = opendir($path); //打开当前文件夹由$path指定。
			while (($filename = readdir($handler)) !== false) {
			if ($filename != "." && $filename != "..")
			{
				//文件夹文件名字为'.'和‘..’，不要对他们进行操作
				if (is_dir($path . "/" . $filename))
				{// 如果读取的某个对象是文件夹，则递归
					add_dir_to_zip($path . "/" . $filename, $zip);
				} else { //将文件加入zip对象
					$zip->addFile($path . "/" . $filename, str_replace( WEB_DR . '/', '', $path . "/" . $filename ));
				}
				}
			}
			@closedir($path);
		}
		
		//p_r($id);
		$file_list = array(); //要压缩的对象
		foreach($id as $path)
		{
			array_push( $file_list, str_replace( '根目录/', '', $path ) );
		}
		//p_r($file_list);
		$cls_zip = new ZipArchive();
		$zip_filename = 'file.zip';
		@unlink( WEB_DR . '/' . $zip_filename );
		if( $cls_zip->open( WEB_DR . '/' . $zip_filename, ZipArchive::OVERWRITE) === TRUE)
		{
			foreach($file_list as $path)
			{
				if( is_file( WEB_DR . '/' . $path) )
				{
					$cls_zip->addFile( WEB_DR . '/' . $path , $path);
				}
				if( is_dir( WEB_DR . '/' . $path) )
				{
					add_dir_to_zip( WEB_DR . '/' . $path, $cls_zip );
				}
			}
			$cls_zip->close();
		}
		show_msg( '压缩文件已经生成<a href="' . $web_url . '/' . $zip_filename . '">' . $zip_filename . '</a>', 1 );
		
		//p_r($file_list);
	} else
	{
		show_msg( '请在php.ini开启对 php_zip.php支持', 2 );
	}
} else if($action=='un_zip')
{ 
	$cls_zip = new ZipArchive;
	if ($cls_zip->open( WEB_DR . '/' . $cpath ) === TRUE)
	{
		$cls_zip->extractTo(WEB_DR);
		$cls_zip->close();
		show_msg( '解压已完成', 1 );
	}
} else
{
	show_msg( '非法参数', 2, $back );
}
?>