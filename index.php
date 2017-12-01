<?php 
	include('templates/header.php');
	
?>
		<!--end-navs-->
		<div id='content' class='row'>
			<div class="col-xs-6 col-sm-12 col-md-10 col-lg-10 cate-item">
				<?php 
				//truy van co so du lieu
				$sql = "SELECT * FROM category";
				$stmt = $conn->prepare($sql);
				$stmt->execute();
				$cates = $stmt->fetchAll(PDO::FETCH_OBJ);
				if($stmt->rowCount()==0)
				{
					echo "<p>Chưa có chuyên mục nào</p>";
				}
				else{
				foreach ($cates as $cate) {
					$cate_id = $cate->cate_id;
					// lấy ra tin có cate_id = $cate_id
					$stmt = get3New($cate_id);
					$stmt->execute();
					$tintucs = $stmt->fetchAll(PDO::FETCH_OBJ);
					?>
					<div class='row cate-content'>
					<h4><?php echo $cate->cate_name;?></h4>
				<?php
					if($stmt->rowCount()==0)
					{
						echo "<p class='alert alert-warning' id='alert-news' role='alert'> Chưa có bài viết nào </p>";
					}else
					{
						foreach ($tintucs as $tin) {
						$tieude_khongdau = strtolower(unicode_convert($tin->news_title));
				?>
			
					<div class="media row">
						<div class='img-media'>
							<a href="tin-tuc/<?php echo $tin->news_id;?>/<?php echo $tieude_khongdau;?>.html"><img class="d-flex mr-3" src="upload/<?php echo $tin->hinhanh;?>" alt="Generic placeholder image"></a>
							<a href="tin-tuc/<?php echo $tin->news_id;?>/<?php echo $tieude_khongdau;?>.html"><div class='blackFrame'></div></a>
						</div>
					  	
					  	<div class="media-body">
						    <h5 class="mt-0"><a href="tin-tuc/<?php echo $tin->news_id;?>/<?php echo $tieude_khongdau;?>.html"><?php echo $tin->news_title;?></a></h5>
						    <p class="extend"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><a href=""><?php echo $tin->user_name;?></a><span class="glyphicon glyphicon-time" aria-hidden="true"></span><?php echo formatTimetoDay($tin->post_on); ?></p>
						   	<?php 
						   	echo cutString($tin->mota,180);
						   	?>
						   	<a href="tin-tuc/<?php echo $tin->news_id;?>/<?php echo $tieude_khongdau;?>.html"><div class="button">Chi Tiết  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></div></a>
					  	</div>
					</div>
				<?php 
					}
				}
				?>
				
					</div><!--cate-content-->
				<?php 
					}
				}
				?>
				</div>
<?php include('templates/footer.php');
?>
	