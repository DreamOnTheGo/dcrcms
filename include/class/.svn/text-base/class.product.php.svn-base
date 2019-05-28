<?php

defined('IN_DCR') or exit('No permission.'); 

/**
 * 产品处理类
 * ===========================================================
 * 版权所有 (C) 2006-2020 我不是稻草人，并保留所有权利。
 * 网站地址: http://www.dcrcms.com
 * ----------------------------------------------------------
 * 这是免费开源的软件；您可以在不用于商业目的的前提下对程序代码
 * 进行修改、使用和再发布。
 * 不允许对程序修改后再进行发布。
 * ==========================================================
 * @author:     我不是稻草人 <junqing124@126.com>
 * @version:    v1.0
 * @package class
 * @since 1.0.8
*/

require_once(WEB_CLASS . '/class.data.php');

class cls_product extends cls_data
{
	
	/**
	* Product的构造函数 无需传参数
	*/
	private $nopic;
	private $class_list_ul;//记录ul型产品分类列表 记录<ul></ul>之间的li内容.主要用于前台的产品列表
	private $class_list_id;//记录产品分类id列表 以,分隔 用于记录GetSubClassIDFromList结果
	
	function __construct()
	{
		global $web_url;
		parent:: __construct('{tablepre}product');
		$this->nopic = $web_url . '/include/images/nopic.png';
	}
	
	/**
	 * 设置类要操作的表
	 * @param string $table 表名
	 * @return true
	 */
	function set_table($table)
	{
		parent:: set_table($table);
	}
	
	/**
	 * 添加产品分类
	 * @param array $pro_class_info 插入的产品数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean 成功返回true 失败返回false
	 */
	function add_class($pro_class_info)
	{
		parent:: set_table('{tablepre}product_class');
		
		$class_id = parent::insert($pro_class_info);
		
		$this->write_class_cache();
		
		return $class_id;
	}
	
	/**
	 * 写产品分类列表
	 * @return true
	 */
	private function write_class_cache($parent_id = 0)
	{
		require_once(WEB_CLASS . '/class.cache.php');
		$cache_file_name = 'product_class_list.php';
		$cls_cache = new cls_cache(0, $cache_file_name);
		
		$class_list = $this->get_class_list_loop($parent_id);
			
		$class_list_txt = var_export($class_list, true);
		if(!empty($class_list_txt))
		{
			$class_list_txt = "<?php\r\n\r\n/*产品类*/\r\n\r\n \$cache_arr = " .$class_list_txt . ";\r\n\r\n?>";
		}
		return $cls_cache->write($class_list_txt);
	}
	
	/**
	 * 返回产品类列表
	 * @return array 返回产品分类列表
	 */
	public function get_class_list($parent_id = 0)
	{
		require_once(WEB_CLASS . '/class.cache.php');
		$cache_file_name = 'product_class_list.php';
		//1728000 为20天 缓存20天
		$cls_cache = new cls_cache(1728000, $cache_file_name);
		if($cls_cache->check())
		{
			//缓存存在
			$class_list = $cls_cache->read();
		}else
		{
			//缓存不存在
			$r_val = $this->write_class_cache($parent_id);
			if('r2' == $r_val || 'r1' == $r_val)
			{
				//缓存不可写
				$class_list = $this->get_class_list_loop($parent_id);
			}else
			{
				$class_list = $cls_cache->read();
			}
		}
			
		return $class_list;
	}
	
	/**
	 * 返回产品类列表 内部使用
	 * @param array $parent_id 父类ID 如果为0则返回全部
	 * @param string $level 本参数不建议外部传入 主要用于标记当前为几级分类
	 * @return array 返回产品分类列表
	 */
	private function get_class_list_loop($parent_id = 0 , $level = 1)
	{
		global $web_url_module,$web_url_surfix,$web_url;
		$where = 'parentid=' . $parent_id;
		$order = 'orderid asc,id desc';
		parent:: set_table('@#@product_class');
		$canshu = array('col'=> $col, 'where'=>$where, 'order'=>$order);
		$class_list = parent::select_ex($canshu);
		
		if( $class_list )
		{
			foreach( $class_list as $class_key=>$class )
			{
				$class_sub = $this-> get_class_list_loop($class['id'] , $level+1);
				$class_list[$class_key]['class_level'] = $level;
				
				if( $web_url_module == '1' ){
					$class_list[$class_key]['url'] = $web_url . '/product_list.php?classid='.$class['id'];
				}elseif( $web_url_module == '2' )
				{
					$class_list[$class_key]['url'] = $web_url . '/product_list_'.$class['id'].'.'.$web_url_surfix;
				}
				
				if( $class_sub )
				{
					$class_list[$class_key]['sub_class'] = $class_sub;
				}
			}
		}
		
		return $class_list;
	}
	
	/**
	 * 返回产品类列表 输出<select></select>之间的option内容 version>=1.0.6
	 * <code>
	 * <?php
	 * //前台ul型产品分类菜单列表
	 * include WEB_CLASS."/class.product.php";
	 * $cls_pro = new cls_product();
	 * echo '<select name="parentid" id="parentid">';
	 * $product_class_list = $cls_pro->get_class_list();
	 * $cls_pro-> get_class_list_select($product_class_list, $parentid);
	 * echo '</select>';
	 * ?>
 	 * </code>
	 * @param array $class_list 产品分类 可以用本类的GetClassList来获取
	 * @param int $cur_id 当前的产品分类选择ID
	 * @param string $option_value option值 如果是ID的话value=id 如果是classname的话 value=classname
	 * @return true 输出select里的option
	 */	
	function get_class_list_select( $class_list , $cur_id=0, $option_value = 'id' )
	{
		if($class_list)
		{
			foreach($class_list as $value)
			{
				echo '<option value="'.$value[$option_value].'"';
				if($cur_id == $value['id'] && $cur_id)
				{
					echo 'selected="selected"';
				}
				echo '>' . str_repeat("----", $value['class_level']-1) . $value['classname'] . '</option>';
				if($value['sub_class'] && count($value['sub_class']))
				{
					$this-> get_class_list_select($value['sub_class'], $cur_id, $option_value);
				}
			}
		}else
		{
			echo '<option value="0">当前没有产品分类</option>';
		}
	}
	
	/**
	 * 返回产品类ul下的li 主要用于前台的菜单输出 输出<ul></ul>之间的li内容 version>=1.0.6
	 * <code>
	 * <?php
	 * //前台ul型产品分类菜单列表
	 * include WEB_CLASS."/class.product.php";
	 * $cls_pro = new cls_product();
	 * $product_class_list = $cls_pro->get_class_list();
	 * $tpl-> assign('product_class_list',$product_class_list);
	 * $pro_class_list_txt = $cls_pro-> get_class_list_ul($product_class_list);
	 * $pro_class_list_txt = $cls_pro-> get_class_list_ul_html();
	 * ?>
 	 * </code>
	 * @param array $class_list 产品分类 可以用本类的GetClassList来获取
	 * @return true 没有返回值 主要把值存在了$this->class_list_ul 用GetClassListUlHtml获取就OK了
	 */	
	function get_class_list_ul( $class_list )
	{
		if( $class_list )
		{
			$this-> class_list_ul .= '<ul>';
			foreach( $class_list as $value )
			{
				$this-> class_list_ul .= '<li><a href="' . $value['url'] . '">' . $value['classname'] . '</a>';
				if( $value['sub_class'] && count($value['sub_class']) )
				{
					$this-> get_class_list_ul( $value['sub_class'] );
				}
				$this-> class_list_ul .= '</li>';
			}
			$this->class_list_ul .= '</ul>';
		}
	}
	
	/**
	 * 获取由GetClassListUl产生的HTML 产生这个类主要做为输出前台产品列表用
	 * @return string 获取由GetClassListUl产生的HTML
	 */		
	function get_class_list_ul_html()
	{
		$count = 1;
		$pro_class_list_txt = str_replace('<ul>', '<ul id="navigation">', $this->class_list_ul, $count);
		
		return $pro_class_list_txt;
	}
	
	/**
	 * 返回指定产品分类的数据信息
	 * @param string|int $id 产品类的ID
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为array()时返回全部字段
	 * @return array 返回值为这个产品分类的信息(Array)
	 */
	function get_class_info($id, $col = '')
	{
		global $db, $web_url_module, $web_url_surfix, $web_url;
		parent:: set_table('{tablepre}product_class');
		$info = parent:: select_ex(array('col'=>$col, 'where'=>"id=$id"));
		$info = current($info);
		//这里返回类别的路径
		$parent_info = $this-> get_parent_class_info($id, 'classname,id');
		if($parent_info)
		{
			if($web_url_module == '1')
			{
				$position = '<a href="' . $web_url . '/">首页</a>>><a href="' . $web_url . '/product_list.php?classid=' . $parent_info['id'].'">' . $parent_info['classname'] . '</a>>>' . $info['classname'] . '';
			}else if($web_url_module == '2')
			{
				$position = '<a href="' . $web_url . '/">首页</a>>><a href="' . $web_url . '/product_list_' . $parent_info['id'] . '.' . $web_url_surfix . '">' . $parent_info['classname'] . '</a>>>' . $info['classname'] . '';
			}
			$info['position'] = $position;
		}else
		{
			$position = '<a href="' . $web_url . '/">首页</a>>>' . $info['classname'] . '';
			$info['position'] = $position;
		}
		
		return $info;
	}
	
	/**
	 * 更新产品类信息
	 * @param string|int $id 产品类的ID
	 * @param array $product_class_info 更新的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean 成功返回true 失败返回false
	 */
	function update_class($id, $product_class_info = array())
	{
		$this-> set_table('{tablepre}product_class');
		$return_val = parent:: update($product_class_info, "id=$id");
		
		$this->write_class_cache();
		
		return $return_val;
	}
	/**
	 * 删除指定ID数组的产品分类
	 * @param array $class_id 删除的ID
	 * @return boolean 1成功 2有子类不能被删除 3删除失败mysql错误
	 */
	function delete_class($class_id)
	{
		$this-> set_table('{tablepre}product_class');
		if($this-> has_sub_class($class_id)){
			return 2;
		}else{
			if(parent:: delete($class_id)){
				$this->write_class_cache();
				
				return 1;
			}else{
				
				return 3;
			}
		}
	}
	
	/**
	 * 判断类是不是有子类
	 * @param $class_id 类ID
	 * @return boolean 成功返回true 失败返回false
	 */
	function has_sub_class($class_id)
	{
		$this-> set_table('{tablepre}product_class');
		$sub_where = 'parentid=' . $class_id;
			//echo $sub_where;
		$sub_info = parent:: select_ex(array('col'=>$col, 'where'=>$sub_where, 'limit'=>'1', 'order'=>$order));
		
		return is_array($sub_info) && count($sub_info);
	}
	
	/**
	 * 获取一个类所有子类ID列表 以,分隔 version>=1.0.6
	 * @param $class_id 分类ID
	 * @param $is_contain_self 如果为true的话,结果里包含本$class_id
	 * @return array 获取子类ID列表
	 */
	function get_sub_class_id_list( $class_id = 0 , $is_contain_self = false)
	{
		$class_list = $this-> get_class_list($class_id);
		$this-> get_sub_class_id( $class_list );
		$str = $this-> class_list_id;
		if( ''==trim($str) )
		{
			if( $is_contain_self )
			{
				$str = $class_id;
			}else
			{
				$str = '';
			}
		}else
		{
			$str = substr($str , 0 , strlen($str)-1);
			if( $is_contain_self )
			{
				$str = $class_id . ',' .$str;
			}else
			{
			}
		}
		
		return $str;
	}
	
	/**
	 * 从一个分类List Array里获取所有的ID以,分隔 主要配合GetSubClassIDList使用 version>=1.0.6
	 * @param $class_list 分类
	 * @return array 获取子类ID列表 以,分隔
	 */
	private function get_sub_class_id( $class_list )
	{
		if( $class_list )
		{
			foreach( $class_list as $value )
			{
				$this->class_list_id .= $value['id'] . ',';
				if( $value['sub_class'] && count($value['sub_class']) )
				{
					$this->get_sub_class_id( $value['sub_class'] );
				}
			}
		}
	}
	
	/**
	 * 获取父类名
	 * @param string $class_id 类ID
	 * @param string $col 列名 以,分隔
	 * @return string|boolean(false) 成功返回父类名 失败返回false
	 */
	function get_parent_class_info($class_id, $col = '*')
	{
		global $db;
		$this-> set_table('{tablepre}product_class');
		$parent_info = parent:: select_one(array('col'=>'parentid', 'where'=>"id=$class_id"));
		$parent_info = current($parent_info);
		$parentid = $parent_info['parentid'];
		if($parentid != 0){			
			
			return current(parent::select_one(array('col'=>$col, 'where'=>"id=$parentid")));
		}else{
			
			return false;
		}
	}
	/**
	 * 返回产品类别名
	 * @param string|int $class_id 产品类别ID
	 * @return string 成功返回产品分类ID类名，失败返回false
	 */
	function get_class_name($class_id)
	{
		$this-> set_table('{tablepre}product_class');
		$class_info = parent:: select_one(array('col'=>'classname', 'where'=>"id=$class_id"));
		$class_info = current($class_info);
		
		return $class_info['classname'];
	}
	
	/**
	 * 添加产品
	 * @param array $pro_info 产品数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return int 返回值为文档的ID,失败返回0
	 */
	function add($pro_info)
	{
		//把主表和附加表分开来
		global $product_col_main, $product_col_addon;
		$this-> set_table('{tablepre}product');
		$product_col_main_arr = explode(',', $product_col_main);
		$product_col_addon_arr = explode(',', $product_col_addon);
		
		foreach($pro_info as $key=> $value)
		{
			if(in_array($key,$product_col_addon_arr))
			{
				$col_addon[$key] = $value;
			}else{
				$col_main[$key] = $value;
			}
		}
		$aid = parent:: insert($col_main);
		
		if($aid){
			$col_addon['aid'] = $aid;
			$this-> set_table('{tablepre}product_addon');
			parent:: insert($col_addon);
			
			return $aid;
		}else{
			
			return false;
		}
	}
	
	/**
	 * 返回产品列表
	 * @param string|int $classid 产品类别ID
	 * @param array $canshu 参数列表：
	 * @param array $canshu['col']        要返回的字段列 以,分隔
	 * @param array $canshu['where']      条件
	 * @param array $canshu['limit']      返回的limit
	 * @param array $canshu['group']      分组grop
	 * @param array $canshu['order']      排序 默认是istop desc,id desc
	 * @param boolean $is_sub 是不是也要返回下级的产品
	 * @return array 返回产品列表
	 */
	function get_list($class_id, $canshu = array(), $is_sub = 0){
		$this-> set_table('{tablepre}product');
		global $web_url, $web_url_module, $web_url_surfix;
		
		//得出要返回的class_id
		if($class_id>0)
		{
			if($is_sub)
			{
				$class_id_list = $this->get_sub_class_id_list($class_id, true);
			}else
			{
				$class_id_list = $class_id;
			}
		}else
		{
			if($is_sub)
			{
				$class_id_list = $this->get_sub_class_id_list($class_id, false);
			}else
			{
				$class_id_list = '';
			}
		}
		
		
		$where_arr = array();
		
		if(!empty($where))
		{
			array_push($where_arr, $where);
		}
		if(!empty($class_id_list))
		{
			array_push($where_arr, 'classid in(' . $class_id_list . ')');
		}
		
		if($where_arr)
		{
			$canshu['where'] = implode(' and ', $where_arr);
		}
		
		if(empty($canshu['order']))
		{
			$canshu['order'] = 'istop desc,id desc';
		}
		
		$this-> set_table('{tablepre}product');
		$pro_list = parent:: select_ex($canshu);
		
		$pro_count = count($pro_list);
		
		for($i=0; $i < $pro_count; $i++)
		{
			if(empty($pro_list[$i]['logo']))
			{
				$pro_list[$i]['logo'] = $this->nopic;
			}else
			{
				$pro_list[$i]['logo'] = $web_url . '/uploads/product/' . $pro_list[$i]['logo'];
				//echo $pro_list['logo'];
			}
			if(empty($pro_list[$i]['biglogo']))
			{
				$pro_list[$i]['biglogo'] = $this->nopic;
			}else
			{
				$pro_list[$i]['biglogo'] = $web_url . '/uploads/product/' . $pro_list[$i]['biglogo'];
				//echo $pro_list['logo'];
			}			
			if($web_url_module == '1')
			{
				$pro_list[$i]['url'] = "product.php?id=" . $pro_list[$i]['id'];
			}else if($web_url_module == '2')
			{
				$pro_list[$i]['url'] = "product_" . $pro_list[$i]['id'] . "." . $web_url_surfix;
			}
		}
		
		return $pro_list;
	}
	
	/**
	 * 返回产品信息
	 * @param string|int $aid 产品ID
	 * @param array $col 要返回的字段列
	 * @param array $option_col 要系统处理的col 比如logo会返回他的真实地址 默认处理的有：logo,biglogo,position,prev,next,tags_list,guanlian_list 为了效率 最好明确指定这个处理
	 * @return array 产品信息
	 */
	function get_info($aid, $col = '', $option_col = array('logo', 'biglogo', 'position', 'prev', 'next', 'tags_list', 'guanlian_list')){
		global $db, $web_url, $product_col_main, $product_col_addon, $product_col_list;
		
		if(empty($col))
		{
			$col = $product_col_list;
		}
		
		$col_arr = explode(',', $col);
		
		//下面的操作都要id,classid 如果没有这个则加上
		if(!in_array('classid',$col_arr))
		{
			array_push($col_arr,'classid');
		}		
		if(!in_array('id',$col_arr))
		{
			array_push($col_arr,'classid');
		}
		
		$product_col_main_arr = explode(',', $product_col_main);
		$product_col_addon_arr = explode(',', $product_col_addon);
		
		$col_main = $col_addon = array();
		foreach($col_arr as $key=> $value)
		{
			if(in_array($value, $product_col_addon_arr))
			{
				array_push($col_addon, $value);
			}else{
				array_push($col_main, $value);
			}			
		}
		array_remove_empty($col_main);
		array_remove_empty($col_addon);
		
		$col_main_list = implode(',', $col_main);
		$col_addon_list = implode(',', $col_addon);
		
		parent:: set_table('{tablepre}product');
		$pro_main_info = parent:: select_one(array('col'=>$col_main_list, 'where'=>"id=$aid"));
		$pro_main_info = current($pro_main_info);
		if(!empty($col_addon_list))
		{
			parent:: set_table('{tablepre}product_addon');
			$pro_addon_info = parent:: select_one(array('col'=>$col_addon_list, 'where'=>"id=$aid"));
			if(!$pro_addon_info)
			{
				$pro_addon_info = array();
			}else
			{
				$pro_addon_info = current($pro_addon_info);
			}
		}else
		{
			$pro_addon_info = array();
		}
		$pro_info = array_merge($pro_main_info, $pro_addon_info);
		
		//返回当前路径
		global $web_url_module, $web_url_surfix;
		if(in_array('position', $option_col))
		{
			$parent_info = $this->get_parent_class_info($pro_info['classid'], 'classname,id');
			if($parent_info){
				if($web_url_module == '1')
				{
					$parent_path = '<a href="' . $web_url . '/product_list.php?id=' . $parent_info['id'] . '">' . $parent_info['classname'] . '</a>>>';
				}else if($web_url_module == '2')
				{
					$parent_path = '<a href="' . $web_url . '/product_list_' . $parent_info['id'] . '.' . $web_url_surfix . '">' . $parent_info['classname'] . '</a>>>';
				}
			}
			
			$pro_class_name = $this-> get_class_name($pro_info['classid']);
			if($web_url_module == '1')
			{
				$class_path = $web_url . '/product_list.php?id=' . $pro_info['classid'];
			}else if($web_url_module=='2')
			{
				$class_path = $web_url . '/product_list_' . $pro_info['classid'] . '.' . $web_url_surfix;
			}
			$position = '<a href="' . $web_url . '">首页</a>>>' . $parent_path . '<a href="' . $class_path . '">' . $pro_class_name . '</a>>>' . $pro_info['title'];			
			$pro_info['position'] = $position;
		}
		
		if(in_array('logo', $option_col))
		{
			if(empty($pro_info['logo']))
			{
				$pro_info['logo'] = $this->nopic;
			}else{
				$pro_info['logo'] = $web_url . '/uploads/product/' . $pro_info['logo'];
			}
		}
		
		if(in_array('biglogo', $option_col))
		{
			if(empty($pro_info['biglogo']))
			{
				$pro_info['biglogo'] = $this->nopic;
			}else{
				$pro_info['biglogo'] = $web_url . '/uploads/product/' . $pro_info['biglogo'];
			}
		}
		
		if(in_array('tags_list', $option_col))
		{
			//得出tagslist
			$tags_list = '';
			if(!empty($pro_info['tags']))
			{
				$tag_arr = explode(',', $pro_info['tags']);
				if(is_array($tag_arr))
				{
					foreach($tag_arr as $tagname)
					{
						$tags_list .= '<a href="search.php?s_type=1&tag=' . urlencode($tagname) . '" target="_blank">' . $tagname.'</a> ';
					}
				}
				$pro_info['tags_list'] = $tags_list;
				//echo $pro_info['tags'];
			}
		}
		
		//上一篇下一篇		
		if(in_array('prev', $option_col))
		{
			parent:: set_table('{tablepre}product');
			$prev_info = parent::select_one(array('col'=> 'id,title', 'where'=> "id<$aid and classid=".$pro_info['classid'],'order'=>'id desc'));
			if($prev_info)
			{
				$prev_info = current($prev_info);
				if($web_url_module == '1')
				{
					$prev_url = $web_url . '/product.php?id=' . $prev_info['id'];
				}else if($web_url_module=='2')
				{
					$prev_url = $web_url . '/product_' . $prev_info['id'] . '.' . $web_url_surfix;
				}
				$pro_info['prev'] = "<a href='$prev_url'>" . $prev_info['title'] . "</a>";
			}else
			{
				$pro_info['prev'] = '没有了';
			}
		}
		
		if(in_array('next', $option_col))
		{		
			parent::set_table('{tablepre}product');
			$next_info = parent::select_one(array('col'=> 'id,title', 'where'=> "id>$aid and classid=".$pro_info['classid'],'order'=>'id desc'));
			if($next_info)
			{
				$next_info = current($next_info);
				if($web_url_module == '1')
				{
					$next_url = $web_url . '/product.php?id=' . $next_info['id'];
				}else if($web_url_module=='2')
				{
					$next_url = $web_url . '/product_' . $next_info['id'] . '.' . $web_url_surfix;
				}
				$pro_info['next'] = "<a href='$next_url'>" . $next_info['title'] . "</a>";
			}else
			{
				$pro_info['next'] = '没有了';
			}
		}
		
		if(in_array('guanlian_list', $option_col))
		{
			$guanlian_list = '';
			parent:: set_table('{tablepre}product');
			if(!empty($pro_info['guanlian']))
			{
				$guanlian_products = parent::select_one(array('col'=> 'id,title', 'where'=> "id in(" . $pro_info['guanlian'] . ")"));
				if($guanlian_products)
				{
					foreach($guanlian_products as $guanlian_product)
					{
						$guan_lian_url = '';
						if($web_url_module == '1')
						{
							$guan_lian_url = $web_url.'/product.php?id=' . $guanlian_product['id'];
						}else if($web_url_module == '2')
						{
							$guan_lian_url = $web_url.'/product_'.$guanlian_product['id'].'.'.$web_url_surfix;
						}
						$guanlian_list .= '<a target="_blank" href="' . $guan_lian_url . '">' . $guanlian_product['title'] . '</a>&nbsp;&nbsp;';
					}
				}
			}
			$pro_info['guanlian_list'] = $guanlian_list;
		}
		
		return $pro_info;
	}
	
	/**
	 * 更新产品信息
	 * @param string|int $id 产品ID
	 * @param array $product_info 产品数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean 成功返回true 失败返回false
	 */
	function update($id, $product_info)
	{
		
		//把主表和附加表分开来
		global $product_col_main, $product_col_addon;
		$this-> set_table('{tablepre}product');
		$product_col_main_arr = explode(',', $product_col_main);
		$product_col_addon_arr = explode(',', $product_col_addon);
		
		foreach($product_info as $key=> $value)
		{
			if(in_array($key, $product_col_addon_arr))
			{
				$col_addon[$key] = $value;
			}else{
				$col_main[$key] = $value;
			}
		}
		//p_r($col_main);
		if(parent::update($col_main, "id=$id"))
		{
			if(is_array($col_addon) && count($col_addon) > 0){
				$this->set_table('{tablepre}product_addon');
				if(parent::update($col_addon, "aid=$id"))
				{
					return true;
				}else{
					return false;
				}
			}else
			{
				return true;
			}
		}else{
			return false;
		}
	}
	
	/**
	 * 删除产品
	 * @param array $id_list 删除的文档ID 以,分隔 比如1,2,3 也可以是id数组
	 * @return int 3表示没有选择要删除的数据 2表示删除数据库中的数据时出错 1表示成功
	 */
	function delete($id_list)
	{
		if(empty($id_list))
		{
			return 3;
		}
		if(!is_array($id_list))
		{
			$id_list_arr = explode(',', $id_list);
		}else
		{
			$id_list_arr = $id_list;
		}
		
		//先删除缩略图
		foreach($id_list_arr as $value)
		{
			//存在图片 就删除
			$info = $this->get_info($value, 'logo,biglogo', array());
			
			if(strlen($info['logo']) > 0)
			{
				$file = WEB_DR."/uploads/product/".$info['logo'];
				@unlink($file);
			}
			
			if(strlen($info['biglogo']) > 0)
			{
				$file = WEB_DR . "/uploads/product/" . $info['biglogo'];
				@unlink($file);
			}
		}
		if(parent::delete($id_list))
		{
			$this-> set_table('{tablepre}product_addon');
			if(parent::delete($id_list, 'aid'))
			{
				return 1;
			}else{
				return 2;
			}
		}else{
			return 2;
		}
	}
	/**
	 * 返回产品的LOGO
	 * @param string|int $id 产品ID
	 * @param boolean $empty_fill_default 当返回的LOGO为空时 是不是返回缩略图
	 * @return string 成功返回产品LOGO文件名 失败返回''
	 */
	function get_logo($id, $empty_fill_default = true)
	{
		$pro_info = $this->get_info($id , 'logo' , array());
		if($pro_info)
		{
			$logo = $pro_info['logo'];
			if(strlen($logo) == 0 && $empty_fill_default)
			{
				$logo = $this->nopic;
			}			
		}
		
		return $logo;
	}
	
	/**
	 * 返回产品数
	 * @param string|int $classid 产品类别ID
	 * @param string $where 条件，不要带where 如id=1
	 * @param boolean $issub 是不是也要返回下级的产品
	 * @return array 返回产品数
	 */
	function get_list_count($class_id, $where = '', $is_sub=0)
	{
		$this-> set_table('{tablepre}product');
		global $web_url, $web_url_module, $web_url_surfix;
		
		//得出要返回的class_id
		if($class_id>0)
		{
			if($is_sub)
			{
				$class_id_list = $this->get_sub_class_id_list($class_id, true);
				//var_dump($class_id_list);
			}else
			{
				$class_id_list = $class_id;
			}
		}else
		{
			if($is_sub)
			{
				$class_id_list = $this->get_sub_class_id_list($class_id, false);
			}else
			{
				$class_id_list = '';
			}
		}
		
		$where_arr = array();
		
		if(!empty($where))
		{
			array_push($where_arr, $where);
		}
		if(!empty($class_id_list))
		{
			array_push($where_arr, 'classid in(' . $class_id_list . ')');
		}
		
		if($where_arr)
		{
			$canshu['where'] = implode(' and ', $where_arr);
		}
		$canshu['col'] = 'count(id) as num';
		//p_r($canshu);
		parent:: set_table('@#@product');
		$info = parent::select_one($canshu);
		
		return $info[0]['num'];
	}
}

?>