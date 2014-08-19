<?php 
	require_once('../../classes/database.php');
	$database = new Database();
	$request = json_decode(file_get_contents("php://input"));
	$data = $database->cleandata($request);

	$return = $database->get("
		SELECT id,email,fname,lname
		FROM users 
		WHERE email='".$data['email']."' 
		  AND password='".md5($data['password'])."'
	",false);

	if($return){
		session_start();
		$_SESSION['id'] = $return->id;

		echo json_encode($return);
	}
	else{
		http_response_code(400);
	}
?>