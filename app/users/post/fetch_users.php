<?php 
	require_once('../../classes/database.php');
	require_once('../../classes/check.php');
	$database = new Database();

	$return = $database->get("
		SELECT id,email,fname,lname,user_type
		FROM users
		WHERE archived = 0
	",true);

	if($return){
		echo json_encode($return);
	}
	else{
		http_response_code(400);
	}
?>