<?php 
	require_once('../../classes/check.php');
	require_once('../../classes/database.php');
	$database = new Database();
	$request = $_GET;
	$data = $database->cleandata($request);
	
	if($data['filter'] == "New"){
		$filter = " AND sysdate() < DATE_ADD(date_created,INTERVAL 30 DAY)";
	}
	else if($data['filter'] == "Old"){
		$filter = " AND sysdate() > DATE_ADD(date_created,INTERVAL 30 DAY)";
	}
	
	$query = "SELECT count(*) as total_proposals
	          FROM proposals
	          WHERE proposal_type_id = {$data['proposal_type_id']}
	                {$filter}
	          ORDER BY id DESC";
	          
	$result = $database->get($query,false);

	if(!$result){
		http_response_code(400);
	}

	echo json_encode($result);
?>