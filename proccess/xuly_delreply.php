<?php 
	include_once('../library/connect.php');

	$rep_id = $_POST['rep_id'];

	$sql = "DELETE FROM reply WHERE rep_id = $rep_id";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	echo "true";
?>

