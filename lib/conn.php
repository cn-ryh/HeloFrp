<?php
$mysql_server_name = '127.0.0.1'; //数据库服务器
$mysql_username = '123456789'; //数据库用户名
$mysql_password = '123456789'; //数据库密码
$mysql_database = '123456789'; //数据库名
$conn = mysqli_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
if (mysqli_connect_errno($conn)) 
{ 
	die("连接 MySQL 失败: " . mysqli_connect_error()); 
}
?>