<?php

defined('IN_DCR') or exit('No permission.'); 

/**
 * 更新 修改全站配置的类
 * ===========================================================
 * 版权所有 (C) 2005-2020 我不是稻草人，并保留所有权利。
 * 网站地址: http://www.dcrcms.com
 * ----------------------------------------------------------
 * 这是免费开源的软件；您可以在不用于商业目的的前提下对程序代码
 * 进行修改、使用和再发布。
 * 不允许对程序修改后再进行发布。
 * ==========================================================
 * @author:     我不是稻草人 <junqing124@126.com>
 * @version:    v2.0
 * @package class
 * @since 1.0.8
*/

class cls_config
{
	function __construct()
	{
	}
	
	/**
	 * 更新全站配置
	 * @param array $config_info 配置数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示配置title的值为 标题
	 * @param string $config_file_name 配置文件名
	 * @return string 返回 r1为修改的配置文件不允许修改,返回 r2为修改成功,返回 r3为写入配置文件失败
	 */
	function modify($config_info, $config_file_name = '')
	{
		if( empty($config_file_name) )
		{
			$config_file_name = WEB_INCLUDE . '/config.common.php';
		}
		
		require_once(WEB_CLASS . '/class.file.php');
		$cls_file = new cls_file($config_file_name);
		$config_str = $cls_file->read();
		//替换
		foreach($config_info as $key=> $value)
		{
			$config_str = preg_replace("/[$]" . $key . "\s*\=\s*[\"'].*?[\"'];/is", "\$" . $key . " = '" . $value . "';", $config_str);
		}
		$cls_file->set_text($config_str);
		
		if($cls_file->write())
		{			
			return 'r2';
		}else
		{
			
			return 'r1';
		}
	}
}

?>