<?php 
	require_once('../../classes/database.php');
	require_once('../../classes/check.php');
	$database = new Database();
	$request = json_decode(file_get_contents("php://input"));
	$data = $database->cleandata($request);

	$return = $database->transaction("
		INSERT INTO users(fname,lname,email,password,user_type)
		VALUES ('{$data['fname']}','{$data['lname']}','{$data['email']}',md5('{$data['password']}'),{$data['user_type']})
	");

	if(!$return){
		http_response_code(400);
	}
?>