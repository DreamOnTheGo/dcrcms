<?php
require_once("../include/common.inc.php");
session_start();
require_once("adminyz.php");

require_once(WEB_CLASS . "/class.model.php");
$cls_model = new cls_model( $model_id );
$model_info = $cls_model-> get_info();
$cls_data = cls_app::get_data('@#@' . $model_info['model_table_name']);
$field_list = $cls_model->get_filed_list( $model_id, array( 'oerder'=>'order_id desc') );

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
    	<?php require_once('model_art_header.php'); ?></td>
  </tr>
</table>
<br />
				<?php
                    $page_list_num = 20;//每页显示?条
                    $total_page = 0;//总页数
                    $page = isset($page) ? (int)$page : 1;
                    $start = ($page-1) * $page_list_num;
                    $classid = isset($classid) ? intval($classid) : 0;                    
					
                    $list = $cls_data->select_ex( array( 'where'=>"model_id={$model_id}", 'order'=>'id desc', 'limit'=>"$start,$page_list_num" ) );
					//p_r($gz_list);
                ?>
					<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
                            <tr id="tableHead">
                            	<?php
									foreach($field_list as $field)
									{
										if( ! $field['show_in_list'] ){ continue; }
								?>
                                <td height="21"><?php echo $field['item_name']; ?></td>
                                <?php } ?>
                                <td height="21">添加时间</td>
                                <td height="21">操作</td>
                            </tr>
                            <?php
								foreach($list as $value)
								{
							?>
                            <tr id="list" bgcolor="#FFFFFF" onMouseMove="javascript:this.style.backgroundColor='#F4F9EB';" onMouseOut="javascript:this.style.backgroundColor='#FFFFFF';">
                            	<?php
									reset($field_list);
									foreach($field_list as $field)
									{
										if( ! $field['show_in_list'] ){ continue; }
								?>
                                <td height="21"><div title="<?php echo $value[ $field['field_name'] ]; ?>"><?php echo $value[ $field['field_name'] ]; ?></div></td>
                                <?php } ?>
                                <td height="21"><?php echo date( 'Y-m-d', $value['add_time'] ); ?></td>
                                <td height="21"><a href="model_art_edit.php?action=modify&id=<?php echo $value['id']; ?>&model_id=<?php echo $value['model_id']; ?>">修改</a>&nbsp;&nbsp;<a href="model_art_edit.php?action=view&id=<?php echo $value['id']; ?>&model_id=<?php echo $value['model_id']; ?>">查看</a>&nbsp;&nbsp;<a href="model_art_action.php?action=del&id=<?php echo $value['id']; ?>&model_id=<?php echo $value['model_id']; ?>" onClick="return confirm('确定要删除？');">删除</a></td>
                            </tr>
				            <?php } ?>
                        </table>
					<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
                            <tr>
                                <td height="1" bgcolor="#EEEEEE">
                                <?php
                                require_once(WEB_CLASS.'/class.page.php');
                                
                                if($where_option)
                                {
                                    $where = implode(' and ',$where_option);
                                }
                                
                                $page_num = $cls_model->get_num();
                                $total_page = ceil($page_num / $page_list_num);//总页数
								
                                $cls_page = new cls_page($page, $total_page );
                                $page_html = $cls_page->show_page(); 
                                echo $page_html;
                             ?></td>
                            </tr>
                        </table>
</body>
</html>