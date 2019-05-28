<?php
/**
* �ļ�����Ļ���
* ���������д�롢��ȡ�ļ��Ĳ�������
* @author �Ҳ��ǵ����� www.cntaiyn.cn
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class FClass{
	private $text;
	/**
	 * Article�Ĺ��캯�� ���贫����
	 */
	function __construct(){
	}
	/**
	 * ����setText,����Ҫд����ַ�����saveToFile���浽�ļ������ݾ����������
	 * ����true
	 * @param string $txt �ַ���
	 * @return boolean
	 */
	function setText($txt){
		$this->text=$txt;
		return true;
	}
	/**
	 * ����saveToFile,��setText���õ��ַ���д�����ļ���
	 * �ɹ�����true ʧ��:�������r1 ���ʾ�ļ������� r2Ϊ�ļ�����д
	 * @param string $filename �ļ���
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
	 * ����getContent,�����ļ�������
	 * �ɹ��������� ʧ�ܷ���false
	 * @param string $filename �ļ���
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