<?php

require_once("get.inc.php");

$value = intval($_REQUEST["value"]);

try {
	$marke = getPorto($value, (isset($_REQUEST["usage"]) ? $_REQUEST["usage"] : null));
	header("Content-Type: application/pdf");
	readfile($marke);
	@unlink($marke);		
} catch (Exception $e) {
	die($e->getMessage();
}
if (!file_exists("files/marken" . $value)) {
	die("E_VALUE_UNKNOWN");
}
