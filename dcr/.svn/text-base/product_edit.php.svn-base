<?php
include "../include/common.inc.php";
session_start();
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
		show_msg('请输入产品标题');
		return false;
	}
	if($("#classid").val().length==0 || $("#classid").val()==0){
		show_msg('请选择产品类型');
		return false;
	}
}
</script>
<script type="text/javascript" src="js/product.js"></script>
<style>
	.pro_edit_tab{padding:5px; display:block; float:left; cursor:pointer; width:50px; text-align:center; height:20px;}
	.pro_edit_tab_nocur{ background-color:#0CF;color:#333}
	.pro_edit_tab_cur{ background-color:#09F;color:white}
	.pro_names{width:400px; height:100px;}
</style>
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
  <tr bgColor=#ecf4fc height="20">
    <td><div id="tab_base" class="pro_edit_tab pro_edit_tab_cur" onclick="ShowBase()">基本信息</div> <div id="tab_xiangguang" onclick="ShowXiangguan()" class="pro_edit_tab pro_edit_tab_nocur">关联产品</div></td></tr>
  </table>
<?php
	require_once(WEB_CLASS . "/class.product.php");
	$cls_pro = new cls_product();
	if($action == 'add')
	{
	}else
	{
		$action = 'modify';
		$id = isset($id) ? (int)$id : 0;
		
		if($id != 0)
		{
			$pro_info = $cls_pro->get_info($id);
			//p_r($pro_info);
		}else{
			$errormsg[] = '您没有选择要修改的文档';
			show_msg($errormsg, 2, $back);
		}
	}
?>

<form action="product_action.php" method="post" enctype="multipart/form-data" id="frmAddProduct" name="frmAddProduct" onsubmit="return check();">
<input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
<input type="hidden" name="id" id="id" value="<?php echo $pro_info['id']; ?>">
<input type="hidden" name="oldtags" id="oldtags" value="<?php echo $pro_info['tags']; ?>">
<input type="hidden" name="pro_guanlian_value" id="pro_guanlian_value" value="<?php echo $pro_info['guanlian']; ?>" />
<div id="pro_base">
<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <tr>
    <td width=100 align=right bgcolor="#FFFFFF">产品名称(<font color="red" class="txtRed">*</font>)：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input name="title" type="text" id="title" size="80" value="<?php echo $pro_info['title']; ?>"></td></tr>
  <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">产品类别(<font color="red" class="txtRed">*</font>)：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><span id="pro_class_list">
    <select name="classid" id="classid">    
    <?php
		$pro_class_list = $cls_pro-> get_class_list();
		$cls_pro->get_class_list_select($pro_class_list, $pro_info['classid']);
	?></select>    
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
        <td bgcolor="#FFFFFF"><?php if(strlen($pro_info['logo'])>0){echo "<img src='".$pro_info['logo']."'>";}?></td>
      </tr>
    </table>    
      <input type="file" name="logo" id="logo"></td>
  </tr>
  <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">产品关键字：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input name="keywords" type="text" id="keywords" size="80" value="<?php echo $pro_info['keywords']; ?>">
      (SEO：产品关键字)</td>
  </tr>
  <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">产品描述：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><textarea name="description" cols="80" rows="3" id="description"><?php echo $pro_info['description']; ?></textarea>
      (SEO：产品的描述)</td>
  </tr>
  <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">产品详细介绍：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000">
    <?php cls_app::get_editor('content', $pro_info['content'], '930', '500');?>
    </td></tr>
    <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">产品tag：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input name="tags" type="text" id="tags" size="80" value="<?php echo $pro_info['tags']; ?>" />
      (请以英文状态下的,来分隔tag，如:电脑,手机)</td>
  </tr>
  <tr>
    <td align=right bgcolor="#FFFFFF">产品属性：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input name="istop" type="checkbox" <?php if($pro_info['istop']){echo 'checked="checked"';} ?> id="istop" value="1" />
置顶</td>
  </tr>
  <tr>
    <td align=right bgcolor="#FFFFFF"></td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input type="submit" name="button" id="button" value="<?php if($action=='add'){echo '添加';}else{echo '修改';} ?>产品">
    <input type="reset" name="button2" id="button2" value="重置"></td></tr>
    </table></div>
    <div id="pro_xiangguan" style="display:none">
<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <tr>
    <td width=100 align=right bgcolor="#FFFFFF">搜索产品：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input name="pro_search_name" type="text" id="pro_search_name" size="50" value=""><input type="button" value="搜索" style="margin-left:10px;"  onclick="search_products()"/></td></tr>
  <tr>
    <td colspan="2" align=center bgcolor="#FFFFFF">
    <table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="pro_names_sel">
        <select name="pro_names" class="pro_names" id="pro_names" multiple="multiple">
        </select></div></td>
        <td valign="top"><input type="button" value="关联>>" onclick="guanlian()" /><br /><input value="删除<<" onclick="guanlian_cancel()" type="button"></td>
        <td align="right"><select name="pro_guanlian" class="pro_names" id="pro_guanlian" style="width:400px" multiple="multiple">
        <?php
			if($pro_info['guanlian'])
			{
				$guanlian_id_list = explode(',', $pro_info['guanlian']);
				if($guanlian_id_list)
				{
					foreach($guanlian_id_list as $guanlian_id)
					{
						$t_pro_info = $cls_pro->get_info($guanlian_id, 'title');
						echo '<option value="' . $guanlian_id . '">' . $t_pro_info['title'] . '</option>';
					}
				}
			}
		?>
        </select></td>
      </tr>
      <tr>
        <td colspan="3">提示：关联产品会自动去重</td>
        </tr>
    </table></td>
    </tr>
  <tr>
    <td align=right bgcolor="#FFFFFF"></td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input type="submit" name="button" id="button" value="<?php if($action=='add'){echo '添加';}else{echo '修改';} ?>产品">
    <input type="reset" name="button2" id="button2" value="重置"></td></tr>
    </table></div>
</form>

 </body></html>