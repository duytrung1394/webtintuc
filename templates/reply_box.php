
<div class="reply-box">				<!-- gán id com vào reply-post để có thể toggle -->
				    	<div class="media reply-post rep-post<?php echo $com->com_id;?>" style="display: none;">
							<div class="media-body">
							    <div class="form-group">
							    <textarea class="form-control reply-mess<?php echo $com->com_id;?>"  cols="55" rows="4"></textarea>
									</div>
									<div class="form-group row" >
										<div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
											<p class="alert alert-danger error-reply<?php echo $com->com_id;?>" ></p>

											<?php if(empty($_SESSION['user_id'])) echo "<p class='alert alert-info'> Bạn cần <a  data-toggle='modal' data-target='#myLogin'  style='cursor:pointer' class='alert login-btn'> Đăng nhập</a> để gửi trả lời</p>";?>
										
										</div>
										<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
											<button type="submit" class="btn btn-primary btn-cancel-reply" data-comid="<?php echo $com->com_id;?>">Hủy</button>

											<button type="submit" class="btn btn-primary btn-submit-reply" data-comid=<?php echo "'".$com->com_id."'"; echo empty($_SESSION['user_id'])?'disabled':'';?>  >Gửi</button>
											
										</div>
								</div>
							</div>
							  	<div class='media-header'>
					  			<img class="d-flex mr-3" src="library/images/images.png" alt="Generic placeholder image">
					  			<p><?php echo empty($_SESSION['user_name'])?"khách":$_SESSION['user_name'];?>
				  				
				  			</p>
					  		</div>
						</div>

						<div class='list-reply<?php echo $com->com_id;?>'>
						<?php 
							
							$com_id = $com->com_id;
							//get list reply on comment
							$stmt = getReplyonComid($com_id);
							$stmt->execute();
							if($stmt->rowCount()>0)
							{
								$replys = $stmt->fetchAll(PDO::FETCH_OBJ);
								foreach($replys as $reply)
								{		
						?>	
							<!-- gán id của reply để có thể ẩn reply sau khi xóa -->
							<div class="media reply-x reply<?php echo $reply->rep_id;?>">
								<div class="media-body">
								     <p class="com-profile" ><span class="glyphicon glyphicon-user" aria-hidden="true"></span><a href=""><?php echo $reply->user_name;?></a><span class="glyphicon glyphicon-time" aria-hidden="true"></span><?php echo formatTimetoHours($reply->rep_date);?></p>
							    	<p>
							    		<?php echo $reply->rep_mess;?>
							    	</p>
							    	<div class="form-group row" >
										<div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
										</div>
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
												<?php if(isset($_SESSION['user_id'])){
													if($_SESSION['user_id'] == $reply->user_id || $_SESSION['level']==4)
													{
													?>
													<button type="submit" class="btn btn-primary btn-del-reply" data-repid='<?php echo $reply->rep_id;?>'>Xóa</button>
												<?php 	} }?>
											</div>
									</div>	
								</div>
								  	<div class='media-header'>
						  			<img class="d-flex mr-3" src="library/images/images.png" alt="Generic placeholder image">
						  			<p><?php echo $reply->user_name;?></p>
						  		</div>
							</div>
						<?php } 
							} ?>
						</div> <!-- end-list_reply -->
					</div> <!--end-reply-box-->