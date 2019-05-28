<?php
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
	 * @return array|boolean 上传成功filename为原图 sl_filename为缩略图 上传错误则error=1 error_msg表示错误信息 没有文件上传是为false
	 */
	function UploadFile($fileInput,$dirName='',$fileName='',$sl=array()){
		if(is_uploaded_file($_FILES[$fileInput]['tmp_name'])){
			$file=$_FILES[$fileInput];
			if($this->max_file_size<$file["size"]){
				return array('error'=>1,'error_msg'=>'您上传的文件超过文件上传大小限制');
			}
			if(!in_array($file["type"], $this->allow_files)){
				return array('error'=>1,'error_msg'=>'你上传的文件不在允许上传的类型之内');
			}
			if(!file_exists($dirName)){@mkdir($dirName); }

			$oldName=$file['tmp_name'];
			$pinfo=pathinfo($file["name"]);
			$ftype=$pinfo[extension];
			if(strlen($fileName)==0){
				$fileName = $dirName.DIRECTORY_SEPARATOR.date(ymdhms).rand(1000,9999).".".$ftype;
			}else{
				$t_a=explode('.',$fileName);
				if(count($t_a)>1){
					$fileName = $dirName.DIRECTORY_SEPARATOR.$fileName;
				}else{
					$fileName = $dirName.DIRECTORY_SEPARATOR.$fileName.".".$ftype;
				}
			}
			if(!move_uploaded_file($oldName,$fileName)){
				return false;
			}else{
				$sl_filename=$fileName;
				if(is_array($sl) && count($sl)>0){
					require WEB_CLASS."imgsize.php";
					if($sl['newpic']==1){
						if(!empty($sl['sl_name'])){
							$sl_filename=$dirName.DIRECTORY_SEPARATOR.$sl['sl_name'];
						}else{
							$sl_filename=self::GetSl($fileName);
						}
					}
					$img = new Image($fileName);
					$img->changeSize($sl['width'],$sl['height']);//改变尺寸
					$img->create($sl_filename);
					$img->free();
				}
				if(is_array($sl) && count($sl)>0){
					return array('sl_filename'=>$sl_filename,'filename'=>$fileName);
				}else{
					return array('filename'=>$fileName);
				}
			}
		}else{
			//没有上传文件
			return false;
		}
	}
	/**
	 * 静态 函数GetSl,获取缩略图名
	 * @param string $file_name 图片文件名
	 * @return string 缩略图名
	 */
	static function GetSl($file_name){
		$t_info=pathinfo($file_name);
		return $t_info['dirname'].DIRECTORY_SEPARATOR.$t_info['filename'].'_sl.'.$t_info['extension'];
	}
}
?>