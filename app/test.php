<?php
	require_once('classes/check.php');
	require_once('classes/database.php');
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

	$pagebreak = '<br style="page-break-before: always">';

	header("Content-type: application/vnd.ms-word");
	header("Content-Disposition: attachment;Filename=document_name.doc");

	if($proposal->proposal_type_id == 1){
		$header = 'http://localhost/proposalbuilder/app/classes/tcpdf/images/briston_header.jpg';
		$footer = 'http://localhost/proposalbuilder/app/classes/tcpdf/images/briston_footer.jpg';
		$tab_stops = 'center 3.0in right 0.0in';
		$cover_page = '<img src="http://localhost/proposalbuilder/app/classes/tcpdf/images/briston_bg.jpg" />';
	}
	else{
		$header = 'http://localhost/proposalbuilder/app/classes/tcpdf/images/boss_header.jpg';
		$footer = 'http://localhost/proposalbuilder/app/classes/tcpdf/images/boss_footer.jpg';
		$tab_stops = 'center 3.0in right 7.5in';
		$cover_page = '<img src="http://localhost/proposalbuilder/app/classes/tcpdf/images/boss_bg.jpg" />';
	}

	$trading = "";
	if($proposal->proposal_type_id == "2"){
		$trading = '<tr><td colspan="3"><strong class="label">Trading Name</strong><br/>'.$proposal->trading_name.'</td></tr>';
	}
	$company_details = <<<EOF
<style>
	table{
		line-height:20px;
	}
</style>

<strong style="color:#1a69e0;font-size:16px;">Company Details</strong><br/><br/>
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


/* ECHO HTML */
	$document = <<<EOF
<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
xmlns="http://www.w3.org/TR/REC-html40">
	<head>
		<meta http-equiv=Content-Type content="text/html; charset=utf-8">
		<title></title>
		<style>
			v\:* {behavior:url(#default#VML);}
			o\:* {behavior:url(#default#VML);}
			w\:* {behavior:url(#default#VML);}
			.shape {behavior:url(#default#VML);}
		</style>
		
		<style>
		@page{
			mso-page-orientation: landscape;
			size:21cm 29.7cm;
			margin:1cm 1cm 1cm 1cm;
		}
		@page Section1 {
			mso-footer-margin:.5in;
			mso-header: h1;
			mso-footer: f1;
		}
		@page Section2 {
			mso-header-margin:.5in;
			mso-footer-margin:.5in;
			mso-header: h2;
			mso-footer: f2;
		}
		div.Section1 { page:Section1; }
		div.Section2 { page:Section2; }
		table#hrdftrtbl{
			margin:0in 0in 0in 900in;
			width:1px;
			height:1px;
			overflow:hidden;
		}
		p.MsoFooter, li.MsoFooter, div.MsoFooter{
			margin:0in;
			margin-bottom:.0001pt;
			mso-pagination:widow-orphan;
			tab-stops: {$tab_stops};
			font-size:12.0pt;
		}	
	</style>
	<xml>
		<w:WordDocument>
		<w:View>Print</w:View>
		<w:Zoom>100</w:Zoom>
		<w:DoNotOptimizeForBrowser/>
		</w:WordDocument>
	</xml>
	<style>
		html,body{
			font-family:arial;
		}
		#content ul li{
			font-family:arial;
		}
		#content{
			font-size:14px;
			line-height:20px;
		}
		#footer{
			font-size:12px;
			color:#555555;
		}
	</style>
</head>

<body>
	<div class="Section1">
		<div id="content" style="margin:-0.4in">
			{$cover_page}
			<br/><br/>
			<table style="width:100%;">
				<tr>
					<td style="color:#1a69e0;text-align:right;">
						<em>
						<span style="font-size:18px;font-weight:bold;">{$proposal->client_name}</span>
						<br/>
						<span style="font-size:14px">{$proposal->submission_date}</span>
						</em>
					</td>
				</tr>
			</table>
			<br style="page-break-before:always; clear:both; mso-break-type:section-break">
		</div>
	</div>

	<div class="Section2">
		<div id="content">
			{$company_details}
			<br style="page-break-before: always">
			{$proposal->company_overview}
			<br style="page-break-before: always">
			{$proposal->confirmation_of_requirements}
			<br style="page-break-before: always">
			{$proposal->scope_of_works}
			<br style="page-break-before: always">
			{$proposal->cont_estimate}
			<br style="page-break-before: always">
			{$proposal->conclusion}
		</div>
	</div>
	
	<!-- HEADER and FOOTER !-->
	<table id='hrdftrtbl' border='0' cellspacing='0' cellpadding='0'>
    	<tr>
    		<td>        
    			<div style='mso-element:header' id=h1>
    				<table>
						<tr>
							<td style="width:10px;">
							</td>
						</tr>
    				</table>
        		</div>
    			<div style='mso-element:header' id=h2>
    				<table>
						<tr>
							<td style="width:10px;">
								<img src="{$header}" />
							</td>
						</tr>
    				</table>
        		</div>
    	    </td>
    		<td id="footer">
				<div style='mso-element:footer' id=f1>
					<span style='position:relative;z-index:-1'> 
						<img src="{$footer}" />
						<!--
						<p class=MsoFooter>
							<span style=mso-tab-count:2'></span>
							Page <span style='mso-field-code: PAGE '></span> of
								 <span style='mso-field-code: NUMPAGES '></span>
						</p>
						!-->
					</span>
				</div>
				<div style='mso-element:footer' id=f2>
					<span style='position:relative;z-index:-1'> 
						<img src="{$footer}" />
						<!--
						<p class=MsoFooter>
							<span style=mso-tab-count:2'></span>
							Page <span style='mso-field-code: PAGE '></span> of
								 <span style='mso-field-code: NUMPAGES '></span>
						</p>
						!-->
					</span>
				</div>

				<div style='mso-element:header' id=fh1>
					<p class=MsoHeader><span lang=EN-US style='mso-ansi-language:EN-US'>&nbsp;<o:p></o:p></span></p>
				</div>
				<div style='mso-element:footer' id=ff1>
					<p class=MsoFooter><span lang=EN-US style='mso-ansi-language:EN-US'>&nbsp;<o:p></o:p></span></p>
				</div>
				<div style='mso-element:header' id=fh2>
					<p class=MsoHeader><span lang=EN-US style='mso-ansi-language:EN-US'>&nbsp;<o:p></o:p></span></p>
				</div>
				<div style='mso-element:footer' id=ff2>
					<p class=MsoFooter><span lang=EN-US style='mso-ansi-language:EN-US'>&nbsp;<o:p></o:p></span></p>
				</div>
			</td>
		</tr>
	</table>
	</body>
</html>
EOF;
echo $document;
?>

<!--[if gte vml 1aaaaaaa]>
<v:shapetype id="_x0000_t75"
    coordsize="21600,21600" o:spt="75" o:preferrelative="t" path="m@4@5l@4@11@9@11@9@5xe"
    filled="f" stroked="f">
    <v:stroke joinstyle="miter"/>
    <v:formulas>
        <v:f eqn="if lineDrawn pixelLineWidth 0"/>
        <v:f eqn="sum @0 1 0"/>
        <v:f eqn="sum 0 0 @1"/>
        <v:f eqn="prod @2 1 2"/>
        <v:f eqn="prod @3 21600 pixelWidth"/>
        <v:f eqn="prod @3 21600 pixelHeight"/>
        <v:f eqn="sum @0 0 1"/>
        <v:f eqn="prod @6 1 2"/>
        <v:f eqn="prod @7 21600 pixelWidth"/>
        <v:f eqn="sum @8 21600 0"/>
        <v:f eqn="prod @7 21600 pixelHeight"/>
        <v:f eqn="sum @10 21600 0"/>
    </v:formulas>
    <v:path o:extrusionok="f" gradientshapeok="t" o:connecttype="rect"/>
    <o:lock v:ext="edit" aspectratio="t"/>
</v:shapetype>
<v:shape id="_x0000_s1025" type="#_x0000_t75" alt="" style='position:absolute;
    margin-left:0;margin-top:2pt;width:537pt;height:57pt;z-index:251659264'>
    <v:imagedata src="http://localhost/proposalbuilder/app/classes/tcpdf/images/briston_header.jpg"/>
    <w:wrap type="square"/>
</v:shape>
<![endif]-->