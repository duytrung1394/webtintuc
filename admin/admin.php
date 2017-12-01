<?php include("templates/header.php");
	date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
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
</div>