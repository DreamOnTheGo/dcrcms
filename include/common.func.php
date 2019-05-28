<?php
	/**
	 * @author �Ҳ��ǵ����� www.cntaiyn.cn
	 * @version 1.0
	 * @copyright 2006-2010
	 * @package function
	 * ����encrypt,���ַ������м���
	 * @param string $s Ҫ���ܵ��ַ���
	 * @return string
	 */
	function encrypt($s){
		return crypt(md5($s),'dcr');
	}
	/**
	 * ����jiami,���ַ������м��� �������encrypt����
	 * @param string $s Ҫ���ܵ��ַ���
	 * @return string
	 */
	function jiami($s){
		return encrypt($s);
	}
	/**
	 * ����ShowNext,����javascript��ת
	 * @param string $msg ��ʾ��Ϣ
	 * @param string $url Ҫ��ת�ĵ�ַ
	 * @param string $istop �ǲ����ڸ���������ת
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
	 * ����ShowBack,������һҳ
	 * @param string $msg ��ʾ��Ϣ
	 * @return boolean
	 */
	function ShowBack($msg){
		echo "<script>alert('".$msg."');history.back();</script>'";
		exit;
	}
	/**
	 * ����Redirect,��ת
	 * @param string $url Ҫ��ת�ĵ�ַ
	 * @return boolean
	 */
	function Redirect($url){
		echo "<script>location.href='".$url."';</script>'";
		exit;
	}
	/**
	 * ����mysubstr,��ȡ�ַ��� �ܶ����Ľ��н�ȡ
	 * @param string $str Ҫ��ȡ��������
	 * @param string $start ��ʼ��ȡ��λ��
	 * @param string $len ��ȡ�ĳ���
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
	 * ����PutCookie,д��cookie
	 * @param string $key cookie��
	 * @param string $value cookieֵ
	 * @param string $kptime cookie��Ч��
	 * @param string $pa cookie·��
	 * @return boolean
	 */
	function PutCookie($key,$value,$kptime=0,$pa="/")
	{
		setcookie($key,$value,time()+$kptime,$pa);
	}
	/**
	 * ����DropCookie,ɾ��cookie
	 * @param string $key cookie��
	 * @return boolean
	 */	
	function DropCookie($key)
	{
		setcookie($key,'',time()-360000,"/");
	}
	/**
	 * ����GetCookie,��ȡcookieֵ
	 * @param string $key cookie��
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
	 * ����GetIP,��ȡ��ǰIP
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
	 * ����GetTopUrl,��ȡ��������
	 * @param string $url Ҫ�����ĵ�ַ
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
	 * ����UplodeFile,�ϴ��ļ�
	 * @param string $fileInput �ϴ��ļ��������
	 * @param string $dirName �ļ��ϴ���ŵ�Ŀ¼��
	 * @param string $fileName �ļ���
	 * @param string $sl ��������ͼ�Ĵ�С array('width'=>100,'height'=>100); û�б�ʾ������
	 * @param string $uptypes �����ϴ�������
	 * @param string $maxFileSize ����ϴ���С
	 * @return string|boolean
	 */
	function UplodeFile($fileInput,$dirName,$fileName='',$sl=array(),$uptypes=array('image/jpg','image/jpeg', 'image/png', 'image/pjpeg', 'image/gif', 'image/bmp', 'image/x-png','text/plain'),$maxFileSize=5000000){
		if(is_uploaded_file($_FILES[$fileInput]['tmp_name'])){
			$file=$_FILES[$fileInput];
			if($maxFileSize<$file["size"]){
				ShowBack('���ϴ����ļ������ļ��ϴ���С����');
			}
			if(!in_array($file["type"], $uptypes)){
				ShowBack('���ϴ����ļ����������ϴ�������֮��');
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
					//Ҫ����ͼ
					require WEB_CLASS."imgsize.php";
					$img = new Image($fileName);
					$img->changeSize($sl['width'],$sl['height']);//�ı�ߴ�
					$img->create($fileName);
					$img->free();
				}
				return $fileName;
			}
		}else{
			//û���ϴ��ļ�
			return false;
		}
	}	
	/**
	 * ����ShowMsg,��ʾ��ʾ��Ϣ
	 * @param string $msg ��Ϣ����
	 * @param string $msgType ��Ϣ����1Ϊһ����Ϣ 2Ϊ������Ϣ
	 * @param string $back ���ص�ַ ����ж����������
	 * @param string $msgTitle ��Ϣ����
	 * @return boolean
	 */
	function ShowMsg($msg,$msgType=1,$back='',$msgTitle='��Ϣ��ʾ'){
		/*
		 *msg��ʾ��Ϣ ���Ҫ������������
		 *msgType��Ϣ����1Ϊһ����Ϣ 2Ϊ������Ϣ
		 *backΪ���ص�ַ ����ж����������
		 *msgTitleΪ��Ϣ����
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
		$back_t="<li style='border-bottom:1px dotted #CCC;padding-left:5px;'>&middot;<a style='color:#06F; text-decoration:none' href='javascript:history.back()'>����</a></li>";
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
	<div style='background-color:#BBDFF8; font-size:12px;padding:5px; font-weight:bold; color:#666;'>�����ԣ�</div>
	<div><ul style='list-style:none; line-height:22px; margin:10px; padding:0'>$back_t</ul></div></div>
	</div></html>";
		//$msgStr.=$msg;
		echo $msgStr;
		exit;
	}
	/**
	 * ����GetRandStr,��ȡ����ַ���
	 * @param int $len �ַ�������
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
	 * ����p_r,��ʽ���������
	 * @param array $arr Ҫ���������
	 * @return boolean
	 */	
	function p_r($arr){
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}
?>