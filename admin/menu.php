<?php
session_start();
include "../include/common.inc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
<SCRIPT language=javascript>
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
</SCRIPT>
</HEAD>
<BODY style="background-color:#E3EFFB; background:url(images/menu_bg.jpg)">
<TABLE cellSpacing=0 cellPadding=0 width=170 border=0>
  <TR>
    <TD vAlign=top align=middle><TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TR>
          <TD height=10></TD>
        </TR>
      </TABLE>
      <TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
        <TR height=22>
          <TD background=images/menu_bt.jpg><A class=menuParent onclick=expand(1) href="javascript:void(0);">��˾����</A></TD>
        </TR>
        <TR height=4>
          <TD></TD>
        </TR>
      </TABLE>
      <TABLE id=child1 style=" display:none" cellSpacing=0 cellPadding=0 
      width=150 border=0>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><span style="float:right; font-size:11px;line-height:18px"><A class=menuChild href="single_edit.php?action=add" target=main>�������</A></span><a target="main" href="single_list.php">�����б�</a></TD>
        </TR>
        <TR height=4>
          <TD colSpan=2></TD>
        </TR>
      </TABLE>
      <TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
        <TR height=22>
          <TD background=images/menu_bt.jpg><A class=menuParent onclick=expand(2) href="javascript:void(0);">��������</A></TD>
        </TR>
        <TR height=4>
          <TD></TD>
        </TR>
      </TABLE>
      <TABLE id=child2 style="DISPLAY: none" cellSpacing=0 cellPadding=0 
      width=150 border=0>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><span style="float:right; font-size:11px;line-height:18px"><A class=menuChild href="news_edit.php?action=add" target=main>�������</A></span><A class=menuChild href="news_list.php" target=main>�����б�</A></TD>
        </TR>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><span style="float:right; font-size:11px;line-height:18px"><a href="news_class_edit.php?action=add" target="main">��ӷ���</a></span><A class=menuChild href="news_class_list.php" target=main>���ŷ���</A></TD>
        </TR>
        <TR height=4>
          <TD colSpan=2></TD>
        </TR>
      </TABLE>
      <TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
        <TR height=22>
          <TD background=images/menu_bt.jpg><A 
            class=menuParent onclick=expand(3) 
            href="javascript:void(0);">��Ʒ����</A></TD>
        </TR>
        <TR height=4>
          <TD></TD>
        </TR>
      </TABLE>
      <TABLE id=child3 style="DISPLAY: none" cellSpacing=0 cellPadding=0 
      width=150 border=0>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><span style="float:right; font-size:11px;line-height:18px"><a href="product_edit.php?action=add" target="main">��Ӳ�Ʒ</a></span><A class=menuChild href="product_list.php" target=main>��Ʒ�б�</A></TD>
        </TR>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><span style="float:right; font-size:11px;line-height:18px"><a href="product_class_edit.php?action=add" target="main">��ӷ���</a></span><A class=menuChild href="product_class_list.php" target=main>��Ʒ����</A></TD>
        </TR>
        <TR height=4>
          <TD colSpan=2></TD>
        </TR>
      </TABLE>
      <TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
        <TR height=22>
          <TD background=images/menu_bt.jpg><A 
            class=menuParent onclick=expand(4) 
            href="javascript:void(0);">������Ϣ</A></TD>
        </TR>
        <TR height=4>
          <TD></TD>
        </TR>
      </TABLE>
      <TABLE id=child4 style="DISPLAY: none" cellSpacing=0 cellPadding=0 
      width=150 border=0>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><A class=menuChild href="hudong_field_list.php" target=main>��Ϣ�ֶι���</A></TD>
        </TR>
        <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><A class=menuChild href="hudong_list.php" target=main>��Ϣ�б�</A></TD>
        </TR>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><A class=menuChild href="hudong_list.php?type=1" target=main>δ����Ϣ</A></TD>
        </TR>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><A class=menuChild href="hudong_list.php?type=2" target=main>�Ѷ���Ϣ</A></TD>
        </TR>
        <TR height=4>
          <TD colSpan=2></TD>
        </TR>
      </TABLE>
      <TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
        <TR height=22>
          <TD background=images/menu_bt.jpg><A 
            class=menuParent onclick=expand(7) 
            href="javascript:void(0);">ϵͳ����</A></TD>
        </TR>
        <TR height=4>
          <TD></TD>
        </TR>
      </TABLE>
      <TABLE id=child7 style="DISPLAY: none" cellSpacing=0 cellPadding=0 
      width=150 border=0>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><A class=menuChild href="config_edit.php" target=main>��������</A></TD>
        </TR>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><A class=menuChild href="cache_clear.php" target=main>��ջ���</A></TD>
        </TR>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><A class=menuChild href="password_edit.php" target=main>�޸Ŀ���</A></TD>
        </TR>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><A class=menuChild 
            onclick="if (confirm('ȷ��Ҫ�˳���')) return true; else return false;" href="logout.php" target=_top>�˳�ϵͳ</A></TD>
        </TR>
        <TR height=4>
          <TD colSpan=2></TD>
        </TR>
      </TABLE>
      <TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
        <TR height=22>
          <TD background=images/menu_bt.jpg><A 
            class=menuParent onclick=expand(11) 
            href="javascript:void(0);">ģ�����</A></TD>
        </TR>
        <TR height=4>
          <TD></TD>
        </TR>
      </TABLE>
      <TABLE id=child11 style="DISPLAY: none" cellSpacing=0 cellPadding=0 
      width=150 border=0>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><A class=menuChild href="tpl_edit.php" target=main>ģ������</A></TD>
        </TR>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><A class=menuChild href="tpl_export.php" target=main>����ģ��</A></TD>
        </TR>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><A class=menuChild href="tpl_import.php" target=main>����ģ��</A></TD>
        </TR>
        <TR height=4>
          <TD colSpan=2></TD>
        </TR>
      </TABLE>
      <TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
        <TR height=22>
          <TD background=images/menu_bt.jpg><A class=menuParent onclick=expand(12) href="javascript:void(0);">ϵͳ����</A></TD>
        </TR>
        <TR height=4>
          <TD></TD>
        </TR>
      </TABLE>
      <TABLE id=child12 style="DISPLAY: none" cellSpacing=0 cellPadding=0 
      width=150 border=0>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 src="images/menu_icon.gif" width=9></TD>
          <TD align="left"><A class=menuChild href="http://www.dcrcms.com/news_list.php?id=3" target=_blank>ϵͳ����</A></TD>
        </TR>
      </TABLE></TD>
    <TD width=1 bgColor=#d1e6f7></TD>
  </TR>
</TABLE>
</BODY>
</HTML>
