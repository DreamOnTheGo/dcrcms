<?php
/**
* ���� �޸�ȫվ���õ���
* ��������и���ȫվ���õķ���
* @author �Ҳ��ǵ����� www.cntaiyn.cn
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class Config{
	function __construct(){
	}
	/**
	 * ����UpdateConfig,����ȫվ����
	 * ���� r1Ϊ�޸ĵ��������ݴ���
	 * ���� r2Ϊ�޸ĳɹ�
	 * ���� r3Ϊд�������ļ�ʧ��
	 * @param array $configInfo �������� �������ʾ,��$key=>$value����ʾ����=>ֵ ��array('title'=>'����') ��ʾ����title��ֵΪ ����
	 * @param string $configFileName �����ļ���
	 * @return string
	 */
	function UpdateConfig($configInfo,$configFileName=''){
		include_once(WEB_CLASS.'f_class.php');
		$f=new FClass();
		if(empty($configFileName)){
			$configFileName=WEB_INCLUDE.'config.php';
		}
				 
		$configTxt=$f->getContent($configFileName);
		//�滻
		foreach($configInfo as $key=>$value){
			$configTxt=preg_replace("/[$]".$key."\s*\=\s*[\"'].*?[\"'];/is", "\$".$key." = '".$value."';", $configTxt);
			//$configTxt=str_replace("{\$".$key."}",$value,$configTxt);
		}
		$f->setText($configTxt);
		if($f->saveToFile($configFileName)){
			return 'r2';
		}else{
			return 'r1';
		}
	}
}
?>