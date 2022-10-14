<?php

// Определенение путей
define ( 'ROOT_PATH', './' );
define ( 'KERNEL_PATH', './kernel/' );
define ( 'BIG_PATH', './uploads/big/' );
define ( 'SMALL_PATH', './uploads/small/' );
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

if (isset ($_GET['ph_id']))
{
	$photo_id = $_GET['ph_id'];
	
	$db->query_array ("SELECT * FROM $tbl_sys_photos WHERE photo_id='$photo_id'");
	
	$photo_name = $db->req_array['photo_name'];
	$photo_link = SMALL_PATH.$photo_name;
	$date = $db->req_array['upload_date'];
	$desc_name = $db->req_array['desc_name'];
	$description = $db->req_array['description'];
	$album_id = $db->req_array['album_id'];
	
	$db->query_array ("SELECT album_name FROM $tbl_sys_albums WHERE album_id='$album_id'");
	$album_name = $db->req_array['album_name'];
	
	echo ("
		<html>
		<head>
		<title>Просмотр фотографий</title>
		<style>
		@import url('".ROOT_PATH."css/admin.css');
		</style>
		</head>
		<body>
		<center>
		<div class='nav'><a href='".ROOT_PATH."index.php'>Фотогалерея</a> &gt; <a href='".ROOT_PATH."showalbum.php?alb_id=".$album_id."'>Альбом ".$album_name."</a> &gt; Фотография ".$desc_name."</div><br /><br />
		<table class='showphoto' align='center' cellpadding='5' cellspacing='1'>
			<tr>
				<td align='center' colspan='2'><br /><a href=\"javascript:;\" onclick=\"window.open('fullsize.php?ph_id=".$photo_id."','new','scrollbars=yes,toolbar=yes,status=yes,resizable=yes,width=1280,height=1024')\"><img src='".$photo_link."' /></a><br /><br /></td>
			</tr><tr>
				<th colspan='2'>Информация о фотографии</th>
			</tr><tr>
				<td width='50%'><b>Название</b></th><td width='50%'>".$desc_name."</td>
			</tr><tr>
				<td width='50%'><b>Описание</b></th><td colspan='2'>".$description."</td>
			</tr><tr>
				<th colspan='2'>Характеристики файла</th>
			</tr><tr>
				<td width='50%'><b>Имя</b></td><td width='50%'>".$photo_name."</td>
			</tr><tr>
				<td width='50%'><b>Альбом</b></td><td width='50%'>".$album_name."</td>
			</tr><tr>
				<td width='50%'><b>Дата загрузки</b></td><td width='50%'>".$date."</td>
			</tr>
		</table>
		</center>
		</body>
		</html>
	");









}
?>