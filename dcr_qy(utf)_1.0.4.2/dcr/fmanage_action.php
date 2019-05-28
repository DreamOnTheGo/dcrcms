<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
$pdir=WEB_DR.$cpath;
$pdir=pathinfo($pdir);
$pdir=$pdir['dirname'];
//echo $pdir;
//echo substr(WEB_DR,0,strlen(WEB_DR)-1);
if(WEB_DR==WEB_DR.$cpath || WEB_DR==$cpath ||  $pdir==substr(WEB_DR,0,strlen(WEB_DR)-1)){
	$pdir='';
}else{
	$pdir=str_replace(WEB_DR,'',$pdir);
}
$back=array('文件列表'=>'fmanage.php?cpath='.$pdir);
if($action=='del_dir'){
	if(empty($cpath))ShowMsg('没有操作的目录',2);
	
	if(!isset($cpath)){
		$cpath=WEB_DR;
	}else{
		$cpath=WEB_DR.$cpath.'/';
	}
	include_once WEB_CLASS."f_class.php";
	$f=new FClass($cpath);
	$f->DelDir();
	ShowMsg('删除目录成功',1,$back);
}elseif($action=='rename'){
	rename(WEB_DR.$dir_name.DIRECTORY_SEPARATOR.$oldname,WEB_DR.$dir_name.DIRECTORY_SEPARATOR.$newname);
	ShowMsg('重命名成功',1,$back);
}elseif($action=='del_file'){
	@unlink(WEB_DR.$cpath);
	ShowMsg('删除文件成功',1,$back);
}elseif($action=='edit_file'){
	//编辑文件
	//格式化content
	//如果是sqlite 则要把''换成'
	if($db_type==1){
		$content=str_replace("''","'",$content);
	}
	$content=stripslashes($content);
	//var_dump($content);
	//exit;
	include WEB_CLASS.'f_class.php';
	$f=new FClass($filepath);
	$f->setText($content);
	$r=$f->saveToFile('',true);
	if($r=='r1'){
		ShowMsg('修改文件失败:文件不存在',2,$back);
	}elseif($r=='r2'){
		ShowMsg('修改文件失败:文件不可写',2,$back);
	}elseif($r==false){
		ShowMsg('修改文件失败:原因未知',2,$back);
	}else{
		ShowMsg('修改文件成功',1,$back);
	}
	//ShowMsg('删除文件成功',1,$back);
}else{
	ShowMsg('非法参数',2,$back);
}
?>