<?php 
	require_once('../../classes/check.php');
	require_once('../../classes/database.php');
	$database = new Database();
	$request = $_GET;
	$data = $database->cleandata($request);
	

	if($data['filter'] == "New"){
		$filter = "AND sysdate() < submission_date";
	}
	else if($data['filter'] == "Old"){
		$filter = "AND sysdate() > submission_date";
	}
	
	$query = "SELECT id,title,client_name,submission_date,status
	          FROM proposals
	          WHERE proposal_type_id = {$data['proposal_type_id']}
	                {$filter}
	          ORDER BY id DESC";

	$result = $database->get($query,true);

	if(!$result){
		http_response_code(400);
	}

	echo json_encode($result);
?>