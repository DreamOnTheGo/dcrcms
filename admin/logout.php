<?php
session_start();
include "../include/common.inc.php";
include "class/member_admin_class.php";
$m=new Member_Admin('','');
$isadmin=$m->logout();
ShowNext('','login.htm');
?>