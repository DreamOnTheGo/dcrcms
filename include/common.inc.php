<?php
//error_reporting(0);
//error_reporting(E_ALL || ~E_NOTICE);
define('WEB_INCLUDE', ereg_replace("[/\\]{1,}",'/',dirname(__FILE__) ).'/');
define('WEB_DR', ereg_replace("[/\\]{1,}",'/',substr(WEB_INCLUDE,0,-8) ) );
define('WEB_CLASS',WEB_INCLUDE.'class/');
define('WEB_T',WEB_INCLUDE.'/tplengine/');
define('WEB_Tpl',WEB_DR.'templets/');
define('WEB_TplPath','/templets/');
define('WEB_DATA',WEB_DR.'data/');

set_magic_quotes_runtime(0);
$magic_quotes=get_magic_quotes_gpc();

//�����ļ�
require_once(WEB_INCLUDE.'/config.php');

//sqlite��sqlite_escape_string
function my_sqlite_escape_string($str){
	if(!empty($str)){
		return str_replace("'","''",$str);
	}else{
		return '';
	}
}

//����ע���ⲿ�ύ�ı���
foreach($_REQUEST as $_k=>$_v)
{
	if( strlen($_k)>0 && eregi('^(GLOBALS)',$_k) )
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
		//û�п�..����sqlite
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

//ʱ��
if(PHP_VERSION > '5.1')
{
	@date_default_timezone_set('PRC');
}

/*Session����·��
$sessionPath = WEB_DR."/data/session";
if(is_writeable($sessionPath) && is_readable($sessionPath))
{
	session_save_path($sessionPath);
}
*/

//���������	
$newsColList=array('id','classid','addtime','click','author','source','content','title','keywords','description');
$productColList=array('id','title','classid','logo','click','content','keywords','description','updatetime');

//�û����ʵ���վhost
$web_clihost = 'http://'.$_SERVER['HTTP_HOST'];

//�������ݿ���
require_once(WEB_CLASS.'/db_class.php');

//ȫ�ֳ��ú���
require_once(WEB_INCLUDE.'/common.func.php');

//�������ݿ�
$db=new DB($db_type,$host,$name,$pass,$table,$ut);

//������Ϣ
$version='1.0.1';
?>