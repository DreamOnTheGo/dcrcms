<?php /* Smarty version 2.6.25, created on 2011-04-23 13:27:30
         compiled from left.html */ ?>
<div class="b_b_1"><a href="<?php echo $this->_tpl_vars['web_url']; ?>
/hudong.<?php echo $this->_tpl_vars['web_url_surfix']; ?>
"><img src="<?php echo $this->_tpl_vars['web_templeturl']; ?>
<?php echo $this->_tpl_vars['web_templetdir']; ?>
/images/guestbook.gif" width="200" height="47" /></a></div>
<div class="b_b_1"><a href="<?php echo $this->_tpl_vars['web_url']; ?>
/product_list.<?php echo $this->_tpl_vars['web_url_surfix']; ?>
"><img src="<?php echo $this->_tpl_vars['web_templeturl']; ?>
<?php echo $this->_tpl_vars['web_templetdir']; ?>
/images/produ.jpg" width="200" height="50" /></a></div>
<ul class="prolist">
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
  <li class="clearfix"><a title="显示下级菜单" <?php if ($this->_tpl_vars['productClassList'][$this->_sections['arr']['index']]['sub']): ?>href="javascript:void(0)" onclick="SubNav(<?php echo $this->_tpl_vars['productClassList'][$this->_sections['arr']['index']]['id']; ?>
)"<?php endif; ?>><img class="proliimg" src="<?php echo $this->_tpl_vars['web_templeturl']; ?>
<?php echo $this->_tpl_vars['web_templetdir']; ?>
/images/prolist_li.gif" width="9" height="9" alt="打开下级栏目" /></a>&nbsp;<a href="<?php echo $this->_tpl_vars['productClassList'][$this->_sections['arr']['index']]['url']; ?>
"><?php echo $this->_tpl_vars['productClassList'][$this->_sections['arr']['index']]['classname']; ?>
</a></li>
            	<?php if ($this->_tpl_vars['productClassList'][$this->_sections['arr']['index']]['sub']): ?>
                	<ul class="subclass" id="sub_<?php echo $this->_tpl_vars['productClassList'][$this->_sections['arr']['index']]['id']; ?>
">
            			<?php unset($this->_sections['subarr']);
$this->_sections['subarr']['name'] = 'subarr';
$this->_sections['subarr']['loop'] = is_array($_loop=$this->_tpl_vars['productClassList'][$this->_sections['arr']['index']]['sub']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['subarr']['show'] = true;
$this->_sections['subarr']['max'] = $this->_sections['subarr']['loop'];
$this->_sections['subarr']['step'] = 1;
$this->_sections['subarr']['start'] = $this->_sections['subarr']['step'] > 0 ? 0 : $this->_sections['subarr']['loop']-1;
if ($this->_sections['subarr']['show']) {
    $this->_sections['subarr']['total'] = $this->_sections['subarr']['loop'];
    if ($this->_sections['subarr']['total'] == 0)
        $this->_sections['subarr']['show'] = false;
} else
    $this->_sections['subarr']['total'] = 0;
if ($this->_sections['subarr']['show']):

            for ($this->_sections['subarr']['index'] = $this->_sections['subarr']['start'], $this->_sections['subarr']['iteration'] = 1;
                 $this->_sections['subarr']['iteration'] <= $this->_sections['subarr']['total'];
                 $this->_sections['subarr']['index'] += $this->_sections['subarr']['step'], $this->_sections['subarr']['iteration']++):
$this->_sections['subarr']['rownum'] = $this->_sections['subarr']['iteration'];
$this->_sections['subarr']['index_prev'] = $this->_sections['subarr']['index'] - $this->_sections['subarr']['step'];
$this->_sections['subarr']['index_next'] = $this->_sections['subarr']['index'] + $this->_sections['subarr']['step'];
$this->_sections['subarr']['first']      = ($this->_sections['subarr']['iteration'] == 1);
$this->_sections['subarr']['last']       = ($this->_sections['subarr']['iteration'] == $this->_sections['subarr']['total']);
?>
            			<li>&nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['productClassList'][$this->_sections['arr']['index']]['sub'][$this->_sections['subarr']['index']]['url']; ?>
"><?php echo $this->_tpl_vars['productClassList'][$this->_sections['arr']['index']]['sub'][$this->_sections['subarr']['index']]['classname']; ?>
</a></li>           				<?php endfor; endif; ?>
                    </ul>
		    	<?php endif; ?>  
  <?php endfor; endif; ?>
</ul>