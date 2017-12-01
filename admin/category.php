<?php include("templates/header.php");
		include_once("../library/connect.php");
		include_once("../library/phantrang.php");
?>
	<div id="popup-background">
		<div id="popup-center">
			<div id="popup-info">
				<div>
					<h3></h3>
					<img id="close" src="../library/images/close.png">
				</div>
				<table>
					<tr>
						<td><label for="cate_name">Tên danh mục </label></td>
						<td>
							<input type="text" name="txtcate_name" id="cate_name">
							<p class="errors" style="display: none"></p>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="submit" name="submit" class="submit" style="background-color: #418bca;color: #fff;">
							<input type="submit" name="cancel" id="cancel-add-cate" value="Hủy" style="background-color: #ccc;color:#444;">
							<p class="messages"></p>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div id="container">
		<div id="header">
			<p>Chào admin, <?php echo $_SESSION['user_name'];?>, <a href="../logout.php">Đăng xuất</a>,<a href="../index.php">Home</a></p>
		</div>
		<div id="nav">
			<ul>
				<li><a href="user.php">Quản lí thành viên</a></li>
				<li><a href="category.php">Quản lí chuyên mục</a></li>
				<li><a href="article.php">Quản lí bải viết</a></li>
			</ul>
		</div>
		<div id="content-x">
			<div>
				<h3>Quản lí chuyên mục</h3>
				<button id="add-category"><span class="icon-add" />Thêm</button>
			</div>
		<table id="table">
			<tr>
				<th style="width: 100px">STT</th>
				<th >Chuyên mục</th>
				<th style="width: 120px;">Sửa</th>
				<th style="width: 120px;">Xóa</th>
			</tr>
			<?php 
				// $displayItem= 5;
				// //tim tổng sô chuyên mục
				// $sql ="SELECT cate_id FROM category";
				// $stmt= $conn->prepare($sql);
				// $stmt->execute();
				// $totalCate = $stmt->rowCount();

				// $totalPage = ceil($totalCate/$displayItem);

				// if(isset($_GET['page']) && filter_var($_GET['page'],FILTER_VALIDATE_INT) && $_GET['page']>=1)
				// {
				// 	if($totalPage<$_GET['page']){
				// 		$start = ($totalPage - 1)*$displayItem;
				// 	}else{
				// 		$start = ($_GET['page'] - 1 )*$displayItem;
				// 	}
				// }else{
				// 	$start= 0;
				// }
				//LIMIT $start,$displayItem";
				$sql1 ="SELECT * FROM category";
				$stmt= $conn->prepare($sql1);
				$stmt->execute();
				$rows = $stmt->rowCount();
				if($rows>0){
					$cates = $stmt->fetchAll(PDO::FETCH_OBJ);
					$stt=1;
				
					foreach ($cates as $cate) {
			?>
				<tr>
					<td class="stt"><?php echo $stt;?></td>
					<td><?php echo $cate->cate_name;?> </td>
					<td><a href="javascript:void(0)" class="edit-ajax" data-cateid="<?php echo $cate->cate_id;?>"><span class="icon-edit" />Sửa</a></td>
					<td><a href="javascript:void(0)" class="del-ajax" data-cateid="<?php echo $cate->cate_id;?>"><span class="icon-delete" />Xóa</a></td>
				</tr>
			<?php 	$stt++;
					}
					
				echo "</table>";
			echo "</div>";

			// $pageShow=5;
			// phantrang($pageShow,$displayItem,$totalPage,$start);
			}
		?>
</div>


