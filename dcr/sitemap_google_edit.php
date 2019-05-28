<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
</head>
<BODY>
<DIV id="content">
<form action="sitemap_google_action.php" method="post">
<input type="hidden" name="action" id="action" value="sitemap_google">
<UL class=Form_Advance id=FormRegStep1>
  <LI class=Title>生成Google sitemap</LI>
  <LI class=Seperator>
    <HR>
  </LI>
  <li>
        <DIV class=Hint>sitemap中新闻条数：</DIV>
        <DIV class=FormInput>
          <input id="web_dir_new" size="24" class="Warning" name="web_sitemap_google_news_count_new"  value="<?php echo $web_sitemap_google_news_count; ?>" />
        </DIV>
        <div class="Info">
          <div class="alert_txt"></div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
  <LI>
  <DIV class=Hint>sitemap中产品条数：</DIV>
  <DIV class=FormInput>
    <input name="web_sitemap_google_product_count_new" type="text" class="Warning" id="web_name_new" value="<?php echo $web_sitemap_google_product_count ?>" size="24" />
  </DIV>
  <div class="Info">
    <div class="alert_txt"></div>
  </div>
  <DIV class=HackBox></DIV></LI>
  <li class="Seperator"><hr></li>
  <LI style="margin-left:20px">向Google提交sitemap办法，请在根目录下的robet.txt最后添加一行：<br />
    Sitemap: http://域名/sitemap_google.xml<br />
  就OK了</LI>
  <LI class=SubmitBox><INPUT class="btn" type=submit value="生成" name=Submit></LI></UL>
 </form>
</DIV>
 </BODY></HTML>