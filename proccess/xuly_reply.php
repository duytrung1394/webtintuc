<?php
	session_start();
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	include_once('../library/connect.php'); 

	$com_id    = $_POST['com_id'];
	$user_id   = $_SESSION['user_id'];
	$user_name = $_SESSION['user_name'];
	$rep_mess  = $_POST['rep_mess'];

	$sql = "INSERT INTO reply(rep_mess,rep_date,user_id,com_id) VALUES(:rep_mess,:rep_date,:user_id,:com_id)";
	$stmt= $conn->prepare($sql);
	$stmt->bindParam(":rep_mess",$rep_mess,PDO::PARAM_STR);
	$stmt->bindParam(":rep_date",$rep_date);
	$stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
	$stmt->bindParam(":com_id",$com_id,PDO::PARAM_INT);
	$rep_date = date('Y-m-d H:i:s');
	$stmt->execute();
?>
<div class="media reply-x">
	<div class="media-body">
	    <p class="com-profile" ><span class="glyphicon glyphicon-user" aria-hidden="true"></span><a href="javascript:void(0)">
	    	<?php echo $user_name;?></a><span class="glyphicon glyphicon-time" aria-hidden="true"></span>Vừa xong</p>
    	<p>
    		<?php $rep_mess = nl2br($rep_mess);
    		echo $rep_mess;?>
    	</p>	
	</div>
	  	<div class='media-header'>
			<img class="d-flex mr-3" src="library/images/images.png" alt="Generic placeholder image">
			<p><?php echo $user_name;?></p>
		</div>
</div>