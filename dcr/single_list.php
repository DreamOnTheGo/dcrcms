<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
<script src="../include/js/common.js"></script>
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <TR height=28>
    <TD background=images/title_bg1.jpg>��ǰλ��: <a href="main.php">��̨��ҳ</a>&gt;&gt;�����б�</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>�����б�</TD></TR>
  <TR bgColor=#ecf4fc height=12>
    <TD></TD></TR>
  </TABLE>
<form action="single_action.php" method="post">
<input type="hidden" name="action" id="action" value="delsingle">
<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <TR>
    <TD style="text-align: center" width=56>ID</TD>
    <TD width="534" style="text-align: center">����</TD>
    <TD width="183" style="text-align: center">����ʱ��</TD>
    <TD width="132" style="text-align: center">����</TD>
  </TR>
  <?php
	include WEB_CLASS."/single_class.php";
	$pageListNum=20;//ÿҳ��ʾ?��
	$totalPage=0;//��ҳ��
	$page=isset($page)?(int)$page:1;
	$start=($page-1)*$pageListNum;
	$single=new Single(0);
	$singleList=$single->GetList(array('id','title','updatetime'),$start,$pageListNum);
	foreach($singleList as $value){
		$id=$value['id'];
  ?>  
  <TR>
    <TD bgcolor="#FFFFFF" style="text-align: center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $id; ?>"><?php echo $id; ?></TD>
    <TD bgcolor="#FFFFFF" style="text-align: left"><a href="single_edit.php?action=modify&id=<?php echo $id; ?>"><?php echo $value['title']; ?></a></TD>
    <TD bgcolor="#FFFFFF" style="text-align: center"><?php echo $value['updatetime']; ?></TD>
    <TD bgcolor="#FFFFFF" style="text-align: center"><a href="single_edit.php?action=modify&id=<?php echo $id; ?>">�༭</a></TD>
  </TR>    
  <?php } ?>  
  <TR>
    <TD colspan="5" bgcolor="#FFFFFF" align="right">
    <?php
	require_once(WEB_CLASS.'/page_class.php');
	$sqlNum="select id from {tablepre}single";
	$db->Execute($sqlNum);
	$pageNum=$db->GetRsNum();
	$totalPage=ceil($pageNum/$pageListNum);//��ҳ��
			
	$page=new PageClass($page,$totalPage);
	$showpage=$page->showPage(); 
	echo $showpage;
	?>
    </TD>
    </TR>  
  <TR>
    <TD colspan="5" bgcolor="#FFFFFF"><input type="button" name="button" id="button" value="ȫѡ/��ѡ" onClick="javascript:selectAllChk('id[]');">
      &nbsp; <input type="submit" name="button2" id="button2" value="ɾ��"></TD>
    </TR>  
    </TABLE>
 </form>
 </BODY></HTML>