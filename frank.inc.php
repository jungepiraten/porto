<?php

require_once("get.inc.php");
require_once("fpdf/fpdf.php");
require_once("fpdf/fpdi.php");

function frankPDF($filename, $value, $usage) {
	$fpdf = new FPDI("P", "mm", "A4");
	$fpdf->SetMargins(0,0,0);
	$pagecount = $fpdf->setSourceFile($filename);
	$tpl = $fpdf->importPage(1);
	$fpdf->AddPage();
	$fpdf->useTemplate($tpl, 0, 0, 0, 0, true);

	$marke = getPorto($value, $usage);
	$fpdf->setSourceFile($marke);
	$tpl = $fpdf->importPage(1);
	$fpdf->useTemplate($tpl, 0, 0, 0, 0, true);

	$fpdf->setSourceFile($filename);
	for ($page = 2; $page <= $pagecount; $page++) {
		$tpl = $fpdf->importPage($page);
		$fpdf->AddPage();
		$fpdf->useTemplate($tpl, 0, 0, 0, 0, true);
	}

	@unlink($marke);
	return $fpdf;
}

