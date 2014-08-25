<?php 
	require_once('../../classes/database.php');
	require_once('../../classes/check.php');
	$database = new Database();
	$request = json_decode(file_get_contents("php://input"));
	$data = $database->cleandata($request);

	$return = $database->transaction("
		UPDATE users
		SET archived = 1
		WHERE id = {$data['user_id']}");

	if(!$return){
		http_response_code(400);
	}
?>