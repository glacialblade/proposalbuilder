<?php 
	require_once('../../classes/check.php');
	require_once('../../classes/database.php');
	$database = new Database();
	$request = $_GET;
	$data = $database->cleandata($request);
	
	$result = $database->get("
		SELECT p.id,
               p.title,
               p.client_name,
               p.submission_date,
               p.company_overview,
               p.confirmation_of_requirements,
               p.scope_of_works,
               p.cost_estimate,
               p.conclusion,
               p.proposal_type_id,
               c.id as cid,
               c.legal_name,
               c.trading_name,
               c.head_office,
               c.postal_address,
               c.telephone_no,
               c.fac_no,
               c.web,
               c.primary_contact,
               c.acn,
               c.abn,
               c.poc_email,
               c.mobile_no
        FROM proposals p
        LEFT JOIN company_details c
        ON c.proposal_id = p.id
        WHERE p.id = {$data['proposal_id']}
	",false);

	if(!$result){
		http_response_code(400);
	}

	echo json_encode($result);
?>