<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
	include_once('../library/connect.php');
	$action = $_POST['action'];
	$user_name = $_POST['uname']; 
	$password = sha1($_POST['pass']); 
	if($action == 'login-ajax')
	{
		$sql = "SELECT * FROM users WHERE user_name = :user_name AND password = :password";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':user_name',$user_name,PDO::PARAM_STR);
		$stmt->bindParam(':password',$password,PDO::PARAM_STR);
		$stmt->execute();
		if($stmt->rowCount()==1)
		{
			$user = $stmt->fetch(PDO::FETCH_OBJ);
			$_SESSION['user_name'] = $user_name;
			$_SESSION['user_id'] = $user->user_id;
			$_SESSION['level'] = $user->level;
			$mess= true;
		}else{
			$mess=false;
		}
		echo json_encode(
			array(
				"mess" => $mess
			)
		);
	}else if($action == 'register-ajax'){
		//kiem tra xem user_nem co ton tai hay khong
		$valid = array('success' => false, 'messages' => array());

		$sql = "SELECT user_id FROM users WHERE user_name = :user_name";
		$stmt =$conn->prepare($sql);
		$stmt->bindParam(":user_name",$user_name,PDO::PARAM_STR);
		$stmt->execute();
		if($stmt->rowCount()>0)
		{
			$valid['success'] = false;
			$valid['messages'] = "Tài khoản đã tồn tại";
		}else{
			$sql = "INSERT INTO users(user_name,password,join_date,level) VALUES(:user_name,:password,:join_date,:level)";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(":user_name",$user_name,PDO::PARAM_STR);
			$stmt->bindParam(":password",$password,PDO::PARAM_STR);
			$stmt->bindParam(":join_date",$join_date);
			$stmt->bindParam(":level",$level,PDO::PARAM_INT);
			$join_date = date("Y-m-d H:i:s");
			$level = 1;
			$stmt->execute();
			$valid['success'] = true;
			$valid['messages'] = "Đăng kí thành công nhấp vào <a href='index.php'>đây</a> để trở về";
		}
		echo json_encode(
			array(
				"valid" => $valid
			)
		);
	}

?>
