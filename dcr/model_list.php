<?php
require_once("../include/common.inc.php");
session_start();
require_once("adminyz.php");
require_once( WEB_CLASS . "/class.model.php" );
$cls_model = new cls_model();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="css/admin.css" type="text/css" rel="stylesheet">
<script src="../include/js/common.js"></script>
</head>
<body>
<table cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <tr height=28>
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;模型列表</td>
  </tr>
  <tr>
    <td bgColor=#b1ceef height=1></td>
  </tr>
</table>
<br />
<table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <tr>
    <td>
    </td>
  </tr>
  <tr height=22>
    <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>模型列表</td>
  </tr>
  <tr bgColor="#ecf4fc">
    <td style="padding:3px;">
    	<?php require_once('model_header.php'); ?></td>
  </tr>
</table>
<br />
<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <tr>
    <td height="1" colspan="7"></td>
  </tr>
  <tr id="tableHead">
    <td width="10%" height="21">数据标识</td>
    <td width="20%" height="21">模型名</td>
    <td width="40%" height="21">模型表名</td>
    <td width="10%" height="21">加入时间</td>
    <td height="5%">操作</td>
  </tr>
  <?php
                    $model_list = $cls_model->get_list();
					foreach($model_list as $value)
								{
							?>
  <tr id="list" bgcolor="#FFFFFF" onMouseMove="javascript:this.style.backgroundColor='#F4F9EB';" onMouseOut="javascript:this.style.backgroundColor='#FFFFFF';">
    <td height="21"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="20" style="padding:3px 0 0 0;"><input style="margin:0;" type="checkbox" /></td>
          <td style="padding-left:5px;"><?php echo $value['id']; ?></td>
        </tr>
      </table></td>
    <td height="21"><?php echo $value['model_name']; ?></td>
    <td height="21"><?php echo $value['model_table_name']; ?></td>
    <td height="21"><?php echo date('Y-m-d', $value['add_time']); ?></td>
    <td height="21"><a href="model_field_list.php?model_id=<?php echo $value['id']; ?>">字段管理</a>&nbsp;&nbsp;<a href="model_art_list.php?model_id=<?php echo $value['id']; ?>">文章列表</a>&nbsp;&nbsp;<a href="model_action.php?action=del_model&model_id=<?php echo $value['id']; ?>" onClick="return confirm('删除后所有的数据都将清空，确定要删除？');">删除</a></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>