<?php
	include_once('../library/connect.php');

	$com_id = $_POST['com_id'];

	$sql = "DELETE FROM reply WHERE com_id = $com_id";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	$sql2 = "DELETE FROM comment WHERE com_id = $com_id ";
	$stmt = $conn->prepare($sql2);
	$stmt->execute();

	echo "true";
?>