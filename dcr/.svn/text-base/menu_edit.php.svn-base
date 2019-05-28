<?php
require_once("../include/common.inc.php");
session_start();
require_once("adminyz.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>编辑导航条</title>
<link href="css/admin.css" type="text/css" rel="stylesheet" />
<style>
.redtxt{color:red;}
</style>
<script>
	function change_menu_type(type, is_show_txt)
	{
		if(2 == type)
		{
			$('#panel_product').hide();
			$('#panel_single').hide();
			$('#panel_url').hide();
			$('#panel_news').show();
			if(is_show_txt)
			{
				$('#menu_text').val($('#news_class_list option:first').val());
			}
		}
		else if(3 == type)
		{
			$('#panel_product').show();
			$('#panel_single').hide();
			$('#panel_news').hide();
			$('#panel_url').hide();
			if(is_show_txt)
			{
				$('#menu_text').val($('#pro_class_list option:first').val());
			}
		}
		else if(1 == type)
		{
			$('#panel_product').hide();
			$('#panel_single').show();
			$('#panel_news').hide();
			$('#panel_url').hide();
			if(is_show_txt)
			{
				$('#menu_text').val($('#single_list option:first').val());
			}
		}else if(4 == type)
		{
			$('#panel_product').hide();
			$('#panel_single').hide();
			$('#panel_news').hide();
			$('#panel_url').hide();
			if(is_show_txt)
			{
				$('#menu_text').val('在线订单');
			}
		}else if(5 == type)
		{
			if(is_show_txt)
			{
				$('#menu_text').val('');
			}
			$('#panel_product').hide();
			$('#panel_single').hide();
			$('#panel_news').hide();
			$('#panel_url').show();
		}
		
	}
</script>
<?php include "admin_common.php"; ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
	$info = array();
	require_once(WEB_CLASS . '/class.menu.php');
	$cls_menu = new cls_menu();
	$menu_type_list = $cls_menu->get_menu_type_list();
	if($action == 'edit')
	{
		$info = $cls_menu-> get_info($id);
		$subtxt = '修改';
	}else
	{
		$info['menu_type'] = 5;
		$info['order_id'] = 1;
		$action = 'add';
		$subtxt = '添加';
	}
	//p_r($info);
?>
<table cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <tr height=28>
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;<?php echo $subtxt; ?>导航</td></tr>
  <tr>
    <td bgColor=#b1ceef height=1></td></tr></table>
  			<form action="menu_action.php" method="post" target="" enctype="multipart/form-data" onsubmit="return check();">
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <input type="hidden" name="id" value="<?php echo $info['id']; ?>" />
            <table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
              <tr height=20>
                <td></td></tr>
              <tr height=22>
                <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
                align=middle background=images/title_bg2.jpg>添加链接</td></tr>
              <tr bgColor=#ecf4fc height=24>
                <td style="padding:4px;"><a href="menu_edit.php?action=add">添加导航</a> <a href="menu_list.php?action=add">导航列表</a></td></tr>
              </table><br />
							<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">  
                                    <tbody>
                                    <tr bgcolor="#ffffff">
                                        <td height="25" align="right" width="12%"> 菜单类型：</td>
                                      <td width="89%" height="25" colspan="3">
                                      <?php
									  	$menu_type_list = $cls_menu->get_menu_type_list();
										if($menu_type_list)
										{
											foreach($menu_type_list as $key=> $menu)
											{
										?>
                                        <input onclick="change_menu_type(<?php echo $key; ?>,true)" type="radio" <?php if($key == $info['menu_type']){ ?> checked="checked" <?php } ?> name="menu_type" id="menu_type" value="<?php echo $key; ?>" /><?php echo $menu ?>
                                        <?php
											}
										}
									  ?>
                                      </td>
                                      </tr>
                                      <tr bgcolor="#ffffff" style="display:none" id="panel_news">
                                        <td height="25" align="right" width="12%">新闻分类：</td>
                                        <td height="25" colspan="3">
                                        <?php
										?>
                                        <select name="news_class_list" id="news_class_list" onchange="javascript:document.getElementById('menu_text').value=this.options[this.selectedIndex].value">
      								<option value="<?php echo $menu_type_list[2]; ?>"><?php echo $menu_type_list[2]; ?></option>
                                      <?php
									  	$cls_news = cls_app:: get_news();
										$news_class_list  = $cls_news->get_class_list();
										if($news_class_list)
										{
											foreach($news_class_list as $news_class)
											{
										?>
                                        <option <?php if($info['news_class_id'] == $news_class['id']){?> selected="selected"<?php } ?> value="<?php echo $news_class['classname']; ?>"><?php echo $news_class['classname']; ?></option>
                                        <?php
											}
										}
									  ?>
                                      </select></td>
                                      </tr>
                                      <tr bgcolor="#ffffff" id="panel_product" style="display:none">
                                        <td height="25" align="right" width="12%">产品分类：</td>
                                        <td height="25" colspan="3">
                                      <select name="pro_class_list" id="pro_class_list" onchange="javascript:document.getElementById('menu_text').value=this.options[this.selectedIndex].value">
                                      <option value="<?php echo $menu_type_list[3]; ?>"><?php echo $menu_type_list[3]; ?></option>
                                    <?php
                                        $cls_pro = cls_app:: get_product();
                                        $pro_class_list = $cls_pro->get_class_list();
                                        $cls_pro->get_class_list_select($pro_class_list, $info['product_class_id'], 'classname');
                                    ?></select></td>
                                      </tr>
                                      <tr bgcolor="#ffffff" id="panel_single" style="display:none">
                                        <td height="25" align="right" width="12%">公司资料：</td>
                                        <td height="25" colspan="3">
                                 <select name="single_list" id="single_list" onchange="javascript:document.getElementById('menu_text').value=this.options[this.selectedIndex].value">
                                <?php		
                                require_once(WEB_CLASS . "/class.single.php");
                                $cls_single = new cls_single();
                                $single_list = $cls_single->get_list();
                                if($single_list)
                                {
                                    foreach($single_list as $single)
                                    {
                                        ?>
                                      <option <?php if($info['single_id'] == $single['id']){?> selected="selected"<?php } ?> value="<?php echo $single['title']; ?>"><?php echo $single['title']; ?></option>
                                      <?php
                                    }
                                }
                                ?></select></td>
                                      </tr>
                                    
                                    <tr bgcolor="#ffffff">
                                        <td height="25" align="right">链接文本：</td>
                                        <td height="25" colspan="3">
                                          <input name="menu_text" type="text" id="menu_text" size="50" maxlength="100" value="<?php echo $info['menu_text']; ?>" /></td>
                                      </tr><tr bgcolor="#ffffff" id="panel_url">
                                        <td height="25" align="right">链接地址：</td>
                                        <td height="25" colspan="3"><input name="url" type="text" id="url" size="50" maxlength="100" value="<?php echo $info['url']; ?>"></td>
                                      </tr>
                                      <tr bgcolor="#ffffff">
                                        <td height="25" align="right">链接打开方式：</td>
                                        <td height="25" colspan="3">
                                        <select name="target">
                                      <?php
									  	$target_list = $cls_menu->get_target_list();
										if($target_list)
										{
											foreach($target_list as $key=> $target)
											{
										?>
                                        <option <?php if($info['target'] == $key){ ?> selected="selected" <?php }?> value="<?php echo $key; ?>"><?php echo $target; ?></option>
                                        <?php
											}
										}
									  ?>
                                      </select>
                                        </td>
                                      </tr>
                                      <tr bgcolor="#ffffff">
                                        <td height="25" align="right" width="12%">排序：</td>
                                        <td height="25" colspan="3"><input name="order_id" type="text" id="order_id" size="5" maxlength="5" value="<?php echo $info['order_id']; ?>" /></td>
                                      </tr>
                                    <tr bgcolor="#ffffff">
                                      <td height="25" align="right">&nbsp;</td>
                                      <td height="25" colspan="3"><input type="submit" name="Button1" value="<?php echo $subtxt; ?>" id="Button1" />&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                      <input type="reset" name="Button3" value="重置" id="Button3"  />
                                      <script type="text/javascript">
										change_menu_type(<?php echo $info['menu_type']; ?>, false);
                                      </script>
                                      </td>
                                    </tr>                                 
                                </tbody>
                                </table></form>
</body>
</html>
