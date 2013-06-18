<?php

require_once("log.inc.php");

$value = intval($_REQUEST["value"]);

if (!file_exists("files/marken" . $value)) {
	die("E_VALUE_UNKNOWN");
}

$marken = glob("files/marken" . $value . "/*.pdf");

$count = count($marken)-1;
if ($count < 10) {
	mail("poststelle@junge-piraten.de", "Briefmarkenwarnung", "Ohai,\nwir haben nur noch {$count} {$value}er Briefmarken. Bitte nachbestellen (ohne Adresse aber auf A4-Briefpapier) und unter http://porto.intern.junge-piraten.de/upload.php?value={$value} hochladen,\n\ndanke <3");
}

if ($count < 0) {
	log_message($value, "empty");
	die("E_EMPTY");
}

$i = array_rand($marken);
$marke = $marken[$i];

header("Content-Type: application/pdf");
readfile($marke);
@unlink($marke);
log_message($value, "send " . $marke . (isset($_REQUEST["usage"]) ? " (" . $_REQUEST["usage"] . ")" : ""));
