<?php /* Smarty version 2.6.25, created on 2011-04-23 13:27:30
         compiled from header.html */ ?>
<div class="header clearfix">
  <div class="clearfix"><a href="http://www.dcrcms.com" title="稻草人官方网站" target="_blank"><img src="<?php echo $this->_tpl_vars['web_templeturl']; ?>
<?php echo $this->_tpl_vars['web_templetdir']; ?>
/images/banner.gif" width="900" height="120" alt="稻草人企业管理系统" /></a></div>
  <div class="navdiv">
  	<div class="searchbar"><form action="search.php"><input type="text" name="k" class="txt" />
  	  <select name="s_type" id="s_type">
  	    <option value="1">产品</option>
  	    <option value="2">新闻</option>
	    </select>
  	  <input type="submit" name="button" id="button" value="搜索" />
    </form></div>
    <ul id="nav">
      <li class="nav_li_1 top"><a href="<?php echo $this->_tpl_vars['web_url']; ?>
/about.<?php echo $this->_tpl_vars['web_url_surfix']; ?>
">关于我们</a></li>
      <li class="nav_li_2 top"><a href="<?php echo $this->_tpl_vars['web_url']; ?>
/news_list.<?php echo $this->_tpl_vars['web_url_surfix']; ?>
">新闻动态</a>
      <?php if ($this->_tpl_vars['news_class_list']): ?>
      	<ul class="sub">
            <?php unset($this->_sections['arr']);
$this->_sections['arr']['name'] = 'arr';
$this->_sections['arr']['loop'] = is_array($_loop=$this->_tpl_vars['news_class_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            <li><a href="<?php echo $this->_tpl_vars['news_class_list'][$this->_sections['arr']['index']]['url']; ?>
"><?php echo $this->_tpl_vars['news_class_list'][$this->_sections['arr']['index']]['classname']; ?>
</a></li>
            <?php endfor; endif; ?>
		</ul>
      <?php endif; ?>
      </li>
      <li class="nav_li_3 top"><a href="<?php echo $this->_tpl_vars['web_url']; ?>
/product_list.<?php echo $this->_tpl_vars['web_url_surfix']; ?>
">产品展示</a>
      <?php if ($this->_tpl_vars['productClassList']): ?>
      	<ul class="sub">
            <?php unset($this->_sections['arr']);
$this->_sections['arr']['name'] = 'arr';
$this->_sections['arr']['loop'] = is_array($_loop=$this->_tpl_vars['productClassList']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            <li><a href="<?php echo $this->_tpl_vars['productClassList'][$this->_sections['arr']['index']]['url']; ?>
"><?php echo $this->_tpl_vars['productClassList'][$this->_sections['arr']['index']]['classname']; ?>
</a></li>              
            <?php endfor; endif; ?>
		</ul>
      <?php endif; ?>
      </li>
      <li class="nav_li_1 top"><a href="<?php echo $this->_tpl_vars['web_url']; ?>
/lxwm.<?php echo $this->_tpl_vars['web_url_surfix']; ?>
">联系我们</a></li>
      <li class="nav_li_5 top"><a href="<?php echo $this->_tpl_vars['web_url']; ?>
/hudong.<?php echo $this->_tpl_vars['web_url_surfix']; ?>
">在线订单</a></li>
    </ul>
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['web_templeturl']; ?>
<?php echo $this->_tpl_vars['web_templetdir']; ?>
/js/menu.js"></script> 
    <div class="backindex"><a style="color:red" href="<?php echo $this->_tpl_vars['web_url']; ?>
">返回首页</a></div>
  </div>
</div>