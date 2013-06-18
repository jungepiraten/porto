<?php

function log_message($value, $string) {
	file_put_contents("files/marken" . $value . ".log", date("Y-m-d H:i:s") . " " . $_SERVER["REMOTE_ADDR"] . " " . count(glob("files/marken" . $value . "/*.pdf")) . " " . $string . "\n", FILE_APPEND);
}
