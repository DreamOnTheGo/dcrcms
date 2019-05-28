<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">

</HEAD>
<BODY>
<?php
	if($id!=0){			
		include WEB_CLASS."/hudong_class.php";
		$hudong=new HuDong();
		$hudonginfo=$hudong->GetInfo($id);
		if($hudonginfo['type']==1){
			$action='change_type_2';
			$frmSubmitTxt='设置为已处理';
		}else{
			$action='change_type_1';
			$frmSubmitTxt='设置为未处理';
		}
	}else{
		$errormsg[]='您没有选择要修改的文档';
		ShowMsg($errormsg,2);
	}
?>
<DIV id="content">
<form action="hudong_action.php" method="post">
<input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
<input type="hidden" name="id" id="id" value="<?php echo $hudonginfo['id']; ?>">
<UL class=Form_Advance id=FormRegStep1>
  <LI class=Title>订单信息</LI>
  <li class="Seperator"><hr></li>
  <?php
  	$fieldList=$hudong->GetFiledList(array('fieldname','itemname'));
	foreach($fieldList as $value){
  ?>
  <li class="Seperator"><hr></li>
  <LI>
  <DIV class=Hint><?php echo $value['itemname']; ?>：</DIV>
  <DIV class=Input><span style="COLOR: #880000"><?php echo $hudonginfo[$value['fieldname']]; ?></span></DIV>
  <DIV class=HackBox></DIV></LI>  
  <?php } ?>
  <li class="Seperator"><hr></li>
  <LI>
  <DIV class=Hint>加入时间：</DIV>
  <DIV class=Input><span style="COLOR: #880000"><?php echo $hudonginfo['updatetime']; ?></span></DIV>
  <DIV class=HackBox></DIV></LI>
  <li class="Seperator"><hr></li>
  <LI class=SubmitBox><INPUT class="btn" type=submit value="<?php echo $frmSubmitTxt; ?>订单" name=Submit></LI></UL>
 </form>
</DIV>
 </BODY></HTML>