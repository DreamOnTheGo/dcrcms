<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
<script src="../include/js/common.js"></script>
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <TR height=28>
    <TD background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;文件管理器</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>文件改名</TD></TR>
  <TR bgColor=#ecf4fc height=12>
<?php
	$filepath=WEB_DR.$cpath;
	
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
    <TD style="padding:3px;">当前目录：<?php echo $pdir; ?></TD></TR>
  </TABLE>
<form action="fmanage_action.php" method="post">
<input type="hidden" name="action" id="action" value="edit_file">
<input type="hidden" name="filepath" id="filepath" value="<?php echo $filepath;?>">
<input type="hidden" name="cpath" id="cpath" value="<?php echo $oldname;?>">
<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <TR>
    <TD bgcolor="#FFFFFF"><textarea name="content" style="width:97%; padding:3px; border:2px solid gray; background-color:#F5F5FA" rows="30" id="content"><?php
    include WEB_CLASS.'f_class.php';
	$f=new FClass($filepath);
	echo $f->getContent('',true);
	?></textarea></TD>
    </TR>
  <TR>
    <TD bgcolor="#FFFFFF"><input type="submit" name="button" id="button" value="修改" />
      <input type="button" name="button2" id="button2" value="返回" onclick="history.back()" /></TD>
    </TR>    
    </TABLE>
 </form>
 </BODY></HTML>