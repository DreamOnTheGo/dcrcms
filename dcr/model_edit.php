<?php
require_once("../include/common.inc.php");
session_start();
require_once("adminyz.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>编辑友情链接</title>
<link href="css/admin.css" type="text/css" rel="stylesheet" />
<?php include "admin_common.php"; ?>
<script type='text/javascript'>
function check(){
	if($("#model_name").val().length==0)
	{
		$("#model_name").focus();
		alert('请输入模型名');
		return false;
	}
	if($("#model_table_name").val().length==0)
	{
		$("#model_table_name").focus();
		alert('请输入模型表名');
		return false;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<table cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <tr height=28>
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;模型编辑</td></tr>
  <tr>
    <td bgColor=#b1ceef height=1></td></tr></table>
<div id="page">
<?php
	require_once(WEB_CLASS . "/class.model.php");
	$cls_model = new cls_model();
	if($action == 'add')
	{
		$txt = '添加';
	}else
	{
		$txt = '修改';
		$action = 'modify';
		$id = isset($id) ? (int)$id : 0;
		
		if($id != 0)
		{
			$model_info = $cls_model->get_info( $id );
			//p_r($pro_info);
		}else{
			$errormsg[] = '您没有选择要修改的文档';
			show_msg($errormsg, 2, $back);
		}
	}
?>
<form action="model_action.php" method="post" enctype="multipart/form-data" onSubmit="return check();">
	<input type="hidden" name="action" id="action" value="add_model">
    <table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
      <tr height=20>
        <td></td>
      </tr>
      <tr height=22>
        <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg><?php echo $txt; ?>模型</td>
      </tr>
      <tr bgColor=#ecf4fc>
        <td style="padding:3px"><?php require_once('model_header.php'); ?></td>
      </tr>
    </table>
    <table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
      <tbody>
        <tr bgcolor="#ffffff">
          <td height="25" align="right" width="12%"><span class="redtxt">*</span><span class="textR">模型名</span>：</td>
          <td width="89%" height="25" colspan="3">&nbsp;<span class="input marginL">
            <input name="model_name" type="text" id="model_name" size="50" value="<?php echo $model_info['model_name']; ?>" />
          </span></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25" align="right" width="12%"><span class="redtxt">*</span><span class="textR">模型表名</span>：</td>
          <td height="25" colspan="3" style="font-weight: bold; width: 45%;">&nbsp;
            <span class="input marginL">
            <input name="model_table_name" type="text" id="model_table_name" size="50" value="<?php echo $model_info['model_table_name']; ?>" />
            </span><span class="ts_txt" style="font-size:12px;">&nbsp;只能用英文字母或数字，数据表的名字</span></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25" align="right" width="12%"><span class="textR">模型描述</span>：</td>
          <td height="25" colspan="3" style="width: 45%;"><span class="input marginL">&nbsp;
            <textarea name="dec" cols="80" rows="5" id="dec" type="text"><?php echo $model_info['dec']; ?></textarea>
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
