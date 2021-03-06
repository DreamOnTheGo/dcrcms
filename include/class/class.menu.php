<?php

defined('IN_DCR') or exit('No permission.'); 

/**
 * 导航条类
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


class cls_menu extends cls_data
{
	private $menu_type_list; //导航条类型
	private $target_list;//打开方式类型
	/**
	 * 无需传参数
	 */
	function __construct()
	{
		$this->menu_type_list = array('1'=>'公司资料', '2'=>'新闻中心', '3'=>'产品中心', '4'=>'在线定单', '5'=>'自定义链接');
		$this->target_list = array(''=>'当前窗口', '_blank'=>'新窗口');
		parent::__construct('{tablepre}menu');
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
	 * 返回导航条类型
	 * @return array
	 */
	function get_menu_type_list()
	{
		
		return $this->menu_type_list;
	}
	
	/**
	 * 返回导航条打开方式
	 * @return array
	 */
	function get_target_list()
	{
		
		return $this->target_list;
	}
	
	/**
	 * 返回单个资料的信息内容
	 * @param string|int $aid 文档ID
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @return array 返回单个资料
	 */
	function get_info($aid, $col = '*')
	{
		$menu_info = parent::select_one(array('col'=>$col, 'where'=> "id=$aid"));
		$menu_info = current($menu_info);
		return $menu_info;
	}
	
	/**
	 * 插入一个menu
	 * @param array $menu_info 插入的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return int 成功返回true 失败返回false
	 */
	function add($menu_info)
	{	
		parent:: set_table('@#@menu');
		$r_val = parent::insert($menu_info);
		$this->write_cache();
		
		return $r_val;
	}
	
	/**
	 * 更新菜单项
	 * @param string|int $id 文档ID
	 * @param array $menu_info 更新的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @param boolean $is_update_cache 是否更新缓存
	 * @return boolean 成功返回true 失败返回false
	 */
	function update($id, $menu_info, $is_update_cache = true)
	{
		$r_val = parent::update($menu_info, "id=$id");
		if($is_update_cache)
		{
			$this->write_cache();
		}
		
		return $r_val;
	}
	
	/**
	 * 删除指定ID数组的单页面
	 * @param array $id_list 删除的ID数组 比如要删除ID为1，2，3的文档 则为：array(1,2,3)
	 * @return boolean 成功返回true 失败返回false
	 */
	function delete($id_list)
	{
		
		$r_val = parent::delete($id_list);
		$this->write_cache();
		
		return $r_val;
	}
	
	/**
	 * 返回导航条列表
	 * @param array $canshu 参数列表：
	 * @param array $canshu['col']        要返回的字段列 以,分隔
	 * @param array $canshu['where']      条件
	 * @param array $canshu['limit']      返回的limit
	 * @param array $canshu['group']      分组grop
	 * @param array $canshu['order']      排序 默认是order_id
	 * @return array 返回新闻列表
	 */
	function get_list($canshu = array())
	{
		global $web_url_module, $web_url_surfix;
		if( empty($canshu['order']) )
		{
			$canshu['order'] = 'order_id';
		}		
		
		require_once(WEB_CLASS . '/class.cache.php');
		$cache_file_name = 'menu.php';
		//1728000 为20天 缓存20天
		$cls_cache = new cls_cache( $cache_file_name, 1728000 );
		if($cls_cache->check())
		{
			//缓存存在
			$menu_list = $cls_cache->read();
		}else
		{
			//缓存不存在
			$r_val = $this->write_cache();
			if('r2' == $r_val || 'r1' == $r_val)
			{
				//缓存不可写
				$menu_list = parent::select_ex($canshu);
			}else
			{
				$menu_list = $cls_cache->read();
			}			
		}
		
		if( !is_array($menu_list) )
		{
			return false;
		}
		//得出url
		foreach($menu_list as $key=> $value)
		{
			switch($value['menu_type'])
			{
				case 1:
					if( 1 == $web_url_module )
					{
						$url = '?mod=info&id=' . $menu_list[$key]['single_id'];
					}else
					{
						$url = 'info_' . $menu_list[$key]['single_id'] . '.' . $web_url_surfix;
					}
					$menu_list[$key]['url'] = $url;
					break;
				case 2:
					if( 1 == $web_url_module )
					{
						if($value['news_class_id'])
						{
							$url = '?mod=news_list&classid=' . $value['news_class_id'];
						}else
						{
							$url = '?mod=news_list';
						}						
					}else
					{
						if( $value['news_class_id'] )
						{
							$url = 'news_list_.' . $value['news_class_id'] . $web_url_surfix;
						}else
						{
							$url = 'news_list.' . $web_url_surfix;
						}
					}
					$menu_list[$key]['url'] = $url;
					break;
				case 3:
					if(1 == $web_url_module)
					{
						if($value['product_class_id'])
						{
							$url = '?mod=product_list&classid=' . $value['product_class_id'];
						}else
						{
							$url = '?mod=product_list';
						}						
					}else
					{
						if($value['product_class_id'])
						{
							$url = 'product_list_.' . $value['product_class_id'] . $web_url_surfix;
						}else
						{
							$url = 'product_list.' . $web_url_surfix;
						}
					}
					$menu_list[$key]['url'] = $url;
					break;
				case 4:
					if(1 == $web_url_module)
					{
						$url = '?mod=hudong';
					}else
					{
						$url = '?mod=hudong.' . $web_url_surfix;
					}
					$menu_list[$key]['url'] = $url;
					break;
				
			}
		}
		
		return $menu_list;
	}
		
	/**
	 * 写导航条列表
	 * @return true
	 */
	public function write_cache($parent_id = 0)
	{
		require_once(WEB_CLASS . '/class.cache.php');
		$cache_file_name = 'menu.php';
		$cls_cache = new cls_cache($cache_file_name);
		
		
		$menu_list = parent::select_ex(array('order'=> 'order_id'));
			
		$menu_list_txt = var_export($menu_list, true);
		if(!empty($menu_list_txt))
		{
			$menu_list_txt = "<?php\r\n\r\n/*导航条*/\r\n\r\n \$cache_arr = " .$menu_list_txt . ";\r\n\r\n?>";
		}
		$cls_cache->write($menu_list_txt);
	}
}

?>