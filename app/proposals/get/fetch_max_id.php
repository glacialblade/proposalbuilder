<?php 
	require_once('../../classes/check.php');
	require_once('../../classes/database.php');
	$database = new Database();
	$request = $_GET;
	$data = $database->cleandata($request);
	
	$query = "SELECT max(id) as proposal_id
	          FROM proposals
	          WHERE user_id = {$_SESSION['id']}
	            AND proposal_type_id = {$data['proposal_type_id']}";
	
	$result = $database->get($query,false);

	if(!$result){
		http_response_code(400);
	}

	echo json_encode($result);
?>