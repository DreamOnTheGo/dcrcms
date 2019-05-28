<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="css/admin.css" type="text/css" rel="stylesheet">
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
	$('#myframe').css("display","none");
	$('#AddClass').css("display","none");
}
function showClassForm(){
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
</head>
<body>
<table cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <tr height=28>
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;添加新闻</td></tr>
  <tr>
    <td bgColor=#b1ceef height=1></td></tr></table>
<table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <tr height=20>
    <td></td></tr>
  <tr height=22>
    <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>添加新闻</td></tr>
  <tr bgColor=#ecf4fc height=12>
    <td></td></tr>
  </table>
<?php
	include WEB_CLASS."/news_class.php";
	$news=new News();
	if($action=='add'){
		$newsinfo['click']=0;
		$newsinfo['author']='admin';
		$newsinfo['source']='本站';
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
<form action="news_action.php" method="post" enctype="multipart/form-data" name="frmAddNews" id="frmAddNews" onsubmit="return check();">
<input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
<input type="hidden" name="id" id="id" value="<?php echo $newsinfo['id']; ?>">
<input type="hidden" name="issystem" id="issystem" value="<?php echo $issystem; ?>">
<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">  
  <tr>
    <td width=100 align=right bgcolor="#FFFFFF">新闻标题(<font color="red" class="txtRed">*</font>)：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input name="title" type="text" id="title" size="80" value="<?php echo $newsinfo['title']; ?>"></td></tr>
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
      <iframe id="myframe" style="display:none;position:absolute;z-index:9;width:expression(this.nextSibling.offsetWidth);height:expression(this.nextSibling.offsetHeight);top:expression(this.nextSibling.offsetTop);left:expression(this.nextSibling.offsetLeft);" frameborder="0" ></iframe>
      <div id="AddClass" style="display:none;position:absolute;top:100px; border:5px #999 solid; padding:10px; height:100px; width:650px; left:100px; background-color:#ecf4fc; z-index:10000;">
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
  <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">缩略图：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000">
	<table border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td>
        <table width="100" border="0" cellspacing="1" cellpadding="3" bgcolor="#33CCFF">
      <tr>
        <td><span style="color:white">当前缩略图</span></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF"><?php if(strlen($newsinfo['logo'])>0){echo "<img src='".$newsinfo['logo']."'>";}?></td>
      </tr>
    </table>
          <input type="file" size="40" name="logo" id="logo"> 
          (默认大小：宽<?php echo $newslogowidth ?>*高<?php echo $newslogoheight ?>)</td>
        </tr>
    </table>
      </td>
  </tr>
  <tr>
    <td align=right bgcolor="#FFFFFF">新闻作者：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input name="author" type="text" id="author" size="50" value="<?php echo $newsinfo['author']; ?>"></td></tr>
  <tr>
    <td align=right bgcolor="#FFFFFF">新闻来源：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input name="source" type="text" id="source" size="50" value="<?php echo $newsinfo['source']; ?>"></td></tr>
  <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">新闻关键字：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input name="keywords" type="text" id="keywords" size="80" value="<?php echo $newsinfo['keywords']; ?>">
      (SEO：新闻关键字，以,分隔)</td>
  </tr>
  <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">新闻描述：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><textarea name="description" cols="80" rows="3" id="description"><?php echo $newsinfo['description']; ?></textarea>
      (SEO：新闻的描述)</td>
  </tr>
  <?php }?>
  <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">点击：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input name="click" type="text" id="click" size="10" value="<?php echo $newsinfo['click']; ?>" /></td>
  </tr>
  <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">新闻内容(<font color="red">*</font>)：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000">
	<?php APP::GetEditor('content',$newsinfo['content'],'100%','500');?>
    </td></tr>
  <tr>
    <td align=right bgcolor="#FFFFFF">新闻属性：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input name="istop" type="checkbox" <?php if($newsinfo['istop']){echo 'checked="checked"';} ?> id="istop" value="1" />
      置顶</td>
  </tr>
  <tr>
    <td align=right bgcolor="#FFFFFF"></td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input type="submit" name="button" id="button" value="<?php if($action=='add'){echo '添加';}else{echo '修改';} ?>新闻">
    <input type="reset" name="button2" id="button2" value="重置"></td></tr>
    </table>
</form>
 </body></html>