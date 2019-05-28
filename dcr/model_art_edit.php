<?php
require_once("../include/common.inc.php");
session_start();
require_once("adminyz.php");
$txt = '';
if( 'modify' == $action )
{
	$txt = '修改';
} else
{
	$txt = '添加';
}
require_once(WEB_CLASS . "/class.model.php");
$cls_model = new cls_model( $model_id );
$model_info = $cls_model->get_info();
$cls_data = cls_app::get_data('@#@' . $model_info['model_table_name']);
$field_list = $cls_model->get_filed_list( $model_id, array( 'oerder'=>'order_id desc') );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>字段管理</title>
<link href="css/admin.css" type="text/css" rel="stylesheet" />
<?php include "admin_common.php"; ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<table cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <tr height=28>
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;字段管理</td></tr>
  <tr>
    <td bgColor=#b1ceef height=1></td></tr></table>
<div id="page">
             <?php
				if($action != 'add')
				{
					$id = isset($id) ? (int)$id : 0;
					
					if($id != 0)
					{
						$info = $cls_data->select_one_ex( array( 'where'=>"id=$id" ) );
					}else{
						$errormsg[] = '您没有选择文档';
						show_msg($errormsg, 2, $back);
					}
				}else
				{
				}
			?>
				<form action="model_art_action.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
                    <input type="hidden" name="model_id" id="model_id" value="<?php echo $model_id; ?>">
    <table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
      <tr height=20>
        <td></td>
      </tr>
      <tr height=22>
        <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" align=middle background=images/title_bg2.jpg><?php echo $txt; ?>字段</td>
      </tr>
      <tr bgColor=#ecf4fc>
        <td style="padding:3px"><?php require_once('model_art_header.php'); ?></td>
      </tr>
    </table>
    <table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
      <tbody>
      
                    <?php
						if( $field_list )
						{
							foreach( $field_list as $field_info )
							{
                    ?>
        <tr bgcolor="#ffffff">
          <td height="25" align="right" width="12%"><span class="redtxt">*</span><span class="textR"><?php echo $field_info['item_name']; ?> </span>：</td>
          <td width="89%" height="25" colspan="3">
                        <?php
                         if( 'view' == $action )
						 {
							 echo trim($info[$field_info['field_name']]);
						 }
						 else
						 {
								if( 'multitext' == $field_info['dtype'] )
								{
							?>
                            <textarea name="<?php echo $field_info['field_name']; ?>" cols="60" rows="3" id="<?php echo $field_info['field_name']; ?>" type="text"><?php echo trim($info[$field_info['field_name']]); ?></textarea>
                        	<?php
								}elseif( 'select' == $field_info['dtype'] )
								{
							?>                            		
                                <select name='<?php echo $field_info['field_name']; ?>' id='<?php echo $field_info['field_name']; ?>'>"
                                <?php
                                $v_a = explode(',', $field_info['vdefault']);
                                foreach($v_a as $v_v)
                                {
                                    echo "<option value='{$v_v}'>{$v_v}</option>";
                                }
								?>
                                </select>
                                <?php
									if( $info[$field_info['field_name']] )
									{
								?>
                                	
                            <script language="javascript" type="text/javascript">
								document.getElementById('<?php echo $field_info['field_name']; ?>').value = '<?php echo $info[$field_info['field_name']]; ?>';
							</script>
                                <?php
									}
								?>
                            <?php
								}
								else
								{
							?>
                            <div class="left"></div>
                            <input name="<?php echo $field_info['field_name']; ?>" type="text" id="<?php echo $field_info['field_name']; ?>" size="50" value="<?php echo trim($info[$field_info['field_name']]); ?>" />
                            <div class="right"></div>
                        	<?php
                            	} 
							?>
					  <?php
	                      } 
                      ?>
          </td>
        </tr>
                    <?php }} ?>
        <tr bgcolor="#ffffff">
          <td height="25" align="right">&nbsp;</td>
          <td height="25" colspan="3" style="width: 45%;"><input type="submit" value="<?php echo $txt; ?>" id="Button1" />
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            
            &nbsp;
            <input type="reset" value="重置" id="Button3"  /></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
</body>
</html>
