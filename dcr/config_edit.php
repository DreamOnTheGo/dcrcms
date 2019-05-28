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
<DIV id="content">
<form action="config_action.php" method="post">
<input type="hidden" name="action" id="action" value="updateconfig">
<UL class=Form_Advance id=FormRegStep1>
  <LI class=Title>修改网站配置</LI>
  <LI class=Seperator>
    <HR>
  </LI>
  <LI>
  <DIV class=Hint>网址地址：</DIV>
  <DIV class=FormInput>
    <input id="web_url_new" size="24" class="Warning" name="web_url_new"  value="<?php echo str_replace($web_dir,'',$web_url); ?>" />
  </DIV>
  <div class="Info">
    <div class="alert_txt">网站地址，请不要加/</div>
  </div>
  <DIV class=HackBox></DIV></LI>
  <li>
        <DIV class=Hint>网站目录：</DIV>
        <DIV class=FormInput>
          <input id="web_dir_new" size="24" class="Warning" name="web_dir_new"  value="<?php echo $web_dir; ?>" />
        </DIV>
        <div class="Info">
          <div class="alert_txt">如果您的<span style="color:red;">网站安装在二级目录</span>下，请在这里填写目录名</div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
  <LI>
  <DIV class=Hint>网站名称：</DIV>
  <DIV class=FormInput>
    <input id="web_name_new" size="24" class="Warning" name="web_name_new" value="<?php echo $web_name ?>" />
  </DIV>
  <div class="Info">
    <div class="alert_txt">网站名称</div>
  </div>
  <DIV class=HackBox></DIV></LI>
  <LI>
  <DIV class=Hint>网址模式：</DIV>
  <DIV class=FormInput>
    <input type="radio" <?php if($web_url_module=='1'){ ?> checked="checked"<?php } ?> style="width:15px; height:20px; border:none; background-image:none" name="web_url_module_new" id="radio" value="1" />
    动态
    <input type="radio" <?php if($web_url_module=='2'){ ?> checked="checked"<?php } ?> style="width:15px; height:20px; border:none; background-image:none" name="web_url_module_new" id="radio" value="2" />
    伪静态
  </DIV>
  <div class="Info">
    <div class="alert_txt">这里选择你的网站是用动态还是伪静态</div>
  </div>
  <DIV class=HackBox></DIV></LI>
  <LI class=Seperator>
    <HR>
  </LI><LI>
    <DIV class=Hint>网站调试：</DIV>
    <DIV class=FormInput>
    
    <input type="radio" <?php if($web_tiaoshi=='1'){ ?> checked="checked"<?php } ?> style="width:15px; height:20px; border:none; background-image:none" name="web_tiaoshi_new" id="radio" value="1" />
    开
    <input type="radio" <?php if($web_tiaoshi=='0'){ ?> checked="checked"<?php } ?> style="width:15px; height:20px; border:none; background-image:none" name="web_tiaoshi_new" id="radio" value="0" />
    关
      </DIV>
    <div class="Info">
      <div class="alert_txt">这是为了方便开发者 如果写1表示网站在调试阶段。调试阶段可以方便的显示出各种错误。当调试完毕后，请把这个变量设置为0关闭调试。</div>
      </div>
    <DIV class=HackBox></DIV></LI>
  <li class="Seperator"><hr></li>
  <LI class=SubmitBox><INPUT class="btn" type=submit value="修改配置" name=Submit></LI></UL>
 </form>
</DIV>
 </BODY></HTML>