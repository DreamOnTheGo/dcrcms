<?php
require_once("../include/common.inc.php");
session_start();
require_once("adminyz.php");
require_once(WEB_CLASS . "/class.product.php");
$cls_pro = new cls_product();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="css/admin.css" type="text/css" rel="stylesheet">
<?php include "admin_common.php"; ?>
<script type='text/javascript'>
function check(){
	if($("#classid").val().length==0 || $("#classid").val()==0){
		show_msg('请选择产品类型');
		return false;
	}
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
<form action="product_action.php" method="post" onsubmit="return check();">
<input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <tr>
    <td width=152 align=right bgcolor="#FFFFFF">产品ID</td>
    <td width="932" bgcolor="#FFFFFF" style="COLOR: #880000">产品名称</td></tr>
    <?php
	if($id)
	{
		foreach($id as $cur_id)
		{
			$cur_info = $cls_pro->get_info($cur_id, 'title', array());
	?>
    <tr>
    <td width=152 align=right bgcolor="#FFFFFF"><?php echo $cur_id;?><input type="hidden" name="id[]" id="id[]" value="<?php echo $cur_id; ?>"></td>
    <td width="932" bgcolor="#FFFFFF" style="COLOR: #880000"><?php echo $cur_info['title']; ?></td></tr>
    <?php }} ?>
  <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">新的产品类别(<font color="red" class="txtRed">*</font>)：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><select name="classid" id="classid">    
    <?php
		$product_class_list = $cls_pro->get_class_list();
		$cls_pro-> get_class_list_select($product_class_list);
	?></select></td>
  </tr>
  <tr>
    <td align=right bgcolor="#FFFFFF"></td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input type="submit" name="button" id="button" value="批量修改分类">
    <input type="button" name="button2" id="button2" value="返回" onclick="history.back();"></td></tr>
    </table>
</form>
 </body></html>