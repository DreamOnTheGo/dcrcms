<?php /* Smarty version 2.6.25, created on 2011-04-23 13:27:30
         compiled from index.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $this->_tpl_vars['web_name']; ?>
</title>
<meta name="keywords" content="��������ҵվ����ϵͳ"/>
<meta name="description" content="��������ҵվ����ϵͳ"/>
<link href="<?php echo $this->_tpl_vars['web_templeturl']; ?>
<?php echo $this->_tpl_vars['web_templetdir']; ?>
/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['web_templeturl']; ?>
<?php echo $this->_tpl_vars['web_templetdir']; ?>
/js/jquery.js"></script>
</head>
<body>
<div class="wrap"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <div class="con clearfix">
    <div id="con_l"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "left.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
    <div id="con_main">
      <div class="introduce b_b_2 clearfix"> <img class="i_img" src="<?php echo $this->_tpl_vars['web_templeturl']; ?>
<?php echo $this->_tpl_vars['web_templetdir']; ?>
/images/introduce.jpg" width="160" height="118" />
        <div class="i_content">��������ҵվ����ϵͳ����php+sqlite��php+mysql�����汾��php+sqlite�ص��asp+access���,�ŵ������ڱ��ݣ����ڴ����վ�ռ䶼֧��php+sqlite��php+mysql�ص������ڴ�����������ݣ������ݺͻ�ԭ�����㡣</div>
      </div>
      <div class="news b_b_2 clearfix mt10">
        <div class="newsb clearfix">
        <div class="hd">
          <div id=playerBox>
            <div id=playerImage>
              <ul>
          		<?php unset($this->_sections['arr']);
$this->_sections['arr']['name'] = 'arr';
$this->_sections['arr']['loop'] = is_array($_loop=$this->_tpl_vars['tw_news_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['arr']['show'] = true;
$this->_sections['arr']['max'] = $this->_sections['arr']['loop'];
$this->_sections['arr']['step'] = 1;
$this->_sections['arr']['start'] = $this->_sections['arr']['step'] > 0 ? 0 : $this->_sections['arr']['loop']-1;
if ($this->_sections['arr']['show']) {
    $this->_sections['arr']['total'] = $this->_sections['arr']['loop'];
    if ($this->_sections['arr']['total'] == 0)
        $this->_sections['arr']['show'] = false;
} else
    $this->_sections['arr']['total'] = 0;
if ($this->_sections['arr']['show']):

            for ($this->_sections['arr']['index'] = $this->_sections['arr']['start'], $this->_sections['arr']['iteration'] = 1;
                 $this->_sections['arr']['iteration'] <= $this->_sections['arr']['total'];
                 $this->_sections['arr']['index'] += $this->_sections['arr']['step'], $this->_sections['arr']['iteration']++):
$this->_sections['arr']['rownum'] = $this->_sections['arr']['iteration'];
$this->_sections['arr']['index_prev'] = $this->_sections['arr']['index'] - $this->_sections['arr']['step'];
$this->_sections['arr']['index_next'] = $this->_sections['arr']['index'] + $this->_sections['arr']['step'];
$this->_sections['arr']['first']      = ($this->_sections['arr']['iteration'] == 1);
$this->_sections['arr']['last']       = ($this->_sections['arr']['iteration'] == $this->_sections['arr']['total']);
?>
                <li <?php if ($this->_tpl_vars['tw_news_list'][$this->_sections['arr']['index']]['innerkey'] != '1'): ?> class="hide"<?php endif; ?>><img alt="<?php echo $this->_tpl_vars['tw_news_list'][$this->_sections['arr']['index']]['title']; ?>
" src="<?php echo $this->_tpl_vars['tw_news_list'][$this->_sections['arr']['index']]['logo']; ?>
"></li>
          		<?php endfor; endif; ?>
              </UL>
            </DIV>
            <div id=playerNavAndTitle>
              <div id=playerTitle>
          		<?php unset($this->_sections['arr']);
$this->_sections['arr']['name'] = 'arr';
$this->_sections['arr']['loop'] = is_array($_loop=$this->_tpl_vars['tw_news_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['arr']['show'] = true;
$this->_sections['arr']['max'] = $this->_sections['arr']['loop'];
$this->_sections['arr']['step'] = 1;
$this->_sections['arr']['start'] = $this->_sections['arr']['step'] > 0 ? 0 : $this->_sections['arr']['loop']-1;
if ($this->_sections['arr']['show']) {
    $this->_sections['arr']['total'] = $this->_sections['arr']['loop'];
    if ($this->_sections['arr']['total'] == 0)
        $this->_sections['arr']['show'] = false;
} else
    $this->_sections['arr']['total'] = 0;
if ($this->_sections['arr']['show']):

            for ($this->_sections['arr']['index'] = $this->_sections['arr']['start'], $this->_sections['arr']['iteration'] = 1;
                 $this->_sections['arr']['iteration'] <= $this->_sections['arr']['total'];
                 $this->_sections['arr']['index'] += $this->_sections['arr']['step'], $this->_sections['arr']['iteration']++):
$this->_sections['arr']['rownum'] = $this->_sections['arr']['iteration'];
$this->_sections['arr']['index_prev'] = $this->_sections['arr']['index'] - $this->_sections['arr']['step'];
$this->_sections['arr']['index_next'] = $this->_sections['arr']['index'] + $this->_sections['arr']['step'];
$this->_sections['arr']['first']      = ($this->_sections['arr']['iteration'] == 1);
$this->_sections['arr']['last']       = ($this->_sections['arr']['iteration'] == $this->_sections['arr']['total']);
?>
              	<a target="_blank" title="<?php echo $this->_tpl_vars['tw_news_list'][$this->_sections['arr']['index']]['title']; ?>
" href="<?php echo $this->_tpl_vars['tw_news_list'][$this->_sections['arr']['index']]['url']; ?>
"><?php echo $this->_tpl_vars['tw_news_list'][$this->_sections['arr']['index']]['title']; ?>
</a>
          		<?php endfor; endif; ?>
              </div>
              <div id=playerNav></div>
            </div>
          </div>
          <script type="text/javascript" src="<?php echo $this->_tpl_vars['web_templeturl']; ?>
<?php echo $this->_tpl_vars['web_templetdir']; ?>
/js/player.js"></script>
        </div>
        <ul class="indexnewslist clearfix">
          <?php unset($this->_sections['arr']);
$this->_sections['arr']['name'] = 'arr';
$this->_sections['arr']['loop'] = is_array($_loop=$this->_tpl_vars['newslist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['arr']['show'] = true;
$this->_sections['arr']['max'] = $this->_sections['arr']['loop'];
$this->_sections['arr']['step'] = 1;
$this->_sections['arr']['start'] = $this->_sections['arr']['step'] > 0 ? 0 : $this->_sections['arr']['loop']-1;
if ($this->_sections['arr']['show']) {
    $this->_sections['arr']['total'] = $this->_sections['arr']['loop'];
    if ($this->_sections['arr']['total'] == 0)
        $this->_sections['arr']['show'] = false;
} else
    $this->_sections['arr']['total'] = 0;
if ($this->_sections['arr']['show']):

            for ($this->_sections['arr']['index'] = $this->_sections['arr']['start'], $this->_sections['arr']['iteration'] = 1;
                 $this->_sections['arr']['iteration'] <= $this->_sections['arr']['total'];
                 $this->_sections['arr']['index'] += $this->_sections['arr']['step'], $this->_sections['arr']['iteration']++):
$this->_sections['arr']['rownum'] = $this->_sections['arr']['iteration'];
$this->_sections['arr']['index_prev'] = $this->_sections['arr']['index'] - $this->_sections['arr']['step'];
$this->_sections['arr']['index_next'] = $this->_sections['arr']['index'] + $this->_sections['arr']['step'];
$this->_sections['arr']['first']      = ($this->_sections['arr']['iteration'] == 1);
$this->_sections['arr']['last']       = ($this->_sections['arr']['iteration'] == $this->_sections['arr']['total']);
?>
          <li class="nl"><a target="_blank" href="<?php echo $this->_tpl_vars['newslist'][$this->_sections['arr']['index']]['url']; ?>
"><?php echo $this->_tpl_vars['newslist'][$this->_sections['arr']['index']]['title']; ?>
</a></li>
          <?php endfor; endif; ?>
        </ul>
        </div>
      </div>      
      <div class="products">
        <div class="title"><span><a href="<?php echo $this->_tpl_vars['web_url']; ?>
/product_list.php"><img src="<?php echo $this->_tpl_vars['web_templeturl']; ?>
<?php echo $this->_tpl_vars['web_templetdir']; ?>
/images/more.gif" width="38" height="13" /></a></span><img src="<?php echo $this->_tpl_vars['web_templeturl']; ?>
<?php echo $this->_tpl_vars['web_templetdir']; ?>
/images/products.gif" width="200" height="22" /></div>
        <div class="productb clearfix"> <?php unset($this->_sections['arr']);
$this->_sections['arr']['name'] = 'arr';
$this->_sections['arr']['loop'] = is_array($_loop=$this->_tpl_vars['prolist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['arr']['show'] = true;
$this->_sections['arr']['max'] = $this->_sections['arr']['loop'];
$this->_sections['arr']['step'] = 1;
$this->_sections['arr']['start'] = $this->_sections['arr']['step'] > 0 ? 0 : $this->_sections['arr']['loop']-1;
if ($this->_sections['arr']['show']) {
    $this->_sections['arr']['total'] = $this->_sections['arr']['loop'];
    if ($this->_sections['arr']['total'] == 0)
        $this->_sections['arr']['show'] = false;
} else
    $this->_sections['arr']['total'] = 0;
if ($this->_sections['arr']['show']):

            for ($this->_sections['arr']['index'] = $this->_sections['arr']['start'], $this->_sections['arr']['iteration'] = 1;
                 $this->_sections['arr']['iteration'] <= $this->_sections['arr']['total'];
                 $this->_sections['arr']['index'] += $this->_sections['arr']['step'], $this->_sections['arr']['iteration']++):
$this->_sections['arr']['rownum'] = $this->_sections['arr']['iteration'];
$this->_sections['arr']['index_prev'] = $this->_sections['arr']['index'] - $this->_sections['arr']['step'];
$this->_sections['arr']['index_next'] = $this->_sections['arr']['index'] + $this->_sections['arr']['step'];
$this->_sections['arr']['first']      = ($this->_sections['arr']['iteration'] == 1);
$this->_sections['arr']['last']       = ($this->_sections['arr']['iteration'] == $this->_sections['arr']['total']);
?>
          <dl>
            <dd><a title="<?php echo $this->_tpl_vars['prolist'][$this->_sections['arr']['index']]['title']; ?>
" href="<?php echo $this->_tpl_vars['prolist'][$this->_sections['arr']['index']]['url']; ?>
" target=_blank><img src="<?php echo $this->_tpl_vars['prolist'][$this->_sections['arr']['index']]['logo']; ?>
" width="180" height="140" /></a></dd>
            <dt><a title="<?php echo $this->_tpl_vars['prolist'][$this->_sections['arr']['index']]['title']; ?>
" href="<?php echo $this->_tpl_vars['prolist'][$this->_sections['arr']['index']]['url']; ?>
" target=_blank><?php echo $this->_tpl_vars['prolist'][$this->_sections['arr']['index']]['title']; ?>
</a></dt>
          </dl>
          <?php endfor; endif; ?> </div>
      </div>
    </div>
  </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>