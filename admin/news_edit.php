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
		ShowMsg('���������ű���');
		return false;
	}
	if($("#classid").val().length==0 || $("#classid").val()==0){
		ShowMsg('��ѡ����������');
		return false;
	}
	if(getFckeditorText("content").length==0){
		ShowMsg('��������������');
		return false;
	}
}
</script>
<script type="text/javascript">
function AddClass(){
	classname=encodeURI($('#classname').val());
	classdescription=encodeURI($('#classdescription').val());
	actionArr={classname:classname,classdescription:classdescription};
	$.post("news_class_action.php?action=add_ajax",actionArr, function(data){
														if(data!='������ŷ���ɹ�'){
															alert(data);
														}else if(data=='������ŷ���ɹ�'){
															closeClassForm();
															refreshClassList();
															//alert('dfs');
														}
														}); 
}
function refreshClassList(){
	//ˢ�²�Ʒ���
	$.post("news_class_action.php?action=getlist_ajax",function(list){
																    var s='<select name="classid" id="classid">';
																	s=s+"<option value='0'>��ѡ���������</option>";
																   	for(var i=0;i<list.length;i++){
																		s=s+'<option value='+list[i].id+'>'+decodeURI(list[i].classname)+'</option>'
																   	}
																   	s=s+'</select>';
																   	$('#productClassList').html(s);
																   	},"json");
}
function closeClassForm(){
	$('#classname').val("");
	$('#classdescription').val("");
	$('#AddClass').css("display","none");
}
function showClassForm(){
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
    <TD background=images/title_bg1.jpg>��ǰλ��: <a href="main.php">��̨��ҳ</a>&gt;&gt;�������</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>�������</TD></TR>
  <TR bgColor=#ecf4fc height=12>
    <TD></TD></TR>
  </TABLE>
<?php
	include WEB_CLASS."/news_class.php";
	$news=new News();
	if($action=='add'){
	}else{
		$action='modify';
		$id=isset($id)?(int)$id:0;
		if($id!=0){
			$news=new News();
			$newsinfo=$news->GetInfo($id,$newsColList);
		}else{
			ShowMsg('��û��ѡ��Ҫ�޸ĵ��ĵ�');
		}
	}
	if(!isset($issystem)){
		$issystem=0;
	}
?>
<form action="news_action.php" method="post" id="frmAddNews" name="frmAddNews" onsubmit="return check();">
<input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
<input type="hidden" name="id" id="id" value="<?php echo $newsinfo['id']; ?>">
<input type="hidden" name="issystem" id="issystem" value="<?php echo $issystem; ?>">
<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">  
  <TR>
    <TD width=100 align=right bgcolor="#FFFFFF">���ű���(<font color="red" class="txtRed">*</font>)��</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input name="title" type="text" id="title" size="80" value="<?php echo $newsinfo['title']; ?>"></TD></TR>
    <?php if(!$issystem){ ?>
  <tr>
    <td align="right" valign="top" bgcolor="#FFFFFF">��Ʒ���(<font color="red" class="txtRed">*</font>)��</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><span id="productClassList">
      <?php 
		$newsClassList=$news->GetClassList(array('id','classname'));
		if(count($newsClassList)>0){
			echo '<select name="classid" id="classid">';
			echo "<option value='0'>��ѡ���������</option>";
			foreach($newsClassList as $value){
				echo "<option value='$value[id]'>$value[classname]</option>";
			}
			echo '</select>';
		}else{
			echo "��ǰû�з���";
		}
	?>
      <script type="text/javascript">
	  var classid="<?php echo $newsinfo['classid'];?>";
	  if(classid!=''){
		  document.frmAddNews.classid.value=classid;
	  }
	  </script>
      </span>&nbsp;&nbsp;&nbsp;<a href="#" onclick="javascript:showClassForm()">����������</a>
      <!--<a href="javascript:refreshClassList();">�ֶ�ˢ���б�</a>-->
      <div id="AddClass" style="display:none;position:absolute;top:100px; border:5px #999 solid; padding:10px; height:100px; width:650px; left:100px; background-color:#ecf4fc">
      <div onsubmit="">
        <table cellspacing="0" cellpadding="2" width="95%" align="center" border="0">
          <tr>
            <td align="right" width="100">������(<font color="red" class="txtRed">*</font>)��</td>
            <td style="COLOR: #880000"><input name="classname" type="text" id="classname" size="80" onkeypress="tijiaoAddAction();" /></td>
          </tr>
          <tr>
            <td align="right" valign="top">����˵����</td>
            <td style="COLOR: #880000"><textarea name="classdescription" cols="80" rows="3" id="classdescription"></textarea></td>
          </tr>
          <tr>
            <td align="right"></td>
            <td style="COLOR: #880000"><input type="button" onclick="AddClass()" name="button3" id="button3" value="��ӷ���" />
              <input type="reset" name="button3" id="button4" value="����" />
              <input type="button" value="�ر�" onclick="javascript:closeClassForm()" /></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <TR>
    <TD align=right bgcolor="#FFFFFF">�������ߣ�</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input name="author" type="text" id="author" size="50" value="<?php echo $newsinfo['author']; ?>"></TD></TR>
  <TR>
    <TD align=right bgcolor="#FFFFFF">������Դ��</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input name="source" type="text" id="source" size="50" value="<?php echo $newsinfo['source']; ?>"></TD></TR>
  <TR>
    <TD align=right valign="top" bgcolor="#FFFFFF">���Źؼ��֣�</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input name="keywords" type="text" id="keywords" size="80" value="<?php echo $newsinfo['keywords']; ?>">
      (SEO�����Źؼ��֣���,�ָ�)</TD>
  </TR>
  <TR>
    <TD align=right valign="top" bgcolor="#FFFFFF">����������</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><textarea name="description" cols="80" rows="3" id="description"><?php echo $newsinfo['description']; ?></textarea>
      (SEO�����ŵ�����)</TD>
  </TR>
  <?php }?>
  <TR>
    <TD align=right valign="top" bgcolor="#FFFFFF">��������(<font color="red">*</font>)��</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><?php
include(WEB_INCLUDE."/editor/fckeditor.php");
$editor = new FCKeditor('content') ;
$editor->BasePath = '../include/editor/';
$editor->ToolbarSet='Default'; //���߰�ť����
$editor->Width = '100%' ; 
$editor->Height = '500' ; 
$editor->Value =$newsinfo['content'];
$editor->Create() ;
?></TD></TR>
  <TR>
    <TD align=right bgcolor="#FFFFFF"></TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input type="submit" name="button" id="button" value="<?php if($action=='add'){echo '���';}else{echo '�޸�';} ?>����">
    <input type="reset" name="button2" id="button2" value="����"></TD></TR>
    </TABLE>
 </form>
 </BODY></HTML>