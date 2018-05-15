<?php
	$db="mysql:host=sql9.freemysqlhosting.net;dbname=sql9238008";
	$user="sql9238008";
	$pass="qKpYXVmkCl";
	 $option=array(
	 PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
	 PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION  //PDO ném ra ngoại lệ khi gặp lỗi đồng thời tạo ra PHP warning
	);
	//ket noi
	try {
		$conn=new PDO($db,$user,$pass,$option);
		//$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	} catch (PDOException $e) {
		echo $e->getMessage();
		exit();
	}
?>