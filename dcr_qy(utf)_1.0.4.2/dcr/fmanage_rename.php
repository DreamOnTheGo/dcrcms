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
    align=middle background=images/title_bg2.jpg>文件改名</td></tr>
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
  	$oldname=$cpath;
	if(!isset($cpath)){
		$cpath=WEB_DR;
	}else{
		$cpath=WEB_DR.$cpath.'/';
	}
	$pinfo=pathinfo($cpath);
	//p_r($pinfo);
  ?>
    <td style="padding:3px;">当前目录：<?php echo $pdir; ?></td></tr>
  </table>
<form action="fmanage_action.php" method="post">
<input type="hidden" name="action" id="action" value="rename">
<input type="hidden" name="dir_name" id="dir_name" value="<?php echo $pdir;?>">
<input type="hidden" name="cpath" id="cpath" value="<?php echo $oldname;?>">
<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <tr>
    <td width="9%" bgcolor="#FFFFFF">原文件名：</td>
    <td width="91%" colspan="3" bgcolor="#FFFFFF"><input name="oldname" type="text" id="oldname" value="<?php echo $pinfo['basename'];?>" size="60" readonly="readonly" /></td>
    </tr>  
  <tr>
    <td bgcolor="#FFFFFF">新文件名：</td>
    <td colspan="3" bgcolor="#FFFFFF"><input name="newname" type="text" id="newname" size="60" value="<?php echo $pinfo['basename']; ?>" /></td>
    </tr>
  <tr>
    <td colspan="4" bgcolor="#FFFFFF"><input type="submit" name="button" id="button" value="修改" />
      <input type="button" name="button2" id="button2" value="返回" onclick="history.back()" /></td>
    </tr>    
    </table>
 </form>
 </body></html>