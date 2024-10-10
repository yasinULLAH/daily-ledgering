<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_myconn = "localhost";
$database_myconn = "roznamcha";
$username_myconn = "root";
$password_myconn = "";
$myconn = mysql_pconnect($hostname_myconn, $username_myconn, $password_myconn); 
$con = mysql_connect("localhost","root","");
$db = mysql_select_db("roznamcha");
?>