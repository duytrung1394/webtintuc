<?php require("templates/header.php");
	require '../library/connect.php';
	require_once("../library/phantrang.php");
?>
	<div id="popup-background">
		<div id="popup-center-x">
			<div id="popup-info">
			<div id="form-upload">
				<form action="js/xuly_article.php" method="post" enctype="multipart/form-data" class="form" >
				<div>
					<h3></h3>
					<img id="close" src="../library/images/close.png">
				</div>
				<table>
					<tr>
						<td width="110px"><label for="chuyenmuc">Chức vụ</label></td>
						<td><select id="chuyenmuc" name="chuyenmuc"></select>
						</td>
					</tr>
					<tr>
						<td><label for="news_title">Tiêu đề</label></td>
						<td>
							<input type="text" name="txtnewstitle" id="news_title" size="80" >
							<p class="errors" style="display: none">Bạn chưa nhập title</p>
						</td>
					</tr>
						
				
					<tr>
						<td><label for="hinhanh">Hình ảnh</label></td>
						<td id="hinhanh-old"><input type="file" name="image" id="hinhanh" />
						<label><span style="margin:0 30px;display:none" id="hinhcu">Hình cũ</span></label>
						<span id="old-image" style="display:none"></span>
						</td>
					</tr>
					<tr>
						<td><label>Mô tả:</label></td>
						<td>
							<input type="text" name="txtmota" id="mota" size="80">
							<p class="errors" style="display: none">Bạn chưa nhập Mô tả</p>
						</td>
					</tr>
					<tr>
						<td><label>Nội dung</label></td>
						<td>
							<textarea id="content" rows="10" cols="200" name="content"></textarea>
							<p class="errors" id="errors-content" style="display: none">Bạn chưa nhập nội dung</p>
							<script type="text/javascript">
								CKEDITOR.replace('content');
							</script>
						</td>
					</tr>
					
					<tr><td>
						<input type="hidden" name="operation" id="operation" />
						<input type="hidden" name="news_id" id="news_id" style="display: none" />
						</td>
						<td>
							<input type="submit" name="bt-submit" id="submit-article" style="background-color: #418bca;color: #fff;">
						</td>
					</tr>
				</table>
					<p id="messages"></p>
				</form>
			</div>
			</div>
		</div>
	</div> <!--POPUP-BACKGROUND-->

	<div id="container">
		<div id="header">
			<p>Chào <?php echo $_SESSION['user_name'];?>, <a href="../logout.php">Đăng xuất</a>,<a href="../index.php">Home</a></p>
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
				<h3>Quản lí bài viết</h3>
				<button id="add-article"><span class="icon-add" />Thêm</button>
			</div>
		<table id="table-article">
			<tr>
				<th style="width: 60px">STT</th>
				<th>Tiêu đề</th>
				<th width="330px">Mô tả</th>
				<th width= "110px">Chuyên mục</th>
				<th width= "110px">Người đăng</th>
				<th style="width: 100px">Ngày đăng</th>
				<th style="width: 80px;">Sửa</th>
				<th style="width: 80px;">Xóa</th>
			</tr>
			
				<?php 
				// thực hiên phân trang
				$itemDisplay= 10;
				//tính tổng số page
				$sql = "SELECT news_id FROM tintuc";
				$stmt= $conn->prepare($sql);
				$stmt->execute();
				$totalNews= $stmt->rowCount();
				$totalPage=ceil($totalNews/$itemDisplay);

				if(isset($_GET['page']) && filter_var($_GET['page'],FILTER_VALIDATE_INT) && $_GET['page']>=1){
					if($totalPage<$_GET['page']){
						$start = ($totalPage-1) * $itemDisplay;
					}else{
						$start= ($_GET['page']-1) * $itemDisplay;
					}
				}else{
					$start=0;
				}
				$sql= 	"SELECT t.news_title,t.news_id,t.hinhanh,t.mota,t.post_on,c.cate_name,u.user_name ";
				$sql.= 	"FROM tintuc t ";
				$sql.= 	"INNER JOIN category c ";
				$sql.=  "USING (cate_id) ";
				$sql.=  "INNER JOIN users u ";
				$sql.=  "USING (user_id) ";
				$sql.=  "LIMIT $start,$itemDisplay ";
				$stmt= $conn->prepare($sql);
				$stmt->execute();
				if($stmt->rowCount()>0){
					if(isset($_GET['page'])){
						$stt= ($_GET['page']-1)*$itemDisplay+1;		 // VD: page =2; item= 10; ->page 2 : stt= (2-1)*10 =10, stt đếm từ 10
					}else{
						$stt=1;
					}
					$news = $stmt->fetchAll(PDO::FETCH_OBJ);
					foreach ($news as $new) {
					?>
					<tr>
					<td><?php echo $stt;?></td>
					<td><?php echo $new->news_title;?></td>
					<td><?php echo $new->mota;?></td>
					<td><?php echo $new->cate_name;?></td>
					<td><?php echo $new->user_name;?></td>
					<td><?php 
						$timestamp = strtotime($new->post_on);
						$date = date("d-m-Y"); 
						echo $date;
					?></td>
					<td><a href="javascript:void(0)" class="edit-article" data-newsid="<?php echo $new->news_id;?>"><span class="icon-edit" />Sửa</a></td>
					<td>
						<a href="javascript:void(0)" class="del-article" data-newsid="<?php echo $new->news_id;?>"><span class="icon-delete" />Xóa</a></td>
				</tr>

				<?php
				$stt++;
					}
				}
				?>
		</table>

	</div>
			<?php
					$pageShow=5;
					phantrang($pageShow,$itemDisplay,$totalPage,$start);
			?>
</div>