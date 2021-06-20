<?php
if (!isset($_GET['zh']))
	exit;
$zh = $_GET['zh'];
$zhs = explode('|',$zh);
$i = 3;
if (isset($_GET['hsk'])) {
	$i = $_GET['hsk'];
	if (!ctype_digit(strval($i)) || $i < 1 || $i > 7) { // não é inteiro entre 1 e 7
		$i = 3;
	}
}
$f = file("sentences $i.tsv");
$naofoi = true;
foreach ($f as $l) {
	$l = str_getcsv($l,"\t","");
	foreach ($zhs as $zh) {
		if (mb_strpos($l[0],$zh) !== false) {
			if ($naofoi) {
				echo "<h3>HSK $i</h3>\n";
				$naofoi = false;
			}
			$str = explode($zh,$l[0]);
			echo "<div class='frase'>
	<div class='red big' onclick='zi(event)'>";
			$j = 1;
			foreach ($str as $s) {
				for ($k=0; $k<mb_strlen($s); $k++) {
					echo "<span>".mb_substr($s,$k,1)."</span>";
				}
				if ($j < sizeof($str)) {
					echo "<span class='und'>$zh</span>";
				}
				$j++;
			}
			echo "		<svg class='svg1' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100' onclick='frase(this)'>
			<circle cx='50' cy='50' r='45'/>
			<line x1='20' y1='50' x2='80' y2='50'/>
			<line x1='50' y1='20' x2='50' y2='80'/>
		</svg>
		<svg class='svg2' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100' onclick='frase(this)' style='display:none'>
			<circle cx='50' cy='50' r='45'/>
			<line x1='20' y1='50' x2='80' y2='50'/>
		</svg>
	</div>
	<div class='hid'>
		<span class='gray'>$l[1]</span><br>
		<span>$l[2]</span>
	</div>
</div>\n";
		}
	}
}
?>
