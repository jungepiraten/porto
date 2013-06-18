<h1>Vorhandene Markenvorräte</h1>
<table>
<tr>
 <th>Wert</th>
 <th>Vorhanden</th>
</tr>
<?php
$valueDirs = glob("files/marken*/");
foreach ($valueDirs as $valueDir) {
	if (preg_match('#^files/marken([0-9]+)/$#', $valueDir, $match)) {
		$values[] = $match[1];
	}
}

sort($values);
foreach ($values as $value) {
	$valueDir = "files/marken" . $value . "/";
	$count = count(glob($valueDir . "*.pdf"));
?>
<tr>
 <th align="right"><?php print($value) ?> ct</th>
 <td align="right" style="font-weight:bold;color:<?php print($count < 10 ? ($count < 5 ? "#ee0000" : "#ccaa22") : "#000000") ?>;"><?php print($count) ?></td>
 <td><a href="upload.php?value=<?php print($value) ?>">Hochladen</a> <a href="frank.php?value=<?php print($value) ?>">Frankieren</a></td>
</tr>
<?php } ?>
</table>
