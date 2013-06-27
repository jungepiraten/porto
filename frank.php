<?php

require_once("frank.inc.php");

header("Content-Type: text/html; charset=utf8");

$value = intval($_REQUEST["value"]);
$usage = isset($_REQUEST["usage"]) ? $_REQUEST["usage"] : null;

function handleDir($root, $dir, $value, $usage, $output) {
	foreach (glob($root . "/" . $dir . "*") as $name) {
		$name = substr($name, strlen($root) + 1);
		if (is_dir($root . "/" . $name)) {
			handleDir($root, $name . "/", $value, $usage, $output);
		} else {
			$fpdf = frankPDF($root . "/" . $name, $value, $usage);
			$output->addFromString($name, $fpdf->Output("", "S"));
			unlink($root . "/" . $name);
		}
	}
	rmdir($root . "/" . $dir);
}

if (isset($_FILES["brief"])) {
	try {
		switch ($_FILES["brief"]["type"]) {
		case "application/zip":
			$temp = "/tmp/frank-" . $value . "." . rand(100,999);

			$input = new ZipArchive;
			$input->open($_FILES["brief"]["tmp_name"]);
			mkdir($temp . "/");
			$input->extractTo($temp . "/");
			$input->close();

			$output = new ZipArchive;
			$output->open($temp . ".zip", ZipArchive::CREATE);
			handleDir($temp, "", $value, $usage, $output);
			$output->close();

			header("Content-Type: application/zip");
			header("Content-Disposition: attachment; filename=" . $_FILES["brief"]["name"]);
			header("Content-Size: " . filesize($temp . ".zip"));
			readfile($temp . ".zip");
			@unlink($temp . ".zip");
			exit;
		case "application/pdf":
			$fpdf = frankPDF($_FILES["brief"]["tmp_name"], $value, $usage);
			header("Content-Type: application/pdf");
			$fpdf->Output("", "I");
			exit;
		}
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
