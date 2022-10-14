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


if (isset ($_GET['alb_id'])) { // проверка существования именя альбома

	$album_id = $_GET['alb_id'];
	
	$db->query_array ("SELECT album_name, album_id FROM $tbl_sys_albums where album_id='$album_id'");
	$album_name = $db->req_array['album_name'];
	$album_id = $db->req_array['album_id'];
	
	// параметр номера выводимой страницы (если страниц в альбоме больше 1)
	if (!isset ($_GET['p']) or empty ($_GET['p']))
	{
		$p = 1;
	}
	else
	{
		$p = $_GET['p'];
	}
	
	$lim = 15*$p-15;
	
	$query = $db->query ("SELECT * FROM $tbl_sys_photos WHERE album_id='$album_id' ORDER BY photo_id DESC LIMIT $lim,15");
	$table_num_rows = @mysqli_num_rows (@mysql_query ("SELECT * FROM $tbl_sys_photos WHERE album_id='$album_id' ORDER BY photo_id DESC"));

	if ($query)
	{ // валидный альбом - вывод содержимого
	
		echo ("
			<html>
			<head>
			<title>Просмотр альбома $album_name</title>
			<style>
			@import url('".ROOT_PATH."css/admin.css');
			</style>
			</head>
			<body>
			<center>
			<div class='nav'><a href='".ROOT_PATH."index.php'>Фотогалерея</a> &gt; Альбом ".$album_name."</div><br /><br />
			<table class='showalbum' cellpadding='5' cellspacing='1'>
			<tr>
		");

		$i=0;
		$td=0; // переменная, отвечающая за кол-во фотографий в строке вывода
		
		$num_rows = mysqli_num_rows ($query);

		if (!empty ($num_rows ))
		{
		
			
			
			
			$tr = 0; // строки
			while ($i++ < $num_rows)
			{
				$photo = mysqli_fetch_assoc ($query);
				$photo_name = $photo['photo_name'];
				$desc_name = $photo['desc_name'];
				$date = $photo['upload_date'];
				$ph_id = $photo['photo_id'];

				if ($td == 5)// если вывели уже 5 фотографий в строке - переход на новую  строку
				{ 
					$tr++;
					if ($tr != 3)
					{
						echo ("</tr><tr>");
					}
					else
					{
						echo ("</tr>");
					}
					
					$td=0; // и обнуляем переменную
				}
				
				
				
				echo ("
					<td>
					<table cellpadding='5' cellspacing='1'><tr>
					<td align='center'><a href = '".ROOT_PATH."showphoto.php?ph_id=".$ph_id."'><img src = '".THUMB_PATH.$photo_name."' /></a></td>
					</tr><tr>
					<td align='center'>$desc_name</td>
					</tr><tr>
					<td align='center'>Добавлено: $date</td>
					</tr>
					</table>
					</td>
				");
				
				$td++;
				
				
				
			}
			
			echo ("
				</tr>
				</table>
				<br /><br />
				<p style='width: 1100px; text-align: left;'>
			");
			
			
			
			$num_pages = ceil($table_num_rows / 15);
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
						echo ("&nbsp;<a href='".ROOT_PATH."showalbum.php?alb_id=".$album_id."&p=".$i."'>".$i."</a>");	
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
			
			
		}
		else
		{
			echo ("<td><div class='notice'>В альбоме нет фотографий</div></td>");
		}
	}
	else // не валидный альбом -  404 :)
	{ 

		$html->error("Данный альбом не существует");

	}
	
}
else
{ 
	header ("location: ./index.php");
}

?>