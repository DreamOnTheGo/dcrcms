<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="css/admin.css" type="text/css" rel="stylesheet">
<script src="../include/js/common.js"></script>

</head>
<body>
<table cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <tr height=28>
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;产品分类列表</td></tr>
  <tr>
    <td bgColor=#b1ceef height=1></td></tr></table>
<table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <tr height=20>
    <td></td></tr>
  <tr height=22>
    <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>产品分类</td></tr>
  <tr bgColor=#ecf4fc height=12>
    <td></td></tr>
  </table>
  <form action="product_class_action.php" method="post">
  <input type="hidden" name="action" value="order" />
<table width="95%" border="0" cellspacing="1" cellpadding="5" bgcolor="#4776BE" align="center" class="itemtable">
    <tr>
      <td colspan="2" align="left" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="5">
      	<?php
	include WEB_CLASS."/product_class.php";
	$pc=new Product(0);
        	$class_list=$pc->GetClassList();
           // p_r($class_list);
		   if($class_list)
		   {
            foreach($class_list as $value){
        ?>
        <tr onMouseMove="javascript:this.bgColor='#F4F9EB';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
          <td width="4%" bgcolor="#c0c0c0" style="border-bottom:2px dotted #F4F9EB"><?php echo $value['id']; ?></td>
          <td width="61%" style="border-bottom:2px dotted #c0c0c0">·<?php echo $value['classname']; ?></td>
          <td width="35%" style="border-bottom:2px dotted #c0c0c0"><span style="float:right;">排序：
            <input name="orderid[<?php echo $value['id']; ?>]" type="text" value="<?php echo $value['orderid']; ?>" size="5" />
          </span><a href="product_class_edit.php?action=add&parentid=<?php echo $value['id'];?>">添加下级分类</a>&nbsp; <a href="product_class_edit.php?action=modify&id=<?php echo $value['id'];?>">编辑</a>&nbsp; <a href="product_class_action.php?action=delproductclass&classid=<?php echo $value['id'];?>">删除</a></td>
        </tr>
         	<?php if(is_array($value['sub']) && count($value['sub'])){ 
                   foreach($value['sub'] as $sub_value){
                ?>
            <tr onMouseMove="javascript:this.bgColor='#c0c0c0';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
              <td width="4%" bgcolor="#c0c0c0" style="border-bottom:1px dotted white"><?php echo $sub_value['id']; ?></td>
              <td width="66%" style="border-bottom:1px dotted #c0c0c0"><?php echo str_repeat("&nbsp;",4); ?>·<?php echo $sub_value['classname']; ?></td>
              <td width="30%" style="border-bottom:1px dotted #c0c0c0"><span style="float:right;">排序：
            <input name="orderid[<?php echo $sub_value['id']; ?>]" type="text" value="<?php echo $sub_value['orderid']; ?>" size="5" />
          </span><a href="product_class_edit.php?action=modify&id=<?php echo $sub_value['id'];?>">编辑</a>&nbsp; <a href="product_class_action.php?action=delproductclass&classid=<?php echo $sub_value['id'];?>">删除</a></td>
            </tr>
        <?php }}?>
        <?php }?>
        <?php } ?>
        <tr>
          <td colspan="3"><input type="button" name="button" id="button" onclick="location.href='product_class_edit.php?action=add&parentid=0'" value="添加顶级分类" />
            <input type="submit" name="button2" id="button2" value="排序" /></td>
          </tr>
      </table>
      </td>
    </tr>
    </table>
  </form>
 </body></html>