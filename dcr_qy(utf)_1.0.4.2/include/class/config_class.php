<?php
/**
* 更新 修改全站配置的类
* 这个类中有更新全站配置的方法
* @author 我不是稻草人 www.cntaiyn.cn
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class Config{
	function __construct(){
	}
	/**
	 * 函数UpdateConfig,更新全站配置
	 * @param array $configInfo 配置数据 用数组表示,用$key=>$value来表示列名=>值 如array('title'=>'标题') 表示配置title的值为 标题
	 * @param string $configFileName 配置文件名
	 * @return string 返回 r1为修改的配置数据错误,返回 r2为修改成功,返回 r3为写入配置文件失败
	 */
	function UpdateConfig($configInfo,$configFileName=''){
		include_once(WEB_CLASS.'f_class.php');
		$f=new FClass();
		if(empty($configFileName)){
			$configFileName=WEB_INCLUDE.'config.php';
		}
				 
		$configTxt=$f->getContent($configFileName);
		//替换
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