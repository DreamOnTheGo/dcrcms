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
	if($("#title").val().length==0){
		ShowMsg('�������Ʒ����');
		return false;
	}
	if($("#classid").val().length==0 || $("#classid").val()==0){
		ShowMsg('��ѡ���Ʒ����');
		return false;
	}
}
</script>
<script type="text/javascript">
function AddClass(){
	classname=encodeURI($('#classname').val());
	classdescription=encodeURI($('#classdescription').val());
	actionArr={classname:classname,classdescription:classdescription};
	$.post("product_class_action.php?action=add_ajax",actionArr, function(data){
														if(data!='��Ӳ�Ʒ����ɹ�'){
															alert(data);
														}else if(data=='��Ӳ�Ʒ����ɹ�'){
															closeProductClassForm();
															refreshProductClassList();
															//alert('dfs');
														}
														}); 
}
function refreshProductClassList(){
	//ˢ�²�Ʒ���
	$.post("product_class_action.php?action=getlist_ajax",function(list){
																    var s='<select name="classid" id="classid">';
																	s=s+"<option value='0'>��ѡ���Ʒ���</option>";
																   	for(var i=0;i<list.length;i++){
																		s=s+'<option value='+list[i].id+'>'+decodeURI(list[i].classname)+'</option>'
																   	}
																   	s=s+'</select>';
																   	$('#productClassList').html(s);
																   	},"json");
}
function closeProductClassForm(){
	$('#classname').val("");
	$('#classdescription').val("");
	$('#myframe').css("display","none");
	$('#AddClass').css("display","none");
}
function showProductClassForm(){
	$('#myframe').css("display","block");
	$('#AddClass').css("display","block");
}
function tijiaoAddAction(){
	keyCode=event.keyCode;
	if(keyCode==13){
		AddClass();
		event.keyCode=0;
	}
	return false;
}
</script>
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <TR height=28>
    <TD background=images/title_bg1.jpg>��ǰλ��: <a href="main.php">��̨��ҳ</a>&gt;&gt;��Ӳ�Ʒ</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>��Ӳ�Ʒ</TD></TR>
  <TR bgColor=#ecf4fc height=12>
    <TD></TD></TR>
  </TABLE>
<?php
	include WEB_CLASS."/product_class.php";
	if($action=='add'){
	}else{
		$action='modify';
		$id=isset($id)?(int)$id:0;
		if($id!=0){			
			$pro=new Product(0);
			$productinfo=$pro->GetInfo($id,$productColList);
		}else{
			$errormsg[]='��û��ѡ��Ҫ�޸ĵ��ĵ�';
			ShowMsg($errormsg,2,$back);
		}
	}
?>
<form action="product_action.php" method="post" enctype="multipart/form-data" id="frmAddProduct" name="frmAddProduct" onsubmit="return check();">
<input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
<input type="hidden" name="id" id="id" value="<?php echo $productinfo['id']; ?>">
<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <TR>
    <TD width=100 align=right bgcolor="#FFFFFF">��Ʒ����(<font color="red" class="txtRed">*</font>)��</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input name="title" type="text" id="title" size="80" value="<?php echo $productinfo['title']; ?>"></TD></TR>
  <TR>
    <TD align=right valign="top" bgcolor="#FFFFFF">��Ʒ���(<font color="red" class="txtRed">*</font>)��</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><span id="productClassList"> <?php 
		$pro=new Product(0);
		$productClassList=$pro->GetClassList(array('id','classname'));
		if(count($productClassList)>0){
			echo '<select name="classid" id="classid">';
			echo "<option value='0'>��ѡ���Ʒ���</option>";
			foreach($productClassList as $value){
				echo "<option value='$value[id]'>$value[classname]</option>";
			}
			echo '</select>';
		}else{
			echo "��ǰû�з���";
		}
	?>
    <script type="text/javascript">
	  var classid="<?php echo $productinfo['classid'];?>";
	  if(classid!=''){
		  document.frmAddProduct.classid.value=classid;
	  }
	  </script>
    </span>&nbsp;&nbsp;&nbsp;<a href="#" onclick="javascript:showProductClassForm()">��Ӳ�Ʒ���</a>  <!--<a href="javascript:refreshProductClassList();">�ֶ�ˢ���б�</a>-->
      <iframe id="myframe" style=" display:none;position:absolute;z-index:9;width:expression(this.nextSibling.offsetWidth);height:expression(this.nextSibling.offsetHeight);top:expression(this.nextSibling.offsetTop);left:expression(this.nextSibling.offsetLeft);" frameborder="0" ></iframe>
    <div id="AddClass" style="display:none;position:absolute;top:100px; border:5px #999 solid; padding:10px; height:100px; width:650px; left:100px; background-color:#ecf4fc; z-index:11">
<TABLE cellSpacing=0 cellPadding=2 width="95%" align=center border=0>
  <TR>
    <TD align=right width=100>������(<font color="red" class="txtRed">*</font>)��</TD>
    <TD style="COLOR: #880000"><input name="classname" type="text" id="classname" size="80" onkeypress="tijiaoAddAction();"></TD></TR>
  <TR>
    <TD align=right valign="top">����˵����</TD>
    <TD style="COLOR: #880000"><textarea name="classdescription" cols="80" rows="3" id="classdescription"></textarea></TD>
  </TR>
  <TR>
    <TD align=right></TD>
    <TD style="COLOR: #880000"><input type="button" onClick="AddClass()" name="button" id="button" value="��ӷ���">
    <input type="reset" name="button2" id="button2" value="����">  <input type="button" value="�ر�" onClick="javascript:closeProductClassForm()"></TD></TR>
    </TABLE>
</div>
    </TD>
  </TR>
  <TR>
    <TD align=right valign="top" bgcolor="#FFFFFF">��Ʒ����ͼ��</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><table width="100" border="0" cellspacing="1" cellpadding="3" bgcolor="#33CCFF">
      <tr>
        <td><span style="color:white">��ǰ����ͼ</span></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF"><?php if(strlen($productinfo['logo'])>0){echo "<img src='".$productinfo['logo']."'>";}?></td>
      </tr>
    </table>    
      <input type="file" name="logo" id="logo"></TD>
  </TR>
  <TR>
    <TD align=right valign="top" bgcolor="#FFFFFF">��Ʒ�ؼ��֣�</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input name="keywords" type="text" id="keywords" size="80" value="<?php echo $productinfo['keywords']; ?>">
      (SEO����Ʒ�ؼ���)</TD>
  </TR>
  <TR>
    <TD align=right valign="top" bgcolor="#FFFFFF">��Ʒ������</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><textarea name="description" cols="80" rows="3" id="description"><?php echo $productinfo['description']; ?></textarea>
      (SEO����Ʒ������)</TD>
  </TR>
  <TR>
    <TD align=right valign="top" bgcolor="#FFFFFF">��Ʒ��ϸ���ܣ�</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><?php
include(WEB_INCLUDE."/editor/fckeditor.php");
$editor = new FCKeditor('content') ;
$editor->BasePath = '../include/editor/';
$editor->ToolbarSet='Default'; //���߰�ť����
$editor->Width = '100%' ; 
$editor->Height = '200' ; 
$editor->Value =$productinfo['content'];
$editor->Create() ;
?></TD></TR>
  <TR>
    <TD align=right bgcolor="#FFFFFF">��Ʒ���ԣ�</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input name="istop" type="checkbox" <?php if($productinfo['istop']){echo 'checked="checked"';} ?> id="istop" value="1" />
�ö�</TD>
  </TR>
  <TR>
    <TD align=right bgcolor="#FFFFFF"></TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input type="submit" name="button" id="button" value="<?php if($action=='add'){echo '���';}else{echo '�޸�';} ?>��Ʒ">
    <input type="reset" name="button2" id="button2" value="����"></TD></TR>
    </TABLE>
</form>
 </BODY></HTML>