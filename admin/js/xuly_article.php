<?php 
	session_start();
	require_once("../../library/connect.php");
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$operation = $_POST['operation'];
	
	if($operation =="add"){
		$cate_id= $_POST['chuyenmuc'];
		$news_title= $_POST['txtnewstitle'];
		$mota = $_POST['txtmota'];
		$content= $_POST['content'];
		$user_name = $_SESSION['user_name'];
		$user_id = $_SESSION['user_id'];
		$valid = array('success' => false, 'messages' => array());

		if($_FILES['image']['error']>0){
			$valid['success'] = false;
			$valid['messages'] = "Lỗi Bạn chưa chọn file";
				
		 }else{
			
			$allowed=array('image/jpeg','image/png','image/jpg');
			//lấy phần mở rông
			$tmp_ext=explode('.', $_FILES['image']['name']);
			$ext=end($tmp_ext);
			if(in_array(strtolower($_FILES['image']['type']),$allowed))
				{	
					$renamed=uniqid("anh_",true).".".$ext;
					if(!move_uploaded_file($_FILES['image']['tmp_name'],"../../upload/".$renamed)){
						$valid['success'] = false;
						$valid['messages'] = "Error while uploading";
						
					}else{
						//thực hiện truy vấn 
						$sql ="INSERT INTO tintuc(news_title, hinhanh, mota, content, post_on, cate_id, user_id) VALUES(:news_title,:hinhanh,:mota,:content,:post_on,:cate_id,:user_id)";
						$stmt = $conn->prepare($sql);
						$stmt->bindParam(":news_title",$news_title,PDO::PARAM_STR);
						$stmt->bindParam(":hinhanh",$renamed,PDO::PARAM_STR);
						$stmt->bindParam(":mota",$mota,PDO::PARAM_STR);
						$stmt->bindParam(":content",$content,PDO::PARAM_STR);
						$stmt->bindParam(":post_on",$post_on);
						$stmt->bindParam(":cate_id",$cate_id,PDO::PARAM_INT);
						$stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
						$post_on = date("Y-m-d H:i:s");
						$stmt->execute();
						$valid['success'] = true;
						$valid['messages'] = "Successfully Uploaded";
						//lay ra neu ID
						$sql="SELECT MAX(news_id) as news_id FROM tintuc";
						$stmt= $conn->prepare($sql);
						$stmt->execute();
						$news = $stmt->fetch(PDO::FETCH_OBJ);
						$news_id = $news->news_id;
					}
				}else{
						$valid['success'] = false;
						$valid['messages'] = "Có lỗi, Mời bạn chọn ảnh";
				}
			}

		//nếu thêm cơ sở dữ liệu thành công thì cho $hinh, $date để trả về file jsson
		if($valid['success']==true){
			$hinh= $renamed;		
			$time_stamp= strtotime($post_on); 
			$date = date("d-m-Y");
		}else{
			$hinh = "none";
			$user_name ="none";
			$date="none";
			$news_id = "none";
		}
		//lấy news id
		
		 //lấy cate_name 
		$sql="SELECT cate_name FROM category WHERE cate_id = $cate_id";
		$stmt= $conn->prepare($sql);
		$stmt->execute();
		$cate = $stmt->fetch(PDO::FETCH_OBJ);
		$cate_name = $cate->cate_name;


		echo json_encode(
			array( 
				"news_id" => "$news_id",
				"news_title" => "$news_title",
				"hinhanh" => "$hinh",
				"mota" => "$mota",
				"date" => "$date",
				"cate_name" => "$cate_name",
				"user_id" => "$user_id",
				"user_name" => "$user_name",
				"valid" => $valid
			)
		);
   }
  	else if($operation=="edit")
	{	
   		$news_id = $_POST['news_id'];
   		$cate_id= $_POST['chuyenmuc'];
		$news_title= $_POST['txtnewstitle'];
		$mota = $_POST['txtmota'];
		$content= $_POST['content'];
		// $user_name = $_SESSION['user_name'];
		// $user_id = $_SESSION['user_id'];

		$valid = array('success' => false, 'messages' => array());
		$change_image=""; //Đặt cờ để xem hình có thay đổi hay không;

		if($_FILES['image']["error"]>0){
			$valid["success"] = true;
			$change_image= "none";
		}else{
			$allowed = array("image/jpg","image/png","image/jpeg");
				//lay phan mo rong
				$tmp_ext = explode(".",$_FILES['image']['name']);
				$ext = end($tmp_ext);
				if(in_array($_FILES['image']['type'],$allowed)){

						$renamed=uniqid("anh_",true).".".$ext;

					if(!move_uploaded_file($_FILES['image']['tmp_name'],"../../upload/".$renamed)){
						$valid["success"]=false;
						$valid['messages']= "Lỗi upload";
					}else{
						$valid["success"]=true;
						$valid['messages'] ="Upload thành công";
					}
				}
				else{
					$valid["success"]=false;
					$valid['messages'] ="Lỗi định dạng file ảnh";
			}	
		}
 
   if($valid['success']==true){
   	//nếu không thay hình ảnh
   		if($change_image == "none"){
	   		$sql ="UPDATE tintuc SET news_title = :news_title, mota = :mota, content = :content, cate_id =:cate_id WHERE news_id = :news_id ";
	   		$stmt = $conn->prepare($sql);
	   		$stmt->bindParam(":news_title",$news_title,PDO::PARAM_STR);
	   		$stmt->bindParam(":mota",$mota,PDO::PARAM_STR);
	   		$stmt->bindParam(":content",$content,PDO::PARAM_STR);
	   		$stmt->bindParam(":cate_id",$cate_id,PDO::PARAM_STR);
	   		$stmt->bindParam(":news_id",$news_id,PDO::PARAM_INT);
	   		$stmt->execute();
	   		$hinh ="none";
   		}//ngược lại  update hinh
   		else{
   			$sql = "SELECT hinhanh FROM tintuc WHERE news_id = :news_id ";
			$stmt = $conn->prepare($sql);
   			$stmt->bindParam(":news_id",$news_id,PDO::PARAM_INT);	
   			$stmt->execute();
   			if($stmt->rowCount()>0)
   			{
   				$images = $stmt->fetch(PDO::FETCH_OBJ);
   				$old_image = $images->hinhanh;
   				unlink("../../upload/".$old_image); 
   			}

	   		$sql ="UPDATE tintuc SET news_title = :news_title,hinhanh =:hinhanh, mota = :mota, content = :content, cate_id =:cate_id WHERE news_id = :news_id ";
	   		$stmt = $conn->prepare($sql);
	   		$stmt->bindParam(":news_title",$news_title,PDO::PARAM_STR);
	   		$stmt->bindParam(":hinhanh",$renamed,PDO::PARAM_STR);
	   		$stmt->bindParam(":mota",$mota,PDO::PARAM_STR);
	   		$stmt->bindParam(":content",$content,PDO::PARAM_STR);
	   		$stmt->bindParam(":cate_id",$cate_id,PDO::PARAM_STR);
	   		$stmt->bindParam(":news_id",$news_id,PDO::PARAM_INT);
	   		$stmt->execute();
	   		$hinh=$renamed;
 		}
 	}
 	$sql= "SELECT cate_name FROM category WHERE cate_id = $cate_id";
 	$stmt= $conn->prepare($sql);
 	$stmt->execute();
 	$cate = $stmt->fetch(PDO::FETCH_OBJ);
 	$cate_name =$cate->cate_name;
 	echo json_encode(
 		array(
			"news_id"    => "$news_id",
			"news_title" => "$news_title",
			"hinh" 		 =>	"$hinh",
			"mota"       =>	"$mota",
			"content"    =>	"$content",
			"operation"  =>"$operation",
			"cate_name"	 => "$cate_name",
			"valid"      =>	$valid
 			)
 		);
	}
?>