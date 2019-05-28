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
	if($("#itemname").val().length==0){
		ShowMsg('请输入表单提示文字');
		return false;
	}
	if($("#fieldname").val().length==0){
		ShowMsg('请输入字段名称');
		return false;
	}
	if($("#maxlength").val().length==0){
		ShowMsg('字段的最大长度请输入，如果不确定就用默认的255');
		return false;
	}
}
</script>
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <TR height=28>
    <TD background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;信息字段管理</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg><span style="float:right;"><a href="#">添加字段</a></span>信息字段管理</TD></TR>
  <TR bgColor=#ecf4fc height=12>
    <TD></TD></TR>
</TABLE>
<?php
	include WEB_CLASS."/hudong_class.php";
	$hd=new HuDong();
	if($action=='add'){
		$hdFieldInfo['maxlength']=250;
		$hdFieldInfo['dtype']='text';
	}else{
		$action='modify';
		$id=isset($id)?(int)$id:0;
		if($id!=0){
			$hdFieldInfo=$hd->GetFieldInfo($id);
		}else{
			$errormsg[]='您没有选择要修改的文档';
			ShowMsg($errormsg,2,$back);
		}
	}
?>
<form action="hudong_field_action.php" method="post" onsubmit="return check();">
<input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
<?php if($action=='modify'){ ?>
<input type="hidden" name="fieldname" id="fieldname" value="<?php echo $hdFieldInfo['fieldname']; ?>">
<?php }?>
<input type="hidden" name="id" id="id" value="<?php echo $hdFieldInfo['id']; ?>">
<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">  
  <tr>
    <td width="25%" bgcolor="#FFFFFF" style="text-align: left"><strong>表单提示文字(<font color="red" class="txtRed">*</font>)：</strong><br />
      发布内容时显示的提示文字</td>
    <td bgcolor="#FFFFFF" style="text-align: left"><input name="itemname" type="text" id="itemname" size="50" value="<?php echo $hdFieldInfo['itemname']; ?>" /></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" style="text-align: left"><strong>字段名称(<font color="red" class="txtRed">*</font>)：</strong><br />
      只能用英文字母或数字，数据表的真实字段名</td>
    <td bgcolor="#FFFFFF" style="text-align: left"><?php if($action=='modify'){ echo $hdFieldInfo['fieldname'];}else{ ?><input name="fieldname" type="text" id="fieldname" size="50" /><?php } ?></td>
  </tr>
  <TR>
    <TD bgcolor="#FFFFFF" style="text-align: left"><strong>字段类型：</strong></TD>
    <TD bgcolor="#FFFFFF" style="text-align: left">
      <input id="dtype" value="text" type="radio" checked="checked" name="dtype"/>
      单行文本
      
        <input id="dtype" value="multitext" type="radio" name="dtype"/>
        多行文本
      
        
        <input id="dtype" value="select" type="radio" name="dtype"/>
        使用option下拉框
      
        <input id="dtype" value="radio" type="radio" name="dtype"/>
        使用radio选项卡
      
        <input id="dtype" value="checkbox" type="radio" name="dtype"/>
        Checkbox多选框
		<script language="javascript" type="text/javascript">
		 $.each($("input[name='dtype']"),function(){
                if($(this).val() =="<?php echo $hdFieldInfo['dtype']; ?>")
                {
                    $(this).attr("checked","checked");
                }
            });
        </script></TD>
  </TR>
  <TR>
    <TD bgcolor="#FFFFFF" style="text-align: left"><strong>默认值：</strong><br />
      如果定义数据类型为select、radio、checkbox时，此处填写被选择的项目(用&ldquo;,&rdquo;分开，如&ldquo;男,女,人妖&rdquo;)。 </TD>
    <TD bgcolor="#FFFFFF" style="text-align: left"><textarea name="vdefault" cols="100" rows="5" id="vdefault" type="text"><?php echo $hdFieldInfo['vdefault']; ?></textarea></TD>
  </TR>
  <TR>
    <TD bgcolor="#FFFFFF" style="text-align: left"><strong>最大长度：</strong><br />
      文本数据必须填写，允许的最大值为30000，本数值对多行文本无效</TD>
    <TD bgcolor="#FFFFFF" style="text-align: left"><input name="maxlength" id="maxlength" value="<?php echo $hdFieldInfo['maxlength']; ?>" size="10" /></TD>
  </TR>    
  <?php //} ?>
  <TR>
    <TD colspan="2" bgcolor="#FFFFFF" align="center"><input type="submit" name="button" id="button" value="确定">
      &nbsp; <input type="reset" name="button2" id="button2" value="重置"></TD>
    </TR>  
    </TABLE>
 </form>
</BODY></HTML>