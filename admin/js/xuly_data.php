<?php 
	include_once("../../library/connect.php");

 	$action = $_POST['action'];
	
	if($action=="getdata-add"){
		$sql= "SELECT cate_id,cate_name FROM category";
		$stmt= $conn->prepare($sql);
		$stmt->execute();
		$cates = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($cates);
	}else if($action=="getdata-edit"){

		$news_id = $_POST['news_id'];
		//lấy toàn bộ dữ liệu vào form
		$sql= "SELECT news_id,news_title,hinhanh,mota,content,cate_id FROM tintuc WHERE news_id= :news_id";
		$stmt= $conn->prepare($sql);
		$stmt->bindParam("news_id",$news_id,PDO::PARAM_INT);
		$stmt->execute();
		$news = $stmt->fetchAll(PDO::FETCH_ASSOC);
		//ấy danh sach cate
		$sql1=  "SELECT cate_name,cate_id FROM category";
		$stmt1= $conn->prepare($sql1);
		$stmt1->execute();
		$cates = $stmt1->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode(
			array(
				"news" => $news,
				"cates" => $cates
			)
		);

	}
	else if($action == "deldata"){

		 $news_id = $_POST['news_id'];

		$sql= "DELETE FROM tintuc WHERE news_id= :news_id";
		$stmt= $conn->prepare($sql);
		$stmt->bindParam("news_id",$news_id,PDO::PARAM_INT);
		$stmt->execute();

		echo json_encode(
			array(
				"news_id" => "$news_id",
			)
		);
	}

?>
