<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
<?php include "admin_common.php"; ?>
<script type='text/javascript'>
function check(){
	if($("#classname").val().length==0){
		ShowMsg('���������ŷ�����');
		return false;
	}
}
</script>
</HEAD>
<BODY>
<div class="boxy"></div>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <TR height=28>
    <TD background=images/title_bg1.jpg>��ǰλ��: <a href="main.php">��̨��ҳ</a>&gt;&gt;�������ŷ���</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>�������ŷ���</TD></TR>
  <TR bgColor=#ecf4fc height=12>
    <TD></TD></TR>
  </TABLE>
<?php
	if($action=='add'){
	}else{
		$action='modify';
		$id=isset($id)?(int)$id:0;
		if($id!=0){			
			include WEB_CLASS."/news_class.php";
			$news=new News();
			$newsClassInfo=$news->GetClassInfo($id);
		}else{
			ShowMsg('��û��ѡ��Ҫ�޸ĵ��ĵ�');
		}
	}
?>
<form action="news_class_action.php" method="post" onsubmit="return check();">
<input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
<input type="hidden" name="id" id="id" value="<?php echo $newsClassInfo['id']; ?>">
<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <TR>
    <TD width=100 align=right bgcolor="#FFFFFF">������(<font color="red" class="txtRed">*</font>)��</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input name="classname" type="text" id="classname" size="80" value="<?php echo $newsClassInfo['classname']; ?>"></TD></TR>
  <TR>
    <TD align=right valign="top" bgcolor="#FFFFFF">����˵����</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><textarea name="classdescription" cols="80" rows="3" id="classdescription"><?php echo $newsClassInfo['classdescription']; ?></textarea></TD>
  </TR>
  <TR>
    <TD align=right bgcolor="#FFFFFF"></TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input type="submit" name="button" id="button" value="<?php if($action=='add'){echo '����';}else{echo '�޸�';} ?>����">
    <input type="reset" name="button2" id="button2" value="����"></TD></TR>
    </TABLE>
 </form>
 </BODY></HTML>