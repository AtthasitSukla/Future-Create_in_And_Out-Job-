<?
session_start();
session_destroy();
setcookie('admin_userid');
setcookie('admin_pos');
setcookie('admin_email');
setcookie('area');
setcookie('admin_department');
setcookie('admin_production_line');
setcookie('ipaddress');
setcookie('main_userid');
setcookie('positionid');

?>
 <meta http-equiv='refresh' CONTENT='1;URL=login.php'>