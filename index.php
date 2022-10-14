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


// выбираем все альбомы из таблицы альбомов

if (!isset ($_GET['p']) or empty ($_GET['p']))
{
	$p = 1;
}
else
{
	$p = $_GET['p'];
}

echo ("
	<html>
	<head>

	<style type = 'text/css'>
	@import url('./css/admin.css');
	</style>
	</head>
	<body>
	<center>
	<br /><br /><br /><br /><br />
	<div class='nav'>Фотоблог</div><br /><br />
	<table valign='middle' class='showalbum' cellpadding='5' cellspacing='1'>
	<tr>
	<td>
");

$lim = 3*$p-3;

$query = $db->query ("SELECT * FROM $tbl_sys_albums LIMIT $lim,3");
$table_num_rows = mysql_num_rows (@mysql_query ("SELECT * FROM $tbl_sys_albums"));

$i=0;
while ($albums = @mysqli_fetch_assoc ($query))
{ // в цикле выводим  каждый альбом...

	$i++;
	$album_name = $albums['album_name'];
	$album_id = $albums['album_id'];

	// выводим альбом...
	$html = <<<EOF
	<table cellpadding='5' cellspacing='1'>
		<tr>
			<th colspan='5' align='left'>
				$album_name &nbsp; 
				[ <a href = './showalbum.php?alb_id=$album_id'>Перейти в альбом</a>]
			</th>
			
			
		</tr><tr> 
EOF;

	echo $html;
	unset ($html);
	
	// дальше - вывод в следующей строке таблицы последних загруженных изображений
	
	
	$r = $db->query ("SELECT * FROM $tbl_sys_photos WHERE album_id='$album_id' ORDER BY photo_id DESC LIMIT 5");
	while ($req_array = @mysqli_fetch_array ($r))
	{
		$thumb_name = THUMB_PATH.$req_array['photo_name'];
		echo ("<td align='center'><a href = './showalbum.php?alb_id=$album_id'><img src='$thumb_name' /></a></td>");
	}
	
	
	
	$num_rows = mysqli_num_rows ($r);
	if (empty ($num_rows))
	{ 
		echo ("<td><div class='notice'>В альбоме нет фотографий</div></td>");
	}
	
	echo ("</tr></table>");
	
	if ($i != 3)
	{
		echo ("<br />");
	}
		
}

echo ("
	</td>
	</tr>
	</table>
	<br /><br />
	<p style='width: 1100px; text-align: left;'>
");

$num_pages = ceil($table_num_rows / 3);
if ($num_pages > 1)
{
	echo ("Страницы (".$num_pages.") :");
					
	$i = 1;
	while ($i <= ($num_pages))
	{
		if ($i == $p)
		{
			echo ("&nbsp;<b>[".$i."]</b>");
		}
		else
		{
			echo ("&nbsp;<a href=\"".ROOT_PATH."index.php?p=".$i."\">".$i."</a>");	
		}
		$i++;
	}
					
}

echo ("
	</p>
	</center>
	</body>
	</html>
");

?>