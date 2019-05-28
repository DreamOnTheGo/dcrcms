<?php
require_once("../include/common.inc.php");
session_start();
if( 'change_page_list_num' == $action )
{
	put_cookie( 'productlist_page_list_num', $num, 100000 );
	$page_list_num = $num;
}else
{
	$page_list_num_cookie = get_cookie( 'productlist_page_list_num' );
	$page_list_num = !empty( $page_list_num_cookie ) ? intval( $page_list_num_cookie ) : 20;
}
require_once( "adminyz.php" );
require_once( WEB_CLASS . "/class.product.php" );
$cls_pro = new cls_product();
$pro_class_list = $cls_pro->get_class_list();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="css/admin.css" type="text/css" rel="stylesheet">
<?php require_once("admin_common.php");?>
<script src="../include/js/common.js"></script>
<script src="js/product.js"></script>
<script type="text/javascript">
	function change_page_list_num()
	{
		var url = "?action=change_page_list_num&num=" + document.getElementById("page_list_num").value;
		window.location = url;
	}
</script>
</head>
<body>
<table cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <tr height=28>
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;产品分类列表</td>
  </tr>
  <tr>
    <td bgColor=#b1ceef height=1></td>
  </tr>
</table>
<table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <tr height=20>
    <td></td>
  </tr>
  <tr height=22>
    <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>产品列表</td>
  </tr>
  <tr bgColor=#ecf4fc height=12>
    <td></td>
  </tr>
</table>
<table cellSpacing=1 cellPadding=2 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <tr>
    <td><form action="" method="get">
        产品标题:
        <input type="text" name="title" id="title" value="<?php echo $title ?>" />
        <input type="submit" name="button3" id="button3" value="搜索" />
      </form></td>
  </tr>
  <tr>
    <td align="left" style="text-align: left"><form action="" method="get">
        产品分类:
        <select name="classid" id="classid">
          <option>全部分类</option>
          <?php
		$cls_pro->get_class_list_select($pro_class_list,$classid);
	?>
        </select>
        <input type="submit" name="button3" id="button3" value="进入分类" />
      </form></td>
  </tr>
</table>
<script type="text/javascript">
	function do_action($action)
	{
		if('delproduct' == $action)
		{
			if(!confirm('确定要删除?'))
			{
				return false;
			}
		}
		document.getElementById("action").value = $action;
		if('chang_pl_type' == $action)
		{
			var frm_attr = document.getElementById("pro_frm").attributes;
			frm_attr.getNamedItem("action").value= "product_pl_class.php";
			
		}
		document.getElementById("pro_frm").submit();
	}
    </script>
<form action="product_action.php" name="pro_frm" id="pro_frm" method="post">
  <input type="hidden" name="action" id="action" value="">
  <?php
	$total_page = 0;//总页数
	$page = isset($page) ? (int)$page : 1;
	$start = ($page-1) * $page_list_num;
	$classid = isset($classid) ? intval($classid) : 0;
	
	if(strlen($title)) $where_option[] = "title like '%$title%'";
	if($where_option) $where = implode(' and ',$where_option);
	
	$pro_list = $cls_pro->get_list($classid, array('col'=> 'id,title,istop,classid,logo,updatetime', 'limit'=>"$start,$page_list_num", 'order'=> 'id desc', 'where'=> $where), 1);
?>
  <table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
    <tr>
      <td style="text-align: center" width=75>ID</td>
      <td width="443" style="text-align: center">标题</td>
      <td width="145" style="text-align: center">产品类别</td>
      <td width="161" style="text-align: center">加入时间</td>
      <td width="142" style="text-align: center">操作</td>
    </tr>
    <?php
	foreach($pro_list as $value){
  ?>
    <tr height="30" bgcolor="#FFFFFF" onMouseMove="javascript:this.style.backgroundColor='#F4F9EB';" onMouseOut="javascript:this.style.backgroundColor='#FFFFFF';">
      <td style="text-align: center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $value['id']; ?>">
        <?php echo $value['id']; ?></td>
      <td><div ondblclick="show_edit_input(<?php echo $value['id']; ?>)"><span id="span_title_txt_<?php echo $value['id']; ?>"><?php echo $value['title']; ?></span><span style="display:none;" id="span_title_input_<?php echo $value['id']; ?>">
          <input old_value="<?php echo $value['title']; ?>" type="text" value="<?php echo $value['title']; ?>" onkeyup="input_title_keyup(event, <?php echo $value['id']; ?>)" id="input_title_<?php echo $value['id']; ?>" />
          </span></div></td>
      <td style="text-align: center"><select id="cur_type[<?php echo $value['id']; ?>]" name="cur_type[<?php echo $value['id']; ?>]">
          <?php
		$cls_pro->get_class_list_select($pro_class_list, $value['classid']);
	?>
        </select></td>
      <td style="text-align: center"><?php echo $value['updatetime']; ?></td>
      <td style="text-align: center"><a href="product_edit.php?action=modify&id=<?php echo $value['id']; ?>">编辑</a>
        <?php if(!$value['istop']){ ?>
        &nbsp;<a href="product_action.php?action=top&page=<?php echo $page; ?>&id=<?php echo $value['id']; ?>">置顶</a>
        <?php }else{ ?>
        &nbsp;<a href="product_action.php?action=top_no&page=<?php echo $page; ?>&id=<?php echo $value['id']; ?>">取消置顶</a>
        <?php } ?>
        &nbsp;<a href="product_action.php?action=delsingleproduct&id=<?php echo $value['id']; ?>" onclick="return confirm('确定要删除?');">删除</a></td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="5" bgcolor="#FFFFFF"><div style="float:left;">每页显示条目数:&nbsp;<input type="text" id="page_list_num" name="page_list_num" value="<?php echo $page_list_num; ?>" size="5" /><input type="button" onclick="change_page_list_num()" value="更改" /></div>
	  <div style="float:right;"><?php
	require_once(WEB_CLASS.'/class.page.php');
	
	if($where_option)
	{
		$where = implode(' and ',$where_option);
	}
	$page_num = $cls_pro->get_list_count($classid, $where, 1);
	$total_page = ceil($page_num / $page_list_num);//总页数
			
	$cls_page = new cls_page($page, $total_page);
	$page_html = $cls_page->show_page(); 
	echo $page_html;
	?></div>
    </td>
    </tr>
    <tr>
      <td colspan="5" bgcolor="#FFFFFF"><input type="button" name="button" id="button" value="全选/反选" onClick="javascript:selectAllChk('id[]');">
        <input type="button" name="button2" id="button2" value="删除" onclick="javascript:do_action('delproduct');">
        <input title="修改产品列中分类下选择的分类" type="button" name="buttonselect" id="buttonselect" value="修改分类" onclick="javascript:do_action('chang_type');"/>
        <input title="在弹出的页面中批量修改产品的分类" type="button" name="buttonselect" id="buttonselect" value="批量修改分类" onclick="javascript:do_action('chang_pl_type');"/></td>
    </tr>
  </table>
</form>
</body>
</html>