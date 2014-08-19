<?php 
	require_once('../../classes/check.php');
	require_once('../../classes/database.php');
	$database = new Database();
	$request = json_decode(file_get_contents("php://input"));
	$data = $database->cleandata($request);

	$result = $database->transaction("
		DELETE FROM images
		WHERE id = {$data['id']}
	");
	
	if(!$result){
		http_response_code(400);
	}
	else{
		unlink("../../../".$data['image']);
	}

	echo json_encode($result);
?>