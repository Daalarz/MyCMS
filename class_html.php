<?php
class html_install
{
	function do_form()
	{
		echo ("
			<html>
			<head>
			<title>Установка фотогалереи</title>
			<style type = 'text/css'>
			@import url('../css/install.css');
			</style>
			</head>
			<body>
			<center>
			<div class='header'><br />Добро пожаловать в программу установки блока \"Фотогалерея\"!<br /><br /></div><br />
			<div class='notice'><b>Внимание!</b>&nbsp;На сервере должна присутствовать установленная система управления базами данных <b>MySQL</b> и обработчик скриптового языка <b>PHP</b> версии не ниже <b>7.0</b>!<br /></div><br />
			<div class='notice'><b>Внимание!</b>&nbsp;На сервере системы управления базами данных <b>MySQL</b> уже должна быть создана база данных!<br /></div><br />
			<div class='notice'><b>Внимание!</b>&nbsp;Поля, отмеченные <span style = 'color: #FF0000'><b>*</b></span>, обязательны к заполнению!<br ></div><br /><br />
			<form action = './index.php' method = 'post'>
			
			<table cellpadding='5' cellspacing='1'>
				
					<tr>
						<th colspan='2'>MySQL</th>
					</tr><tr>
						<td width='50%'>Сервер базы данных: <span style = 'color: #FF0000'>*</span><br /><div class='warn'>localhost</td>
						<td width='50%'><input class = 'field' type = 'text' name = 'db_host' value='localhost' /></td>
					</tr><tr>
						<td>Имя БД: <span style = 'color: #FF0000'>*</span></td>
						<td><input class = 'field' type = 'text' name = 'db_name' /></td>
					</tr><tr>
						<td>Имя пользователя БД: <span style = 'color: #FF0000'>*</span></td>
						<td><input class = 'field' type = 'text' name = 'db_user' /></td>
					</tr><tr>
						<td>Пароль пользователя БД: <span style = 'color: #FF0000'>*</span></td>
						<td><input class = 'field' type = 'text' name = 'db_pass'></td>
					</tr><tr>
						<td>Префикс таблиц MySQL: <span style = 'color: #FF0000'>*</span></td>
						<td><input class = 'field' type = 'text' name = 'db_prefix' value='phg_'></td>
				
			</table><br /><br />
			
			<table cellpadding='5' cellspacing='1'>
				
					<tr>
						<th colspan='2'>Аккаунт администратора Фотогалереи</th>
					</tr><tr>
						<td width='50%'>Желаемый логин администратора фотогалереи: <span style = 'color: #FF0000'>*</span>&nbsp; &nbsp; &nbsp;</td>
						<td width='50%'><input class = 'field' type = 'text' name = 'user' /></td>
					</tr><tr>
						<td>Желаемый пароль: <span style = 'color: #FF0000'>*</span></td>
						<td><input class = 'field' type = 'password' name = 'pass' /></td>
					</tr><tr>
						<td>Повторите желаемый пароль: <span style = 'color: #FF0000'>*</span></td>
						<td><input class = 'field' type = 'password' name = 'passw' /></td>
					</tr><tr>
						<td>Введите \"OK\" для начала установки: <span style = 'color: #FF0000'>*</span></td>
						<td><input class = 'field' type = 'text' name = 'control'></td>
					</tr><tr>
						<td colspan = '2' align='center'><input class = 'button' type = 'submit' value = 'Установка' /></td>
					</tr>
				
			</table>
			</form>
			<p class = 'copyright' valign = 'bottom'>MyCMS v1.1 &copy; Daalarz, 2008</p>
			</center>
			</body>
			</html>
		");
	}

	function do_finish()
	{
		echo ("
			<html>
			<head>
			<title>Установка завершена!</title>
			<style type = 'text/css'>
			@import url('../css/install.css');
			</style>
			</head>
			<body>
			<center>
			<div class='header'><br />Добро пожаловать в программу установки блока \"Фотогалерея\"!<br /><br /></div><br />
			<div class = 'notice'><br />Установка блока \"Фотогалерея\" успешно завершена!<br />
			<a href='../admin/index.php'>Перейти на страницу администрирования</a><br /><br /></div>
			</center>
			</body>
			</html>
		");
	}
	
	function notice($msg)
	{
		echo ("
			<html>
			<head>
			<title>Ошибка!</title>
			<style type = 'text/css'>
			@import url('../css/install.css');
			</style>
			</head>
			<body>
			<center>
			<div class='header'><br />Добро пожаловать в программу установки блока \"Фотогалерея\"!<br /><br /></div><br />
			<div class = 'notice'>$msg<br /><br />
			<a href = './install.php'>Назад</a><br /><br /></div>
			</center>
			</body>
			</html>
		");
		exit();
	}
	
}

class html_admin
{
	var $script_name;
	var $thumb_name;
	var $ph_name;
	var $ph_size;
	var $req_array;
	var $album;
	var $album_name;
	
	function do_auth()
	{
		echo ("
			<html>
			<head>
			<title>Авторизация</title>
			<style type = 'text/css'>
			@import url('../css/admin.css');
			</style>
			</head>
			<body>
			<center><br />
			<div class = 'header'><br />Добро пожаловать в панель управления блоком \"Фотогалерея!\"<br /><br /></div><br /><br /><br />
			
			<table class = 'auth' cellpadding='5' cellspacing='1'>
				<tr><th colspan='2'>Авторизация</th>
				</tr>
				<form action = '".$this->script_name."' method = 'post'>
				<tr>
					<td width='50%'>Логин:</td>
					<td width='50%'><input class = 'field'  type = 'text' name = 'uname' /></td>
				</tr><tr>
					<td>Пароль:</td>
					<td><input class = 'field' type = 'password' name = 'psswd' /></td>
				</tr><tr>
					<td colspan='2' align = 'center'><input class = 'button' type = 'submit' value = 'Вход' /></td>
				</tr>
				</form>
			</table>
			</center>
			</body>
			</html>
		");
	}
	
	function do_admin_index()
	{
		echo ("
			<html>
			<head>
			<title>Управление Фотогалереей</title>
			<style type = 'text/css'>
			@import url('../css/admin.css');
			</style>
			</head>
			<body>
			<center>
			<frame valign='top' align='center' scrolling='no' style='width: 100%;'>
			<div class = 'header'><br />Добро пожаловать в панель управления Фотогалереей!<br /><br /></div>
			</frame><br />
			<iframe align='left' style='width: 20%; height: 80%;' hspace='0' vspace='0' scrolling='no' src='./admlinks.html' frameborder='0' scrolling='no'>
			</iframe>
			<iframe align='left' style='width: 80%; height: 80%;' hspace='0' vspace='0' src='./sysinfo.php' frameborder='0' name = 'main'></iframe>
			</center>
			</body>
			</html>
		");
	}
	
	function do_ad()
	{
		echo ("
			<html>
			<head>
			<title>ACCESS DENIED!</title>
			<style type = 'text/css'>
			@import url('../css/admin.css');
			
			</style>
			</head>
			<body>
			<center>
			<div class = 'ad'><br /><b>ACCESS DENIED</b><br />
			<hr />
			<b>ДОСТУП ЗАПРЕЩЕН</b><br /><br /></div><br /><br />
			</center>
			</body>
			</html>
		");
	}
	
	function do_upload_form()
	{
		echo ("
			<html>
			<head>
					
			<style type = 'text/css'>
			@import url('../css/admin.css');
			</style>
			</head>
			<body>
			<center>
					
			<div class='header'>Добавление фотографии</div><br /><br />
			
			<table cellpadding='5' cellspacing='1'>
			<form action = './upload.php' method = 'post' enctype = 'multipart/form-data'>
			
			<tr>
			<th colspan='2'>Файл для загрузки</th>
			</tr><tr>
			<td width='50%'><div class='warn'>Допускаются только файлы MIME-типа image/jpeg с расширением *.jpg или *.jpeg</div></td>
			<td width='50%'>
				<input class='file' type = 'file' name = 'photo'><br /></td>
				</tr><tr>
				<td align='center' colspan='2'>
				<input class='button' type = 'submit' value = 'Загрузить'>
				</td>
				</tr>
			</form>
			</table>
			</center>
			</body>
			</html>
		");
	}
	
	function upload_result($st)
	{
		switch ($st) {
			case 1:
				echo ("
					<html>
					<head>
					<title>Результат загрузки файла</title>
					<style type = 'text/css'>
					@import url('../css/admin.css');
					</style>
					</head>
					<body>
					<center>
					<div class='header'>Добавление фотографии</div><br /><br />
					<div class='notice'>Файл успешно загружен!</div><br /><br />
					<table cellpadding='5' cellspacing='1'>
					<tr><th colspan='2'>Характеристики файла</th></tr>
					<tr><td width='50%'>Изображение</td><td width='50%'><img src = '$this->thumb_name' /></td></tr>
					<tr><td width='50%'>Имя файла</td><td width='50%'>$this->ph_name</td></tr>
					<tr><td>Размер файла (Б)</td><td>$this->ph_size</td></tr></table>
					<br /><br />
					<table cellpadding='5' cellspacing='1'>
					<form action = './addalbum.php' method = 'post'>
					<tr><th colspan='2'>Альбом для загружаемого файла</th></tr>
					<tr><td width='50%'><div class='warn'>Выберите альбом:</div></td><td width='50%'>
					<select name = 'album_id'>
				");
			break;
			
			case 2:
				echo ("<option value = '".$this->req_array["album_id"]."'>".$this->req_array["album_name"]."</option>");
			break;
			
			case 3:
				echo ("
					</select></td></tr>
					<tr><th colspan='2'>Название фотографии</th></tr>
					<tr><td width='50%'><div class='warn'>Не более 50 символов</div></td>
					<td width='50%'><input class='field' type = 'text' name = 'desc_name' /></td></tr>
					<tr><th colspan='2'>Описание фотографии</th></tr>
					<tr><td width='50%'><div class='warn'>Не более 200 символов</div></td>
					<td width='50%'><textarea name='descrpt' cols='20' rows='5'></textarea></tr>
					<tr><td colspan='2'><center><input class='button' type = 'submit' value = 'Добавить' /></center></td></tr>
					</form>
					</table>
				");
			break;
			
			default: $this->notice("Неверный параметр");
		}
	}
	
	function notice($msg)
	{
		echo ("
			<html>
			<head>
			<title></title>
			<style type = 'text/css'>
			@import url('../css/admin.css');
			</style>
			</head>
			<body>
			<center>
			<div class = 'notice'><br />$msg<br />
			<br /></div>
			</center>
			</body>
			</html>
		");
		exit();
	}
	
	function error($msg)
	{
		echo ("
			<html>
			<head>
			<title></title>
			<style type = 'text/css'>
			@import url('../css/admin.css');
			</style>
			</head>
			<body>
			<center>
			<div class = 'error'><br />$msg<br />
			<br /></div>
			</center>
			</body>
			</html>
		");
		exit();
	}
	
	function createalbum_form()
	{
		echo ("
			<html>
			<head>
			<title>Создание нового альбома :: Панель администратора MyCMS Photogallery Block</title>
			<style type = 'text/css'>
			@import url('../css/admin.css');

			</style>
			</head>
			<body>
			<center>

			<div class = 'header'>Создание нового альбома</div><br /><br />
			<table cellpadding='5' cellspacing='1'>
			<form method = 'post' action = './createalbum.php'>
			<tr>
			<th colspan='2'>Название альбома</th>
			</tr><tr>
			<td width='50%'>
			<div class='warn'>Допускаются только названия, состоящие из одного слова. 
			Допускаются символы [A-Z], [a-z], [А-Я], [а-я], [0-9].<br /> 
			Название альбома не должно начинаться с цифр!</div></td>
			<td width='50%'>
			<input class = 'field' type = 'text' name = 'add_album_name' /></td>
			</tr></tr>
			<th colspan = '2'>Описание альбома</th>
			</tr><tr>
			<td width='50%'>
			<div class = 'warn'>Допускаются символы [A-Z], [a-z], [А-Я], [а-я], [0-9].<br />
			Описание не должно превышать длину в 200 символов</div></td>
			<td width='50%'>
			<input class = 'field' type = 'text' name = 'descr' /></td>
			</tr><tr>
			<td colspan='2' align = 'center'><input class = 'button' type = 'submit' value = 'Добавить' /></td>
			</tr>
			</table>
			</form>
			</center>
			</body>
			</html>
		");
	}
	
	function createalbum_finish()
	{
		echo ("
			<html>
			<head>
			<style type = 'text/css'>
			@import url('../css/admin.css');
			</style>
			<body>
			<center>
			<div class = 'notice'><br />Альбом '$this->album_name' успешно создан!<br />
			<a href = './upload.php'>Загрузить фотографию</a> &nbsp; &middot; &nbsp; <a href = './index.php'>На главную</a><br /><br /></div>
			</center>
			</body>
			</html>
		");
	}
	
	function addinalbum_notice()
	{
		echo ("
			<html>
			<head>
			<title>Добавление фотографии в альбом</title>
			<style type = 'text/css'>
			@import url('../css/admin.css');
			</style>
			</head>
			<body>
			<center>
			<div class = 'notice'><br />Файл успешно добавлен в альбом '$this->album'!<br /><a href='../index.php'>На главную</a></br /><br /></div>
			</center>
			</body>
			</html>
		");
	}
	
	function db_error()
	{
		echo ("
			<html>
			<head>
			<title>MySQL Engine Error</title>
			</head>
			<body>
			".mysql_error()."
			</body>
			</html>
		");
		exit();
	}
	
	
}
?>