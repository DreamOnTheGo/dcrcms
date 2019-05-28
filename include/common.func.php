<?php
	/**
	 * @author 我不是稻草人 www.cntaiyn.cn
	 * @version 1.0
	 * @copyright 2006-2010
	 * @package function
	 * 函数encrypt,对字符串进行加密
	 * @param string $s 要加密的字符串
	 * @return string
	 */
	function encrypt($s){
		return crypt(md5($s),'dcr');
	}
	/**
	 * 函数jiami,对字符串进行加密 这里调用encrypt函数
	 * @param string $s 要加密的字符串
	 * @return string
	 */
	function jiami($s){
		return encrypt($s);
	}
	/**
	 * 函数ShowNext,生成javascript跳转
	 * @param string $msg 显示信息
	 * @param string $url 要跳转的地址
	 * @param string $istop 是不是在父窗口中跳转
	 * @return boolean
	 */
	function ShowNext($msg,$url,$istop=0){
		if(strlen($msg)>0){
			if($istop){
				$mymsg="<script type='text/javascript'>alert('".$msg."');top.location.href='".$url."';</script>";
			}else{
				$mymsg="<script type='text/javascript'>alert('".$msg."');location.href='".$url."';</script>";
			}
		}else{
			if($istop){
				$mymsg="<script type='text/javascript'>top.location.href='".$url."';</script>";
			}else{
				$mymsg="<script type='text/javascript'>location.href='".$url."';</script>";
			}
		}
		echo $mymsg;
		exit;
	}
	/**
	 * 函数ShowBack,返回上一页
	 * @param string $msg 显示信息
	 * @return boolean
	 */
	function ShowBack($msg){
		echo "<script>alert('".$msg."');history.back();</script>'";
		exit;
	}
	/**
	 * 函数Redirect,跳转
	 * @param string $url 要跳转的地址
	 * @return boolean
	 */
	function Redirect($url){
		echo "<script>location.href='".$url."';</script>'";
		exit;
	}
	/**
	 * 函数mysubstr,截取字符串 能对中文进行截取
	 * @param string $str 要截取的字条串
	 * @param string $start 开始截取的位置
	 * @param string $len 截取的长度
	 * @return string
	 */
	function mysubstr($str, $start, $len) {
		$tmpstr = "";
		$strlen = $start + $len;
		for($i = 0; $i < $strlen; $i++) {
			if(ord(substr($str, $i, 1)) > 0xa0) {
				$tmpstr .= substr($str, $i, 2);
				$i++;
			} else
				$tmpstr .= substr($str, $i, 1);
		}
		return $tmpstr;
	}
	/**
	 * 函数PutCookie,写入cookie
	 * @param string $key cookie名
	 * @param string $value cookie值
	 * @param string $kptime cookie有效期
	 * @param string $pa cookie路径
	 * @return boolean
	 */
	function PutCookie($key,$value,$kptime=0,$pa="/")
	{
		setcookie($key,$value,time()+$kptime,$pa);
	}
	/**
	 * 函数DropCookie,删除cookie
	 * @param string $key cookie名
	 * @return boolean
	 */	
	function DropCookie($key)
	{
		setcookie($key,'',time()-360000,"/");
	}
	/**
	 * 函数GetCookie,获取cookie值
	 * @param string $key cookie名
	 * @return string
	 */		
	function GetCookie($key)
	{
		if( !isset($_COOKIE[$key]))
		{
			return '';
		}
		else
		{
			return $_COOKIE[$key];		
		}
	}
	/**
	 * 函数GetIP,获取当前IP
	 * @return string
	 */	
	function GetIP()
	{
		if(!empty($_SERVER["HTTP_CLIENT_IP"]))
		{
			$cip = $_SERVER["HTTP_CLIENT_IP"];
		}
		else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
			$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		else if(!empty($_SERVER["REMOTE_ADDR"]))
		{
			$cip = $_SERVER["REMOTE_ADDR"];
		}
		else
		{
			$cip = '';
		}
		preg_match("/[\d\.]{7,15}/", $cip, $cips);
		$cip = isset($cips[0]) ? $cips[0] : 'unknown';
		unset($cips);
		return $cip;
	}
	/**
	 * 函数GetTopUrl,获取顶级域名
	 * @param string $url 要操作的地址
	 * @return string
	 */	
	function GetTopUrl($url=''){
		if(empty($url)){
			$url=$_SERVER['SERVER_NAME'];
		}
		$t_url=parse_url($url);
		$t_url=str_replace('www.','',$t_url['path']);
		return $t_url;
	}
	/**
	 * 函数UplodeFile,上传文件
	 * @param string $fileInput 上传文件框的名字
	 * @param string $dirName 文件上传后放的目录名
	 * @param string $fileName 文件名
	 * @param string $sl 生成缩略图的大小 array('width'=>100,'height'=>100); 没有表示不缩放
	 * @param string $uptypes 允许上传的类型
	 * @param string $maxFileSize 最大上传大小
	 * @return string|boolean
	 */
	function UplodeFile($fileInput,$dirName,$fileName='',$sl=array(),$uptypes=array('image/jpg','image/jpeg', 'image/png', 'image/pjpeg', 'image/gif', 'image/bmp', 'image/x-png','text/plain'),$maxFileSize=5000000){
		if(is_uploaded_file($_FILES[$fileInput]['tmp_name'])){
			$file=$_FILES[$fileInput];
			if($maxFileSize<$file["size"]){
				ShowBack('您上传的文件超过文件上传大小限制');
			}
			if(!in_array($file["type"], $uptypes)){
				ShowBack('你上传的文件不在允许上传的类型之内');
			}
			if(!file_exists($dirName)){mkdir($dirName); }
			
			$oldName=$file['tmp_name'];
			$pinfo=pathinfo($file["name"]); 
			$ftype=$pinfo[extension]; 
			if(strlen($fileName)==0){
				$fileName = $dirName.date(ymdhms).rand(1000,9999).".".$ftype; 
			}else{
				$t_a=explode('.',$fileName);
				if(count($t_a)>1){
					$fileName = $dirName.$fileName;
				}else{
					$fileName = $dirName.DIRECTORY_SEPARATOR.$fileName.".".$ftype; 
				}
			}
			if(!move_uploaded_file($oldName,$fileName)){
				return false;
			}else{
				if(is_array($sl) && count($sl)>0){
					//要缩放图
					require WEB_CLASS."imgsize.php";
					$img = new Image($fileName);
					$img->changeSize($sl['width'],$sl['height']);//改变尺寸
					$img->create($fileName);
					$img->free();
				}
				return $fileName;
			}
		}else{
			//没有上传文件
			return false;
		}
	}	
	/**
	 * 函数ShowMsg,显示提示信息
	 * @param string $msg 信息内容
	 * @param string $msgType 信息类型1为一般信息 2为错误信息
	 * @param string $back 返回地址 如果有多个则传入数组
	 * @param string $msgTitle 信息标题
	 * @return boolean
	 */
	function ShowMsg($msg,$msgType=1,$back='',$msgTitle='信息提示'){
		/*
		 *msg显示信息 如果要多条则传入数组
		 *msgType信息类型1为一般信息 2为错误信息
		 *back为返回地址 如果有多个则传入数组
		 *msgTitle为信息标题
		 */
		if(is_array($msg)){
			foreach($msg as $value){
				if($msgType==2){
					$msg_t.="<li style='border-bottom:1px dotted #CCC;padding-left:5px;color:red;'>&middot;$value</li>";
				}else{
					$msg_t.="<li style='border-bottom:1px dotted #CCC;padding-left:5px;color:green;'>&middot;$value</li>";
				}
			}
		}else{
			if($msgType==2){
				$msg_t="<li style='border-bottom:1px dotted #CCC;padding-left:5px;color:red;'>&middot;$msg</li>";
			}else{
				$msg_t="<li style='border-bottom:1px dotted #CCC;padding-left:5px;color:green;'>&middot;$msg</li>";
			}
		}
		$back_t="<li style='border-bottom:1px dotted #CCC;padding-left:5px;'>&middot;<a style='color:#06F; text-decoration:none' href='javascript:history.back()'>返回</a></li>";
		if(is_array($back)){
			foreach($back as $key=>$value){
				$back_t.="<li style='border-bottom:1px dotted #CCC;padding-left:5px;'>&middot;<a style='color:#06F; text-decoration:none' href='$value'>$key</a></li>";
			}
		}
		$msgStr="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'><div style='width:500px; margin:0 auto; border:1px #09F solid; font-size:12px;'>
	<div style='background-color:#09F; font-size:12px;padding:5px; font-weight:bold; color:#FFF;'>$msgTitle</div>
	<div><ul style='list-style:none; line-height:22px; margin:10px; padding:0'>$msg_t</ul></div>
	<div style='border:1px #BBDFF8 solid; width:96%; margin:0 auto; margin-bottom:10px;'>
	<div style='background-color:#BBDFF8; font-size:12px;padding:5px; font-weight:bold; color:#666;'>您可以：</div>
	<div><ul style='list-style:none; line-height:22px; margin:10px; padding:0'>$back_t</ul></div></div>
	</div></html>";
		//$msgStr.=$msg;
		echo $msgStr;
		exit;
	}
	/**
	 * 函数GetRandStr,获取随机字符串
	 * @param int $len 字符串长度
	 * @return string
	 */
	function GetRandStr($len=4){
		$chars=array("a","b","c","d","e","f","g", "h", "i", "j", "k","l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v","w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G","H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R","S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2","3", "4", "5", "6", "7", "8", "9");
		$charsLen=count($chars)-1;
		shuffle($chars);
		$output="";
		for($i=0;$i<$len;$i++){
			$output .= $chars[mt_rand(0, $charsLen)];
		}
		return $output;
	}
	/**
	 * 函数p_r,格式化输出数据
	 * @param array $arr 要输出的数组
	 * @return boolean
	 */	
	function p_r($arr){
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}
?>