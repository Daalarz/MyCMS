<?php

// установка путей 
define ( 'ROOT_PATH', '../' );
define ( 'KERNEL_PATH', '../kernel/' );
define ( 'THUMB_PATH', '../uploads/thumb/' );
define ( 'SMALL_PATH', '../uploads/small/' );
define ( 'BIG_PATH', '../uploads/big/' );

require_once KERNEL_PATH."config.php";

require KERNEL_PATH."class_html.php";
$html = new html_admin;

// соединяемся с сессией...
if (isset ($_COOKIE['phg_sid']))
{
	session_id($_COOKIE['phg_sid']);
	session_start();
}

if (isset ($_SESSION['user']) && !empty ($_SESSION['user'])) // если существует имя юзера и непусто
{
	require KERNEL_PATH."class_mysql_engine.php";
	$db = new db_engine;
	
	// выясняем названия таблиц с учетом префикса и подгоняем под шаблон tbl_
	$tbl_sys_users = $CONFIG['db_prefix']."sys_users";
	$tbl_sys_auth_err = $CONFIG['db_prefix']."sys_auth_err";
	$tbl_sys_temp = $CONFIG['db_prefix']."sys_temp";
	$tbl_sys_albums = $CONFIG['db_prefix']."sys_albums";
	$tbl_sys_photos = $CONFIG['db_prefix']."sys_photos";
	
	$db->host = $CONFIG['db_host'];
	$db->user = $CONFIG['db_user'];
	$db->pass = $CONFIG['db_pass'];
	$db->name = $CONFIG['db_name'];
	
	/*if ( !$db->server_connect() )
	{
		$db->error();
	}*/
	
	if (!$db->connect())
	{
		$db->error();
	}
	
	$db->query_array("SELECT user, pass FROM $tbl_sys_users WHERE user_id=1");
	

	// выясняем реальный логин и пароль админа
	$R_psswd = $db->req_array['pass']; // из таблицы
	$R_user = $db->req_array['user']; // из таблицы
	
	$ip = $_SERVER['REMOTE_ADDR'];
	$strid = md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['HTTP_ACCEPT']);
	
	// выясняем данные сессии
	$pass = $_SESSION['pass']; // из сессии
	$user = $_SESSION['user']; // из сессии
	$s_ip = $_SESSION['ip'];
	$str = $_SESSION['strid'];

	
	if ($R_user == $user &&
		$R_psswd == $pass &&
		$ip == $s_ip &&
		$strid == $str) // если все данные совпадают - ACCESS! :)
	{
?>

<html>
<head>
<style type="text/css">
@import url(../css/admin.css);
</style>
</head>
<body>
<center>
<div class="header">Системная информация</div><br /><br />
<table cellpadding="5" cellspacing="1">
<tr><th colspan="2">Server info</th></tr>
<tr><td>SERVER SOFTWARE</td><td><?php echo $_SERVER["SERVER_SOFTWARE"]; ?></td></tr>
<tr><td width="50%">DOCUMENT ROOT</td><td width="50%"><?php echo $_SERVER["DOCUMENT_ROOT"]; ?></td></tr>
<tr><td>HTTP-HOST</td><td><?php echo $_SERVER["HTTP_HOST"]; ?></td></tr>
<tr><td>REMOTE ADDRESS</td><td><?php echo $_SERVER["REMOTE_ADDR"]; ?></td></tr>
<tr><td>SERVER ADDRESS</td><td><?php echo $_SERVER["SERVER_ADDR"]; ?></td></tr>
<tr>
</table><table cellpadding='5' cellspacing='1'>
<tr><th colspan='2'>User info</th></tr>
<tr><td width='50%'>HTTP-User-Agent</td><td width='50%'><?php echo $_SERVER['HTTP_USER_AGENT']; ?></td></tr>
<tr><td>HTTP-Accept</td><td><?php echo $_SERVER['HTTP_ACCEPT']; ?></td></tr>

<?php
	}
	else
	{
		header ("location: ../index.php");
	}

}
else
{
	$html->notice("Сесии администратора не найдено");
}

?>