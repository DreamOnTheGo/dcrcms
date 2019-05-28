<?php
define('WEB_INCLUDE', str_replace("\\", '/', dirname(__FILE__) ).'/');
define('WEB_DR', str_replace("\\", '/', substr(WEB_INCLUDE,0,-8) ) );
define('WEB_CLASS',WEB_INCLUDE.'class/');
define('WEB_T',WEB_INCLUDE.'/tplengine/');
define('WEB_Tpl',WEB_DR.'templets/');
define('WEB_TplPath','/templets/');
define('WEB_DATA',WEB_DR.'data/');
define('WEB_MYSQL_BAKDATA_DIR',WEB_DR.'data/databak/');

@set_magic_quotes_runtime(0);
$magic_quotes=get_magic_quotes_gpc();

//配置文件
require_once(WEB_INCLUDE.'/app_info.php');
require_once(WEB_INCLUDE.'/config.php');

if($web_tiaoshi=='0'){error_reporting(0);}

//sqlite的sqlite_escape_string
function my_sqlite_escape_string($str){
	if(!empty($str)){
		return str_replace("'","''",$str);
	}else{
		return '';
	}
}

//检查和注册外部提交的变量
foreach($_REQUEST as $_k=>$_v)
{
	if( strlen($_k)>0 && preg_match('/^(GLOBALS)/i',$_k) )
	{
		exit('Request var not allow!');
	}
}

function _GetRequest(&$svar){
	global $db_type,$magic_quotes;
	if(!$magic_quotes){
		if(is_array($svar)){
			foreach($svar as $_k => $_v) $svar[$_k] = _GetRequest($_v);
		}else{
			if($db_type==1){
				$svar = my_sqlite_escape_string($svar);
			}elseif($db_type==2){
				$svar = addslashes($svar);
			}
		}
	}else{
		//没有开..兼容sqlite
		if(is_array($svar)){
			foreach($svar as $_k => $_v) $svar[$_k] = _GetRequest($_v);
		}else{
			if($db_type==1){
				$svar = stripslashes($svar);
				$svar = my_sqlite_escape_string($svar);
			}
		}
	}
	return $svar;
}

foreach(Array('_GET','_POST','_COOKIE') as $_request)
{
	foreach($$_request as $_k => $_v) ${$_k} = _GetRequest($_v);
}
unset($_GET,$_POST);

//时区
if(PHP_VERSION > '5.1')
{
	@date_default_timezone_set('PRC');
}

/*Session保存路径
$sessionPath = WEB_DR."/data/session";
if(is_writeable($sessionPath) && is_readable($sessionPath))
{
	session_save_path($sessionPath);
}
*/

//各个表的列	
$newsColList=array('id','classid','istop','logo','addtime','click','author','source','content','title','keywords','description');
$productColList=array('id','title','istop','tags','classid','logo','biglogo','click','content','keywords','description','updatetime');

//用户访问的网站host
$web_clihost = 'http://'.$_SERVER['HTTP_HOST'];

//引入数据库类
require_once(WEB_CLASS.'/db_class.php');

//引入全站程序静态类
require_once(WEB_CLASS.'/app_class.php');

//全局常用函数
require_once(WEB_INCLUDE.'/common.func.php');

//连接数据库
$db=new DB($db_type,$host,$name,$pass,$table,$ut);

//程序信息
$version=$app_version;
?>