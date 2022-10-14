<?php
/*==============================

MYSQL ENGINE

==============================*/
class db_engine
{
	var $host;
	var $user;
	var $pass;
	var $name;
	var $req_array = array();
	var $html_error;
 var $connect;
	
	function connect()
	{
		 $this->connect = @mysqli_connect ($this->host, $this->user, $this->pass, $this->name);
  return $this->connect;
	}
	
	/*function connect()
	{
		return @mysql_select_db ($this->name);
	}*/
	
	function query ($query)
	{
		@mysqli_query($this->connect, "$query") or die ("<html>
			<head>
			<title></title>
			<style type = 'text/css'>
			@import url('../css/admin.css');
			</style>
			</head>
			<body>
			<center>
			<div class = 'error'><br />Ошибка при обращении с базой данных<br />
			<br /></div>
			</center>
			</body>
			</html>
		");
		
	}
	
	function query_array ($query)
	{
		return $this->req_array = @mysqli_fetch_array(@mysqli_query($this->connect, "$query")) or die ("
			<html>
			<head>
			<title></title>
			<style type = 'text/css'>
			@import url('../css/admin.css');
			</style>
			</head>
			<body>
			<center>
			<div class = 'error'><br />Ошибка при обращении с базой данных<br />
			<br /></div>
			</center>
			</body>
			</html>"
		) ; // mysql_fetch_assoc?
	}
	
	function num_rows ($query)
	{
		return @mysqli_num_rows (@mysqli_query ($this->connect, $query));
	}
	
	function error()
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
			<div class = 'error'><br />Ошибка при обращении с базой данных<br />
			<br /></div>
			</center>
			</body>
			</html>
		");
		exit();
	}

function fetch_assoc($query)
{
 return @mysqli_fetch_assoc($query);
}
}
?>