<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="css/admin.css" type="text/css" rel="stylesheet">

</head>
<body>
<div id="content">
<form action="config_action.php" method="post">
<input type="hidden" name="action" id="action" value="updateconfig_tpl">
<ul class=Form_Advance id=FormRegStep1>
  <li class=Title>网站模板配置</li>
  <li class="Seperator"><hr></li>
  <li>
    <div class="Hint">模板目录：</div><div class="FormInput"><input id="tpl_dir_new" size="24" name="tpl_dir_new" value="<?php echo $tpl_dir ?>"/></div><div class="Info">
      <div class="alert_txt">网站模板目录</div></div>
    <div class="HackBox"></div>
  </li>
  <li>
    <div class="Hint">模板缓存时间：</div><div class="FormInput"><input id="web_cache_time_new" size="24" name="web_cache_time_new" value="<?php echo $web_cache_time ?>"/></div><div class="Info">
      <div class="alert_txt">模板缓存时间,设置为0时表示关闭缓存 更新这个数值后请<a href="cache_clear.php">清空下缓存</a></div></div>
    <div class="HackBox"></div>
  </li>
  <li class="Seperator"><hr></li>
  <li>
  <div class=Hint>新闻缩略图宽：</div>
  <div class=FormInput>
    <input id="newslogowidth_new" size="24" class="Warning" name="newslogowidth_new" value="<?php echo $newslogowidth ?>" />
  </div>
  <div class="Info">
    <div class="alert_txt"><span class="Hint">文章缩略图宽</span></div>
  </div>
  <div class=HackBox></div></li>
  <li>
  <div class=Hint>新闻缩略图高：</div>
  <div class=FormInput>
    <input id="newslogoheight_new" size="24" class="Warning" name="newslogoheight_new" value="<?php echo $newslogoheight ?>" />
  </div>
  <div class="Info">
    <div class="alert_txt"><span class="Hint">文章缩略图高</span></div>
  </div>
  <div class=HackBox></div></li>
  <li class="Seperator"><hr></li>
  <li>
  <div class=Hint>产品缩略图宽：</div>
  <div class=FormInput>
    <input id="prologowidth_new" size="24" class="Warning" name="prologowidth_new" value="<?php echo $prologowidth ?>" />
  </div>
  <div class="Info">
    <div class="alert_txt"><span class="Hint">产品缩略图宽</span></div>
  </div>
  <div class=HackBox></div></li>
  <li>
  <div class=Hint>产品缩略图高：</div>
  <div class=FormInput>
    <input id="prologoheight_new" size="24" class="Warning" name="prologoheight_new" value="<?php echo $prologoheight ?>" />
  </div>
  <div class="Info">
    <div class="alert_txt"><span class="Hint">产品缩略图高</span></div>
  </div>
  <div class=HackBox></div></li>
  <li class="Seperator"><hr></li>  <li>
  <div class=Hint>友情链接缩略图宽：</div>
  <div class=FormInput>
    <input id="flinklogowidth_new" size="24" class="Warning" name="flinklogowidth_new" value="<?php echo $flinklogowidth ?>" />
  </div>
  <div class="Info">
    <div class="alert_txt"><span class="Hint">友情链接缩略图宽</span></div>
  </div>
  <div class=HackBox></div></li>
  <li>
  <div class=Hint>友情链接缩略图高：</div>
  <div class=FormInput>
    <input id="flinklogoheight_new" size="24" class="Warning" name="flinklogoheight_new" value="<?php echo $flinklogoheight ?>" />
  </div>
  <div class="Info">
    <div class="alert_txt"><span class="Hint">友情链接缩略图高</span></div>
  </div>
  <div class=HackBox></div></li>
  <li class="Seperator"><hr></li>
  <li><div class=Hint>首页新闻条数：</div><div class=FormInput><input id="index_news_count_new" size="24" class="Warning" name="index_news_count_new" value="<?php echo $index_news_count ?>" /></div><div class="Info"><div class="alert_txt"><span class="Hint">首页中调用的新闻数量,比如你想在首页中调用10条则设置为10</span></div></div><div class=HackBox></div></li>
  <li><div class=Hint>首页产品条数：</div><div class=FormInput><input id="index_product_count_new" size="24" class="Warning" name="index_product_count_new" value="<?php echo $index_product_count ?>" /></div><div class="Info"><div class="alert_txt"><span class="Hint">首页中调用的产品数量,比如你想在首页中调用10条则设置为10</span></div></div><div class=HackBox></div></li>
  <li class="Seperator"><hr></li>
  <li>
    <div class=Hint>新闻列表页每页新闻数：</div><div class=FormInput><input id="list_news_count_new" size="24" class="Warning" name="list_news_count_new" value="<?php echo $list_news_count ?>" /></div><div class="Info"><div class="alert_txt"></div></div><div class=HackBox></div></li>  
  <li class="Seperator"><hr></li>
  <li>
    <div class=Hint>产品列表页每页产品数：</div><div class=FormInput><input id="list_product_count_new" size="24" class="Warning" name="list_product_count_new" value="<?php echo $list_product_count ?>" /></div><div class="Info"><div class="alert_txt"></div></div><div class=HackBox></div></li>  
  <li class="Seperator"><hr></li>
    
  <li class=SubmitBox><input class="btn" type=submit value="修改配置" name=Submit></li></ul>
 </form>
</div>
 </body></html>