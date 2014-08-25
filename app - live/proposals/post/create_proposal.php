<?php 
	require_once('../../classes/check.php');
	require_once('../../classes/database.php');
	$database = new Database();
	$request = json_decode(file_get_contents("php://input"));
	$data = $database->cleandata($request);

	if($data['proposal_type_id'] == 2){
		$company_overview = <<<EOF
<p style="text-align:justify;">Briston Outsourcing Service Solutions (BOSS), is an Australian owned and operated company providing managed capability outsourcing services to clients across Australia. Our company specializes in identify existing or emerging capabilities within organizations and establishing low cost, fully integrated outsourced services to reduce your cost baseline and increase your scope of operations. We have the knowledge, skills and resources to provide your company with access to an inexpensive, highly proficient, global workforce that will allow you to compete effectively in any market.</p><br/><table><tr><td><p style="text-align:justify;"><br/>Our primary aim is to reduce the risk that clients face when stepping into the world of outsourcing by ensuring that we provide detailed analysis, and full capability management services. This is done by following a simple process:</p></td><td>&nbsp;&nbsp;<img src="http://reportbuilder.bristonoutsourcing.com/app/classes/tcpdf/images/company_overview_boss.jpg" /></td></tr></table><ol><li><p style="text-align:justify;">Conduct a detailed analysis of your requirements to identify what capabilities are available for you to outsource, what systems and processes you have in place, and what modifications and support training you need to get moving.</p></li><li><p style="text-align:justify;">Establish the recruiting requirements for your new team members in the Philippines, then recruit, induct and train your new team.</p></li><li><p style="text-align:justify;">Manage minor modifications within your organisation to allow you to effectively integrate your new capability. This may include introduction of new cloud based IT and communications systems, development of new SOPs, and training of your existing team to work cohesively with your new team members.</p></li><li><p style="text-align:justify;">Provide ongoing performance management of your new team on the ground in our Manila office through detailed training, development, and management by our Australian management staff. We are one of the few BPOs to provide qualified Australian training and management staff in our Manila office working hand in hand with your Philippines staff to guarantee you get the capability that you need.</p></li></ol>
EOF;
	}
	else{
		$company_overview = <<<EOF
<table><tr><td><img src="http://reportbuilder.bristonoutsourcing.com/app/classes/tcpdf/images/company_overview_briston.jpg" /></td><td valign="top"><p>Briston Training and Development Pty Ltd (Briston) is a Registered Training Organisation (RTO) based in Brisbane, Qld. The company operates in three primary service areas, namely training design, training delivery, and provision of training support services. While Briston has the capacity to deliver nationally recognised qualifications from its own scope, the company also partners with several other RTOs including Evocca College, Outsource Services, and Shoreline Learning and Development to deliver a wide range of qualifications to clients across all industry groups.</p><p>Briston commenced delivery of training in January 2010 for its first client within the corrective services industry. Initial programs were custom designed for delivery to inmates within a maximum security remand center in Brisbane focusing on community based behaviors, and on provision of peer support roles within high risk units. The program was quickly expanded to incorporate delivery of “in Unit” Health and Fitness programs and LLN tutor training. Since this time, Briston has designed and delivered more than 15 different education programs for correctional centers using delivery methods and systems, which integrate seamlessly with security and operational requirements within each facility.</p><p>In April 11, Briston restructured to form a dedicated training design cell responsible for the conduct of specialized training analysis and design, developing customized courses for delivery in response to client’s needs.</p></td></tr></table>
EOF;
	}

	if($data['proposal_type_id'] == 2){
		$conclusion = <<<EOF
<p>Jarrod I apologize for the sheer length of this overall quite simple estimate! However I wanted to give you as much information as I could. Whether you decide to go with us or not, as I mentioned via Skype, give me a call anytime and I am happy to act as a sounding board to talk you through some of the considerations, risks or options that you may encounter.</p><p>If you do decide to go with us then please contact me anytime and we can get started on refining exactly what you want in each role in terms of experience and skill, and my guys will start developing our testing procedures for the recruitment phase.</p><p>For the VA in particular, we are still in start up phase with that capability. We have plenty to select from, but I guess my point is that I am happy to play around with the rates I quoted above and run much lower margins if you can help me test and establish the procedures for clients as I take this to market, and once we have it running smoothly, help me spread the good word on BOSS! Anything you can do to help us get our name out there would be appreciated and I am happy to run referral programs etc.</p><p>Overall though, as I said above, we may not be the cheapest, but I guarantee we are the safest and most efficient. We would love the chance to work with you so please keep us in mind and hopefully I hear from you soon.</p><p>Kind regards,</p><b>Andrew Bridge</b><br/>Director<br/>Briston Outsourcing Service Solutions<br/><br/>M: 0404 036 591 | E: andrew.bridge@briston.com.au<br/>
EOF;
	}
	else{
		$conclusion = <<<EOF
<p>This cost allows for an initial consultation regarding the desired output of the overall project, three consolidated client feedback rounds, and the time and costs associated with producing audio scripts and voice.</p>
<p>The three feedback rounds consist of one following submission of an initial sample module to confirm style, structure and understanding of intent, a second following submission of all first draft modules and a third prior to final submission of the courses. As Briston guarantees the standard of our work and endeavours to set the standard amongst eLearning providers, we will ensure that all submitted materials are developed to meet the expectations agreed during project acceptance and in the three provided review rounds.</p>
<b style="color:#1a69e0">Conclusion – Moving forward</b>
<p>Once you have made the decision to engage us for this project, we recommend a scope confirmation meeting to ensure that all parameters have been identified correctly, to discuss and review base materials, and to confirm design timeframes, processes and deliverables.<p>
<p>Should you have questions on this project or once you are ready to proceed, please feel contact me on the details below at any time. I would be happy to meet with you at your convenience should you wish to discuss the project or our capability in person.<p>

<b>Andrew Bridge</b><br/>
Director<br/>
<span style="color:#1a69e0;"><em>Briston Training & Development</em></span>
<span style="color:#1a69e0"><em>Briston Outsourcing Service Solutions</em></span><br/>
<span style="color:#1a69e0"><em>M: 0404 036 591 | E: andrew.bridge@briston.com.au</em></span>
EOF;
	}

	$result = $database->transaction("
		INSERT INTO proposals(title,client_name,submission_date,date_modified,user_id,proposal_type_id,company_overview,conclusion)
		            VALUES   ('{$data['title']}',
		            	      '{$data['client_name']}',
		            	      '{$data['submission_date']}',
		            	       sysdate(),
		            	       {$_SESSION['id']},
		            	       {$data['proposal_type_id']},
		            	      '{$company_overview}',
		            	      '{$conclusion}');
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