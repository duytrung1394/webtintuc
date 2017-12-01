<?php 
	session_start();
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	require_once("../library/connect.php");

	$user_id = $_SESSION['user_id'];
	$user_name = $_SESSION['user_name'];
	$news_id = $_POST['news_id'];
	$com_mess  = $_POST['com'];

	$sql = "INSERT INTO comment(com_mess,com_date,user_id,news_id) VALUES(:com_mess,:com_date,:user_id,:news_id)";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(":com_mess",$com_mess,PDO::PARAM_STR);
	$stmt->bindParam(":com_date",$com_date);
	$stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
	$stmt->bindParam(":news_id",$news_id,PDO::PARAM_INT);
	$com_date = date("Y-m-d H:i:s");
	$stmt->execute();

	$sql = "SELECT MAX(com_id) as com_max FROM comment";
	$stmt2 = $conn->prepare($sql);
	$stmt2->execute();
	$coms = $stmt2->fetch(PDO::FETCH_OBJ);
	$com_id = $coms->com_max;  
?>
	<div class="media comment-x">
  		<div class='media-header'>
  			<img class="d-flex mr-3" src="library/images/images.png" alt="Generic placeholder image">
  			<p><?php echo $user_name;?></p>
  		</div>
	  	<div class="media-body">
	  		 <p class="com-profile" style="font-size: 0.97em"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><a href=""><?php echo $user_name;?></a><span class="glyphicon glyphicon-time" aria-hidden="true"></span>Vừa xong</p>
	    	<p>
	    		<?php 
	    		$com_mess = nl2br($com_mess);
				echo $com_mess; 
				?>
	    	</p>
	    	
	    </div>	
	</div><!--end-media-->
	