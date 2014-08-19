<?php 
	require_once('../../classes/check.php');
	require_once('../../classes/database.php');
	$database = new Database();
	$request = json_decode(file_get_contents("php://input"));
	$data = $database->cleandata($request);

	$result = $database->transaction("
		UPDATE proposals
		   SET title = '{$data['title']}',
		       client_name = '{$data['client_name']}',
		       submission_date = '{$data['submission_date']}',
		       company_overview = '{$data['company_overview']}',
		       confirmation_of_requirements = '{$data['confirmation_of_requirements']}',
		       scope_of_works = '{$data['scope_of_works']}',
		       cost_estimate = '{$data['cost_estimate']}',
		       conclusion = '{$data['conclusion']}',
		       date_modified = sysdate()
		 WHERE id = {$data['id']};
	");
	
	if($result){
		$result = $database->transaction("
			UPDATE company_details
			   SET legal_name = '{$data['legal_name']}',
			       trading_name = '{$data['trading_name']}',
			       head_office = '{$data['head_office']}',
			       postal_address = '{$data['postal_address']}',
			       telephone_no = '{$data['telephone_no']}',
			       fac_no = '{$data['fac_no']}',
			       web = '{$data['web']}',
			       primary_contact = '{$data['primary_contact']}',
			       acn = '{$data['acn']}',
			       abn = '{$data['abn']}',
			       poc_email = '{$data['poc_email']}',
			       mobile_no = '{$data['mobile_no']}'
			 WHERE id = {$data['cid']};
		");
	}
	if(!$result){
		http_response_code(400);
	}

	echo json_encode($result);
?>