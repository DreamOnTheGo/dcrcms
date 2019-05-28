<?php
include "../include/common.inc.php";
session_start();
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
</HEAD>
<BODY>
<DIV id="content">
<form action="watermark_action.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="action" id="action" value="cfg_watermark">
<UL class=Form_Advance id=FormRegStep1>
  <LI class=Title>修改水印配置</LI>
  <LI class=Seperator>
    <HR>
  </LI>
  <LI>
    <DIV class=Hint>水印类型：</DIV>
    <DIV class=FormInput>
      <input type="radio" <?php if($web_watermark_type == '0'){ ?> checked="checked"<?php } ?> style="width:15px; height:20px; border:none; background-image:none" name="web_watermark_type_new" id="radio5" value="0" />
无
<input type="radio" <?php if($web_watermark_type == '1'){ ?> checked="checked"<?php } ?> style="width:15px; height:20px; border:none; background-image:none" name="web_watermark_type_new" id="radio6" value="1" />
图片
<input type="radio" <?php if($web_watermark_type == '2'){ ?> checked="checked"<?php } ?> style="width:15px; height:20px; border:none; background-image:none" name="web_watermark_type_new" id="radio" value="2" />
      文字
      </DIV>
    <div class="Info">
      <div class="alert_txt">水印的类型</div>
      </div>
    <DIV class=HackBox></DIV></LI>
  <LI class=Seperator>
    <HR>
  </LI><LI>
    <DIV class=Hint>文字内容：</DIV>
    <DIV class=FormInput>
      <input type="text" name="web_watermark_txt_new" id="web_watermark_txt_new" value="<?php echo $web_watermark_txt; ?>" />
    </DIV>
    <div class="Info">
      <div class="alert_txt"><span class="Hint"><?php if(!file_exists(WEB_INCLUDE.'watermark/ziti.ttf')){echo "<span style='color:red;'>字体不存在</span>";}else{echo "<span style='color:green;'>字体已存在</span>";} ?>
        (如果要用文字水印,请把字体文件上传到include/watermark/ziti.ttf,默认情况下windows上的字体可以到C:\Windows\Fonts下找，改成ziti.ttf传include/watermark/ziti.ttf就OK了)</span></div>
      </div>
    <DIV class=HackBox></DIV></LI>
  <li class="Seperator"><hr></li><LI>
    <DIV class=Hint>水印图片：</DIV>
    <DIV class=FormInput>
      <input type="file" name="web_watermark_logo_new" id="web_watermark_logo_new" />
    </DIV>
    <div class="Info">
      <div class="alert_txt"><span class="Hint"><?php if(!file_exists(WEB_INCLUDE.'watermark/watermark.gif')){echo "<span style='color:red;'>图片不存在</span>";}else{echo "<span style='color:green;'>图片已存在</span>";} ?>水印图片</span></div>
      </div>
    <DIV class=HackBox></DIV></LI>
  <li class="Seperator"><hr></li>
  <LI>
    <DIV class=Hint>水印位置：</DIV>
    <DIV class=FormInput>
      <input type="radio" <?php if($web_watermark_weizhi=='1'){ ?> checked="checked"<?php } ?> style="width:15px; height:20px; border:none; background-image:none" name="web_watermark_weizhi_new" id="radio2" value="1" />
      左上
      <input type="radio" <?php if($web_watermark_weizhi=='2'){ ?> checked="checked"<?php } ?> style="width:15px; height:20px; border:none; background-image:none" name="web_watermark_weizhi_new" id="radio2" value="2" />
      右上 
      <input type="radio" <?php if($web_watermark_weizhi=='3'){ ?> checked="checked"<?php } ?> style="width:15px; height:20px; border:none; background-image:none" name="web_watermark_weizhi_new" id="radio3" value="3" />
      左下
      <input type="radio" <?php if($web_watermark_weizhi=='4'){ ?> checked="checked"<?php } ?> style="width:15px; height:20px; border:none; background-image:none" name="web_watermark_weizhi_new" id="radio3" value="4" />
      右下 
      <input type="radio" <?php if($web_watermark_weizhi=='5'){ ?> checked="checked"<?php } ?> style="width:15px; height:20px; border:none; background-image:none" name="web_watermark_weizhi_new" id="radio4" value="5" /> 
      中
</DIV>
    <div class="Info">
      <div class="alert_txt">水印在图片上的位置<a href="http://www.dcrcms.com/news.php?id=33" target="_blank"></a></div>
      </div>
    <DIV class=HackBox></DIV></LI>
  <li class="Seperator"><hr></li>
  <LI class=SubmitBox><INPUT class="btn" type=submit value="修改配置" name=Submit></LI></UL>
 </form>
</DIV>
 </BODY></HTML>