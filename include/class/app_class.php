<?php
/**
* 程序信息的类，比如获取一个编辑器，清空缓存，获取samrty模板引擎.
* 全是静态类
* @author 我不是稻草人 www.dcrcms.com
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class App{
	/**
	 * 函数GetEditor，获取一个编辑器
	 * @param string $editor_name 编辑器名
	 * @param string $default_value 编辑内默认值
	 * @param string $editor_width 编辑器宽
	 * @param string $editor_height 编辑器高
	 * @param string $daohang 菜单样式 1为简单 2为全部
	 * @return true
	 */
	public static function GetEditor($editor_name,$default_value='',$editor_width='100%',$editor_height='100%',$daohang=1){
		global $web_url;
		$editor_t="<script src=\"".$web_url."/include/editor/ckeditor/ckeditor.js\" type=\"text/javascript\"></script>\r\n<script type=\"text/javascript\" src=\"".$web_url."/include/editor/ckeditor/ckfinder/ckfinder.js\"></script>\r\n<textarea id=\"".$editor_name."\" name=\"".$editor_name."\">".$default_value."</textarea>\r\n<script type=\"text/javascript\">var editor = CKEDITOR.replace('".$editor_name."',{height:'".$editor_height."',width:'".$editor_width."'});CKFinder.SetupCKEditor(editor, \"".$web_url."/include/editor/ckeditor/ckfinder/\");</script>";
		echo $editor_t;
	}
	/**
	 * 函数GetDb，获取一个数据库连接
	 * @return DB
	 */
	public static function GetDb(){
		global $db_type,$host,$name,$pass,$table,$ut;
		return new DB($db_type,$host,$name,$pass,$table,$ut);
	}
}
?>