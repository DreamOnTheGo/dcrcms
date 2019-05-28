<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>杭州合才企业管理有限公司</title>
<link href="css/admin.css" type="text/css" rel="stylesheet" />
<style>
.redtxt{color:red;}
</style>
<?php include "admin_common.php"; ?>
<script type='text/javascript'>
function check(){
	if($("#webname").val().length==0){
		ShowMsg('请输入网站名');
		return false;
	}
	if($("#weburl").val().length==0){
		ShowMsg('请输入网址');
		return false;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<div id="page" style="margin:10px">
  <?php
	$info=array();
	if($action=='editflink')
	{
		include WEB_CLASS.'article_class.php';
		$art=new Article('{tablepre}flink');
		$info=$art->GetInfo(array(),"id=$id");
		$subtxt='修改';
	}else
	{
		$action='addflink';
		$subtxt='添加';
	}
	//p_r($info);
?>
  			<form action="flink_action.php" method="post" target="" enctype="multipart/form-data" onsubmit="return check();">
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <input type="hidden" name="id" value="<?php echo $info['id']; ?>" />
            <table cellspacing="1" cellpadding="3" border="0" bgcolor="#dddddd" width="100%" class="aa">
                                    <tbody><tr bgcolor="#f0f0f0">
                                        <td height="25" colspan="4">
                                            &nbsp; <b><font color="#00000">【添加友情链接】</font></b></td>
                                    </tr>
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
                                                <td bgcolor="#FFFFFF"><?php if(strlen($info['logo'])>0){echo "<img src='../uploads/logo/".$info['logo']."'>";}?></td>
                                              </tr>
                                            </table>
                                              <input type="file" size="40" name="logo" id="logo" />
                                              (默认大小：宽<?php echo $flinklogowidth ?>*高<?php echo $flinklogoheight ?>)</td>
                                          </tr>
                                        </table></td>
                                      </tr>                                 
                                </tbody>
                                </table><table bgcolor="#dddddd" border="0" cellpadding="5" cellspacing="1" class="aa" width="100%">

                      <tr align="center" bgcolor="#ffffff">
                                        <td width="100%" height="13">
                                            <input type="submit" name="Button1" value="<?php echo $subtxt; ?>" id="Button1" />
                                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

                                            &nbsp;
            <input type="reset" name="Button3" value="重置" id="Button3"  /></td>
                                    </tr>
                                </table></form>
</div>
</body>
</html>
