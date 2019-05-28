<?php
/**
* 文件处理的基类
* 这个类中有写入、读取文件的操作方法
* @author 我不是稻草人 www.cntaiyn.cn
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class FClass{
	private $text;
	/**
	 * Article的构造函数 无需传参数
	 */
	function __construct(){
	}
	/**
	 * 函数setText,设置要写入的字符串，saveToFile保存到文件的内容就是这个设置
	 * 返回true
	 * @param string $txt 字符串
	 * @return boolean
	 */
	function setText($txt){
		$this->text=$txt;
		return true;
	}
	/**
	 * 函数saveToFile,把setText设置的字符串写到到文件中
	 * 成功返回true 失败:如果返回r1 则表示文件不存在 r2为文件不可写
	 * @param string $filename 文件名
	 * @return boolean
	 */
	function saveToFile($filename){
		$fileHandle = fopen($filename, "w");
		if($fileHandle){
			if(is_writable($filename)){
				return fwrite($fileHandle, $this->text);
			}else{
				return 'r2';
			}
		}else{
			return 'r1';
		}
		fclose($fileHandle);
	}
	/**
	 * 函数getContent,返回文件的内容
	 * 成功返回内容 失败返回false
	 * @param string $filename 文件名
	 * @return string|boolean
	 */
	function getContent($filename){
		$fp=fopen($filename,'r');
		if($fp){
			while(!feof($fp)){
				$content.=fgets($fp,4096);
			}
		}else{
			return false;
		}
		fclose($fp);
		return $content;
	}
}
?>