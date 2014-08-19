<?php 
	require_once('../../classes/check.php');
	require_once('../../classes/database.php');
	$database = new Database();
	$request = $_GET;
	$data = $database->cleandata($request);
	
	$query = "SELECT id,title,client_name,date_modified,status
	          FROM proposals
	          WHERE user_id = {$_SESSION['id']}
	            AND proposal_type_id = {$data['proposal_type_id']}
	          ORDER BY id DESC";
	
	$result = $database->get($query,true);

	if(!$result){
		http_response_code(400);
	}

	echo json_encode($result);
?>