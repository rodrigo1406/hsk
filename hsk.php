<?php
$debug = isset($_GET['debug']);
$h = '1';
if (isset($_GET['hsk'])) {
	$h = $_GET['hsk'];
	if (!ctype_digit(strval($h)) || $h < 1 || $h > 7) { // não é inteiro entre 1 e 7
		$h = '1';
	}
	if ($h == '7') {
		$h = '7-9';
	}
}
$f = file("HSK $h.tsv");
$pos = 0;
if (isset($_GET['pos'])) {
	$pos = $_GET['pos'];
	if (!ctype_digit(strval($pos)) || $pos < 1 || $pos > sizeof($f)) { // não é inteiro entre 1 e sizeof($f)
		$pos = 0;
	} else
	if ($pos > sizeof($f)-4) {
		$pos = sizeof($f)-4;
	}
}
$n = 5;
if ($debug) {
	echo "<table>
<tr><th>繁体</th><th>简体</th><th>Pīnyīn</th><th>Translation</th></tr>\n";
	foreach ($f as $l) {
		$l = str_getcsv($l,"\t","");
		echo "<tr>";
		foreach ($l as $c) {
			echo "<td>$c</td>";
		}
		echo "</tr>\n";
	}
	echo "</table>\n";
} else {
	if (!$pos) {
		$el = array_rand($f,$n);
	} else {
		$el = array($pos-1,$pos,$pos+1,$pos+2,$pos+3);
	}
	echo "<div class='cartas'>\n";
	$tr = array();
	foreach ($el as $e) {
		$l = str_getcsv($f[$e],"\t","");
		$tr[] = $l[3];
		echo "<div id='c$e' class='carta' title='$l[2]' data-trad='$l[3]' onclick='card(this)'>\n";
		if ($l[1] == $l[0]) {
			echo "<div class='red'>$l[1]</div>\n";
		} else {
			echo "<div class='red'>$l[1]</div><div class='blue'>$l[0]</div>\n";
		}
		echo "</div>\n";
	}
	echo "</div>\n";
	$t = array_rand($tr);
	$t = $tr[$t];
	echo "<p>$t</p>\n";
}
?>
