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
    <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" align=middle background=images/title_bg2.jpg>模型列表</td>
  </tr>
  <tr bgColor="#ecf4fc">
    <td style="padding:3px;">
    	<?php require_once('model_field_header.php'); ?></td>
  </tr>
</table>
<br />
				<?php
                    $page_list_num = 100;//每页显示?条
                    $total_page = 0;//总页数
                    $page = isset($page) ? (int)$page : 1;
                    $start = ($page-1) * $page_list_num;
                    $classid = isset($classid) ? intval($classid) : 0;
                    
                    $model_list = $cls_model->get_filed_list( $model_id );
                ?>
					<form action="model_action.php" method="post">
	                    <input type="hidden" name="model_id" id="model_id" value="<?php echo $model_id; ?>">
	                    <input type="hidden" name="action" id="action" value="order_field">
						<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
                            <tr>
                                <td height="21" colspan="5">表会自动生成id,add_time,update_time.用于系统记录</td>
                            </tr>
                            <tr>
                                <td height="1" colspan="5"></td>
                            </tr>
                            <tr id="tableHead">
                                <td width="10%" height="21">表单提示文字</td>
                                <td width="20%" height="21">数据字段名</td>
                                <td width="40%" height="21">数据类型</td>
                                <td width="10%" height="21">操作</td>
                                <td height="5%">排序</td>
                            </tr>
                            <?php
								foreach($model_list as $value)
								{
							?>
                            <tr id="list" bgcolor="#FFFFFF" onMouseMove="javascript:this.style.backgroundColor='#F4F9EB';" onMouseOut="javascript:this.style.backgroundColor='#FFFFFF';">
                                <td height="21"><?php echo $value['item_name']; ?></td>
                                <td height="21"><?php echo $value['field_name']; ?></td>
                                <td height="21"><?php echo $value['dtype']; ?></td>
                                <td height="21"><a href="model_field_edit.php?id=<?php echo $value['id']; ?>&action=modify_field">编辑 </a><a onClick="return confirm('您确定要删除?');" href="model_action.php?id=<?php echo $value['id']; ?>&action=del_field">删除</a></td>
                                <td height="21"><input style="border:1px solid gray" name="order_id[<?php echo $value['id']; ?>]" id="order_id[<?php echo $value['id']; ?>]" type="text" size="5" value="<?php echo $value['order_id']; ?>" /></td>
                            </tr>
				            <?php } ?>
                            <tr>
                                <td height="21" align="right" colspan="5" bgcolor="#EEEEEE" style=" padding-right:10px;"><input style="border:1px solid gray;" type="submit" value="排序"></td>
                            </tr>
                        </table>
                        </form>
</body>
</html>