<?php 
	include('templates/header.php');

?>		
		<div id='content' class='row'>
			<div class="col-xs-6 col-sm-12 col-md-10 col-lg-10 cate-item">
				<div class='row cate-content'>
				<?php
				
				if(isset($_GET['cid']))
				{
					$cate_id =$_GET['cid'];
					$sql = "SELECT * FROM category WHERE cate_id = :cate_id" ;
					$stmt= $conn->prepare($sql);
					$stmt->bindParam(":cate_id",$cate_id,PDO::PARAM_INT);
					$stmt->execute();
					if($stmt->rowCount()>0){
						$cate = $stmt->fetch(PDO::FETCH_OBJ);
						echo "<h3>".$cate->cate_name."</h3>";
					?>

				<?php
					
					$displayItem = 5;
					//tính tổng số trang cần hiện thị
					$sql = "SELECT news_id FROM tintuc WHERE cate_id = :cate_id ";
					$stmt= $conn->prepare($sql);
					$stmt->bindParam(":cate_id",$cate_id,PDO::PARAM_INT);
					$stmt->execute();
					$totalNew = $stmt->rowCount();
					$totalPage = ceil($totalNew/$displayItem);
					//kiem tra co ton tai bien page tren duong dang k
					if(isset($_GET['page']) && filter_var($_GET['page'],FILTER_VALIDATE_INT) && $_GET['page']>0)
					{
						//nếu $_GET[page] > tong page 
						if($_GET['page'] > $totalPage)
						{
							$start = ($totalPage-1) * $displayItem; 
						}else{
							$start = ($_GET['page']-1) * $displayItem; 
						}
					}else{
						$start = 0;
					}
					// truy van lay ra tin tuc
					$stmt = getNewsonCateid($cate_id,$start,$displayItem);
					
					$stmt->execute();
					
					if($stmt->rowCount() > 0)
					{
						$tintucs = $stmt->fetchALl(PDO::FETCH_OBJ);

						foreach($tintucs as $tin)
						{
						$tieude_khongdau = strtolower(unicode_convert($tin->news_title));
				?>	
					<div class="media row">
						<div class='img-media  col-12 col-md-3'>
							<a href="tin-tuc/<?php echo $tin->news_id;?>/<?php echo $tieude_khongdau;?>.html" ><img class="d-flex mr-3" src="upload/<?php echo $tin->hinhanh;?>" alt="Generic placeholder image">
							<div class='blackFrame'></div></a>
						</div>
					  	
					  	<div class="media-body col-12 col-md-9">
						   <h5 class="mt-0"><a href="tin-tuc/<?php echo $tin->news_id;?>/<?php echo $tieude_khongdau;?>.html"><?php echo $tin->news_title;?></a></h5>
						    <p class="extend"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><a href=""><?php echo $tin->user_name;?></a><span class="glyphicon glyphicon-time" aria-hidden="true"></span><?php echo formatTimetoDay($tin->post_on); ?></p>
						   	<?php 
						   	echo cutString($tin->mota,180);
						   	?>
						   	<a href="tin-tuc/<?php echo $tin->news_id;?>/<?php echo $tieude_khongdau;?>.html"><div class="button">Chi Tiết  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></div></a>
					  	</div>
					</div>

					<?php 
						} //end-foreach
					}else{
						echo "<p class='alert alert-danger'>Không có bài viết ở trong chuyên mục này</p>";
					}
						//phantrang 
						$pageShow = 5;
						phantrangcate($pageShow,$displayItem, $totalPage, $start);

				}else{
					echo "<p class='alert alert-danger'>chuyên mục không tồn tại</p>";
					}
				}

				?>
				</div>
			</div>
			<!--end-cate-item-->
	<?php include('templates/footer.php');
	?>
	
	