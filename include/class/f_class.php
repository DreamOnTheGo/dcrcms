<?php
/**
* 文件处理的基类 有写入、读取文件的操作方法
* @author 我不是稻草人 www.dcrcms.com
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class FClass{
	private $text;
	private $current_dir;//当前目录 或者文件
	/**
	 * FClass的构造函数 无需传参数
	 * @param string $c_dir 目录名
	 */
	function __construct($c_dir=''){
		$this->current_dir=$c_dir;
	}
	/**
	 * 函数setText,设置要写入的字符串，saveToFile保存到文件的内容就是这个设置
	 * 返回true
	 * @param string $txt 字符串
	 * @return boolean 返回true
	 */
	function setText($txt){
		$this->text=$txt;
		return true;
	}
	/**
	 * 函数set_current_dir,设置当前操作目录 版本>1.0.5
	 * 返回true
	 * @param string $current_dir 目录名
	 * @return boolean 返回true
	 */	
	function set_current_dir($current_dir='')
	{
		$this->current_dir=$current_dir;
	}
	/**
	 * 函数saveToFile,把setText设置的字符串写到到文件中
	 * @param string $filename 文件名
	 * @param boolean $isconvert 是不是转换 把<#dcr#form转成<form,</#dcr#form>转成</from>,<#dcr#textarea转成<textarea,</#dcr#textarea>转成</textarea> 适用版本>=1.0.4
	 * @return boolean 成功返回true 失败:如果返回r1 则表示文件不存在 r2为文件不可写
	 */
	function saveToFile($filename='',$isconvert=false){
		if(empty($filename))$filename=$this->current_dir;
		$fileHandle = fopen($filename, "w");
		if($fileHandle){
			if(is_writable($filename)){
				if($isconvert)
				{
					$this->text=str_ireplace('<#dcr#form','<form',$this->text);
					$this->text=str_ireplace('</#dcr#form>','</form>',$this->text);
					$this->text=str_ireplace('<#dcr#textarea','<textarea',$this->text);
					$this->text=str_ireplace('</#dcr#textarea>','</textarea>',$this->text);
				}
				$rs=fwrite($fileHandle, $this->text);
				@fclose($fileHandle);
				return $rs;
			}else{
				return 'r2';
			}
		}else{
			return 'r1';
		}		
		@fclose($fileHandle);
	}
	/**
	 * 函数getContent,返回文件的内容
	 * @param string $filename 文件名
	 * @param boolean $isconvert 是不是转换 把<form转成<#dcr#form,</from>转成</#dcr#form>,<textarea 转成<#dcr#textarea,</textarea>转成</#dcr#textarea> 适用版本>=1.0.4
	 * @return boolean 成功返回true 失败:如果返回r1 表示目录不存在 r2为文件不可操作
	 */
	function getContent($filename='',$isconvert=false){
		if(empty($filename))$filename=$this->current_dir;
		$fp=fopen($filename,'r');
		if($fp){
			while(!feof($fp)){
				$content.=fgets($fp,4096);
			}
		}else{
			return false;
		}
		fclose($fp);
		if($isconvert)
		{
			$content=str_ireplace('<form','<#dcr#form',$content);
			$content=str_ireplace('</form>','</#dcr#form>',$content);
			$content=str_ireplace('<textarea','<#dcr#textarea',$content);
			$content=str_ireplace('</textarea>','</#dcr#textarea>',$content);
		}
		return $content;
	}
	/**
	 * 函数ClearDir,清空一个目录下的文件 适用版本号>=1.0.4
	 * @param string $dir_name 目录名 这个目录名要带/
	 * @return boolean 成功返回true 失败:如果返回r1 表示目录不存在 r2为文件不可写 r3表示不是目录
	 */
	function ClearDir($dir_name=''){
		if(empty($dir_name))$dir_name=$this->current_dir;
		if(is_dir($dir_name)){
			if($handle=opendir($dir_name)){
				while(false!==($item=readdir($handle))){
					if($item!= "." && $item!= ".."){
						if(is_dir($item)){
							$this->ClearDir($dir_name.$item);
						}else{
							@unlink($dir_name.$item);
						}
					}
				}
				closedir( $handle );
				return 'r1';
			}else{
				closedir( $handle );
				return 'r2';
			}
		}else{
			return 'r3';
		}
	}
	/**
	 * 函数GetFileList,返回一个目录的文件列表 注意 这个只能返回一级目录 适用版本号>=1.0.4
	 * @return array 成功返回文件列表,失败返回false
	 */
	function GetFileList(){
		$dir_name=$this->current_dir;
		$file_list=array();
		$row=0;
		if(is_dir($dir_name)){
			if($handle=opendir($dir_name)){
				while(false!==($item=readdir($handle))){
					//echo $item;
					if($item!= "." && $item!= ".."){
						if(is_dir($dir_name.$item)){
							//$this->ClearDir($dir_name.$item);
						}else{
							$file_list[$row]['path']=$dir_name.$item;
							$file_list[$row]['filename']=$item;
							$row++;
						}
					}
				}
			}else{
			closedir( $handle );
			}
		}else{
		}
		//p_r($file_list);
		return $file_list;
	}
	/**
	 * 函数GetDirList,返回一个目录下的目录列表 注意 这个只能返回一级目录 适用版本号>=1.0.4
	 * @return array 成功返回目录列表,失败返回false
	 */
	function GetDirList(){
		$dir_name=$this->current_dir;
		$file_list=array();
		$row=0;
		if(is_dir($dir_name)){
			if($handle=opendir($dir_name)){
				while(false!==($item=readdir($handle))){
					//echo $item;
					if($item!= "." && $item!= ".."){
						if(is_dir($dir_name.$item)){
							$file_list[$row]['path']=$dir_name.$item;
							$file_list[$row]['filename']=$item;
							//$file_list[$row]['filename']=$item;
							$row++;
						}else{
						}
					}
				}
			}else{
			closedir( $handle );
			}
		}else{
		}
		//p_r($file_list);
		return $file_list;
	}
	/**
	 * 函数DelDir,删除一个目录 适用版本号>=1.0.4
	 * @return true|false
	 */
	function DelDir($dir=''){
		if(empty($dir))$dir=$this->current_dir;
		$dir_name=$dir;//调试时用的 
		if($this->is_empty_dir($dir_name)){
			@rmdir($dir_name);//直接删除 
		}else{			
			if($handle=opendir($dir_name)){
				while(false!==($item=readdir($handle))){
					if($item!= "." && $item!= ".."){
						$pathdir=$dir_name.'/'.$item;
						echo $pathdir.'<br>';
						if(is_dir($pathdir)){
							if($this->is_empty_dir($pathdir)){
								rmdir($pathdir);//直接删除 
							}else{
								$this->DelDir($pathdir); 
							}
						}else{
							unlink($pathdir);
						}
					}
				}
				closedir( $handle );
			}else{
				closedir( $handle );
			}
			@rmdir($dir_name);//直接删除 
      	}
	}
	
	/**
	 * 函数is_empty_dir,判断是不是空目录 适用版本号>=1.0.4
	 * @return true|false
	 */
	function is_empty_dir($pathdir){
		//echo $pathdir;
		//判断目录是否为空
		$dhandle=opendir($pathdir); 
		$i=0; 
   		while($t=readdir($dhandle)){
			$i++;
		}
		closedir($dhandle);
		if($i>2)return false;
		else return true;
	}
}
?>