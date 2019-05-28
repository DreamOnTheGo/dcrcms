<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="css/admin.css" type="text/css" rel="stylesheet">
<script src="../include/js/common.js"></script>
</head>
<body>
<table cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <tr height=28>
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;文件管理器</td></tr>
  <tr>
    <td bgColor=#b1ceef height=1></td></tr></table>
<table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <tr height=20>
    <td></td></tr>
  <tr height=22>
    <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>文件列表</td></tr>
  <tr bgColor=#ecf4fc height=12>
  <?php
  
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
	//文档路径
	$path_arr = explode("/",$cpath);
	$path_rs_arr=array();
	for($i=0;$i<count($path_arr);$i++)
	{
		if($i==0)
		{
			$href=$path_arr[$i];
		}else{
			$t_arr=array();
			for($j=0;$j<$i+1;$j++)
			{
				$t_arr[]=$path_arr[$j];
			}
			$t_path=implode('/',$t_arr);
			$href=$t_path;
		}
		$path_rs_arr[]="<a href='?cpath=$href'>$path_arr[$i]</a>";
	}
	$path_rs=implode('/',$path_rs_arr);
  ?>
    <td style="padding:3px;"><a href="fmanage.php?cpath=<?php echo $pdir;?>">上级目录</a> 当前目录：<?php echo $path_rs; ?></td></tr>
  </table>
<form action="product_action.php" method="post">
<input type="hidden" name="action" id="action" value="delproduct">
<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">  
  <tr>
    <td width="36%" bgcolor="#FFFFFF">文件名</td>
    <td width="17%" bgcolor="#FFFFFF">文件大小</td>
    <td width="17%" bgcolor="#FFFFFF">最后修改时间</td>
    <td width="7%" bgcolor="#FFFFFF" align="center">可读</td>
    <td width="7%" bgcolor="#FFFFFF" align="center">可写</td>
    <td width="16%" bgcolor="#FFFFFF">操作</td>
  </tr>
  <?php
	if(!isset($cpath)){
		$cpath=WEB_DR;
	}else{
		$cpath=WEB_DR.$cpath.'/';
	}
	//数据库的列表'
	include_once WEB_CLASS."f_class.php";
	$f=new FClass($cpath);
	$dir_list=$f->GetDirList();
	$file_list=$f->GetFileList();
	//p_r($file_list);
	sort($dir_list);
	sort($file_list);
	//p_r($dir_list);
	$dir_num=count($dir_list);
	for($i=0;$i<$dir_num;$i++){
		if(preg_match("/^_(.*)$/i",$dir_list[$i]['filename'])) continue;
		if(preg_match("/^\.(.*)$/i",$dir_list[$i]['filename'])) continue;
	?>    
  <tr bgcolor="#FFFFFF" onMouseMove="javascript:this.style.backgroundColor='#F4F9EB';" onMouseOut="javascript:this.style.backgroundColor='#FFFFFF';">
    <td><a href="fmanage.php?cpath=<?php echo str_replace(WEB_DR,'',$dir_list[$i]['path']); ?>"><img border="0" src="images/dir.gif" /><?php echo $dir_list[$i]['filename']; ?></a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><a href="fmanage_rename.php?type=dir&action=rename&cpath=<?php echo str_replace(WEB_DR,'',$dir_list[$i]['path']); ?>">改名</a> <a onclick="return confirm('确定要删除目录<?php echo str_replace(WEB_DR,'',$dir_list[$i]['path']); ?>？')" href="fmanage_action.php?action=del_dir&cpath=<?php echo urlencode(str_replace(WEB_DR,'',$dir_list[$i]['path'])); ?>">删除</a></td>
  </tr>  
	<?php
	}
	$file_num=count($file_list);
	for($i=0;$i<$file_num;$i++){
		@$file_size = filesize($file_list[$i]['path']);
		@$file_size=$file_size/1024;
		if($file_size<0.1){
			@list($ty1,$ty2)=explode(".",$file_size);
			$file_size=$ty1.".".substr($ty2,0,2);
		}else{
			@list($ty1,$ty2)=explode(".",$file_size);
			$file_size=$ty1.".".substr($ty2,0,1);
		}
		
		@$file_time = filemtime($file_list[$i]['path']);
		@$file_time = date("Y-m-d H:i:s",$file_time);
		$cur_filename=$cpath.$file_list[$i]['filename'];//文件路径
		
  ?>  
  <tr bgcolor="#FFFFFF" onMouseMove="javascript:this.style.backgroundColor='#F4F9EB';" onMouseOut="javascript:this.style.backgroundColor='#FFFFFF';">
    <td><img border="0" src="images/file.gif" /><a href="<?php echo $web_url; ?>/<?php echo str_replace(WEB_DR,'',$file_list[$i]['path']); ?>" target="_blank"><?php echo $file_list[$i]['filename']; ?></a></td>
    <td><?php echo $file_size; ?>K</td>
    <td><?php echo $file_time; ?></td>
    <td width="7%" align="center"><?php if(is_readable($cur_filename)){echo '<span style="color:green;">√</span>';}else{echo '<span style="color:red">X</span>';}?></td>
    <td width="7%" align="center"><?php if(is_writable($cur_filename)){echo '<span style="color:green;">√</span>';}else{echo '<span style="color:red">X</span>';}?></td>
    <td>
    <?php
	$allow_edit='txt|inc|pl|cgi|asp|xml|xsl|aspx|cfm htm|html|php|js|css';
	if(preg_match("/\.($allow_edit)/i",$file_list[$i]['filename'])){
	?>
    <a href="fmanage_edit.php?action=edit_file&cpath=<?php echo urlencode(str_replace(WEB_DR,'',$file_list[$i]['path'])); ?>">编辑</a>
    <?php } ?>
    <a href="fmanage_rename.php?type=file&action=rename&cpath=<?php echo str_replace(WEB_DR,'',$file_list[$i]['path']); ?>">改名</a> <a onclick="return confirm('确定要删除文件<?php echo str_replace(WEB_DR,'',$file_list[$i]['path']); ?>？')" href="fmanage_action.php?action=del_file&cpath=<?php echo urlencode(str_replace(WEB_DR,'',$file_list[$i]['path'])); ?>">删除</a></td>
  </tr>    
  <?php } ?>  
    </table>
 </form>
 </body></html>