<?php

require_once("get.inc.php");

header("Content-Type: text/html; charset=utf8");

$value = intval($_REQUEST["value"]);
$usage = isset($_REQUEST["usage"]) ? $_REQUEST["usage"] : null;

if (isset($_FILES["brief"])) {
	require_once("fpdf/fpdf.php");
	require_once("fpdf/fpdi.php");

	try {
		$fpdf = new FPDI("P", "mm", "A4");
		$fpdf->SetMargins(0,0,0);
		$pagecount = $fpdf->setSourceFile($_FILES["brief"]["tmp_name"]);
		$tpl = $fpdf->importPage(1);
		$fpdf->AddPage();
		$fpdf->useTemplate($tpl, 0, 0, 0, 0, true);

		$marke = getPorto($value, $usage);
		$fpdf->setSourceFile($marke);
		$tpl = $fpdf->importPage(1);
		$fpdf->useTemplate($tpl, 0, 0, 0, 0, true);

		$fpdf->setSourceFile($_FILES["brief"]["tmp_name"]);
		for ($page = 2; $page <= $pagecount; $page++) {
			$tpl = $fpdf->importPage($page);
			$fpdf->AddPage();
			$fpdf->useTemplate($tpl, 0, 0, 0, 0, true);
		}

		header("Content-Type: application/pdf");
		$fpdf->Output("", "I");
		@unlink($marke);
		exit;
	} catch (Exception $e) {
		die($e->getMessage());
	}
}

?>
<form action="" method="post" enctype="multipart/form-data">
 Wert: <input type="text" name="value" value="<?php print($value) ?>" size="3" />ct<br/>
 Grund: <input type="text" name="usage" size="20" /><br />
 <input type="file" name="brief" />
 <input type="submit" value="Frankieren" />
</form>
