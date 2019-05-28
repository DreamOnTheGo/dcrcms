<?php
include "../include/common.inc.php";
session_start();
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
<style>
#ln{
	position:absolute;
	z-index:1;
	padding:0px;
	margin:0px;
	border:0px;
	background:#ecf0f5;
	width:23px;
	text-align:left;
}
#txt_ln {
	font-family:Arial, Helvetica, sans-serif;
	background:#ecf0f5;
	height:160px;
	overflow:hidden;
	width:43px;
	border-right:0;
	line-height:20px;
	margin:0px;
	padding:0px;
	padding-left:2px;
	padding-right:2px;
	text-align:center;
	overflow:hidden;height:550px;border-right:none;text-align:right
}
#txt_main{
	font-family:Arial, Helvetica, sans-serif;
	margin:0px;
	width:90%;
	padding:0 0 0 48px;
	overflow-x: hidden;
	line-height:20px;
	height:550px;
}
</style>
<script src="../include/js/common.js"></script>
<script>
function show_ln(){ 
 var txt_ln  = document.getElementById('txt_ln'); 
 var txt_main  = document.getElementById('txt_main'); 
 txt_ln.scrollTop = txt_main.scrollTop; 
 while(txt_ln.scrollTop != txt_main.scrollTop) { 
  txt_ln.value += (i++) + '\n'; 
  txt_ln.scrollTop = txt_main.scrollTop; 
 } 
 return; 
} 

function editTab(){ 
 var code, sel, tmp, r 
 var tabs='' 
 event.returnValue = false 
 sel =event.srcElement.document.selection.createRange() 
 r = event.srcElement.createTextRange() 

 switch (event.keyCode){ 
  case (8) : 
   if (!(sel.getClientRects().length > 1)){ 
    event.returnValue = true 
    return 
   } 
   code = sel.text 
   tmp = sel.duplicate() 
   tmp.moveToPoint(r.getBoundingClientRect().left, sel.getClientRects()[0].top) 
   sel.setEndPoint('startToStart', tmp) 
   sel.text = sel.text.replace(/^\t/gm, '') 
   code = code.replace(/^\t/gm, '').replace(/\r\n/g, '\r') 
   r.findText(code) 
   r.select() 
   break 
  case (9) : 
   if (sel.getClientRects().length > 1){ 
    code = sel.text 
    tmp = sel.duplicate() 
    tmp.moveToPoint(r.getBoundingClientRect().left, sel.getClientRects()[0].top) 
    sel.setEndPoint('startToStart', tmp) 
    sel.text = '\t'+sel.text.replace(/\r\n/g, '\r\t') 
    code = code.replace(/\r\n/g, '\r\t') 
    r.findText(code) 
    r.select() 
   }else{ 
    sel.text = '\t' 
    sel.select() 
   } 
   break 
  case (13) : 
   tmp = sel.duplicate() 
   tmp.moveToPoint(r.getBoundingClientRect().left, sel.getClientRects()[0].top) 
   tmp.setEndPoint('endToEnd', sel) 

   for (var i=0; tmp.text.match(/^[\t]+/g) && i<tmp.text.match(/^[\t]+/g)[0].length; i++) tabs += '\t' 
   sel.text = '\r\n'+tabs 
   sel.select() 
   break 
  default  : 
   event.returnValue = true 
   break 
 } 
} 
</script> 
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <TR height=28>
    <TD background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>>><a href="fmanage.php">文件管理器</a>>>文件编辑</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>文件编辑</TD></TR>
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
	//文档路径
	$path_arr = explode("/",$oldname);
	$path_rs_arr=array();
	for($i=0;$i<count($path_arr)-1;$i++)
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
		$path_rs_arr[]="<a href='fmanage.php?cpath=$href'>$path_arr[$i]</a>";
	}
	$path_rs=implode('/',$path_rs_arr);
  ?>
    <TD style="padding:3px;">当前目录：<?php echo $path_rs; ?></TD></TR>
  </TABLE>
<form action="fmanage_action.php" method="post">
<input type="hidden" name="action" id="action" value="edit_file">
<input type="hidden" name="filepath" id="filepath" value="<?php echo $filepath;?>">
<input type="hidden" name="cpath" id="cpath" value="<?php echo $oldname;?>">
<input type="hidden" name="modi" id="modi" value="false">
<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <TR>
    <TD bgcolor="#FFFFFF"><div id="ln"><textarea id='txt_ln' name='content' rows='10' cols='4' readonly></textarea></div>
    <textarea id='txt_main' name='content' rows='10' cols='70 'onkeydown='editTab()' onChange="document.getElementById('modi').value='ture'" onscroll='show_ln()' wrap='off'><?php
    require_once(WEB_CLASS . '/class.file.php');
	$cls_file = new cls_file($filepath);
	echo $cls_file->read(true);
	?></textarea>
               <script>for(var i=1; i<=50; i++) document.getElementById('txt_ln').value += i + '\n';</script> </TD>
    </TR>
  <TR>
    <TD bgcolor="#FFFFFF"><input type="submit" name="button" id="button" value="修改" />
      <input type="button" name="button2" id="button2" value="返回" onclick="history.back()" /></TD>
    </TR>    
    </TABLE>
 </form>
 </BODY></HTML>