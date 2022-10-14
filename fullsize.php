<?php

// Определенение путей
define ( 'ROOT_PATH', './' );
define ( 'KERNEL_PATH', './kernel/' );
define ( 'BIG_PATH', './uploads/big/' );
define ( 'THUMB_PATH', './uploads/thumb/' );

// Подгружаем ядро...
require_once KERNEL_PATH."config.php";
require_once KERNEL_PATH."class_mysql_engine.php";
require_once KERNEL_PATH."class_html.php";

$tbl_sys_users = $CONFIG['db_prefix']."sys_users";
$tbl_sys_auth_err = $CONFIG['db_prefix']."sys_auth_err";
$tbl_sys_temp = $CONFIG['db_prefix']."sys_temp";
$tbl_sys_albums = $CONFIG['db_prefix']."sys_albums";
$tbl_sys_photos = $CONFIG['db_prefix']."sys_photos";

$html = new html_admin;
$db = new db_engine;

$db->host = $CONFIG['db_host'];
$db->user = $CONFIG['db_user'];
$db->pass = $CONFIG['db_pass'];
$db->name = $CONFIG['db_name'];

/*if (!$db->server_connect())
{
	$db->error();
}*/

if (!$db->connect())
{
	$db->error();
}

if(isset ($_GET['ph_id']))
{

	$photo_id = $_GET['ph_id'];
	$db->query_array ("SELECT photo_name FROM $tbl_sys_photos where photo_id='$photo_id'");
	$photo_name = $db->req_array['photo_name'];
	$big_photo_link = BIG_PATH.$photo_name;

	echo ("
		<html>
		<head>
		<title>Нажмите на фотографию, чтобы закрыть окно</title>
		</head>
		<body scroll='auto' marginwidth='0' marginheight='0' style='background-color:#222222;'>
		<table width='100%' height='100%' border='0' cellpadding='0' cellspacing='2'>
		<td align='center' valign='middle'>

		  <table cellspacing='2' cellpadding='0' style='border: 1px solid #000000; background-color: #999999;'>
		   <td>
		<a href='javascript: window.close()'><img src='".$big_photo_link."' width='100%' height='100%' class='image' border='0' alt='' title='Нажмите на фотографию, чтобы закрыть окно'></a><br />
		   </td>
		  </table>
		 </td>
		</table>
		</body>
		</html>
		
	");
}

?>