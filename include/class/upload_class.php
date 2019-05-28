<?php
defined('IN_DCR') or exit('No permission.'); 

/**
* 上传类 处理上传文件之类的类
* @author 我不是稻草人 www.dcrcms.com
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class Upload{
	private $allow_files;//允许的文件类型
	private $max_file_size;//文件最大上传大小
	/**
	 * Upload的构造函数 无需传参数
	 */
	function __construct(){
		//初始化数据
		$this->allow_files=array('image/jpg','image/jpeg', 'image/png', 'image/pjpeg', 'image/gif', 'image/bmp', 'image/x-png');
		$this->max_file_size=5000000;
	}
	/**
	 * 静态function 函数UplodeFile,上传文件
	 * @param string $fileInput 上传文件框的名字
	 * @param string $dirName 文件上传后放的目录名 为空时当前目录
	 * @param string $fileName 文件名
	 * @param array $sl 缩略图参数 array('width'=>100,'height'=>100,'newpic'=>1,'sl_name'=''); newpic=1时生成新的缩略图 0为覆盖原图 sl_name表示缩略图名 如果为空则用默认的
	 * @param array $dirFeiLei 目录分类 type表示类型 caishu为扩展参数 默认为按日期 (含)1.0.6版本以后有效 现在有效且默认的是array('type'=>'date','caishu'=>'Y_m_d') 为了这个参数 几乎改写了上传过程 大家请以后台上传文件为参考 ^_^ 从这些个变量得出一个结论 最好不要对原变量来改 比如fileName让他从头到尾都是从外传来的值 而用新的变量来记录处理的变量
	 * @return array|boolean 上传成功filename为原图 sl_filename为缩略图 上传错误则error=1 error_msg表示错误信息 没有文件上传是为false
	 */
	function UploadFile($fileInput,$dirName='',$fileName='',$sl=array(),$dirFeiLei=array('type'=>'date','caishu'=>'Y_m_d')){
		$returnValue=array();//返回的结果
		if(is_uploaded_file($_FILES[$fileInput]['tmp_name'])){
			$file=$_FILES[$fileInput];
			if($this->max_file_size<$file["size"]){
				return array('error'=>1,'error_msg'=>'您上传的文件超过文件上传大小限制');
			}
			if(!in_array($file["type"], $this->allow_files)){
				return array('error'=>1,'error_msg'=>'你上传的文件不在允许上传的类型之内');
			}
			if(is_array($dirFeiLei) && !empty($dirFeiLei['type']) && !empty($dirFeiLei['caishu']));
			{
				if('date'==$dirFeiLei['type'])
				{
					$dirCanShu=date($dirFeiLei['caishu']);//因为参数产生的多的字符串
				}
			}
			
			
			$realFileName='';//真实的FileName 这里是为了区别以前的路径名 fileName是全路径 realFileName是不含目录分类参数带来的的路径
			$realSlFileName='';//真实的缩略图FileName 意思同上
			$realDirName='';//真实的目录名 意思同上 这三个变量主要是为了区别加了dirFeiLei这个参数产生的字符串 ^_^
			
			$oldName=$file['tmp_name'];
			$pinfo=pathinfo($file["name"]);
			$ftype=$pinfo[extension];
			if(strlen($fileName)==0){
				$realFileName=date(ymdhms).rand(1000,9999).".".$ftype;
			}else{
				$t_a=explode('.',$fileName);
				if(count($t_a)>1){
					$realFileName=$fileName;
				}else{
					$realFileName=$fileName.".".$ftype;
				}
			}
			
			if(!empty($dirCanShu))
			{
				$realDirName=$dirName.'/'.$dirCanShu;
			}else
			{
				$realDirName=$dirName;
			}
			if(!file_exists($realDirName)){@mkdir($realDirName); }
			$fileName = $realDirName.'/'.$realFileName;			
			
			if(!move_uploaded_file($oldName,$fileName)){
				return false;
			}else{
				if(is_array($sl) && count($sl)>0){
					require WEB_CLASS."imgsize.php";
					if($sl['newpic']==1){
						$realSlFileName=self::GetSl($realFileName);
					}else
					{
						$realSlFileName=$realFileName;
					}
					//echo $realDirName;
					$sl_filename=$realDirName.'/'.$realSlFileName;
					//echo $sl_filename;
					$img = new Image($fileName);
					$img->changeSize($sl['width'],$sl['height']);//改变尺寸
					$img->create($sl_filename);
					$img->free();
				}
				if(!empty($dirCanShu))
				{
					$realFileName=$dirCanShu.'/'.$realFileName;
					$realSlFileName=$dirCanShu.'/'.$realSlFileName;
				}
				if(is_array($sl) && count($sl)>0){
					return array('sl_filename'=>$realSlFileName,'filename'=>$realFileName);
				}else{
					return array('filename'=>$realFileName);
				}
			}
		}else{
			//没有上传文件
			return false;
		}
	}
	/**
	 * 静态 函数GetSl,获取缩略图名 1.0.6后大改写 原来是全路径 现在只是非全路径了 注意！！！
	 * @param string $file_name 图片文件名
	 * @return string 缩略图名
	 */
	static function GetSl($file_name){
		$b_name=explode('.',$file_name);
		return $b_name[0].'_sl.'.$b_name[1];
	}
}
?>