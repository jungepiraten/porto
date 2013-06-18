<?php

require_once("log.inc.php");

header("Content-Type: text/html; charset=utf8");

$value = intval($_REQUEST["value"]);

if (isset($_FILES["porto"])) {
	require_once("fpdf/fpdf.php");
	require_once("fpdf/fpdi.php");

	if (!file_exists("files/marken" . $value)) {
		mkdir("files/marken" . $value);
	}

	$fpdf = new FPDI("P", "mm", "A4");
	$fpdf->SetMargins(0,0,0);
	$pagecount = $fpdf->setSourceFile($_FILES["porto"]["tmp_name"]);
	$tpl = $fpdf->importPage(1);

	$i = 0;
	do {
		do {
			$filename = rand(10000,99999) . ".pdf";
		} while (file_exists("files/marken" . $value . "/" . $filename));

		$fpdf = new FPDI("P", "mm", "A4");
		$fpdf->AddPage();
		$pagecount = $fpdf->setSourceFile($_FILES["porto"]["tmp_name"]);
		$tpl = $fpdf->importPage(++$i);
		$fpdf->useTemplate($tpl, 0, 0, 0, 0, true);
		$fpdf->Output("files/marken" . $value . "/" . $filename, "F");

		log_message($value, "add " . $filename);
	} while ($pagecount - $i > 0);

	print("<p><strong>Habe " . $pagecount . " Marken hinzugefügt</strong></p>");
}

?>
<p><strong>Wichtig!</strong> Bitte lade _nur_ Marken mit dem angegeben Wert hoch und benutze eine A4-Seite pro Marke (Ausgabeformat "DIN A4 Normalpapier (Einlegeblatt)", zugänglich nach angabe von leeren Adressen).</p>
<form action="" method="post" enctype="multipart/form-data">
 Wert: <input type="text" name="value" value="<?php print($value) ?>" size="3" />ct<br/>
 <input type="file" name="porto" />
 <input type="submit" value="Hochladen" />
</form>
