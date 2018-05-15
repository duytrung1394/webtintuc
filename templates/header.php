<?php 
	session_start();
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	include_once('library/connect.php');
	include_once('library/phantrang1.php');
	include('library/function.php');
?>
<!DOCTYPE html>
<html>
<head lang="vi">
	<base href="<?php echo HTTP_HOST;?>" />
	<title><?php 
		$tieude = tieude();
		echo $tieude;
	?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="public/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="public/css/mystyle.css">
	<link href="public/css/glyphicons.css" rel="stylesheet" />

</head>
<body>
	<div class="container" id='tp'>
		<nav class="navbar navbar-toggleable-md navbar-light bg-faded" id='nav-top'>
			  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			  </button>
			  
			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			    <ul class="navbar-nav mr-auto">
			      	<li class="nav-item">
			       		<a class="navbar-brand" href="#">
				    		<img src="library/images/icon-face.png" width="20" height="20" alt="">
				  		</a>
			      	</li>
			      	<li class="nav-item">
			      	 	<a class="navbar-brand" href="#">
				    		<img src="library/images/icon-instar.png" width="20" height="20" alt="">
				  		</a>
			      	</li>
			      	<li class="nav-item">
			       		<a class="navbar-brand" href="#">
				    		<img src="library/images/icon-tweet.png" width="20" height="20" alt="">
				  		</a>
			      	</li>
			      	<li class="nav-item">
			       		<a class="navbar-brand" href="#">
				    		<img src="library/images/icon-youtub.png" width="20" height="20" alt="">
				  		</a>
			      	</li>
			    </ul>
			    <div class="my-2 my-lg-0" id='nav-top-right'>
			    	<?php 
			    		if(isset($_SESSION['user_name']))
			    		{
			    	?>		
			    			<a class="mr-sm-2"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $_SESSION['user_name'];?></a>
			    			<a class="mr-sm-2" href="logout.php">Đăng xuất</a>
			    			<?php if($_SESSION['level']==4)
			    			{?>
			    				<a class="mr-sm-2" href="admin/admin.php">Quản lí</a>
			    			<?php
			    			}?>
			    	<?php 
			    		}
			    	else{
					?>
						<a class="mr-sm-2 login-btn" data-toggle="modal" data-target="#myLogin" >Đăng nhập</a>
			      		<a class="mr-sm-2 register-btn" data-toggle="modal" data-target="#myLogin" >Đăng kí</a>
					<?php 
			    	}
			    	?>
			      
			    </div>
			  </div>
			</nav>
		
		
			<!-- Modal -->
		<?php require('modal.php');?>
		<!--end-modal-->
		
		<div class="row" id='header'>
			<div class="col-xs-6 col-sm-12 col-md-4 col-lg-4">
				<div id="main">
		            <div id="msg"><a href="index.php">XIN<br>CHÀO</a></div>
		            <div id="box">
		                <div id="side1">WEB</div>
						<div id="side2">&#9787;</div>
		                <div id="side3">TỨC</div>
		                <div id="side4">TIN</div>
            		</div>
       			</div>
			</div>
		</div>
	</div> <!--contaier-->

	<?php require("navs.php");?>

	<div class="container">