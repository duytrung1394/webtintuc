		<div class="col-xs-6 col-sm-12 col-md-2 col-lg-2">
			
		</div>
	</div>
		<!--content-->
		<div id="footer">
			Copyright@duytrung 08/2017
		</div>


	</div>
	<?php $url = $_SERVER['REQUEST_URI'];?>
	<a  href="<?php echo $url.'#tp';?>" id="btn-go-top" class="btn btn-info"><span class="glyphicon glyphicon-chevron-up"></span></a>
		<!--container-->
	<script type="text/javascript" src='public/js/jquery.js'></script>
	<script type="text/javascript" src='public/js/bootstrap.min.js'></script>
	<script type="text/javascript" src='public/js/form-login.js'></script>
	<script type="text/javascript" src='public/js/comment.js'></script>
	<script type="text/javascript" src='public/js/reply.js'></script>
	<script type="text/javascript">
		$(document).ready(function (){
			// $('#list-comment').delegate('.toggle-rep-comment','click',function (){
			// 	var id = $(this).attr('data-comid');
			// 	$('.rep-post'+id).slideToggle();
			// });
			$('.toggle-rep-comment').click(function (){
				var id = $(this).attr('data-comid');
				$('.reply-mess'+id).val("");
				$('.rep-post'+id).slideToggle();
			});
			if($( document ).height()>1000)
			{
				$(window).bind('scroll', function () {
				// if($(window).height() >800)
				// {
					 if ($(window).scrollTop() > 150) {
			        $('#navs').addClass('fixed');
			        $('#nav-menu').removeClass('container');
			        $('#nav-menu').addClass('container-fluid');
				    } else {
				        $('#navs').removeClass('fixed');
				        $('#nav-menu').removeClass('container-fluid');
				        $('#nav-menu').addClass('container');
				    }
				// }
			   
			    //button go top
			    if($(window).scrollTop() > 600){
			    	$("#btn-go-top").fadeIn();
			    }else{
			    	$("#btn-go-top").fadeOut();
			    }

			});
			//form-dang ki- dang nhap , khi nhap vao link dang nhập
			}
		});
		
	</script>
</body>
</html>