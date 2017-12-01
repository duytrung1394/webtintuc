<?php 
	include_once("../../library/connect.php");
	$action= $_POST['action'];

	if($action=="get-info"){
		$user_id=$_POST['user_id'];
		$sql="SELECT user_name,level FROM users WHERE user_id = $user_id";
		$stmt= $conn->prepare($sql);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_OBJ);
		$user_name= $user->user_name;
		$level= $user->level;
		echo json_encode(
			array(
				"user_name" => "$user_name",
				"level" => "$level",
			)
		);

	 }else if($action=="edit-user"){

		$user_id = $_POST['user_id'];
		$level = $_POST['level'];
		$user_name= $_POST['user_name'];
		$sql= "UPDATE users SET user_name= :user_name,level = :level ";
		$sql.= "WHERE user_id = $user_id";
		$stmt= $conn->prepare($sql);
		$stmt->bindParam(":user_name",$user_name,PDO::PARAM_STR);
		$stmt->bindParam(":level",$level,PDO::PARAM_INT);
		$stmt->execute();
		echo json_encode(
			array(
				"user_id" => "$user_id",
				"user_name" => "$user_name",
				"level" => "$level"
			)
		);
	}
	else if($action=="del-user"){
		$user_id = $_POST['user_id'];
		$sql= "DELETE FROM reply WHERE user_id = $user_id";
		$stmt= $conn->prepare($sql);
		$stmt->execute();


		$sql= "DELETE FROM comment WHERE user_id = $user_id ";
		$stmt= $conn->prepare($sql);
		$stmt->execute();

	 	$sql="DELETE FROM users WHERE user_id = $user_id";
	 	$stmt= $conn->prepare($sql);
	 	$stmt->execute();
	 	echo json_encode(
			 array(
			 	"user_id"=>"$user_id"
			 )
		);
	}
