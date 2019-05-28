<?php

/**
 * 后台管理员类
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

require_once(WEB_CLASS . '/class.data.php');

class cls_member_admin extends cls_data
{
	private $username;
	private $password;
	
	function __construct($username, $password)
	{
		//密码应该为加密后的字符串
		$this->username = $username;
		$this->password = $password;
		parent::__construct('{tablepre}admin');
	}
	function cls_member_admin($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
	}
	
	/**
	 * 验证用户名
	 * @return boolean
	 */
	function yz()
	{
		$info = parent::select_one(array('col'=>'id', 'where'=>"username='" . $this->username."' and password='".$this->password."'"));
		$info = current($info);
		
		return $info['id'];
	}
	
	/**
	 * 验证用户名
	 * @param array $canshu 参数列表：
	 * @param array $canshu['col']        要返回的字段列 以,分隔
	 * @param array $canshu['where']      条件
	 * @param array $canshu['limit']      返回的limit
	 * @param array $canshu['group']      分组grop
	 * @param array $canshu['order']      排序 默认是istop desc,id desc
	 * @return boolean
	 */
	function get_info($canshu = array())
	{
		if(!empty($canshu['where']))
		{
			$canshu['where'] .= " and username='" . $this->username . "'";
		}else
		{
			$canshu['where'] = " username='" . $this->username . "'";
		}
		
		$info = parent::select_one($canshu);
		
		return current($info);
	}
		
	/**
	 * 登陆
	 * @return boolean
	 */
	function login(){
		//登陆
		$_SESSION['admin_u'] = $this->username;
		$_SESSION['admin_p'] = $this->password;
		
		$login_info = array(
							'loginip'=> get_ip(),
							'logintime'=> date('Y-m-d H:i:s'),
							'logincount'=> 'logincount+1'
							);
		parent::update($login_info, "username='" . $this->username . "'");
	}
		
	/**
	 * 修改密码
	 * @param string $password 新密码
	 * @return boolean
	 */
	function changpas($password)
	{
		
		$info = array(
							'password'=>jiami($password)
							);
		//p_r($info);
		return parent::update($info, "username='" . $this->username . "'");
	}	
		
	/**
	 * 退出管理
	 * @return true
	 */
	function logout()
	{
		unset($_SESSION['admin_u']);
		unset($_SESSION['admin_p']);
	}
}
?>