<?php
session_start();
include "../include/common.func.php";
error_reporting(E_ALL || ~E_NOTICE);

header('Content-type:text/html;charset=gb2312');
header('cache-control:no-cache;must-revalidate');

//��ʾ��Ϣ��ʼ
$errormsg=array();//������Ϣ
$back=array('��Ա��̨'=>'../admin/login.htm','��ҳ'=>'../index.php');
//��ʾ��Ϣ����
$db_type=$_POST['db_type'];
$sqlite_table=$_POST['sqlite_table'];
$sqlite_name=$_POST['sqlite_name'];
$sqlite_pass=$_POST['sqlite_pass'];
$action=$_POST['action'];
$host=$_POST['host'];
$name=$_POST['name'];
$pass=$_POST['pass'];
$table=$_POST['table'];
$ut=$_POST['ut'];
$tablepre=$_POST['tablepre'];
$adminuser=$_POST['adminuser'];
$adminpas=$_POST['adminpas'];
$web_url=$_POST['web_url'];
$web_name=$_POST['web_name'];
if($action=='install'){
	//��ʼ��װ
	if($db_type==2){
		$conn=mysql_connect($host,$name,$pass);
		if($conn){
			if(mysql_select_db($table)){
				mysql_query("SET NAMES 'gbk'");
				//û�д��� ��ʼ��װ
				//��װ��
				$fp = fopen(dirname(__FILE__).'\sql_table.txt','r');
				while(!feof($fp)){
					 $line = rtrim(fgets($fp,1024));
					 if(ereg(";$",$line)){
						 $query .= $line."\n";
						 $query = str_replace('{tablepre}',$tablepre,$query);
						$rs = mysql_query($query,$conn);
						   $query='';
					 }
					 else if(!ereg("^(//|--)",$line)){
						   $query .= $line;
					 }
				}
				fclose($fp);
				//��ʼ������
				$fp = fopen(dirname(__FILE__).'\sql_data.txt','r');
				while(!feof($fp)){
					 $line = rtrim(fgets($fp,1024));
					 if(ereg(";$",$line)){
						 $query .= $line."\n";
						 $query = str_replace('{tablepre}',$tablepre,$query);
						 $query=trim($query);
						 $rs = mysql_query($query);
						 $query='';
					 }
					 else if(!ereg("^(//|--)",$line)){
						   $query .= $line;
					 }
				}
				fclose($fp);
				//�������Ա
				$sql="insert into $tablepre"."admin(username,password) values('$adminuser','".jiami($adminpas)."')";
				mysql_query($sql);
				//��������
				$db_config="";
				$db_config.="<?php\n";
				$db_config.="\$db_type='2';\n";
				$db_config.="\$host='$host';\n";
				$db_config.="\$name='$name';\n";
				$db_config.="\$pass='$pass';\n";
				$db_config.="\$table='$table';\n";
				$db_config.="\$ut='gbk';\n";
				$db_config.="\$tablepre='$tablepre';\n";
				$db_config.="?>";
				require("../include/class/f_class.php");
				$f=new FClass();
				$f->setText($db_config);
				$f->saveToFile('../include/config_db.php');
				
				require("../include/class/config_class.php");
				$config=new Config();
				$configInfo=array(
								  'web_url'=>$web_url,
								  'web_name'=>$web_name
								  );
				$rs=$config->UpdateConfig($configInfo,'../include/config.php');
				
				//�Ѱ�װ�ļ������ֻ���
				@rename('index.php','index.php_back');
				
				if($rs=='r2'){
					$msg[]='����װ�ɹ�����ѡ����������ӽ��뵽���ҳ�棡';
					ShowMsg($msg,1,$back);
				}
				if($rs=='r3'){
					$msg[]='��������ʧ�ܣ�д�����ļ�ʱ����,��������ļ�(include/config.php include/config_db.php)��д��Ȩ�ޣ�';
					ShowMsg($msg,2);
				}
			}else{
				$msg[]='���ݿ���Ϣ����';
				ShowMsg($msg,2);
			}
		}else{
			$msg[]='���ݿ���Ϣ����';
			ShowMsg($msg,2);	
		}
	}elseif($db_type==1){
		$db_path=dirname(__FILE__).'/../data/'.$sqlite_table;
		$pdo=new PDO("sqlite:$db_path");
			if($pdo){
				//û�д��� ��ʼ��װ
				//��װ��
				$pdo->exec("create table '<?php'(a)");
				$fp = fopen(dirname(__FILE__).DIRECTORY_SEPARATOR.'sql_table.txt','r');
				if(!$fp){
					$msg[]='��ȡ��װ�ļ�(sql_table.txt)����';
					ShowMsg($msg,2);
				}
				while(!feof($fp)){
					 $line = rtrim(fgets($fp,1024));
					 if(ereg(";$",$line)){
						 $query .= $line."\n";
						 $query = str_ireplace('{tablepre}',$tablepre,$query);
						 $query = str_ireplace(' unsigned','',$query);
						 $query = str_ireplace(' ON UPDATE CURRENT_TIMESTAMP','',$query);
						 $query = str_ireplace(' NOT NULL auto_increment','',$query);
						 //$query = str_replace(' PRIMARY KEY  (`id`)','',$query);
						 $query = str_ireplace(' ENGINE=MyISAM DEFAULT CHARSET=gbk','',$query);
						 //echo $query;
						 $rs = $pdo->exec($query);
						 //print_r($pdo->errorInfo());
						 //exit;
						 $query='';
					 }
					 else if(!ereg("^(//|--)",$line)){
						   $query .= $line;
					 }
				}
				fclose($fp);
				//��ʼ������
				$fp = fopen(dirname(__FILE__).DIRECTORY_SEPARATOR.'sql_data.txt','r');
				if(!$fp){
					$msg[]='��ȡ��װ�ļ�(sql_data.txt)����';
					ShowMsg($msg,2);
				}
				while(!feof($fp)){
					 $line = rtrim(fgets($fp,1024));
					 if(ereg(";$",$line)){
						 $query .= $line."\n";
						 $query = str_replace('{tablepre}',$tablepre,$query);
						 $query=trim($query);
						 $rs = $pdo->exec($query);
						 $query='';
					 }
					 else if(!ereg("^(//|--)",$line)){
						   $query .= $line;
					 }
				}
				fclose($fp);
				//�������Ա
				$sql="insert into $tablepre"."admin(username,password) values('$adminuser','".jiami($adminpas)."')";
				$pdo->exec($sql);
				//��������
				$db_config="";
				$db_config.="<?php\n";
				$db_config.="\$db_type='1';\n";
				$db_config.="\$host='$sqlite_table';\n";
				$db_config.="\$name='$sqlite_name';\n";
				$db_config.="\$pass='$sqlite_pass';\n";
				$db_config.="\$tablepre='$tablepre';\n";
				$db_config.="?>";
				require("../include/class/f_class.php");
				$f=new FClass();
				$f->setText($db_config);
				$f->saveToFile('../include/config_db.php');
				
				require("../include/class/config_class.php");
				$config=new Config();
				$configInfo=array(
								  'web_url'=>$web_url,
								  'web_name'=>$web_name
								  );
				$rs=$config->UpdateConfig($configInfo,'../include/config.php');
				
				//�Ѱ�װ�ļ������ֻ���
				@rename('index.php','index.php_back');
				
				if($rs=='r2'){
					$msg[]='����װ�ɹ�����ѡ����������ӽ��뵽���ҳ�棡';
					ShowMsg($msg,1,$back);
				}
				if($rs=='r3'){
					$msg[]='��������ʧ�ܣ�д�����ļ�ʱ����,��������ļ�(include/config.php include/config.php)��д��Ȩ�ޣ�';
					ShowMsg($msg,2);
				}
		}else{
			$msg[]='���ݿ���Ϣ����';
			ShowMsg($msg,2);	
		}
	}
}elseif($action=='checkconnect_ajax'){
	$conn=mysql_connect($host,$name,$pass);
	if($conn){
		if(mysql_select_db($table)){
			echo '���ݿ���Ϣ��ȷ��';
		}else{
			echo '���ݿ���Ϣ����';
		}
	}else{
		echo '���ݿ���Ϣ����';
	}
}
function checkinput(){
	global $errormsg,$title,$classid,$content;
	if(strlen($title)==0){
		$errormsg[]='����д���ű���';
		$iserror=true;
	}
	if($classid==0){
		$errormsg[]='��ѡ����������';
		$iserror=true;
	}
	if(strlen($content)==0){
		$errormsg[]='����д��������';
		$iserror=true;
	}
	return $iserror;
}
?>