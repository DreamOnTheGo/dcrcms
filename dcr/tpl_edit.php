<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
</HEAD>
<BODY>
<DIV id="content">
<form action="config_action.php" method="post">
<input type="hidden" name="action" id="action" value="updateconfig_tpl">
<UL class=Form_Advance id=FormRegStep1>
  <LI class=Title>��վģ������</LI>
  <li class="Seperator"><hr></li>
  <li>
    <div class="Hint">ģ��Ŀ¼��</div><div class="FormInput"><input id="tpl_dir_new" size="24" name="tpl_dir_new" value="<?php echo $tpl_dir ?>"/></div><div class="Info">
      <div class="alert_txt">��վģ��Ŀ¼</div></div>
    <div class="HackBox"></div>
  </li>
  <li>
    <div class="Hint">ģ�建��ʱ�䣺</div><div class="FormInput"><input id="web_cache_time_new" size="24" name="web_cache_time_new" value="<?php echo $web_cache_time ?>"/></div><div class="Info">
      <div class="alert_txt">ģ�建��ʱ��,����Ϊ0ʱ��ʾ�رջ��� ���������ֵ����<a href="cache_clear.php">����»���</a></div></div>
    <div class="HackBox"></div>
  </li>
  <li class="Seperator"><hr></li>
  <LI>
  <DIV class=Hint>��������ͼ��</DIV>
  <DIV class=FormInput>
    <input id="newslogowidth_new" size="24" class="Warning" name="newslogowidth_new" value="<?php echo $newslogowidth ?>" />
  </DIV>
  <div class="Info">
    <div class="alert_txt"><span class="Hint">��������ͼ��</span></div>
  </div>
  <DIV class=HackBox></DIV></LI>
  <LI>
  <DIV class=Hint>��������ͼ�ߣ�</DIV>
  <DIV class=FormInput>
    <input id="newslogoheight_new" size="24" class="Warning" name="newslogoheight_new" value="<?php echo $newslogoheight ?>" />
  </DIV>
  <div class="Info">
    <div class="alert_txt"><span class="Hint">��������ͼ��</span></div>
  </div>
  <DIV class=HackBox></DIV></LI>
  <li class="Seperator"><hr></li>
  <LI>
  <DIV class=Hint>��Ʒ����ͼ��</DIV>
  <DIV class=FormInput>
    <input id="prologowidth_new" size="24" class="Warning" name="prologowidth_new" value="<?php echo $prologowidth ?>" />
  </DIV>
  <div class="Info">
    <div class="alert_txt"><span class="Hint">��Ʒ����ͼ��</span></div>
  </div>
  <DIV class=HackBox></DIV></LI>
  <LI>
  <DIV class=Hint>��Ʒ����ͼ�ߣ�</DIV>
  <DIV class=FormInput>
    <input id="prologoheight_new" size="24" class="Warning" name="prologoheight_new" value="<?php echo $prologoheight ?>" />
  </DIV>
  <div class="Info">
    <div class="alert_txt"><span class="Hint">��Ʒ����ͼ��</span></div>
  </div>
  <DIV class=HackBox></DIV></LI>
  <li class="Seperator"><hr></li>
  <li><DIV class=Hint>��ҳ����������</DIV><DIV class=FormInput><input id="index_news_count_new" size="24" class="Warning" name="index_news_count_new" value="<?php echo $index_news_count ?>" /></DIV><div class="Info"><div class="alert_txt"><span class="Hint">��ҳ�е��õ���������,������������ҳ�е���10��������Ϊ10</span></div></div><DIV class=HackBox></DIV></li>
  <li><DIV class=Hint>��ҳ��Ʒ������</DIV><DIV class=FormInput><input id="index_product_count_new" size="24" class="Warning" name="index_product_count_new" value="<?php echo $index_product_count ?>" /></DIV><div class="Info"><div class="alert_txt"><span class="Hint">��ҳ�е��õĲ�Ʒ����,������������ҳ�е���10��������Ϊ10</span></div></div><DIV class=HackBox></DIV></li>
  <li class="Seperator"><hr></li>
  <li>
    <DIV class=Hint>�����б�ҳÿҳ��������</DIV><DIV class=FormInput><input id="list_news_count_new" size="24" class="Warning" name="list_news_count_new" value="<?php echo $list_news_count ?>" /></DIV><div class="Info"><div class="alert_txt"></div></div><DIV class=HackBox></DIV></li>  
  <li class="Seperator"><hr></li>
  <li>
    <DIV class=Hint>��Ʒ�б�ҳÿҳ��Ʒ����</DIV><DIV class=FormInput><input id="list_product_count_new" size="24" class="Warning" name="list_product_count_new" value="<?php echo $list_product_count ?>" /></DIV><div class="Info"><div class="alert_txt"></div></div><DIV class=HackBox></DIV></li>  
  <li class="Seperator"><hr></li>
    
  <LI class=SubmitBox><INPUT class="btn" type=submit value="�޸�����" name=Submit></LI></UL>
 </form>
</DIV>
 </BODY></HTML>