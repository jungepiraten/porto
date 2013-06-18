<?php

require_once("log.inc.php");

function getPorto($value, $usage = null) {
	if (!file_exists("files/marken" . $value)) {
		throw new Exception("E_VALUE_UNKNOWN");
	}

	$marken = glob("files/marken" . $value . "/*.pdf");

	$count = count($marken)-1;
	if ($count < 10) {
		mail("poststelle@junge-piraten.de", "Briefmarkenwarnung", "Ohai,\nwir haben nur noch {$count} {$value}er Briefmarken. Bitte nachbestellen (ohne Adresse aber auf A4-Briefpapier) und unter http://porto.intern.junge-piraten.de/upload.php?value={$value} hochladen,\n\ndanke <3");
	}

	if ($count < 0) {
		log_message($value, "empty");
		throw new Exception("E_EMPTY");
	}

	$i = array_rand($marken);
	$marke = $marken[$i];

	log_message($value, "send " . $marke . ($usage != null ? " (" . $usage . ")" : ""));
	return $marke;
}
