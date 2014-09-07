<?php 
	require_once('../../classes/check.php');
	require_once('../../classes/database.php');
	$database = new Database();
	$request = json_decode(file_get_contents("php://input"));
	$data = $database->cleandata($request);

	if($data['proposal_type_id'] == 2){
		$company_overview = <<<EOF
<p style="text-align:justify;">Briston Outsourcing Service Solutions (BOSS), is an Australian owned and operated company providing managed capability outsourcing services to clients across Australia. Our company specializes in identify existing or emerging capabilities within organizations and establishing low cost, fully integrated outsourced services to reduce your cost baseline and increase your scope of operations. We have the knowledge, skills and resources to provide your company with access to an inexpensive, highly proficient, global workforce that will allow you to compete effectively in any market.</p><br/><table><tr><td><p style="text-align:justify;"><br/>Our primary aim is to reduce the risk that clients face when stepping into the world of outsourcing by ensuring that we provide detailed analysis, and full capability management services. This is done by following a simple process:</p></td><td>&nbsp;&nbsp;<img src="http://reportbuilder.bristonoutsourcing.com/app/classes/tcpdf/images/company_overview_boss.jpg" /></td></tr></table><ol><li><p style="text-align:justify;">Conduct a detailed analysis of your requirements to identify what capabilities are available for you to outsource, what systems and processes you have in place, and what modifications and support training you need to get moving.</p></li><li><p style="text-align:justify;">Establish the recruiting requirements for your new team members in the Philippines, then recruit, induct and train your new team.</p></li><li><p style="text-align:justify;">Manage minor modifications within your organisation to allow you to effectively integrate your new capability. This may include introduction of new cloud based IT and communications systems, development of new SOPs, and training of your existing team to work cohesively with your new team members.</p></li><li><p style="text-align:justify;">Provide ongoing performance management of your new team on the ground in our Manila office through detailed training, development, and management by our Australian management staff. We are one of the few BPOs to provide qualified Australian training and management staff in our Manila office working hand in hand with your Philippines staff to guarantee you get the capability that you need.</p></li></ol>
<b style="color:#1a69e0">So why use us?</b>
<p style="text-align:justify;">We can offer a number of advantages over other providers in this field:</p>
<ul><li>We are Australian owned and operated so you can have one of our staff meet you in your office at any time to work through any issues or requirements you may have.</li><li>Our Manila office is managed by a highly qualified team of Australian staff with experience in training, management, project management and solutions engineering.</li><li>	We are also a Registered Training Organization (RTO) with experience in organizational analysis, development of competency based training programs, and in people and performance management. We guarantee that your new capability will meet your requirements and that your organization will be ready to use them effectively in a fully integrated operations model.</li></ul>
<p style="text-align:justify;">We may not always be the cheapest outsourcing option available to you, but we will ALWAYS be the most effective and reliable!</p>
<b style="color:#1a69e0">SMT Waste Brokers – Service Options</b>
<p style="text-align:justify;">Based on our discussion 28 May 14, you identified the following points:</p>
<ul>
	<li>That you are currently using a number of freelancers to support your organization in areas such as web design, SEO and bookkeeping.</li>
	<li>You currently use cloud-based systems to support these areas and are actively using Skype as a communication system. </li>
	<li>That you currently need to increase your capability through outsourcing in the following broad areas:
		<ul>
			<li><b style="color:#008000">Administration (Virtual Assistant).</b> Primary tasks being email management, schedule management, database administration, and miscellaneous administrative tasks.</li>
			<li><b style="color:#008000">Marketing.</b> Requirement for outbound sales calls based on prepared scripts, lead generation and appointment scheduling. Likely requirement for email marketing and potential development of marketing resource materials.</li>
			<li><b style="color:#008000">Bookkeeping.</b> Management of company financial records in Xero, preparation, distribution and follow up of invoices.</li>
		</ul>
	</li>
</ul>
<b style="color:#1a69e0">Recommendations and Cost Estimate</b>
<p style="text-align:justify;">In our cost calculations, we estimate based on either a full time basis using an annual salary, or casual basis where services are invoiced against either hourly, or daily rates. Annual costs are invariably lower as they allow us to provide you with a dedicated asset without the requirement for coordinating workloads and scheduling multiple clients against one asset. We do however realize that this is not feasible for all clients, particularly with emerging capabilities, and therefore we can support through hourly/daily rates for staff which work on a project/task basis across multiple clients. Clients are welcome to switch from this option to a full time option as their capability develops without financial impact.</p>
<p style="text-align:justify;">Our fees include all IT costs (computer with MS Office, Skype, and VOIP) and all associated wages and benefits for staff. Specific software licenses you may require can be provided but will be invoiced at cost. Of note, s<br>
Against the requirements you have outlined for us listed above, we recommend the following:</p>
<ul>
	<li><b style="color:#008000">Administration (Virtual Assistant).</b> Based on our discussion I believe you would strongly benefit from a full time VA that you can train and develop to fit your requirements. VA’s are typically less expensive than other specialist roles such as IT or marketing, and if recruited carefully and progressively trained and developed, can provide significant capability enhancement. All our VAs will have a minimum of tertiary level education and will be proficient in both written and verbal English, with IT skills across the Microsoft Office Suite. Specialist requirements can be recruited should you have a particular need, such as prior employment with Australian firms, or particular IT skill sets.
		<ul>
			<li><b style="color:#008000">Full Time Cost Estimate:</b> $22, 500 - $33,800 pending experience and English proficiency. Lower end will be proficient and experienced, higher bracket will have significant experience, very high English skills and greater flexibility of skills. We will panel 3-5 candidates for you to interview, then will negotiate on your behalf regarding final salary and conditions.</li>
			<li><b style="color:#008000">Casual Cost Estimate:</b> Depending on your requirements for experience/language we can provide support ranging from $12 - $17.50 per hour, or $90  - $130 per day.</li>
		</ul>
	</li>
	<li>Marketing. During our discussion you indicated that at present you are likely to require support 2-3 days per week, or a spread of hours equivalent to that duration. Accordingly I have reflected those estimates below, however as with the VA, should you decide to grow to a full time capability down the track it will certainly reduce your rates. The capability available varies from candidates with “call centre” standard English and 3-5 yr of experience, with marketing qualifications through to senior marketing staff with 10-15 yr of experience and Australian standard English. Pending your requirements I have reflected that range below. I also recommend that we incorporate some product specific marketing tests during the recruitment phase to ensure you get the right fit.
		<ul>
			<li><b style="color:#008000">Casual Cost Estimate:</b> From $13 - $19.50 per hour, or $100  - $150 per day.</li>
			<li><b style="color:#008000">Full Time Cost Estimate:</b> From $26, 200 - $37,400 per year.</li>
		</ul>
	</li>
	<li><b style="color:#008000">Bookkeeping.</b> While we have the ability to recruit a local bookkeeper in the Philippines for you, with the estimated price likely to reflect the marketing costs above pending your experience requirements, we recommend engaging an organization for your needs rather than an individual. We currently use D&V solutions to handle our bookkeeping via Xero with their rates being $15 per hr for the range of services you have indicated, or $17 per hour for management accounting such as tax minimization etc. We have had few issues with the company who employ more than 30 staff, and we are able to directly assist in your relationship with them through our links to their firm and our presence on the ground in Manila. You would be allocated an individual bookkeeper available during business hours via skype, email or phone, and they would also be managed via a team leader with considerable experience. If this option does not suit, then I am happy to source a specific person for you directly.</li>
</ul>
EOF;
	}
	else{
		$company_overview = <<<EOF
<table><tr><td><img src="http://reportbuilder.bristonoutsourcing.com/app/classes/tcpdf/images/company_overview_briston.jpg" /></td><td valign="top"><p>Briston Training and Development Pty Ltd (Briston) is a Registered Training Organisation (RTO) based in Brisbane, Qld. The company operates in three primary service areas, namely training design, training delivery, and provision of training support services. While Briston has the capacity to deliver nationally recognised qualifications from its own scope, the company also partners with several other RTOs including Evocca College, Outsource Services, and Shoreline Learning and Development to deliver a wide range of qualifications to clients across all industry groups.</p><p>Briston commenced delivery of training in January 2010 for its first client within the corrective services industry. Initial programs were custom designed for delivery to inmates within a maximum security remand center in Brisbane focusing on community based behaviors, and on provision of peer support roles within high risk units. The program was quickly expanded to incorporate delivery of “in Unit” Health and Fitness programs and LLN tutor training. Since this time, Briston has designed and delivered more than 15 different education programs for correctional centers using delivery methods and systems, which integrate seamlessly with security and operational requirements within each facility.</p><p>In April 11, Briston restructured to form a dedicated training design cell responsible for the conduct of specialized training analysis and design, developing customized courses for delivery in response to client’s needs.</p></td></tr></table>
<br/>
<table>
	<tr>
		<td valign="top">
			<p>
				The departments largest project was won in Jun 11, and involved the analysis, design and delivery of competency based training courses for Serco staff responsible for management and operation of the new South Queensland Correctional Centre at Gatton, Qld. During a nine-month project, more than fifteen designers worked to analyze and design training programs across systems such as security and surveillance, fire services, electrical services, kitchen operations and gardening and maintenance. In total, more than 75 training modules were designed, delivered and assessed as part of a highly successful project.
			</p>
			<p>
				Briston’s design team has now worked with clients across a variety of industries including construction, education, health services, security, community services and automotive. Our past clients include:
			</p>
			<ul>
				<li>Baulderstone;</li>
				<li>Super Retail Group;</li>
				<li>Queensland Rail;</li>
				<li>Chubb;</li>
				<li>The Salvation Army;</li>
				<li>SmashCare Australia;</li>
				<li>GEO Australia; and</li>
				<li>Serco.</li>
			</ul>
		</td>
		<td><img src="http://reportbuilder.bristonoutsourcing.com/app/classes/tcpdf/images/company_overview_briston_2.jpg" /></td>
	</tr>
</table>
<b style="color:#1a69e0">Company Status</b>
<p>
	As a provider of choice, Briston is a small business and also holds third part certification as an RTO:
</p>
<ul>
	<li><b>Third party quality certification</b>: Briston Training and Development is a Registered Training Organisation (RTO) listed on the national training register under provider number 32127.</li>
</ul>
EOF;
	}

	if($data['proposal_type_id'] == 2){
// 		$conclusion = <<<EOF
// <p>Jarrod I apologize for the sheer length of this overall quite simple estimate! However I wanted to give you as much information as I could. Whether you decide to go with us or not, as I mentioned via Skype, give me a call anytime and I am happy to act as a sounding board to talk you through some of the considerations, risks or options that you may encounter.</p><p>If you do decide to go with us then please contact me anytime and we can get started on refining exactly what you want in each role in terms of experience and skill, and my guys will start developing our testing procedures for the recruitment phase.</p><p>For the VA in particular, we are still in start up phase with that capability. We have plenty to select from, but I guess my point is that I am happy to play around with the rates I quoted above and run much lower margins if you can help me test and establish the procedures for clients as I take this to market, and once we have it running smoothly, help me spread the good word on BOSS! Anything you can do to help us get our name out there would be appreciated and I am happy to run referral programs etc.</p><p>Overall though, as I said above, we may not be the cheapest, but I guarantee we are the safest and most efficient. We would love the chance to work with you so please keep us in mind and hopefully I hear from you soon.</p><p>Kind regards,</p><b>Andrew Bridge</b><br/>Director<br/>Briston Outsourcing Service Solutions<br/><br/>M: 0404 036 591 | E: andrew.bridge@briston.com.au<br/>
// EOF;
	$conclusion = <<<EOF
<b style="color:#1a69e0">Conclusion – Moving forward</b><p>Once you have made the decision to engage us for this project, we recommend a scope confirmation meeting to ensure that all parameters have been identified correctly, to discuss and review base materials, and to confirm design timeframes, processes and deliverables.</p><p>Should you have questions on this project or once you are ready to proceed, please feel contact me on the details below at any time. I would be happy to meet with you at your convenience should you wish to discuss the project or our capability in person.</p>
EOF;
	}
	else{
		$conclusion = <<<EOF
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