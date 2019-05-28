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
		ShowMsg('请输入产品标题');
		return false;
	}
	if($("#classid").val().length==0 || $("#classid").val()==0){
		ShowMsg('请选择产品类型');
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
														if(data!='添加产品分类成功'){
															alert(data);
														}else if(data=='添加产品分类成功'){
															closeProductClassForm();
															refreshProductClassList();
															//alert('dfs');
														}
														}); 
}
function refreshProductClassList(){
	//刷新产品类别
	$.post("product_class_action.php?action=getlist_ajax",function(list){
																    var s='<select name="classid" id="classid">';
																	s=s+"<option value='0'>请选择产品类别</option>";
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

</head>
<body>
<table cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <tr height=28>
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;添加产品</td></tr>
  <tr>
    <td bgColor=#b1ceef height=1></td></tr></table>
<table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <tr height=20>
    <td></td></tr>
  <tr height=22>
    <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>添加产品</td></tr>
  <tr bgColor=#ecf4fc height=12>
    <td></td></tr>
  </table>
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
			$errormsg[]='您没有选择要修改的文档';
			ShowMsg($errormsg,2,$back);
		}
	}
?>
<form action="product_action.php" method="post" enctype="multipart/form-data" id="frmAddProduct" name="frmAddProduct" onsubmit="return check();">
<input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
<input type="hidden" name="id" id="id" value="<?php echo $productinfo['id']; ?>">
<input type="hidden" name="oldtags" id="oldtags" value="<?php echo $productinfo['tags']; ?>">
<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <tr>
    <td width=100 align=right bgcolor="#FFFFFF">产品名称(<font color="red" class="txtRed">*</font>)：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input name="title" type="text" id="title" size="80" value="<?php echo $productinfo['title']; ?>"></td></tr>
  <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">产品类别(<font color="red" class="txtRed">*</font>)：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><span id="productClassList"> <?php 
		$pro=new Product(0);
		$productClassList=$pro->GetClassList(array('id','classname'));
		if(count($productClassList)>0){
			echo '<select name="classid" id="classid">';
			echo "<option value='0'>请选择产品类别</option>";
			foreach($productClassList as $value){
				echo "<option value='$value[id]'>$value[classname]</option>";
				if(is_array($value['sub']) && count($value['sub'])){ ?>
				<?php
                    foreach($value['sub'] as $subvalue){
                ?>
                <option value="<?php echo $subvalue['id'] ?>" <?php if($subvalue['id']==$parentid || $productClassInfo['parentid']==$subvalue['id']){ ?>selected="selected" <?php } ?>>----<?php echo $subvalue['classname'] ?></option>  
        <?php }
		}
			}
			echo '</select>';
		}else{
			echo "当前没有分类";
		}
	?>
    <script type="text/javascript">
	  var classid="<?php echo $productinfo['classid'];?>";
	  if(classid!=''){
		  document.frmAddProduct.classid.value=classid;
	  }
	  </script>
    </span>&nbsp;&nbsp;&nbsp;<!--<a href="#" onclick="javascript:showProductClassForm()">添加产品类别</a>  <a href="javascript:refreshProductClassList();">手动刷新列表</a>-->
      <iframe id="myframe" style=" display:none;position:absolute;z-index:9;width:expression(this.nextSibling.offsetWidth);height:expression(this.nextSibling.offsetHeight);top:expression(this.nextSibling.offsetTop);left:expression(this.nextSibling.offsetLeft);" frameborder="0" ></iframe>
    <div id="AddClass" style="display:none;position:absolute;top:100px; border:5px #999 solid; padding:10px; height:100px; width:650px; left:100px; background-color:#ecf4fc; z-index:11">
<table cellSpacing=0 cellPadding=2 width="95%" align=center border=0>
  <tr>
    <td align=right width=100>分类名(<font color="red" class="txtRed">*</font>)：</td>
    <td style="COLOR: #880000"><input name="classname" type="text" id="classname" size="80" onkeypress="tijiaoAddAction();"></td></tr>
  <tr>
    <td align=right valign="top">分类说明：</td>
    <td style="COLOR: #880000"><textarea name="classdescription" cols="80" rows="3" id="classdescription"></textarea></td>
  </tr>
  <tr>
    <td align=right></td>
    <td style="COLOR: #880000"><input type="button" onClick="AddClass()" name="button" id="button" value="添加分类">
    <input type="reset" name="button2" id="button2" value="重置">  <input type="button" value="关闭" onClick="javascript:closeProductClassForm()"></td></tr>
    </table>
</div>
    </td>
  </tr>
  <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">产品缩略图：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><table width="100" border="0" cellspacing="1" cellpadding="3" bgcolor="#33CCFF">
      <tr>
        <td><span style="color:white">当前缩略图</span></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF"><?php if(strlen($productinfo['logo'])>0){echo "<img src='".$productinfo['logo']."'>";}?></td>
      </tr>
    </table>    
      <input type="file" name="logo" id="logo"></td>
  </tr>
  <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">产品关键字：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input name="keywords" type="text" id="keywords" size="80" value="<?php echo $productinfo['keywords']; ?>">
      (SEO：产品关键字)</td>
  </tr>
  <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">产品描述：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><textarea name="description" cols="80" rows="3" id="description"><?php echo $productinfo['description']; ?></textarea>
      (SEO：产品的描述)</td>
  </tr>
  <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">产品详细介绍：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000">
    <?php APP::GetEditor('content',$productinfo['content'],'930','500');?>
    </td></tr>
    <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">产品tag：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input name="tags" type="text" id="tags" size="80" value="<?php echo $productinfo['tags']; ?>" />
      (请以英文状态下的来分隔tag，如:电脑,手机)</td>
  </tr>
  <tr>
    <td align=right bgcolor="#FFFFFF">产品属性：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input name="istop" type="checkbox" <?php if($productinfo['istop']){echo 'checked="checked"';} ?> id="istop" value="1" />
置顶</td>
  </tr>
  <tr>
    <td align=right bgcolor="#FFFFFF"></td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input type="submit" name="button" id="button" value="<?php if($action=='add'){echo '添加';}else{echo '修改';} ?>产品">
    <input type="reset" name="button2" id="button2" value="重置"></td></tr>
    </table>
</form>
 </body></html>