<?php require("templates/header.php");
	require '../library/connect.php';
?>
	<div id="popup-background">
		<div id="popup-center">
			<div id="popup-info">
				<div>
					<h3>Chỉnh sửa Thành viên</h3>
					<img id="close" src="../library/images/close.png">
				</div>
				<table>
					<tr>
						<td><label for="txtuser_name">Tên thành viên </label></td>
						<td>
							<input type="text" name="txtuser_name" id="txtuser_name">
							<p class="errors" style="display: none">Bạn chưa nhập user_name</p>
						</td>
					</tr>
					<tr>
						<td><label for="level">Chức vụ</label></td>
						<td><select id="chucvu">
						</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="submit" name="submit" id="sb-edit" style="background-color: #418bca;color: #fff;">
							<input type="submit" name="cancel" id="cancel-edit-user" value="Hủy" style="background-color: #ccc;color:#444;">
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
				<h3>Quản lí Thành viên</h3>
			</div>
		<table id="table">
			<tr>
				<th style="width: 100px">STT</th>
				<th>User Name</th>
				<th style="width: 150px">Join Date</th>
				<th style="width: 150px">Chức vụ</th>
				<th style="width: 120px;">Sửa</th>
				<th style="width: 120px;">Xóa</th>
			</tr>
			<?php 
			//hiện danh sach thành viên
				$sql= "SELECT * ";
				$sql.= " FROM users ";
				$sql.= "ORDER BY user_id ASC ";

				$stmt= $conn->prepare($sql);
				$stmt->execute();
				if($stmt->rowCount()>0){
					$stt=1;
					$users =$stmt->fetchAll(PDO::FETCH_OBJ);
					foreach ($users as $user) {

				?>
				<tr>
					<td><?php echo $stt;?></td>
					<td><?php echo $user->user_name;?></td>
					<?php $time_stamp = strtotime($user->join_date);
						$join_date= date("d-m-Y");
					echo "<td>".$join_date."</td>";?>
					<td>
						<?php 
						switch ($user->level) {
							case '1':
								echo "Người dùng";
								break;
							case '2':
								echo "Mod";
								break;
							case '4':
								echo "Admin";
								break;
							
							default:
								echo "Khach";
								break;
						}
						?>
					</td>
					<td><a href="javascript:void(0);" class="edit-user"  data-userid="<?php echo $user->user_id;?>"><span class="icon-edit" >Sửa</a></td>
					<td><a href="javascript:void(0);" class="del-user" data-userid="<?php echo $user->user_id;?>"><span class="icon-delete" >Xóa</a></td>
				</tr>
				<?php
				$stt++;
					}	 
				} else{
					echo "<tr><td colspan='6'>Chưa có thành viên nào</td>
					</tr>";
				}
				?>
		
		</div>
	</div><!--CONTAINER-->