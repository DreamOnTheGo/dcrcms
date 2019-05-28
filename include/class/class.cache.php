<?php

defined('IN_DCR') or exit('No permission.'); 

/**
 * 缓存类
 * ===========================================================
 * 版权所有 (C) 2006-2020 我不是稻草人，并保留所有权利。
 * 网站地址: http://www.dcrcms.com
 * ----------------------------------------------------------
 * 这是免费开源的软件；您可以在不用于商业目的的前提下对程序代码
 * 进行修改、使用和再发布。
 * 不允许对程序修改后再进行发布。
 * ==========================================================
 * @author:     我不是稻草人 <junqing124@126.com>
 * @version:    v1.0.3
 * @package class
 * @since 1.0.8
*/

class cls_cache
{
	var $cache_dir;  //缓存目录
	var $cache_limit_time   = 0; //缓存时间
	var $cache_file_name = ''; //缓存文件名
	var $cache_file_ext = 'php'; //缓存文件扩展名
  
	/**
	 * 构造函数
	 * @param string $cache_limit_time 缓存时间
	 * @param string $cache_file_name 缓存文件名
	 * @param string $cache_dir 缓存目录
	 * @return true 返回一个缓存类实例
	 */	
	function __construct( $cache_file_name = '', $cache_limit_time = 0, $cache_dir = '' )
	{
		$this->cache_limit_time = $cache_limit_time;
		$this->cache_file_name = $cache_file_name;
		if(empty($cache_dir))
		{
			$this->cache_dir = WEB_CACHE;
		}else
		{
			$this->cache_dir = $cache_dir;
		}
	}
	  
	/**
	 * 写入缓存
	 * @param string $cache_content 缓存内容 缓存内容为数组 以$cache_arr为变量名 缓存内容示例:$cache_arr=array('1');
	 * @return true;
	 */	
	function write($cache_content)
	{
		require_once(WEB_CLASS . '/class.file.php');
		$cache_file = $this->cache_dir . '/' . $this->cache_file_name;
		$cls_file = new cls_file($cache_file);
		$cls_file->set_text($cache_content);
		
		$r_val = $cls_file->write();
		return $r_val;
	} 
	  
	/**
	 * 读取缓存
	 * @return array 缓存结果;
	 */	
	function read()
	{
		include_once($this->get_cache_dir() . '/' . $this->cache_file_name);
		
		return $cache_arr;
	} 
	
	/**
	 * 检查缓存是不是存在
	 * @return boolean;
	 */	
	function check()
	{
		$cache_file = $this->cache_dir . '/' . $this->cache_file_name;
		return file_exists($cache_file) && filemtime($cache_file) > (time() - $this->cache_limit_time);
	}
	
	/**
	 * 获取缓存目录
	 * @param string $cache_content 缓存内容
	 * @return true;
	 */	
	function get_cache_dir()
	{
		
		return $this->cache_dir;
	}	
}

?>