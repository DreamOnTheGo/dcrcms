<?php /* Smarty version 2.6.25, created on 2011-04-23 13:27:30
         compiled from footer.html */ ?>
<div id="footer">
  <div class="wrap_noborder clearfix">
   	  <div class="f_logo"><img src="<?php echo $this->_tpl_vars['web_templeturl']; ?>
<?php echo $this->_tpl_vars['web_templetdir']; ?>
/images/logo.gif" width="200" height="50" /></div>
        <div class="copyright">
        友情连接:
          		<?php unset($this->_sections['arr']);
$this->_sections['arr']['name'] = 'arr';
$this->_sections['arr']['loop'] = is_array($_loop=$this->_tpl_vars['flink_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                <a href="<?php echo $this->_tpl_vars['flink_list'][$this->_sections['arr']['index']]['weburl']; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['flink_list'][$this->_sections['arr']['index']]['webname']; ?>
"><?php echo $this->_tpl_vars['flink_list'][$this->_sections['arr']['index']]['webname']; ?>
</a>
          		<?php endfor; endif; ?><br />
        <!--为了程序更好发展请保留本信息 谢谢了-->程序提供：<a target="_blank" class="txtRed" href="http://www.dcrcms.com">www.dcrcms.com</a> QQ:335759285 164683872</div>
  </div>
</div>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['web_templeturl']; ?>
<?php echo $this->_tpl_vars['web_templetdir']; ?>
/js/common.js"></script> 