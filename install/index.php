<?php
session_start();
require("../include/common.func.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK href="css/install.css" type="text/css" rel="stylesheet">
<title>��������ҵվ����ϵͳ_����װ</title>
<script type="text/javascript" src="../include/js/jquery.js"></script>
</HEAD>
<BODY>
<?php
$step=$_GET['step'];
if($step=="1" || empty($step)){
	?>
<div id="content" style="margin:80px 180px">
  <UL class=Form_Advance id=FormRegStep1>
    <LI class=Title>��װ�������_����װ</LI>
    <li class="Seperator">
      <hr>
    </li>
    <li>����PHP�汾��<?php echo PHP_VERSION;?></li>
    <li>sqlite��
      <?php
  if(function_exists("pdo_drivers")){
	$pdo_drivers=pdo_drivers();
	if(in_array('sqlite',$pdo_drivers)){
		//ͨ�������µ����ݿ���ȫ������¿�
		$sql="";		
		$pdo=new PDO("sqlite:test.db");
		if($pdo){
			//û�д��� ��ʼ��װ
			//��װ��
			$pdo->exec("create table test(a int)");
			if($pdo->errorCode()=='00000'){
				//���Բ�������
				$pdo->exec("insert into test values(1)");
				if($pdo->errorCode()=='00000'){
					echo "<span style='color:green'>֧��</span>";
				}else{
					echo "<span style='color:red'>��֧��</span>";
				}
			}else{
				echo "<span style='color:red'>��֧��</span>";
			}
			unset($pdo);
			@unlink('test.db');
		}else{
			echo "<span style='color:red'>����ʧ�ܣ�����installĿ¼û�ж�дȨ�޻��߿ռ䲻֧�ֱ�CMS����Ҫ�õ���SQLITE����</span>";
		}
	}else{
		echo "<span style='color:red'>��֧��</span>";
	}
}else{
	echo "<span style='color:red'>��֧��</span>";
}
  ?>
    </li>
    <li>mysql��
      <?php  
  if(extension_loaded('mysql')){
	  echo "<span style='color:green'>֧��</span>";
  }else{
	  echo "<span style='color:red'>��֧��</span>";
  }
  ?>
    </li>
    <li>GD��
      <?php  
  if(extension_loaded('gd')){
	  echo "<span style='color:green'>֧��</span>";
  }else{
	  echo "<span style='color:red'>��֧��</span>";
  }
  ?>
    </li>
    <li class="Seperator">
      <hr>
    </li>
    <li>Ŀ¼���(<span style="color:red">����Ŀ¼Ҫ�ж�дȨ��</span>)��</li>
    <li>
      <table width="300" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>Ŀ¼��</td>
          <td>д��Ȩ��</td>
          <td>��ȡȨ��</td>
        </tr>
        <?php
  function TestWrite($dir){
	$tfile = '_test.txt';
	$d = ereg_replace('/$','',$dir);
	$fp = @fopen($d.'/'.$tfile,'w');
		if(!$fp) return false;
		else
		{
			fclose($fp);
			$rs = @unlink($dir.'/'.$tfile);
			if($rs) return true;
			else return false;
		}
	}
  	$darr=array(
				'/include/*',
				'/data/*',
				'/uploads/*',
				'/templets/*',
				'/install'
				);
	define('WEB_INCLUDE', ereg_replace("[/\\]{1,}",'/',dirname(__FILE__) ));
	define('WEB_DR', ereg_replace("[/\\]{1,}",'/',substr(WEB_INCLUDE,0,-8) ) );
	foreach($darr as $dir){		
		$filldir = WEB_DR.str_replace('/*','',$dir);
		$isread=(is_readable($filldir) ? '<font color=green>[��]��</font>' : '<font color=red>[��]��</font>');
	    $iswrite = (TestWrite($filldir) ? '<font color=green>[��]д</font>' : '<font color=red>[��]д</font>');
		echo "<tr><td>$dir</td><td>$isread</td><td>$iswrite</td></tr>";
      	//$rsta = (is_readable($filldir) ? '<font color=green>[��]��</font>' : '<font color=red>[��]��</font>');
	    		//$wsta = (TestWrite($filldir) ? '<font color=green>[��]д</font>' : '<font color=red>[��]д</font>');
	    		//echo "<td>$rsta</td><td>$wsta</td>\r\n";
	}
  ?>
      </table>
    </li>
    <li class="Seperator">
      <hr>
    </li>
    <LI class=SubmitBox>
      <INPUT class="btn" type="button" onclick="location.href='index.php?step=2'" value="������һ��" name=Submit>
    </LI>
  </UL>
</div>
<?php
}
if($step=="2"){
?>
<DIV id="content" style="margin:80px 180px">
  <form action="install_action.php" method="post">
    <input type="hidden" name="action" id="action" value="install">
    <UL class=Form_Advance id=FormRegStep1>
      <LI class=Title>��������ҵվ����ϵͳ_����װ</LI>
      <li class="Seperator">
        <hr>
      </li>
      <li>
        <DIV class=Hint>���ݿ����ͣ�</DIV>
        <DIV class=FormInput>
          <input name="db_type" type="radio" id="db_type" style="width:15px; border:none; height:15px;" onclick="ShowPanel(1)" value="1" checked="checked" />SQLite
          <input type="radio" onclick="ShowPanel(2)" name="db_type" id="db_type" value="2" style="width:15px; border:none; height:15px;" />Mysql
        </DIV>
        <div class="Info">
          <div class="alert_txt"><span class="Hint">SQLite��վ�����������С��10Wʱѡ��,����վҪ������������Ƚϴ�ʱѡ��Mysql</span></div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <span id="sqlitepanel">
      <li>
        <DIV class=Hint>���ݿ����ƣ�</DIV>
        <DIV class=FormInput>
          <input id="sqlite_table" size="24" class="Warning" name="sqlite_table" value="dcr_qy.php" />
        </DIV>
        <div class="Info">
          <div class="alert_txt">����������ݿ���,Ĭ��Ϊdcr_qy.php�����ݿ�Ὠ����dataĿ¼�У�Ϊ�˷�ֹ���ݿⱻ���أ�һ������ݿ�ĺ�׺����Ϊ.php</div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      </span> <span id="mysqlpanel" style="display:none">
      <li>
        <DIV class=Hint>���ݿ�������</DIV>
        <DIV class=FormInput>
          <input id="host" size="24" class="Warning" name="host" value="localhost" />
        </DIV>
        <div class="Info">
          <div class="alert_txt"><span class="Hint">�����Ļ�Ϊlocalhost,�Ǳ�����IP</span></div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <li>
        <DIV class=Hint>���ݿ����ƣ�</DIV>
        <DIV class=FormInput>
          <input id="table" size="24" class="Warning" name="table" />
        </DIV>
        <div class="Info">
          <div class="alert_txt"></div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <li>
        <DIV class=Hint>���ݿ��û���</DIV>
        <DIV class=FormInput>
          <input name="name" class="Warning" id="name" size="24" />
        </DIV>
        <div class="Info">
          <div class="alert_txt"></div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <li>
        <DIV class=Hint>���ݿ����룺</DIV>
        <DIV class=FormInput>
          <input id="pass" size="24" class="Warning" name="pass" />
        </DIV>
        <div class="Info">
          <div class="alert_txt">
            <div id="content_alert"></div>
          </div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      </span>
      <li>
        <DIV class=Hint>���ݿ�ǰ׺��</DIV>
        <DIV class=FormInput>
          <input id="tablepre" size="24" class="Warning" name="tablepre" value="dcr_qy_" />
        </DIV>
        <div class="Info">
          <div class="alert_txt">������ݿ��д�����ͬǰ׺�ı����ò�ͬ��ǰ׺</div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <li class="Seperator">
        <hr>
      </li>
      <li>
        <DIV class=Hint>����Ա�û�����</DIV>
        <DIV class=FormInput>
          <input id="adminuser" size="24" class="Warning" name="adminuser" value="admin" />
        </DIV>
        <div class="Info">
          <div class="alert_txt"><span class="Hint">����Ա�û���</span></div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <li>
        <DIV class=Hint>����Ա���룺</DIV>
        <DIV class=FormInput>
          <input name="adminpas" type="text" class="Warning" id="adminpas" value="admin" size="24" />
        </DIV>
        <div class="Info">
          <div class="alert_txt"><span class="Hint">����Ա����</span></div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <li class="Seperator">
        <hr>
      </li>
      <li>
        <DIV class=Hint>��ַ��ַ��</DIV>
        <DIV class=FormInput>
          <?php
  $topurl='http://'.GetTopUrl();
  //����ж˿ڼ���
  ?>
          <input id="web_url" size="24" class="Warning" name="web_url"  value="<?php echo $topurl;?>" />
        </DIV>
        <div class="Info">
          <div class="alert_txt">��վ��ַ</div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <li>
        <DIV class=Hint>��վ���ƣ�</DIV>
        <DIV class=FormInput>
          <input id="web_name" size="24" class="Warning" name="web_name" value="�ҵ���վ" />
        </DIV>
        <div class="Info">
          <div class="alert_txt">��վ����</div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
      <li class="Seperator">
        <hr>
      </li>
      <LI class=SubmitBox>
        <INPUT class="btn" type=submit value="��װ����" name=Submit>
      </LI>
    </UL>
  </form>
  <script type="text/javascript">
 function ShowPanel(id){
	 if(id==1){
		 $("#sqlitepanel").css("display","block")
		 $("#mysqlpanel").css("display","none")
	 }else if((id==2)){
		 $("#sqlitepanel").css("display","none")
		 $("#mysqlpanel").css("display","block")
	 }
 }
 $("#pass").blur(function(){
	action='checkconnect_ajax';
	host=$('#host').val();
	name=$('#name').val();
	pass=$('#pass').val();
	table=$('#table').val();
	actionArr={action:action,host:host,name:name,pass:pass,table:table};
	$.post("install_action.php",actionArr, function(data){
													if(data=='���ݿ���Ϣ��ȷ��'){
														alertTxt="<span style='color:green'>"+data+"</span>";
													}else if(data='���ݿ���Ϣ����'){
														alertTxt="<span style='color:red'>"+data+"</span>";
													}
													$('#content_alert').html(alertTxt);
													}); 
						 
						 }); 
</script>
</DIV>
<?php } ?>
</BODY>
</HTML>