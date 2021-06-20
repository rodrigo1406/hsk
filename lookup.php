<?php
$zi = '';
if (isset($_GET['zi'])) {
	$zi = $_GET['zi'];
}
$fr = '';
if (isset($_GET['frase'])) {
	$fr = $_GET['frase'];
}
$pos = false;
if (isset($_GET['pos'])) {
	$pos = $_GET['pos'];
}
if ($pos === false) {
	$pos = mb_strpos($fr,$zi);
}
if ($pos !== false) { // gera os ngrams (tamanho 1 a 4)
	$arr = array();
	for ($i=-3; $i<0; $i++) {
		if ($pos+$i >= 0) {
			$arr[] = mb_substr($fr,$pos+$i,1-$i);
		}
	}
	$arr[] = $zi;
	for ($i=1; $i<4; $i++) {
		if ($pos+$i < mb_strlen($fr)) {
			$arr[] = mb_substr($fr,$pos,$i+1);
		}
	}
	if ($pos > 0 && $pos < mb_strlen($fr)-1) {
		$arr[] = mb_substr($fr,$pos-1,3);
	}
	if ($pos > 1 && $pos < mb_strlen($fr)-1) {
		$arr[] = mb_substr($fr,$pos-2,4);
	}
	if ($pos > 0 && $pos < mb_strlen($fr)-2) {
		$arr[] = mb_substr($fr,$pos-1,4);
	}
}
$f = file("HSK.tsv");
foreach ($f as $l) {
	$l = str_getcsv($l,"\t","");
	if (in_array($l[0],$arr) || in_array($l[1],$arr)) {
		echo "<p>";
		if ($l[0] == $l[1]) {
			echo "<span class='red'>$l[1]</span> <span class='gray'>($l[2])</span> $l[3]";
		} else {
			echo "<span class='red'>$l[1]</span>|<span class='blue'>$l[0]</span> <span class='gray'>($l[2])</span> $l[3]";
		}
		echo "</p>";
	}
}
?>
