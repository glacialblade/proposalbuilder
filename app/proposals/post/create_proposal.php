<?php 
	require_once('../../classes/check.php');
	require_once('../../classes/database.php');
	$database = new Database();
	$request = json_decode(file_get_contents("php://input"));
	$data = $database->cleandata($request);

	$result = $database->transaction("
		INSERT INTO proposals(title,client_name,submission_date,date_modified,user_id,proposal_type_id)
		            VALUES   ('{$data['title']}',
		            	      '{$data['client_name']}',
		            	      '{$data['submission_date']}',
		            	       sysdate(),
		            	       {$_SESSION['id']},
		            	       {$data['proposal_type_id']});
	");
	if($result){
		$result = $database->transaction("
			INSERT INTO company_details(legal_name,trading_name,head_office,postal_address,telephone_no,fac_no,web,primary_contact,acn,abn,poc_email,mobile_no,proposal_id)
	        VALUES(
				'BRISTON TRAINING AND DEVELOPMENT PTY LTD',
				'BRISTON OUTSOURCING SERVICE SOLUTIONS (BOSS)',
				'Building 1, Level 3, 2-14 Murrajong Road, Springwood, QLD, 4127',
				'Southgate, Box 8, 3350 Pacific Highway, Springwood, 4127',
				'1300 919 692',
				'(07) 3503 9191',
				'http://www.briston.com.au',
				'Andrew Bridge',
				'35 151 116 746',
				'35 151 116 746',
				'andrew.bridge@briston.com.au',
				'0404 036 591',
				(SELECT max(id) FROM proposals WHERE user_id = {$_SESSION['id']})
	        )
		");
	}
	
	if(!$result){
		http_response_code(400);
	}

	echo json_encode($result);
?>