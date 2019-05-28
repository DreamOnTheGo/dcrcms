<?php
include "../include/common.inc.php";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="css/admin.css" type="text/css" rel="stylesheet">
<script language=javascript>
	function expand(el)
	{
		childObj = document.getElementById("child" + el);

		if (childObj.style.display == 'none')
		{
			childObj.style.display = 'block';
		}
		else
		{
			childObj.style.display = 'none';
		}
		return;
	}
</script>
</head>
<body style="background-color:#E3EFFB; background:url(images/menu_bg.jpg)">
<table cellSpacing=0 cellPadding=0 width=170 border=0>
  <tr>
    <td vAlign=top align="center"><table cellSpacing=0 cellPadding=0 width="100%" border=0>
        <tr>
          <td height=10></td>
        </tr>
      </table>
      <table cellSpacing="0" cellPadding="0" width="150" border="0">
        <tr height="22">
          <td background="images/menu_bt.jpg" align="center"><a class=menuParent onclick=expand(1) href="javascript:void(0);">公司资料</a></td>
        </tr>
        <tr height=4>
          <td></td>
        </tr>
      </table>
      <table id="child1" style="display:none" cellSpacing=0 cellPadding=0 width=150 border=0>
        <tr height=20>
          <td align="center" width=15><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left" width="135"><span style="float:right; font-size:11px;line-height:18px"><a class=menuChild href="single_edit.php?action=add" target=main>添加资料</a></span><a target="main" href="single_list.php">资料列表</a></td>
        </tr>
        <tr height=4>
          <td colSpan=2></td>
        </tr>
      </table>
      <table cellSpacing=0 cellPadding=0 width=150 border=0>
        <tr height=22>
          <td background=images/menu_bt.jpg align="center"><a class=menuParent onclick=expand(2) href="javascript:void(0);">新闻中心</a></td>
        </tr>
        <tr height=4>
          <td></td>
        </tr>
      </table>
      <table id="child2" style="display:none" cellSpacing=0 cellPadding=0 width=150 border=0>
        <tr height=20>
          <td align="center" width=15><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left" width="135"><span style="float:right; font-size:11px;line-height:18px"><a class=menuChild href="news_edit.php?action=add" target=main>添加新闻</a></span><a class=menuChild href="news_list.php" target=main>新闻列表</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left" width="135"><span style="float:right; font-size:11px;line-height:18px"><a href="news_class_edit.php?action=add" target="main">添加分类</a></span><a class=menuChild href="news_class_list.php" target=main>新闻分类</a></td>
        </tr>
        <tr height=4>
          <td colSpan=2></td>
        </tr>
      </table>
      <table cellSpacing=0 cellPadding=0 width=150 border=0>
        <tr height=22>
          <td background=images/menu_bt.jpg align="center"><a class=menuParent onclick=expand(3) href="javascript:void(0);">产品中心</a></td>
        </tr>
        <tr height=4>
          <td></td>
        </tr>
      </table>
      <table id=child3 style="DISPLAY: none" cellSpacing=0 cellPadding=0 width=150 border=0>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left" width="135"><span style="float:right; font-size:11px;line-height:18px"><a href="product_edit.php?action=add" target="main">添加产品</a></span><a class=menuChild href="product_list.php" target=main>产品列表</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 
            src="images/menu_icon.gif" width=9></td>
          <td align="left" width="135"><span style="float:right; font-size:11px;line-height:18px"><a href="product_class_edit.php?action=add" target="main">添加分类</a></span><a class=menuChild href="product_class_list.php" target=main>产品分类</a></td>
        </tr>
        <tr height=4>
          <td colSpan=2></td>
        </tr>
      </table>
      <table cellSpacing=0 cellPadding=0 width=150 border=0>
        <tr height=22>
          <td background=images/menu_bt.jpg align="center"><a class=menuParent onclick=expand(4) href="javascript:void(0);">互动中心</a></td>
        </tr>
        <tr height=4>
          <td></td>
        </tr>
      </table>
      <table id=child4 style="DISPLAY: none" cellSpacing=0 cellPadding=0 
      width=150 border=0>
        <tr height=20>
          <td align="center" width="15"><img height=9 
            src="images/menu_icon.gif" width=9></td>
          <td align="left" width="135"><a class=menuChild href="hudong_field_list.php" target=main>信息字段管理</a></td>
        </tr>
        <td align="center" width="15"><img height=9 
            src="images/menu_icon.gif" width=9></td>
          <td align="left" width="135"><a class=menuChild href="hudong_list.php" target=main>信息列表</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 
            src="images/menu_icon.gif" width=9></td>
          <td align="left" width="135"><a class=menuChild href="hudong_list.php?type=1" target=main>未读信息</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 
            src="images/menu_icon.gif" width=9></td>
          <td align="left" width="135"><a class=menuChild href="hudong_list.php?type=2" target=main>已读信息</a></td>
        </tr>
        <tr height=4>
          <td colSpan=2></td>
        </tr>
      </table>
      <table cellSpacing=0 cellPadding=0 width=150 border=0>
        <tr height=22>
          <td background=images/menu_bt.jpg align="center"><a class=menuParent onclick=expand(7) href="javascript:void(0);">系统管理</a></td>
        </tr>
        <tr height=4>
          <td></td>
        </tr>
      </table>
      <table id=child7 style="DISPLAY: none" cellSpacing=0 cellPadding=0 width=150 border=0>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left" width="135"><a class=menuChild href="config_edit.php" target=main>基本设置</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left" width="135"><a class=menuChild href="menu_list.php" target=main>导航条设置</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left"><a class=menuChild href="watermark_edit.php" target='main'>水印设置</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left" width="135"><a class=menuChild href="email_edit.php" target=main>网站邮件配置</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left"><a class=menuChild href="cache_clear.php" target=main>清空缓存</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left"><a class=menuChild href="dbmanage.php" target=main>数据库管理</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left"><a class=menuChild href="fmanage.php" target=main>文件管理器</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left"><a class=menuChild href="model_list.php" target=main>模型管理</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left"><a class=menuChild href="sitemap_baidu_edit.php" target=main>生成百度sitemap</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left"><a class=menuChild href="sitemap_google_edit.php" target=main>生成Google sitemap</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 
            src="images/menu_icon.gif" width=9></td>
          <td align="left"><a class=menuChild href="password_edit.php" target=main>修改口令</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 
            src="images/menu_icon.gif" width=9></td>
          <td align="left"><a class=menuChild onclick="if(confirm('确定要退出吗？')) return true; else return false;" href="logout.php" target=_top>退出系统</a></td>
        </tr>
        <tr height=4>
          <td colSpan=2></td>
        </tr>
      </table>
      <table cellSpacing=0 cellPadding=0 width=150 border=0>
        <tr height=22>
          <td background=images/menu_bt.jpg align="center"><a class=menuParent onclick=expand(11) href="javascript:void(0);">模板管理</a></td>
        </tr>
        <tr height=4>
          <td></td>
        </tr>
      </table>
      <table id=child11 style="DISPLAY: none" cellSpacing=0 cellPadding=0 
      width=150 border=0>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left" width="135"><a class=menuChild href="tpl_edit.php" target=main>模板设置</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left"><a class=menuChild href="fmanage.php?cpath=templets/<?php echo $tpl_dir; ?>" target=main>模板文件管理器</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left"><a class=menuChild href="tpl_export.php" target=main>导出模板</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left"><a class=menuChild href="tpl_import.php" target=main>导入模板</a></td>
        </tr>
        <tr height=4>
          <td colSpan=2></td>
        </tr>
      </table>      
      <table cellSpacing=0 cellPadding=0 width=150 border=0>
        <tr height=22>
          <td background=images/menu_bt.jpg align="center"><a class=menuParent onclick=expand(13) href="javascript:void(0);">友情链接</a></td>
        </tr>
        <tr height=4>
          <td></td>
        </tr>
      </table>
      <table id="child13" style="DISPLAY: none" cellSpacing=0 cellPadding=0 width=150 border=0>
        <tr height=20>
          <td align="center" width=15><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left" width="130"><span style="float:right; font-size:11px;line-height:18px"><a href="flink_edit.php?action=add" target="main">添加链接</a></span><a class=menuChild href="flink_list.php" target=main>链接列表</a></td>
        </tr>
        <tr height=4>
          <td colSpan=2></td>
        </tr>
      </table>    
      <table cellSpacing=0 cellPadding=0 width=150 border=0>
        <tr height=22>
          <td background=images/menu_bt.jpg align="center"><a class=menuParent onclick=expand(12) href="javascript:void(0);">帮助中心</a></td>
        </tr>
        <tr height=4>
          <td></td>
        </tr>
      </table>
      <table id=child12 style="DISPLAY: none" cellSpacing=0 cellPadding=0 width=150 border=0>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left" width="135"><a class=menuChild href="http://www.dcrcms.com/help.php" target="_blank">系统帮助</a></td>
        </tr>
        <tr height=20>
          <td align="center" width="15"><img height=9 src="images/menu_icon.gif" width=9></td>
          <td align="left"><a class=menuChild href="http://www.dcrcms.com/hudong.php" target="_blank">意见留言</a></td>
        </tr>
      </table></td>
    <td width=1 bgColor=#d1e6f7></td>
  </tr>
</table>
</body>
</html>
