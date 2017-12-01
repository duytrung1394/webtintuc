<?php 
	include('templates/header.php');
?>
	<div id='content' class='row'>
		<div class="col-xs-6 col-sm-12 col-md-10 col-lg-10" id='detail-content'>

	<?php
	if(isset($_GET['nid']))
	{	
		$news_id = $_GET['nid'];
		$sql = "SELECT t.news_id,t.news_title,t.hinhanh,t.mota,t.content,t.post_on,u.user_name ";
		$sql .= " FROM tintuc t ";
		$sql .=	" INNER JOIN users u ";
		$sql .= " USING(user_id) ";
		$sql .= " WHERE t.news_id = :news_id ";

		$stmt = $conn->prepare($sql);
		$stmt->bindParam(":news_id",$news_id,PDO::PARAM_INT);
		$stmt->execute();
		if($stmt->rowCount()>0)
		{
			$tintucs = $stmt->fetchAll(PDO::FETCH_OBJ);
			foreach($tintucs as $tin)
			{
			?>
			<div id='main-content'>
				<h4><?php echo $tin->news_title;?></h4>
			 <p class="extend"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><a href=""><?php echo $tin->user_name;?></a><span class="glyphicon glyphicon-time" aria-hidden="true"></span><?php echo formatTimetoDay($tin->post_on);?></p>
			<h5 id='description'><?php echo $tin->news_title;?></h5>
			<p>
				<?php echo $tin->content;?>
			</p>
 
			</div>
			<!--main-content-->
			<div id='comment-box' style="margin-bottom: 100px;">
				<h4>Bình luận</h4>
				<div id="post-comment">
				  	<div class="media">
				  		<div class='media-header'>
				  			<img class="d-flex mr-3" src="library/images/images.png" alt="Generic placeholder image">
				  			<p><?php echo empty($_SESSION['user_name'])?"khách":$_SESSION['user_name'];
				  			?>
				  			</p>
				  		</div>
					  	<div class="media-body">
					    	<div class="form-group">
								<textarea class="form-control" id='txtcomment' name='txtcoment' cols="90" rows="4"></textarea>
							</div>
							<div class="form-group row" >
								<div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
									<p class='alert alert-danger error-comment' ></p>
									<?php if(empty($_SESSION['user_id'])) echo "<p class='alert alert-info'> Bạn cần <a  data-toggle='modal' data-target='#myLogin'  style='cursor:pointer' class='alert login-btn'> Đăng nhập</a> để gửi bình luận</p>";?>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
									<button type="submit" class="btn btn-primary btn-cancel-comment">Hủy</button>
									<button type="submit" class="btn btn-primary" id="submit-comment" data-newsid="<?php echo $tin->news_id;?>" data-userid="<?php echo $_SESSION['user_id'];?>" <?php echo empty($_SESSION['user_id'])?'disabled':"";?> >Bình luận</button>
								</div>
							</div>
						</div><!--end-media-->
					</div>
				</div><!--end-post-comment-->
				<h5>Danh sách bình luận</h5>
			<div id='list-comment'>
				<?php 
					//get list comment on news
					$itemDisplay = 10;
					//tinh tong so page can hien thi
					$sql = "SELECT com_id FROM comment WHERE news_id = $news_id";
					$stmt = $conn->prepare($sql);
					$stmt->execute();
					$totalItem = $stmt->rowCount();
					$totalPage = ceil($totalItem/$itemDisplay);

					if(isset($_GET['page']) && filter_var($_GET['page'],FILTER_VALIDATE_INT) && $_GET['page']>0){
						if($_GET['page']>$totalPage)
						{
							$start = ($totalPage-1)*$itemDisplay;
						}else{
							$start = ($_GET['page']-1)*$itemDisplay; 
						}
					}else{
						$start = 0;
					}

					$sql = "SELECT c.com_id,c.com_mess,c.com_date,u.user_name,u.user_id FROM comment c ";
					$sql .= "INNER JOIN users u USING(user_id) WHERE news_id = $news_id ";
					$sql .= "ORDER BY com_id DESC ";
					$sql .= "LIMIT $start,$itemDisplay";
					$stmt = $conn->prepare($sql);
					$stmt->execute();

					if($stmt->rowCount()>0)
					{
						$coms = $stmt->fetchAll(PDO::FETCH_OBJ);
						foreach($coms as $com)
						{
				?> 

			  	<div class="media comment-x comment<?php echo $com->com_id;?>">
			  		<div class='media-header'>
			  			<img class="d-flex mr-3" src="library/images/images.png" alt="Generic placeholder image">
			  			<p><?php echo $com->user_name;?></p>
			  		</div>
				  	<div class="media-body">
				  		 <p class="com-profile"  ><span class="glyphicon glyphicon-user" aria-hidden="true"></span><a href=""><?php echo $com->user_name;?></a><span class="glyphicon glyphicon-time" aria-hidden="true"></span><?php echo formatTimetoHours($com->com_date);?></p>
				    	<p>
				    		 <?php 
				    		 $mess = nl2br($com->com_mess);
				    		 echo $mess; 
				    		 ?>
				    	</p>
				    	<div class="form-group row" >
								<div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
								</div>
								<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
									<?php if(isset($_SESSION['user_id'])){
										if($_SESSION['user_id'] == $com->user_id || $_SESSION['level']==4)
										{
										?>
										<button type="submit" class="btn btn-primary btn-del-comment" data-comid='<?php echo $com->com_id;?>'>Xóa</button>
									<?php 	} }?>
								
									<button type="submit" class="btn btn-primary toggle-rep-comment" data-comid='<?php echo $com->com_id;?>'>Trả lời</button>
								</div>
						</div>
					<!---replyboox-->
					<?php require('templates/reply_box.php'); ?>
					<!---end-replyboox-->
				    </div>	
				</div><!--end-media-->
			
				<?php 

					}
				}
				?>
				</div>
				<?php 
					$pageShow = 5;
					phantrang($pageShow,$itemDisplay,$totalPage,$start);
				?>
			</div>
			<!--end-comment-->
			<?php 
			}	
		}
		else{
			echo "<p class='alert alert-danger'>Bài viết không tồn tại</p>";
		}
	}else{
		echo "<p class='alert alert-danger'>Bài viết không tồn tại</p>";
	}
	?>
	</div>
	
	<?php 
	include('templates/footer.php');
	?>