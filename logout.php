<?php
	session_start(); 
	session_destroy();
	header("location:trang-chu.html");
	exit();
?>