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
<style>
.redtxt{color:red;}
</style>
<?php include "admin_common.php"; ?>
<script type='text/javascript'>
function check(){
	if($("#webname").val().length==0){
		show_msg('请输入网站名');
		return false;
	}
	if($("#weburl").val().length==0){
		show_msg('请输入网址');
		return false;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<div id="page" style="margin:10px">
  <?php
	$info = array();
	if($action == 'editflink')
	{
		require_once(WEB_CLASS . '/class.data.php');
		$flink_data = new cls_data('{tablepre}flink');
		$info = $flink_data-> select_one(array('where'=>"id=$id"));
		$info = current($info);
		$subtxt = '修改';
	}else
	{
		$action = 'addflink';
		$subtxt = '添加';
	}
	//p_r($info);
?>
  			<form action="flink_action.php" method="post" target="" enctype="multipart/form-data" onsubmit="return check();">
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <input type="hidden" name="id" value="<?php echo $info['id']; ?>" />
            <table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <tr height=20>
    <td></td></tr>
  <tr height=22>
    <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>添加友情链接</td></tr>
  <tr bgColor=#ecf4fc height=12>
    <td></td></tr>
  </table>
<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">  
                                    <tbody>
                                    <tr bgcolor="#ffffff">
                                        <td height="25" align="right" width="12%">
                                          <span class="redtxt">*</span> 网站名：</td>
                                      <td width="89%" height="25" colspan="3">&nbsp;<input type="text" id="webname" maxlength="50" name="webname" value="<?php echo $info['webname']; ?>"/></td>
                                      </tr>
                                    <tr bgcolor="#ffffff">
                                        <td height="25" align="right" width="12%">
                                            <span class="redtxt">*</span>网址：</td>
                                        <td height="25" colspan="3" style="font-weight: bold; width: 45%;">
                                            &nbsp;<input name="weburl" type="text" id="weburl" size="50" maxlength="100" value="<?php echo $info['weburl']; ?>">
                                            (如:http://baidu.com)</td>
                                      </tr>
                                    <tr bgcolor="#ffffff">
                                        <td height="25" align="right" width="12%">网站logo：</td>
                                        <td height="25" colspan="3" style="width: 45%;"><table border="0" cellspacing="1" cellpadding="3">
                                          <tr>
                                            <td><table width="100" border="0" cellspacing="1" cellpadding="3" bgcolor="#33CCFF">
                                              <tr>
                                                <td><span style="color:white">当前缩略图</span></td>
                                              </tr>
                                              <tr>
                                                <td bgcolor="#FFFFFF"><?php if(strlen($info['logo'])>0){echo "<img src='../uploads/flink/".$info['logo']."'>";}?></td>
                                              </tr>
                                            </table>
                                              <input type="file" size="40" name="logo" id="logo" />
                                              (默认大小：宽<?php echo $flinklogowidth ?>*高<?php echo $flinklogoheight ?>)</td>
                                          </tr>
                                        </table></td>
                                      </tr>
                                    <tr bgcolor="#ffffff">
                                      <td height="25" align="right">&nbsp;</td>
                                      <td height="25" colspan="3" style="width: 45%;"><input type="submit" name="Button1" value="<?php echo $subtxt; ?>" id="Button1" />
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

                                            &nbsp;
                                      <input type="reset" name="Button3" value="重置" id="Button3"  /></td>
                                    </tr>                                 
                                </tbody>
                                </table></form>
</div>
</body>
</html>
