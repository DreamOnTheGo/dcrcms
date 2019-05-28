<?php
include "../include/common.inc.php";
session_start();
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
    <td style="padding:3px;">
  <?php
  
	$pdir = WEB_DR . '/' . $cpath;
	$real_path = ($pdir);
	if(strlen($real_path) < strlen(WEB_DR))
	{
		show_msg('网站目录在权限范围之外', 2);
	}
	$pdir = pathinfo($pdir);
	$pdir = $pdir['dirname'];
	//echo $pdir;
	//echo substr(WEB_DR,0,strlen(WEB_DR)-1);
	if(WEB_DR == WEB_DR . '/' . $cpath || WEB_DR == $cpath ||  $pdir == substr( WEB_DR, 0, strlen( WEB_DR ) - 1 ) )
	{
		$pdir = '';
	}else{
		$pdir = str_replace(WEB_DR,'',$pdir);
	}
	//文档路径
	$path_arr_t = explode("/", $cpath);
	$path_arr = array();
	array_push($path_arr, '根目录');
	foreach($path_arr_t as $key=> $value)
	{
		if(!empty($value))
		{
			array_push($path_arr, $value);
			unset($path_arr_t[$key]);
		}
	}
	$path_rs_arr = array();
	
	for($i = 0; $i < count($path_arr); $i++)
	{
		if($i == 0)
		{
			$href = '';
		}else{
			$t_arr=array();
			for( $j = 0; $j < $i + 1; $j++ )
			{
				$t_arr[]=$path_arr[$j];
			}
			$t_path = implode('/',$t_arr);
			$href = str_replace('根目录/', '', $t_path);
		}
		$path_rs_arr[] = "<a href='?cpath=$href'>$path_arr[$i]</a>";
	}
	$path_rs = implode('/',$path_rs_arr);
  ?><a href="fmanage.php?cpath=<?php echo $pdir;?>">上级目录</a> 当前目录：<?php echo $path_rs; ?>
  <br />
  <span style="color:red;">功能说明:如果要使用压缩文件功能，请在php.ini中开启php_zip，请不要让文件或目录有中文名，否则无法压缩进文件。解压缩文件的话，只解压到根目录下</span>
  </td></tr>
  </table>
<form action="fmanage_action.php" method="post">
<input type="hidden" name="action" id="action" value="zip">
<input type="hidden" name="cur_path" id="action" value="<?php echo str_replace('根目录/', '', strip_tags($path_rs)); ?>">
<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">  
  <tr>
    <td width="3%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="36%" bgcolor="#FFFFFF">文件名</td>
    <td width="17%" bgcolor="#FFFFFF">文件大小</td>
    <td width="17%" bgcolor="#FFFFFF">最后修改时间</td>
    <td width="7%" bgcolor="#FFFFFF" align="center">可读</td>
    <td width="7%" bgcolor="#FFFFFF" align="center">可写</td>
    <td width="16%" bgcolor="#FFFFFF">操作</td>
  </tr>
  <?php
	if( empty($cpath) )
	{
		$cpath = WEB_DR;
	}else{
		$cpath = WEB_DR . $cpath;
	}
	
	//数据库的列表'
	include_once WEB_CLASS . "/class.dir.php";
	//echo $cpath;
	$cls_dir = new cls_dir( $cpath );
	$dir_list = $cls_dir->get_dir_list();
	$file_list = $cls_dir->get_file_list();
	sort($dir_list);
	sort($file_list);
	//p_r($file_list);
	$dir_num = count($dir_list);
	for( $i = 0; $i < $dir_num; $i ++ ){
		if( preg_match( "/^_(.*)$/i", $dir_list[$i]['filename'] ) ) continue;
		if( preg_match( "/^\.(.*)$/i",$dir_list[$i]['filename'] ) ) continue;
		$dir_list[$i]['filename'] = iconv( 'gbk', $web_code, $dir_list[$i]['filename'] );
		$dir_list[$i]['path'] = iconv( 'gbk', $web_code, $dir_list[$i]['path'] );
	?>    
  <tr bgcolor="#FFFFFF" onMouseMove="javascript:this.style.backgroundColor='#F4F9EB';" onMouseOut="javascript:this.style.backgroundColor='#FFFFFF';">
    <td align="center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo str_replace('根目录/', '', strip_tags($path_rs)) . '/' . $dir_list[$i]['filename']; ?>" /></td>
    <td><a href="fmanage.php?cpath=<?php echo urlencode( str_replace(WEB_DR,'',$dir_list[$i]['path']) ); ?>"><img border="0" src="images/dir.gif" /><?php echo $dir_list[$i]['filename']; ?></a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><a href="fmanage_rename.php?type=dir&action=rename&cpath=<?php echo str_replace(WEB_DR,'',$dir_list[$i]['path']); ?>">改名</a> <a onclick="return confirm('确定要删除目录<?php echo str_replace(WEB_DR,'',$dir_list[$i]['path']); ?>？')" href="fmanage_action.php?action=del_dir&cpath=<?php echo urlencode(str_replace(WEB_DR,'',$dir_list[$i]['path'])); ?>">删除</a></td>
  </tr>  
	<?php
	}
	$file_num = count($file_list);
	for( $i = 0;$i < $file_num; $i ++ )
	{
		@$file_size = filesize( $file_list[$i]['path'] );
		@$file_size = $file_size / 1024;
		if( $file_size < 0.1 )
		{
			@list($ty1, $ty2) = explode(".", $file_size);
			$file_size = $ty1 . "." . substr($ty2, 0, 2);
		}else{
			@list($ty1, $ty2) = explode(".", $file_size);
			$file_size = $ty1 . "." . substr($ty2, 0, 1);
		}
		
		@$file_time = filemtime($file_list[$i]['path']);
		@$file_time = date("Y-m-d H:i:s",$file_time);
		//echo $file_list[$i]['path'] . '<br>';
		$cur_filename = $cpath . '/' . $file_list[$i]['filename'];//文件路径
		$file_list[$i]['filename'] = iconv( 'gbk', $web_code, $file_list[$i]['filename'] );
		$file_list[$i]['path'] = iconv( 'gbk', $web_code, $file_list[$i]['path'] );
  ?>  
  <tr bgcolor="#FFFFFF" onMouseMove="javascript:this.style.backgroundColor='#F4F9EB';" onMouseOut="javascript:this.style.backgroundColor='#FFFFFF';">
    <td align="center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo str_replace('根目录/', '', strip_tags($path_rs)) . '/' .  $file_list[$i]['filename']; ?>" /></td>
    <td><img border="0" src="images/file.gif" /><a href="<?php echo $web_url; ?>/<?php echo str_replace(WEB_DR, '', $file_list[$i]['path']); ?>" target="_blank"><?php echo $file_list[$i]['filename']; ?></a></td>
    <td><?php echo $file_size; ?>K</td>
    <td><?php echo $file_time; ?></td>
    <td width="7%" align="center"><?php if(is_readable($cur_filename)){echo '<span style="color:green;">√</span>';}else{echo '<span style="color:red">X</span>';}?></td>
    <td width="7%" align="center"><?php if(is_writable($cur_filename)){echo '<span style="color:green;">√</span>';}else{echo '<span style="color:red">X</span>';}?></td>
    <td>
    <?php
	$allow_edit = 'txt|inc|pl|cgi|asp|xml|xsl|aspx|cfm|htm|html|php|js|css';
	if( preg_match( "/\.($allow_edit)/i", $file_list[$i]['filename']) )
	{
	?>
    <a href="fmanage_edit.php?action=edit_file&cpath=<?php echo urlencode(str_replace(WEB_DR,'',$file_list[$i]['path'])); ?>">编辑</a>
    <?php }
	if( preg_match( "/\.(zip)/i", $file_list[$i]['filename']) )
	{
	?>
    <a href="fmanage_action.php?action=un_zip&cpath=<?php echo urlencode(str_replace(WEB_DR,'',$file_list[$i]['path'])); ?>">解压缩</a>
    <?php } ?>
    <a href="fmanage_rename.php?type=file&action=rename&cpath=<?php echo str_replace(WEB_DR,'',$file_list[$i]['path']); ?>">改名</a> <a onclick="return confirm('确定要删除文件<?php echo str_replace(WEB_DR,'',$file_list[$i]['path']); ?>？')" href="fmanage_action.php?action=del_file&cpath=<?php echo urlencode(str_replace(WEB_DR,'',$file_list[$i]['path'])); ?>">删除</a></td>
  </tr>    
  <?php } ?>  
  <tr bgcolor="#FFFFFF" onMouseMove="javascript:this.style.backgroundColor='#F4F9EB';" onMouseOut="javascript:this.style.backgroundColor='#FFFFFF';">
    <td colspan="7"><input type="button" name="button" id="button" value="全选/反选" onClick="javascript:selectAllChk('id[]');">
      &nbsp;<input type="submit" name="zip" value="压缩选定的文件" /></td>
    </tr> 
    </table>
 </form>
 </body></html>