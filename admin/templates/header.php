<?php session_start();
	if(empty($_SESSION['user_name'])|| $_SESSION['level'] !=4 ){
		header("location:../index.php");
	}
?>
<!DOCTYPE html>
<html>
<head lang="vi">
	<title>quản lí</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="templates/style.css">
	<script type="text/javascript" src="../library/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/popup.js"></script>
	<script type="text/javascript" src="js/category.js"></script>
	<script type="text/javascript" src="js/user.js"></script>
	<script type="text/javascript" src="js/article.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			//$("#popup-background").css('visibility', 'hidden');
			$("#content-x table tr:last").css("border-bottom","none");
		})
	</script>
</head>
<body>
	
