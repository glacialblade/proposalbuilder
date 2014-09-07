<?php
	require_once('../../classes/tcpdf/tcpdf.php');
	require_once('../../classes/check.php');
	require_once('../../classes/database.php');
	$database = new Database();
	$data = $database->cleandata($_GET);

	$host = "http://localhost/proposalbuilder";
	
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

	if($proposal->proposal_type_id == 1){
		class MYPDF extends TCPDF {
		    public function Header() {
		        // Logo=
		        $image_file = '../../classes/tcpdf/images/briston_header.jpg';
		        $this->Image($image_file, 23, 10, 162, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		        // Set font
		        $this->SetFont('helvetica', 'B', 20);
		        // Title
		        //$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		    }
		    public function Footer() {
		        $image_file = '../../classes/tcpdf/images/briston_footer.jpg';
		    	$this->Image($image_file, 23, 268, 162, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		        // Position at 15 mm from bottom
		        $this->SetY(-15);
		        // Set font
		        $this->SetFont('helvetica', 'I', 10);
		        // Page number
		        $this->Cell(173, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		    }
		}
	}
	else if($proposal->proposal_type_id == 2){
		class MYPDF extends TCPDF {
		    public function Header() {
		        // Logo=
		        $image_file = '../../classes/tcpdf/images/boss_header.jpg';
		        $this->Image($image_file, 15, 10, 180, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		        // Set font
		        $this->SetFont('helvetica', 'B', 20);
		        // Title
		        //$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		    }
		    public function Footer() {
		        $image_file = '../../classes/tcpdf/images/boss_footer.jpg';
		    	$this->Image($image_file, 15, 284, 180, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		        // Position at 15 mm from bottom
		        $this->SetY(-15);
		        // Set font
		        $this->SetFont('helvetica', 'I', 10);
		        // Page number
		        $this->Cell(345, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		    }
		}
	}
	// create new PDF document
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor($proposal->client_name);
	$pdf->SetTitle($proposal->title);

	// set default header data
	//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	$pdf->setListIndentWidth(4);
	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		require_once(dirname(__FILE__).'/lang/eng.php');
		$pdf->setLanguageArray($l);
	}

	// ---------------------------------------------------------

	// set font
	$pdf->SetFont('helvetica', '', 10);
	$pdf->SetMargins(25, 10, 25);

/* ==================COVER PAGE================= */
	$pdf->SetPrintHeader(false);
	$pdf->SetPrintFooter(false); 
	$pdf->AddPage();
	if($proposal->proposal_type_id == 1){
	$html = <<<EOF
	<img src="{$host}/app/classes/tcpdf/images/briston_bg.jpg" />
EOF;
	}
	else if($proposal->proposal_type_id == 2){
	$html = <<<EOF
	<img src="{$host}/app/classes/tcpdf/images/boss_bg.jpg" />
EOF;
	}

	$pdf->SetMargins(0, 0, 10);
	$pdf->writeHTML($html, true, false, true, false, '');

	$html = <<<EOF
<br/><br/><br/><br/>
<div style="text-align:right;color:#1a69e0;">
	<em>
	<span style="font-size:18px;font-weight:bold;">{$proposal->client_name}</span>
	<br/>
	<span style="font-size:14px">{$proposal->submission_date}</span>
	</em>
</div>
EOF;
	$pdf->writeHTML($html, true, false, true, false, '');
/* ===============END COVER PAGE================= */

	$pdf->SetMargins(25, 40, 25);
	/* START OF SLIDES */
	$pdf->SetPrintHeader(true);
	$pdf->AddPage();
	$pdf->SetPrintFooter(true); 

	// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
	// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

	// COMPANY DETAILS
	$trading = "";
	$rowspan="6";
	$lineheight = "350";
	if($proposal->proposal_type_id == "2"){
		$lineheight = "380";
		$rowspan="7";
		$trading = '<tr><td colspan="3"><strong class="label">Trading Name</strong><br/>'.$proposal->trading_name.'</td></tr>';
	}
	$html = <<<EOF
<style>
	table{
		line-height:20px;
	}
</style>

<strong style="color:#1a69e0;">Company Details</strong><br/><br/>
<table border="1" style="border-color:white;" cellpadding="8">
	<tr>
		<td rowspan="{$rowspan}" style="line-height:{$lineheight}px;text-align:center;background-color:#99ccff;">
			Company Details
		</td>
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
	$pdf->addPage();

	check_file($pdf,$proposal->company_overview,"Company Overview","","<br/><br/>");
	check_file($pdf,$proposal->confirmation_of_requirements,"Confirmation of Requirements","<br/><br/>","");
	check_file($pdf,$proposal->scope_of_works,"Scope of Works","<br/><br/>","");
	check_file($pdf,$proposal->cost_estimate,"Cost Estimate","<br/><br/>","");
	check_file($pdf,$proposal->conclusion,"Conclusion","<br/><br/>","");

	// ---------------------------------------------------------

	//Close and output PDF document
	//$pdf->Output($proposal->title.'.pdf', 'I');
	$pdf->Output($proposal->title.'.pdf', 'FD');

	//============================================================+
	// END OF FILE
	//============================================================+
	function check_file($pdf,$html,$title,$br,$br_two){
		$page_head = '<style>p,ul{ line-height:22.5px; }</style>';
		$page_head .= '<b style="color:#1a69e0">'.$title.'</b>';

		if(strip_tags($html) != "" && strip_tags($html) != "&nbsp;" && preg_match('/[a-zA-z0-9]+/',strip_tags($html))){
			$pdf->writeHTML($br.$page_head.$br_two.$html, true, false, true, false, '');	
		}
	}
?>