<?php

defined('IN_DCR') or exit('No permission.'); 

/**
 * 新闻类
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

class cls_news extends cls_data
{
	/**
	 * Article的构造函数 无需传参数
	 */
	function __construct()
	{
		parent::__construct('{tablepre}news');
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
	 * 添加新闻分类
	 * @param array $class_info 插入的新闻分类 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean 成功返回true 失败返回false
	 */
	function add_class($class_info)
	{
		$this->set_table('{tablepre}news_class');
		return parent::insert($class_info);
	}
	
	
	/**
	 * 返回新闻类列表
	 * @param array $canshu 参数列表：
	 * @param array $canshu['col']        要返回的字段列 以,分隔
	 * @param array $canshu['where']      条件
	 * @param array $canshu['limit']      返回的limit
	 * @param array $canshu['group']      分组grop
	 * @param array $canshu['order']      排序 默认是istop desc,id desc
	 * @return array 返回产品列表
	 */
	function get_class_list($canshu = array())
	{
		if(empty($canshu['order']))
		{
			$canshu['order'] = 'id desc';
		}
		$this-> set_table('{tablepre}news_class');
		$info = parent::select_ex($canshu);
		global $web_url_module, $web_url_surfix;
		foreach($info as $i_key=>$i_value)
		{
			if($web_url_module == '1')
			{
				$info[$i_key]['url'] = 'news_list.php?classid=' . $i_value['id'];
			}else if($web_url_module == '2')
			{
				$info[$i_key]['url'] = 'news_list_' . $i_value['id'] . '.' . $web_url_surfix;
			}
		}
		
		return $info;
	}
	
	/**
	 * 返回新闻类的信息
	 * @param string|int $id 新闻分类ID
	 * @param array $col 要返回的字段列 以,分隔
	 * @return array 返回值为这个新闻类的信息(Array)
	 */
	function get_class_info($id, $col = '*')
	{
		$this->set_table('{tablepre}news_class');
		$info = parent::select_one(array('col'=>$col, 'where'=>"id=$id"));
		
		return current($info);
	}
	
	/**
	 * 更新新闻分类信息
	 * @param string|int $id 新闻分类ID
	 * @param array $class_info 更新的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean 成功返回true 失败返回false
	 */
	function update_class($id, $class_info = array())
	{
		$this-> set_table('{tablepre}news_class');
		
		return parent::update($class_info, "id=$id");
	}
	
	/**
	 * 删除新闻分类
	 * @param array $id_list 删除的文档ID 以,分隔 比如1,2,3 也可以是id数组
	 * @return boolean 成功返回true 失败返回false
	 */
	function delete_class($id_list)
	{
		$this->set_table('{tablepre}news_class');
		
		return parent:: delete($idarr);
	}
	
	/**
	 * 返回新闻分类的数量
	 * @return int 返回新闻分类的数量
	 */
	function get_class_num()
	{
		$this->set_table('{tablepre}news_class');
		$info = parent:: select_one(array('col'=>'count(id) as sum'));
		$info = current($info);
		
		return $info['sum'];
	}
	
	/**
	 * 返回新闻类别名
	 * @param string|int $id 新闻类别ID
	 * @return string 成功则返回新闻类名 失败返回''
	 */
	function get_class_name($id)
	{
		$this->set_table('{tablepre}news_class');
		$info = parent:: select_one(array('col'=>'classname', 'where'=>"id=$id"));
		$info = current($info);
		
		return $info['classname'];
	}
	
	/**
	 * 返回单个新闻的信息内容
	 * @param string|int $id 文档ID
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @return array 返回新闻数据
	 */
	function get_info($id, $col = '',  $option_col = array('logo', 'position', 'prev', 'next'))
	{
		$this-> set_table('{tablepre}news');
		global $db, $web_url, $web_url_module, $web_url_surfix, $news_col_main, $news_col_addon, $news_col_list;
		
		if(empty($col))
		{
			$col = $news_col_list;
		}
		//echo $col;
		$col_arr = explode(',', $col);
		
		//下面的操作都要id,classid 如果没有这个则加上
		if(!in_array('classid',$col_arr))
		{
			array_push($col_arr,'classid');
		}		
		if(!in_array('id',$col_arr))
		{
			array_push($col_arr,'id');
		}
		
		$news_col_main_arr = explode(',', $news_col_main);
		$news_col_addon_arr = explode(',', $news_col_addon);
		
		$col_main = $col_addon = array();
		foreach($col_arr as $key=> $value)
		{
			if(in_array($value, $news_col_addon_arr))
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
		
		parent:: set_table('{tablepre}news');
		$news_main_info = parent:: select_one(array('col'=>$col_main_list, 'where'=>"id=$id"));
		$news_main_info = current($news_main_info);
		if(!$news_main_info)
		{
			$news_main_info = array();
		}
		if(!empty($col_addon_list))
		{
			parent:: set_table('{tablepre}news_addon');
			$news_addon_info = parent:: select_one(array('col'=>$col_addon_list, 'where'=>"aid=$id"));
			if(!$news_addon_info)
			{
				$news_addon_info = array();
			}else
			{
				$news_addon_info = current($news_addon_info);
			}
		}else
		{
			$news_addon_info = array();
		}
		$news_info = array_merge($news_main_info, $news_addon_info);

		//返回当前路径
		//获得栏目信息
		
		if(in_array('position', $option_col))
		{
			$classname = $this->get_class_name($news_info['classid']);
			
			$position = '<a href="' . $web_url . '">首页</a>>><a href="news_list.php">新闻中心</a>>><a href="' . $web_url . '/news_list.php?classid=' . $news_info['classid'] . '">' . $classname . '</a>>>' . $news_info['title'];
			
			$news_info['position'] = $position;
		}
		
		if(in_array('logo', $option_col))
		{
			if(empty($news_info['logo']))
			{
				$news_info['logo'] = $this->nopic;
			}else{
				$news_info['logo'] = $web_url . '/uploads/news/' . $news_info['logo'];
			}
		}
		
		if(in_array('prev', $option_col))
		{
			//上一篇
			parent::set_table('{tablepre}news');
			
			$prev_info = parent::select_one(array('col'=>'id,title', 'where'=>"id<$id and classid=".$news_info['classid'], 'order'=>'id desc'));			
			if($prev_info)
			{
				$prev_info = current($prev_info);
				if($web_url_module == '1')
				{
					$prev_url = $web_url . '/news.php?id=' . $prev_info['id'];
				}else if($web_url_module=='2')
				{
					$prev_url = $web_url . '/news_' . $prev_info['id'] . '.' . $web_url_surfix;
				}
				$news_info['prev'] = '<a href="' . $prev_url . '">' . $prev_info['title'] . '</a>';
			}else
			{
				$news_info['prev'] = '没有了';
			}
		}
		
		if(in_array('next', $option_col))
		{
			//下一篇
			parent::set_table('{tablepre}news');
			
			$next_info = parent::select_one(array('col'=>'id,title', 'where'=>"id>$id and classid=".$news_info['classid']));
			if($next_info)
			{
				$next_info = current($next_info);
				if($web_url_module == '1')
				{
					$next_url = $web_url . '/news.php?id=' . $next_info['id'];
				}else if($web_url_module == '2')
				{
					$next_url = $web_url . '/news_' . $next_info['id'] . '.' . $web_url_surfix;
				}
				$news_info['next'] = '<a href="' . $next_url . '">' . $next_info['title'] . '</a>';
			}else
			{            
				$news_info['next'] = '没有了';
			}
		}
		
		return $news_info;
	}
	/**
	 * 插入一个新闻
	 * @param array $news_info 插入的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return int 返回值为文档的ID,失败返回0
	 */
	function add($news_info)
	{				
		//把主表和附加表分开来
		global $news_col_main, $news_col_addon;
		$this-> set_table('{tablepre}news');
		$news_col_main_arr = explode(',', $news_col_main);
		$news_col_addon_arr = explode(',', $news_col_addon);
		
		foreach($news_info as $key=> $value)
		{
			if(in_array($key,$news_col_addon_arr))
			{
				$col_addon[$key] = $value;
			}else{
				$col_main[$key] = $value;
			}
		}
		$aid = parent:: insert($col_main);
		
		if($aid){
			$col_addon['aid'] = $aid;
			$this-> set_table('{tablepre}news_addon');
			parent:: insert($col_addon);
			
			return $aid;
		}else{
			
			return false;
		}
				
	}
	
	/**
	 * 更新一个文档
	 * @param string|int $id 新闻ID
	 * @param array $news_info 更新的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean 成功返回true 失败返回false
	 */
	function update($id, $news_info)
	{
		//把主表和附加表分开来
		global $news_col_main, $news_col_addon;
		$this-> set_table('{tablepre}news');
		$news_col_main_arr = explode(',', $news_col_main);
		$news_col_addon_arr = explode(',', $news_col_addon);
		
		foreach($news_info as $key=> $value)
		{
			if(in_array($key, $news_col_addon_arr))
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
				$this->set_table('{tablepre}news_addon');
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
	 * 更新文档的点击数
	 * @param string|int $id 新闻ID
	 * @param string $jizhun_col 更新的基准列名，默认为click
	 * @return boolean 成功返回true 失败返回false
	 */
	function update_click($id, $jizhun_col = 'click')
	{		
		$this->set_table('{tablepre}news');
		
		return parent::update(array("$jizhun_col"=> "$jizhun_col+1") ,"id=$id");
	}
	
	/**
	 * 删除指定ID数组的新闻
	 * @param array $id_list 删除的文档ID 以,分隔 比如1,2,3 也可以是id数组
	 * @return int 3表示没有选择要删除的数据 2表示删除数据库中的数据时出错 1表示成功
	 */
	function delete($id_list)
	{
		
		$this-> set_table('{tablepre}news');
		if(!is_array($id_list))
		{
			$id_list_arr = explode(',', $id_list);
		}else
		{
			$id_list_arr = $id_list;
		}
				
		//先删除缩略图
		foreach($id_list_arr as $id)
		{
			//存在图片 就删除
			$info = $this->get_info($id, 'logo', array());
			
			if(strlen($info['logo']) > 0)
			{
				$file = WEB_DR."/uploads/news/".$info['logo'];
				@unlink($file);
			}
			
		}
		parent::set_table('{tablepre}news');
		if(parent::delete($id_list)){
			$this-> set_table('{tablepre}news_addon');
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
	 * 返回新闻的LOGO
	 * @param string|int $id ID
	 * @param boolean $empty_fill_default 当返回的LOGO为空时 是不是返回缩略图
	 * @return string 成功返回LOGO文件名 失败返回''
	 */
	function get_logo($id, $empty_fill_default = true)
	{
		$this-> set_table('{tablepre}news');
		$info = $this->get_info($id, 'logo', array());
		$logo = $info['logo'];
		if(strlen($logo)==0 && $empty_fill_default)
		{
			$logo = $this->nopic;
		}
		
		return $logo;
	}
	
	/**
	 * 调用新闻列表
	 * @param string|int $classid 新闻类型
	 * @param array $canshu 参数列表：
	 * @param array $canshu['col']        要返回的字段列 以,分隔
	 * @param array $canshu['where']      条件
	 * @param array $canshu['limit']      返回的limit
	 * @param array $canshu['group']      分组grop
	 * @param array $canshu['order']      排序 默认是istop desc,id desc
	 * @param string $date_mode 新闻列表日期格式 参数和date函数一样 (含)1.0.6以后有效
	 * @return array 返回返回新闻列表
	 */
	function get_list($classid, $canshu = array(), $date_mode = 'Y-m-d H:i:s')
	{
		global $web_url, $web_url_module, $web_url_surfix;
		
		if(empty($canshu['order']))
		{
			$canshu['order'] = 'istop desc,id desc';
		}
		
		$where_arr = array();
		if($classid)
		{
			array_push($where_arr, "classid=$classid");
		}
		if(!empty($canshu['where']))
		{
			array_push($where_arr, $canshu['where']);			
		}
		
		if(is_array($where_arr))
		{
			$where_option = implode(' and ', $where_arr);
		}
		$canshu['where'] = $where_option;
		
		$this-> set_table('{tablepre}news');
		$news_list = parent::select_ex($canshu);
		
		$a_sum = count($news_list);
		for($i=0; $i < $a_sum; $i++){
			if(empty($news_list[$i]['logo']))
			{
				$news_list[$i]['logo'] = $this->nopic;
			}else
			{
				$news_list[$i]['logo'] = $web_url.'/uploads/news/'.$news_list[$i]['logo'];
				//echo $news_info['logo'];
			}
			
			if($news_list[$i]['addtime']>0)
			{
				$news_list[$i]['addtime'] = date($date_mode, $news_list[$i]['addtime']);
			}
			if($news_list[$i]['updatetime']>0)
			{
				$news_list[$i]['updatetime'] = date($date_mode, $news_list[$i]['updatetime']);
			}
			$news_list[$i]['innerkey'] = $i+1; //内部使用的下标值
			
			if($web_url_module == '1')
			{
				$news_list[$i]['url'] = "news.php?id=" . $news_list[$i]['id'];
			}else if($web_url_module == '2')
			{
				$news_list[$i]['url'] = "news_" . $news_list[$i]['id'] . "." . $web_url_surfix;
			}
		}
		
		return $news_list;
	}
	
	/**
	 * 返回新闻数量
	 * @param string|int $classid 新闻类型
	 * @return int 返回指定新闻类ID的新闻数量
	 */
	function get_news_count($classid, $where = '')
	{
		$canshu = array();
		$this-> set_table('{tablepre}news');
		$where_arr = array();
		if($classid != 0){
			array_push($where_arr, 'classid=' . $classid);
		}
		
		if(!empty($where))
		{
			array_push($where_arr, $where);
		}
		
		if(is_array($where_arr))
		{
			$where_option = implode(' and ',$where_arr);
		}
		
		$canshu['where'] = $where_option;
		
		$canshu['col'] = 'count(id) as sum';
		$info = parent::select_one($canshu);
		$info = current($info);
		return $info['sum'];
	}
}

?>