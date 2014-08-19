<?php
	require_once('../../classes/tcpdf/tcpdf.php');
	require_once('../../classes/check.php');
	require_once('../../classes/database.php');
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

	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Kevin Cotongco');
	$pdf->SetTitle('Test Proposal');

	// set default header data
	//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		require_once(dirname(__FILE__).'/lang/eng.php');
		$pdf->setLanguageArray($l);
	}

	// ---------------------------------------------------------

	// set font
	$pdf->SetFont('helvetica', '', 10);

	// add a page
	$pdf->AddPage();

	// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
	// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

	// COMPANY DETAILS
	$trading = "";
	if($proposal->proposal_type_id == "2"){
		$trading = '<tr><td colspan="3"><strong class="label">Trading Name</strong><br/>'.$proposal->trading_name.'</td></tr>';
	}
	$html = <<<EOF
<style>
	table{
		line-height:20px;
	}
	.label{
		font-size:14px;
	}
</style>

<strong style="color:#005892;font-size:18px;">Company Details</strong><br/><br/>
<table border="1" style="border-color:white;" cellpadding="8">
	<tr>
		<td colspan="3">
			<strong class="label">Legal Name of Company</strong><br/>
			{$proposal->legal_name}
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<strong class="label">Head Office</strong><br/>
			{$proposal->head_office}
		</td>
	</tr>
	{$trading}
	<tr>
		<td colspan="3">
			<strong class="label">Postal Address</strong><br/>
			{$proposal->postal_address}
		</td>
	</tr>
	<tr>
		<td>
			<strong class="label">Telephone No.</strong><br/>
			{$proposal->telephone_no}
		</td>
		<td>
			<strong class="label">Facsimile No.</strong><br/>
			{$proposal->fac_no}
		</td>
		<td>
			<strong class="label">Web</strong><br/>
			{$proposal->web}
		</td>
	</tr>
	<tr>
		<td>
			<strong class="label">Primary Contact</strong><br/>
			{$proposal->primary_contact}
		</td>
		<td>
			<strong class="label">A.C.N</strong><br/>
			{$proposal->acn}
		</td>
		<td>
			<strong class="label">A.B.N</strong><br/>
			{$proposal->abn}
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<strong class="label">P.O.C. Email Address</strong><br/>
			{$proposal->poc_email}
		</td>
		<td>
			<strong class="label">Mobile No.</strong><br/>
			{$proposal->mobile_no}
		</td>
	</tr>
</table>
EOF;
	$pdf->writeHTML($html, true, false, true, false, '');

	// COMPANY OVERVIEW
	$pdf->addPage();
	$page_head = '<strong style="color:#005892;font-size:18px;">Company Overview</strong><br/><br/>';
	$pdf->writeHTML($page_head.$proposal->company_overview, true, false, true, false, '');

	// CONFIRMATION OF REQUIREMENTS
	$pdf->addPage();
	$page_head = '<strong style="color:#005892;font-size:18px;">Confirmation of Requirements</strong><br/><br/>';
	$pdf->writeHTML($page_head.$proposal->confirmation_of_requirements, true, false, true, false, '');

	// SCOPE OF WORKS
	$pdf->addPage();
	$page_head = '<strong style="color:#005892;font-size:18px;">Scope of Works</strong><br/><br/>';
	$pdf->writeHTML($page_head.$proposal->scope_of_works, true, false, true, false, '');

	// COST ESTIMATE
	$pdf->addPage();
	$html = '<strong style="color:#005892;font-size:18px;">Cost Estimate</strong>';
	$pdf->writeHTML($html.$proposal->cost_estimate, true, false, true, false, '');

	// COST ESTIMATE
	$pdf->addPage();
	$html = '<strong style="color:#005892;font-size:18px;">Conclusion</strong>';
	$pdf->writeHTML($html.$proposal->conclusion, true, false, true, false, '');

	// ---------------------------------------------------------

	//Close and output PDF document
	//$pdf->Output($proposal->title.'.pdf', 'I');
	$pdf->Output($proposal->title.'.pdf', 'FD');

	//============================================================+
	// END OF FILE
	//============================================================+

?>