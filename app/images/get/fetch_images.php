<?php 
	require_once('../../classes/check.php');
	require_once('../../classes/database.php');
	$database = new Database();
	$request = $_GET;
	$data = $database->cleandata($request);
	
	$query = "SELECT *
	          FROM images
	          WHERE proposal_id = {$data['proposal_id']}";
	
	$result = $database->get($query,true);

	if(!$result){
		http_response_code(400);
	}

	echo json_encode($result);
?>