<?php
	require_once '../../classes/phpdoc/classes/CreateDocx.inc';
	require_once('../../classes/check.php');
	require_once('../../classes/database5.5.php');
	$database = new Database();
	$data = $database->cleandata($_GET);

	$proposal = $database->get("
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
        WHERE p.user_id = {$_SESSION['id']}
          AND p.id = {$data['proposal_id']}
	",false);

	$docx = new CreateDocx();
	if($proposal->proposal_type_id == 2){
		$docx->importHeadersAndFooters('../../classes/phpdoc/templates/BOSS Proposal.docx');
		$open = '<table><tr><td style="padding-top:30px;">';
		$close = '</td></tr></table>';
	}
	else{
		$docx->importHeadersAndFooters('../../classes/phpdoc/templates/Briston Proposal.docx');
		$open = '<table><tr><td style="padding:35px;padding-bottom:45px;">';
		$close = '</td></tr></table>';
	}

	
	/* ==================COVER PAGE================= */
	// NOT YET DONE
	/* ===============END COVER PAGE================= */

	/* START OF SLIDES */
	// COMPANY DETAILS
	$trading = "";
	if($proposal->proposal_type_id == "2"){
		$trading = '<tr><td colspan="3"><strong class="label">Trading Name</strong><br/>'.$proposal->trading_name.'</td></tr>';
	}
	$html = <<<EOF
<strong style="color:#1a69e0;font-size:16px;">Company Details</strong><br/><br/>
<table style="line-height:20px;border-collapse:collapse;" cellpadding="8">
	<tr>
		<td colspan="3" style="border:1px solid black;">
			<strong class="label">Legal Name of Company</strong><br/>{$proposal->legal_name}
		</td>
	</tr>
	<tr>
		<td colspan="3" style="border:1px solid black;">
			<strong class="label">Head Office</strong><br/>
			{$proposal->head_office}
		</td>
	</tr>
	{$trading}
	<tr>
		<td colspan="3" style="border:1px solid black;">
			<strong class="label">Postal Address</strong><br/>
			{$proposal->postal_address}
		</td>
	</tr>
	<tr>
		<td style="border:1px solid black;">
			<strong class="label">Telephone No.</strong><br/>
			{$proposal->telephone_no}
		</td>
		<td style="border:1px solid black;">
			<strong class="label">Facsimile No.</strong><br/>
			{$proposal->fac_no}
		</td>
		<td style="border:1px solid black;">
			<strong class="label">Web</strong><br/>
			{$proposal->web}
		</td>
	</tr>
	<tr>
		<td style="border:1px solid black;">
			<strong class="label">Primary Contact</strong><br/>
			{$proposal->primary_contact}
		</td>
		<td style="border:1px solid black;">
			<strong class="label">A.C.N</strong><br/>
			{$proposal->acn}
		</td>
		<td style="border:1px solid black;">
			<strong class="label">A.B.N</strong><br/>
			{$proposal->abn}
		</td>
	</tr>
	<tr>
		<td colspan="2" style="border:1px solid black;">
			<strong class="label">P.O.C. Email Address</strong><br/>
			{$proposal->poc_email}
		</td>
		<td style="border:1px solid black;">
			<strong class="label">Mobile No.</strong><br/>
			{$proposal->mobile_no}
		</td>
	</tr>
</table>
EOF;
	$docx->embedHTML($open.$html.$close);

	// COMPANY OVERVIEW
	$docx->addBreak(array('type'=>'page'));
	$page_head = '<strong style="color:#1a69e0;font-size:16px;">Company Overview</strong>';
	$docx->embedHTML($open.$page_head.$proposal->company_overview.$close);

	// CONFIRMATION OF REQUIREMENTS
	$docx->addBreak(array('type'=>'page'));
	$page_head = '<strong style="color:#1a69e0;font-size:16px;">Confirmation of Requirements</strong>';
	$docx->embedHTML($open.$page_head.$proposal->confirmation_of_requirements.$close);

	// SCOPE OF WORKS
	$docx->addBreak(array('type'=>'page'));
	$page_head = '<strong style="color:#1a69e0;font-size:16px;">Scope of Works</strong>';
	$docx->embedHTML($open.$page_head.$proposal->scope_of_works.$close);

	// COST ESTIMATE
	$docx->addBreak(array('type'=>'page'));
	$html = '<strong style="color:#1a69e0;font-size:16px;">Cost Estimate</strong>';
	$docx->embedHTML($open.$html.$proposal->cost_estimate.$close);

	// CONCLUSION
	$docx->addBreak(array('type'=>'page'));
	$html = '<strong style="color:#1a69e0;font-size:16px;">Conclusion</strong>';
	$docx->embedHTML($open.$html.$proposal->conclusion.$close);

	$docx->createDocx('proposal');
?>