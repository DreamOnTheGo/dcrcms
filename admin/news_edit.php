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
		ShowMsg('请输入新闻标题');
		return false;
	}
	if($("#classid").val().length==0 || $("#classid").val()==0){
		ShowMsg('请选择新闻类型');
		return false;
	}
	if(getFckeditorText("content").length==0){
		ShowMsg('请输入新闻内容');
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
														if(data!='添加新闻分类成功'){
															alert(data);
														}else if(data=='添加新闻分类成功'){
															closeClassForm();
															refreshClassList();
															//alert('dfs');
														}
														}); 
}
function refreshClassList(){
	//刷新产品类别
	$.post("news_class_action.php?action=getlist_ajax",function(list){
																    var s='<select name="classid" id="classid">';
																	s=s+"<option value='0'>请选择新闻类别</option>";
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
    <TD background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;添加新闻</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>添加新闻</TD></TR>
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
			ShowMsg('您没有选择要修改的文档');
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
    <TD width=100 align=right bgcolor="#FFFFFF">新闻标题(<font color="red" class="txtRed">*</font>)：</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input name="title" type="text" id="title" size="80" value="<?php echo $newsinfo['title']; ?>"></TD></TR>
    <?php if(!$issystem){ ?>
  <tr>
    <td align="right" valign="top" bgcolor="#FFFFFF">产品类别(<font color="red" class="txtRed">*</font>)：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><span id="productClassList">
      <?php 
		$newsClassList=$news->GetClassList(array('id','classname'));
		if(count($newsClassList)>0){
			echo '<select name="classid" id="classid">';
			echo "<option value='0'>请选择新闻类别</option>";
			foreach($newsClassList as $value){
				echo "<option value='$value[id]'>$value[classname]</option>";
			}
			echo '</select>';
		}else{
			echo "当前没有分类";
		}
	?>
      <script type="text/javascript">
	  var classid="<?php echo $newsinfo['classid'];?>";
	  if(classid!=''){
		  document.frmAddNews.classid.value=classid;
	  }
	  </script>
      </span>&nbsp;&nbsp;&nbsp;<a href="#" onclick="javascript:showClassForm()">添加新闻类别</a>
      <!--<a href="javascript:refreshClassList();">手动刷新列表</a>-->
      <div id="AddClass" style="display:none;position:absolute;top:100px; border:5px #999 solid; padding:10px; height:100px; width:650px; left:100px; background-color:#ecf4fc">
      <div onsubmit="">
        <table cellspacing="0" cellpadding="2" width="95%" align="center" border="0">
          <tr>
            <td align="right" width="100">分类名(<font color="red" class="txtRed">*</font>)：</td>
            <td style="COLOR: #880000"><input name="classname" type="text" id="classname" size="80" onkeypress="tijiaoAddAction();" /></td>
          </tr>
          <tr>
            <td align="right" valign="top">分类说明：</td>
            <td style="COLOR: #880000"><textarea name="classdescription" cols="80" rows="3" id="classdescription"></textarea></td>
          </tr>
          <tr>
            <td align="right"></td>
            <td style="COLOR: #880000"><input type="button" onclick="AddClass()" name="button3" id="button3" value="添加分类" />
              <input type="reset" name="button3" id="button4" value="重置" />
              <input type="button" value="关闭" onclick="javascript:closeClassForm()" /></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <TR>
    <TD align=right bgcolor="#FFFFFF">新闻作者：</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input name="author" type="text" id="author" size="50" value="<?php echo $newsinfo['author']; ?>"></TD></TR>
  <TR>
    <TD align=right bgcolor="#FFFFFF">新闻来源：</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input name="source" type="text" id="source" size="50" value="<?php echo $newsinfo['source']; ?>"></TD></TR>
  <TR>
    <TD align=right valign="top" bgcolor="#FFFFFF">新闻关键字：</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input name="keywords" type="text" id="keywords" size="80" value="<?php echo $newsinfo['keywords']; ?>">
      (SEO：新闻关键字，以,分隔)</TD>
  </TR>
  <TR>
    <TD align=right valign="top" bgcolor="#FFFFFF">新闻描述：</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><textarea name="description" cols="80" rows="3" id="description"><?php echo $newsinfo['description']; ?></textarea>
      (SEO：新闻的描述)</TD>
  </TR>
  <?php }?>
  <TR>
    <TD align=right valign="top" bgcolor="#FFFFFF">新闻内容(<font color="red">*</font>)：</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><?php
include(WEB_INCLUDE."/editor/fckeditor.php");
$editor = new FCKeditor('content') ;
$editor->BasePath = '../include/editor/';
$editor->ToolbarSet='Default'; //工具按钮设置
$editor->Width = '100%' ; 
$editor->Height = '500' ; 
$editor->Value =$newsinfo['content'];
$editor->Create() ;
?></TD></TR>
  <TR>
    <TD align=right bgcolor="#FFFFFF"></TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input type="submit" name="button" id="button" value="<?php if($action=='add'){echo '添加';}else{echo '修改';} ?>新闻">
    <input type="reset" name="button2" id="button2" value="重置"></TD></TR>
    </TABLE>
 </form>
 </BODY></HTML>