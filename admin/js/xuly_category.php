<?php
	include_once("../../library/connect.php");
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$action= $_POST['action'];
	
	// nếu action bằng add-ajax thì truy vấn chỉnh sửa dữ liệu
	if($action=="add-ajax"){
		$cate_name= $_POST['cate_name'];
		//them cate cao csdl
		$sql="INSERT INTO category(cate_name) VALUES(:cate_name)";
		$stmt= $conn->prepare($sql);
		$stmt->bindParam(":cate_name",$cate_name,PDO::PARAM_STR);
		$stmt->execute();
		//vì chuyên mục mới nhất vừa thêm vào có id lớn nhất nên thực hiện hàm truy vấn lấy  max(Cate_id);
		$sql1="SELECT MAX(cate_id) as cate FROM category";
		$stmt1= $conn->prepare($sql1);
		$stmt1->execute();
		$cate=$stmt1->fetch(PDO::FETCH_OBJ);
		$cate_id=$cate->cate;
			echo json_encode(
			array(
				"cate_name"=>"$cate_name",
				"cate_id"=>"$cate_id"
			)
		);
	
	}else if($action=="del-ajax"){
		$cate_id = $_POST['cate_id'];

	 	$sql="DELETE FROM category WHERE cate_id = $cate_id";
	 	$stmt= $conn->prepare($sql);
	 	$stmt->execute();
	 	echo json_encode(
			 array(
			 	"cate_id"=>"$cate_id"
			 )
		);
	}//NẾU action lấy name thì tìm cate_name với id 
	else if($action=="get-name"){
		$cate_id =$_POST['cate_id'];
		$sql="SELECT cate_name FROM category WHERE cate_id= $cate_id";
		$stmt= $conn->prepare($sql);
		$stmt->execute();
		$cate= $stmt->fetch(PDO::FETCH_OBJ);
		$cate_name=$cate->cate_name;
		//cách viết truyền dữ liệu json
		echo json_encode(
			array(
				"cate_name"=>"$cate_name"
			)
		);
	}else if($action=="edit-ajax"){
		$cate_name=$_POST['cate_name'];
		$cate_id= $_POST['cate_id'];
		$sql="UPDATE category SET cate_name = :cate_name WHERE cate_id = $cate_id";
		$stmt= $conn->prepare($sql);
		$stmt->bindParam(":cate_name",$cate_name,PDO::PARAM_STR);
		$stmt->execute();
		echo json_encode(
			 array(
			 	"cate_id"=>"$cate_id",
			 	"cate_name"=>"$cate_name"
			 ) 
		);
	}
?>