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
		ShowMsg('���������ʾ����');
		return false;
	}
	if($("#fieldname").val().length==0){
		ShowMsg('�������ֶ�����');
		return false;
	}
	if($("#maxlength").val().length==0){
		ShowMsg('�ֶε���󳤶������룬�����ȷ������Ĭ�ϵ�255');
		return false;
	}
}
</script>
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <TR height=28>
    <TD background=images/title_bg1.jpg>��ǰλ��: <a href="main.php">��̨��ҳ</a>&gt;&gt;��Ϣ�ֶι���</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg><span style="float:right;"><a href="#">����ֶ�</a></span>��Ϣ�ֶι���</TD></TR>
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
			$errormsg[]='��û��ѡ��Ҫ�޸ĵ��ĵ�';
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
    <td width="25%" bgcolor="#FFFFFF" style="text-align: left"><strong>����ʾ����(<font color="red" class="txtRed">*</font>)��</strong><br />
      ��������ʱ��ʾ����ʾ����</td>
    <td bgcolor="#FFFFFF" style="text-align: left"><input name="itemname" type="text" id="itemname" size="50" value="<?php echo $hdFieldInfo['itemname']; ?>" /></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" style="text-align: left"><strong>�ֶ�����(<font color="red" class="txtRed">*</font>)��</strong><br />
      ֻ����Ӣ����ĸ�����֣����ݱ����ʵ�ֶ���</td>
    <td bgcolor="#FFFFFF" style="text-align: left"><?php if($action=='modify'){ echo $hdFieldInfo['fieldname'];}else{ ?><input name="fieldname" type="text" id="fieldname" size="50" /><?php } ?></td>
  </tr>
  <TR>
    <TD bgcolor="#FFFFFF" style="text-align: left"><strong>�ֶ����ͣ�</strong></TD>
    <TD bgcolor="#FFFFFF" style="text-align: left">
      <input id="dtype" value="text" type="radio" checked="checked" name="dtype"/>
      �����ı�
      
        <input id="dtype" value="multitext" type="radio" name="dtype"/>
        �����ı�
      
        
        <input id="dtype" value="select" type="radio" name="dtype"/>
        ʹ��option������
      
        <input id="dtype" value="radio" type="radio" name="dtype"/>
        ʹ��radioѡ�
      
        <input id="dtype" value="checkbox" type="radio" name="dtype"/>
        Checkbox��ѡ��
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
    <TD bgcolor="#FFFFFF" style="text-align: left"><strong>Ĭ��ֵ��</strong><br />
      ���������������Ϊselect��radio��checkboxʱ���˴���д��ѡ�����Ŀ(��&ldquo;,&rdquo;�ֿ�����&ldquo;��,Ů,����&rdquo;)�� </TD>
    <TD bgcolor="#FFFFFF" style="text-align: left"><textarea name="vdefault" cols="100" rows="5" id="vdefault" type="text"><?php echo $hdFieldInfo['vdefault']; ?></textarea></TD>
  </TR>
  <TR>
    <TD bgcolor="#FFFFFF" style="text-align: left"><strong>��󳤶ȣ�</strong><br />
      �ı����ݱ�����д����������ֵΪ30000������ֵ�Զ����ı���Ч</TD>
    <TD bgcolor="#FFFFFF" style="text-align: left"><input name="maxlength" id="maxlength" value="<?php echo $hdFieldInfo['maxlength']; ?>" size="10" /></TD>
  </TR>    
  <?php //} ?>
  <TR>
    <TD colspan="2" bgcolor="#FFFFFF" align="center"><input type="submit" name="button" id="button" value="ȷ��">
      &nbsp; <input type="reset" name="button2" id="button2" value="����"></TD>
    </TR>  
    </TABLE>
 </form>
</BODY></HTML>