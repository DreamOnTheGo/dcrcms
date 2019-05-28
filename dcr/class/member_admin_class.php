<?php
class Member_Admin{
	private $username;
	private $password;
	function __construct($username,$password){
		//密码应该为加密后的字符串
		$this->username=$username;
		$this->password=$password;
	}
	function Member_Admin($username,$password){
		$this->username=$username;
		$this->password=$password;
	}
	function yz(){
		//登陆验证
		global $db;
		$sql="select id from {tablepre}admin where username='".$this->username."' and password='".$this->password."'" ;
		//var_dump($db->HasRs($sql));
		return $db->HasRs($sql);
	}
	function login(){
		//登陆
		$_SESSION['admin_u']=$this->username;
		$_SESSION['admin_p']=$this->password;
		//更新登陆信息
		global $db;
		$ip=GetIp();
		$sql="update {tablepre}admin set loginip='$ip',logintime='".date('Y-m-d H:i:s')."',logincount=logincount+1";
		$db->ExecuteNoneQuery($sql);
	}
	function changpas($password){
		$sql="update {tablepre}admin set password='".jiami($password)."' where username='".$this->username."'";
		global $db;
		return $db->ExecuteNoneQuery($sql);
	}
	function logout(){
		unset($_SESSION['admin_u']);
		unset($_SESSION['admin_p']);
	}
}
?>