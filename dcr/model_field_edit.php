<?php
require_once("../include/common.inc.php");
session_start();
require_once("adminyz.php");
if( 'modify_field' == $action )
{
	$txt = '修改';
} else
{
	$txt = '添加';
}
require_once( WEB_CLASS . "/class.model.php" );
$cls_model = new cls_model();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>字段管理</title>
<link href="css/admin.css" type="text/css" rel="stylesheet" />
<?php include "admin_common.php"; ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<table cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <tr height=28>
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;字段管理</td></tr>
  <tr>
    <td bgColor=#b1ceef height=1></td></tr></table>
<div id="page">

             <?php
				if($action == 'add_field')
				{
					$field_info['show_in_list'] = 1;
				}else
				{
					$id = isset($id) ? (int)$id : 0;
					
					if($id != 0)
					{
						$field_info = $cls_model->get_field_info( $id );
						//p_r($pro_info);
					}else
					{
						show_msg( '您没有选择要修改的文档' , 2, $back);
					}
				}
			?>
<form action="model_action.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
                    <input type="hidden" name="id" id="id" value="<?php echo $field_info['id']; ?>">
                    <input type="hidden" name="model_id" id="model_id" value="<?php echo $model_id; ?>">
    <table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
      <tr height=20>
        <td></td>
      </tr>
      <tr height=22>
        <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" align=middle background=images/title_bg2.jpg><?php echo $txt; ?>字段</td>
      </tr>
      <tr bgColor=#ecf4fc>
        <td style="padding:3px"><?php require_once('model_field_header.php'); ?></td>
      </tr>
    </table>
    <table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
      <tbody>
        <tr bgcolor="#ffffff">
          <td height="25" align="right" width="12%"><span class="redtxt">*</span><span class="textR">表单文字</span>：</td>
          <td width="89%" height="25" colspan="3">&nbsp;<span class="input marginL">
            <input name="item_name" type="text" id="item_name" size="50" value="<?php echo $field_info['item_name']; ?>" />
          <span class="ts_txt" style="font-size:12px;">发布内容时显示的提示文字</span></span></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25" align="right" width="12%"><span class="redtxt">*</span><span class="textR">字段名称</span>：</td>
          <td height="25" colspan="3">&nbsp;
            <span class="input marginL">
            <?php if($action == 'modify_field'){ echo $field_info['field_name'];}else{ ?><input name="field_name" type="text" id="field_name" size="50" /><?php } ?>
            </span>&nbsp;只能用英文字母或数字，数据表的真实字段名</td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25" align="right" width="12%"><span class="redtxt">*</span><span class="textR">字段类型</span>：</td>
          <td height="25" colspan="3">&nbsp;<span class="input marginL">
            <input id="dtype" style="float:none" value="text" checked="checked" name="dtype" type="radio" />
单行文本
<input id="dtype" style="float:none" value="multitext" name="dtype" type="radio" />
多行文本
<input id="dtype" style="float:none" value="select" name="dtype" type="radio" />
option下拉框
<input id="dtype" style="float:none" value="radio" name="dtype" type="radio" />
radio选项卡
<input id="dtype" style="float:none" value="checkbox" name="dtype" type="radio" />
Checkbox多选框</span>
                            <script language="javascript" type="text/javascript">
							 $.each($("input[name='dtype']"),function(){
									if($(this).val() =="<?php echo $field_info['dtype']; ?>")
									{
										$(this).attr("checked","checked");
									}
								});
							</script></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25" align="right" width="12%"><span class="textR">最大长度</span>：</td>
          <td height="25" colspan="3">&nbsp;<span class="input marginL">
            <input name="maxlength" id="maxlength" value="<?php echo $field_info['maxlength']; ?>" size="10" />
          </span><span class="input marginL"><span style="font-size:12px;" class="ts_txt">文本数据必须填写，允许的最大值为30000，本数值对多行文本无效</span> </span></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25" align="right" width="12%"><span class="textR">列表页显示</span>：</td>
          <td height="25" colspan="3">&nbsp; <span class="input marginL">
            <input id="show_in_list" style="float:none" value="1" checked="checked" name="show_in_list" type="radio" />
显示
<input id="show_in_list" style="float:none" value="0" name="show_in_list" type="radio" />
不显示 是不是在文章列表中显示</span>
                            <script language="javascript" type="text/javascript">
							 $.each($("input[name='show_in_list']"),function(){
									if($(this).val() == "<?php echo $field_info['show_in_list']; ?>")
									{
										$(this).attr("checked","checked");
									}
								});
							</script></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25" align="right" width="12%"><span class="textR">默认值</span>：</td>
          <td height="25" colspan="3" style="width: 45%;"><span class="input marginL">&nbsp;
            <textarea name="vdefault" cols="100" rows="5" id="vdefault" type="text"><?php echo $field_info['vdefault']; ?></textarea>
          </span></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25" align="right">&nbsp;</td>
          <td height="25" colspan="3" style="width: 45%;"><input type="submit" value="<?php echo $txt; ?>" id="Button1" />
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            
            &nbsp;
            <input type="reset" value="重置" id="Button3"  /></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
</body>
</html>
