<?php
require_once("../include/common.inc.php");
session_start();
header('cache-control:no-cache;must-revalidate');
require_once(WEB_CLASS."/class.product.php");
require_once("adminyz.php");

$cls_pro = new cls_product();

//提示信息开始
$error_msg = array();//错误信息
$back = array('产品列表'=> 'product_list.php');
//提示信息结束

//本页为操作新闻的页面
if($action == 'add')
{
	$iserror = false;
	if(empty($title)){		
		$error_msg[] = '请填写产品名称';
		$iserror = true;
	}
	if($classid == 0){
		$error_msg[] = '请选择产品类别';
		$iserror = true;
	}
	if($iserror)
	{
		show_msg($error_msg, 2);
	}else
	{
		//没有错误
		//上传产品图片
		include_once(WEB_CLASS."/class.upload.php");
		$cls_upload = new cls_upload('logo');
		$file_info = $cls_upload->upload(WEB_DR."/uploads/product/", '',array('width'=>$prologowidth,'height'=>$prologoheight, 'newpic'=>1));
		$logo = $file_info['sl_filename'];
		$biglogo = $file_info['filename'];
		
		$guanlian = '';
		if(!empty($pro_guanlian_value))
		{
			$guanlian = substr($pro_guanlian_value, 0, strlen($pro_guanlian_value) - 1);
		}
		$info = array('title'=>$title,
					   		 'logo'=>$logo,
					   		 'biglogo'=>$biglogo,
							 'tags'=>$tags,
					   		 'classid'=>intval($classid),
							 'istop'=>intval($istop),
					   		 'keywords'=>$keywords,
					   		 'description'=>$description,
					   		 'content'=>$content,
					   		 'guanlian'=>$guanlian
							 );
							 
		$rid = $cls_pro->add($info);
		
		if(!$rid)
		{
			$error_msg[] = '添加产品失败';
			show_msg($error_msg, 2);	
		}else{			
			//处理tags
			$tags_list = explode(',',$tags);
			if($tags_list)
			{
				$cls_data_tagindex = cls_app::get_data('{tablepre}tagindex');
				$cls_data_taglist = cls_app::get_data('{tablepre}taglist');
				foreach($tags_list as $tag_info)
				{
					if(!empty($tag_info))
					{
						$tag_list_info=array(
											 'aid'=>$rid,
											 'typeid'=>intval($classid),
											 'tag'=>$tag_info
											 );
						$cls_data_taglist-> insert($tag_list_info);
						
						//删除原来的记录再添加	
						$cls_data_tagindex->delete_ex("tag='$tag_info'");
						
						$tag_total = $cls_data_taglist->select_one(array('col'=>'count(id) as sum','where'=>"tag='$tag_info'"));
						$tag_total = current($tag_total);
						$tag_total = $tag_total['sum'];
						
						$tag_index_info = array(
									   'tag'=>$tag_info,
									   'total'=>$tag_total,
									   'addtime'=>time()
									   );
						$cls_data_tagindex->insert($tag_index_info);
					}
				}
				unset($cls_data_tagindex,$cls_data_taglist);
			}
			$error_msg[] = '添加产品成功';
			$back['继续添加'] = 'product_edit.php?action=add';
			show_msg($error_msg, 1, $back);
		}
	}
}
else if($action == 'modify')
{
	$iserror = false;
	if(empty($title))
	{
		$error_msg[] = '请填写产品名称';
		$iserror = true;
	}
	if($classid==0)
	{
		$error_msg[] = '请选择产品类别';
		$iserror = true;
	}
	if($iserror)
	{
		show_msg($error_msg, 2);
	}
		
	$guanlian = '';
	if(!empty($pro_guanlian_value))
	{
		$guanlian = substr($pro_guanlian_value, 0, strlen($pro_guanlian_value)-1);
	}
	$product_info = array('title'=>$title,
					   'classid'=>intval($classid),
					   'istop'=>intval($istop),
					   'tags'=>$tags,
					   'keywords'=>$keywords,
					   'description'=>$description,
					   'content'=>$content,
					   'guanlian'=>$guanlian
					  );
	
	//原来的图片要删除

	include_once(WEB_CLASS."/class.upload.php");	
	$cls_upload = new cls_upload('logo');
	$file_info = $cls_upload->upload(WEB_DR . "/uploads/product/", '', array('width'=>$prologowidth,'height'=>$prologoheight,'newpic'=>1));
	
	if($file_info)
	{
		$product_info['logo'] = $file_info['sl_filename'];
		$product_info['biglogo'] = $file_info['filename'];
	
		$pro_old_info = $cls_pro->get_info($id , 'logo,biglogo' , array());
		if($pro_old_info)
		{	
			$logo = $pro_old_info['logo'];
			$logo_big = $pro_old_info['biglogo'];
			
			@unlink(WEB_DR . '/uploads/product/' . $logo);
			@unlink(WEB_DR . '/uploads/product/' . $logo_big);
		}
	}
	
	if($cls_pro->update($id, $product_info))
	{
		//处理旧的tags 先减一次
		if(!empty($oldtags))
		{
			$olg_tags_list = explode(',',$oldtags);
			
			$cls_data_tagindex = cls_app:: get_data('{tablepre}tagindex');
			if($olg_tags_list)
			{
				foreach($olg_tags_list as $old_tag)
				{					
					$cls_data_tagindex-> update(array('total'=> 'total-1'), "tag='$old_tag'");
				}
			}
		}
		$tags_list = explode(',', $tags);
		if($tags_list)
		{
			$cls_data_tagindex = cls_app::get_data('{tablepre}tagindex');
			$cls_data_taglist = cls_app::get_data('{tablepre}taglist');
			$cls_data_taglist->delete($id, 'aid');
			foreach($tags_list as $tag_info)
			{
				if(!empty($tag_info))
				{
					$tag_list_info=array(
										 'aid'=>$id,
										 'typeid'=>intval($classid),
										 'tag'=>$tag_info
										 );
					$cls_data_taglist->insert($tag_list_info);
					
					$has_info = $cls_data_tagindex->select_one(array('col'=>'id', 'where'=>"tag='$tag_info'"));
					$has_info = current($has_info);
					
					//原来的记录加一次
					if($has_info)
					{
						$cls_data_tagindex->update(array('total'=> 'total+1'), "tag='$tag_info'");
					}else
					{
						$tag_index_info=array(
									   'tag'=>$tag_info,
									   'total'=>1,
									   'addtime'=>time()
									   );
						$cls_data_tagindex->insert($tag_index_info);
					}
				}
			}
			unset($cls_data_tagindex, $cls_data_taglist);
		}
		$error_msg[]='更新产品成功';
		show_msg($error_msg,1,$back);
	}else
	{
		$error_msg[]='更新产品失败';
		show_msg($error_msg,2);
	}	
}else if($action == 'delproduct')
{
	if( is_array($id) )
	{
		$r = $cls_pro->delete(implode(',', $id));
		if($r==1)
		{
			$error_msg[] = '删除数据成功';
			show_msg($error_msg, 1, $back);
		}elseif($r == 3)
		{
			$error_msg[] = '删除数据失败:没有选择要删除的产品';
			show_msg($error_msg, 2, $back);
		}elseif($r==2)
		{
			$error_msg[] = '删除数据失败:处理数据库数据时失败';
			show_msg($error_msg, 2, $back);
		}
	}else
	{
		show_msg( '请选择要删除的产品' , 2 );
	}
}
elseif($action=='delsingleproduct')
{	
	$r = $cls_pro->delete($id);
	if($r == 1)
	{
		$error_msg[] = '删除数据成功';
		show_msg($error_msg, 1, $back);
	}else if($r == 3)
	{
		$error_msg[] = '删除数据失败:没有选择要删除的产品';
		show_msg($error_msg, 2, $back);
	}elseif($r == 2)
	{
		$error_msg[] = '删除数据失败:处理数据库数据时失败';
		show_msg($error_msg, 2, $back);
	}
}
else if($action == 'top')
{
	$info = array(
				'istop'=>1
				);
	if($cls_pro->update($id, $info)){
		$error_msg[] = '置顶成功';
		show_msg($error_msg, 1, $back);
	}else{
		$error_msg[] = '置顶失败' . mysql_error();
		show_msg($error_msg, 2, $back);
	}
}else if($action == 'top_no')
{
	$info = array(
				'istop'=>0
				);
	if($cls_pro->update($id, $info))
	{
		$error_msg[] = '取消置顶成功';
		show_msg($error_msg, 1, $back);
	}else{
		$error_msg[] = '取消置顶失败' . mysql_error();
		show_msg($error_msg, 2, $back);
	}
}
else if($action == 'chang_type')
{
	if($cur_type)
	{
		foreach($cur_type as $pro_id=>$classid)
		{
			if($classid)
			{
				$cls_pro->update($pro_id, array('classid'=>$classid));
			}
		}
	}
	$error_msg[] = '修改分类成功';
	show_msg($error_msg, 1, $back);
}
else if($action == 'chang_pl_type')
{
	if($id)
	{
		foreach($id as $pro_id)
		{
			if($pro_id)
			{
				$cls_pro->update($pro_id, array('classid'=>$classid));
			}
		}
	}
	$error_msg[] = '修改分类成功';
	show_msg($error_msg,1,$back);
}
else if($action == 'search_xiangguan_products')
{
	$pro_list = $cls_pro->get_list(0, array('col'=>'id,title', 'order'=>'id desc', 'where'=>"title like '%$pro_search_name%'"));
	echo '<select name="pro_names" class="pro_names" id="pro_names" multiple="multiple">';
	if($pro_list)
	{
		foreach($pro_list as $pro_info)
		{
          echo '<option value="' . $pro_info['id'] . '">' . $pro_info['title'] . '</option>';
		}
	}
    echo '</select>';
}
else if($action == 'update_product_name_byajax')
{
    $product_info = array('title'=>$title);
    if($cls_pro->update( $id, $product_info) )
    {
        echo $title;
    }
    else
    {
        echo '更新失败，请刷新页面';
    }
   
}
else
{
	echo '非法操作？';
}
?>