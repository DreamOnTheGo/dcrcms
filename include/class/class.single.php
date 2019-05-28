<?php

defined('IN_DCR') or exit('No permission.'); 

/**
 * 单页面处理类，即后台的公司资料处理
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


class cls_single extends cls_data
{
	
	/**
	 * Article的构造函数 无需传参数
	 */
	function __construct()
	{
		parent::__construct('{tablepre}single');
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
	 * 返回单个资料的信息内容
	 * @param string|int $aid 文档ID
	 * @param array $col 要返回的字段列 如你要返回id,title为：array('id','title') 如果为arrya()时返回全部字段
	 * @return array 返回单个资料
	 */
	function get_info($aid, $col = '*')
	{
		$single_info = parent::select_one_ex(array('col'=>$col, 'where'=> "id=$aid"));
		$single_info['position'] = '<a href="' . $web_url.'">首页</a>>>'.$newsInfo['title'];
		return $single_info;
	}
	
	/**
	 * 插入一个单页面
	 * @param array $single_info 插入的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return int 成功返回true 失败返回false
	 */
	function add($single_info)
	{
		return parent::insert($single_info);
	}
	
	/**
	 * 更新一个文档
	 * @param string|int $id 文档ID
	 * @param array $single_info 更新的数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示插入title的值为 标题
	 * @return boolean 成功返回true 失败返回false
	 */
	function update($id, $single_info)
	{
		return parent::update($single_info, "id=$id");
	}
	
	/**
	 * 更新文档的点击数
	 * @param string|int $aid 新闻ID
	 * @param string $jizhunclick 更新的基准列名，默认为click
	 * @return boolean 成功返回true 失败返回false
	 */
	 function update_click($id, $jizhun_col = 'click')
	{		
		$this->set_table('{tablepre}news');
		
		return parent::update(array("$jizhun_col"=> "$jizhun_col+1") ,"id=$id");
	}
	
	/**
	 * 删除指定ID数组的单页面
	 * @param array $id_list 删除的ID数组 比如要删除ID为1，2，3的文档 则为：array(1,2,3)
	 * @return boolean 成功返回true 失败返回false
	 */
	function delete($id_list)
	{
		return parent::delete($id_list);
	}
	
	/**
	 * 调用单页面列表
	 * @param array $canshu 参数列表：
	 * @param array $canshu['col']        要返回的字段列 以,分隔
	 * @param array $canshu['where']      条件
	 * @param array $canshu['limit']      返回的limit
	 * @param array $canshu['group']      分组grop
	 * @param array $canshu['order']      排序 默认是istop desc,id desc
	 * @return array 返回新闻列表
	 */
	function get_list($canshu)
	{
		return parent::select_ex($canshu);
	}
}

?>