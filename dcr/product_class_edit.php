<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
<?php include "admin_common.php"; ?>
<script type='text/javascript'>
function check(){
	if($("#classname").val().length==0){
		ShowMsg('请输入产品分类名');
		return false;
	}
}
</script>

</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <TR height=28>
    <TD background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;添加产品分类</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>添加产品分类</TD></TR>
  <TR bgColor=#ecf4fc height=12>
    <TD></TD></TR>
  </TABLE>
<?php
	include WEB_CLASS."/product_class.php";
	$p=new Product(0);
	if($action=='add'){
	}else{
		$action='modify';
		$id=isset($id)?(int)$id:0;
		if($id!=0){			
			$productClassInfo=$p->GetClassInfo($id);
		}else{
			ShowMsg('您没有选择要修改的文档');
		}
	}
?>
<form action="product_class_action.php" method="post" onsubmit="return check();">
<input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
<input type="hidden" name="id" id="id" value="<?php echo $productClassInfo['id']; ?>">
<table width="95%" align="center" border="0" cellspacing="1" cellpadding="5" bgcolor="#4776BE" class="itemtable">
    <tr>
      <td width="18%" align="right" bgcolor="#FFFFFF">分类名：</td>
      <td width="82%" bgcolor="#FFFFFF"><input name="classname" type="text" id="classname" value="<?php echo $productClassInfo['classname']; ?>" />
        <span class="txtRed">*</span>(20个字以内)</td>
      </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF">上级分类：</td>
      <td bgcolor="#FFFFFF">
      <?php
        	$class_list=$p->GetClassList(array('id','classname','parentid'));
	  ?>
      <select name="parentid" id="parentid">
        <option value="0">顶级分类</option>
        <?php
            foreach($class_list as $value){
        ?>
        <option value="<?php echo $value['id'] ?>" <?php if($value['id']==$parentid || $productClassInfo['parentid']==$value['id']){ ?>selected="selected" <?php } ?>><?php echo $value['classname'] ?></option>
        	<?php if(is_array($value['sub']) && count($value['sub'])){ ?>
				<?php
                    foreach($value['sub'] as $subvalue){
                ?>
                <option value="<?php echo $subvalue['id'] ?>" <?php if($subvalue['id']==$parentid || $productClassInfo['parentid']==$subvalue['id']){ ?>selected="selected" <?php } ?>>----<?php echo $subvalue['classname'] ?></option>  
        <?php }?>
        <?php }?>
        <?php }?>
      </select></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF">排序：</td>
      <td bgcolor="#FFFFFF"><input name="orderid" type="text" id="orderid" value="<?php echo $productClassInfo['orderid']; ?>" /></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF">分类描述：</td>
      <td bgcolor="#FFFFFF"><textarea name="classdescription" cols="80" rows="5" id="classdescription"><?php echo $productClassInfo['classdescription']; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="button" id="button" value="<?php if($action=='add'){echo '添加分类';}else{echo '编辑分类';} ?>" /></td>
    </tr>
  </table>
 </form>
 </BODY></HTML>