<!DOCTYPE html>
<!--
Lista de caracteres organizados pelo nível do HSK:
https://github.com/infinyte7/HSK-3.0-words-list/tree/main/HSK%20list%20with%20meaning
incrementado com
https://github.com/clem109/hsk-vocabulary
e
https://www.zerotohero.ca/en/zh/explore/new-levels

Sentenças de exemplo:
https://github.com/Destaq/chinese-sentence-miner
-->
<html lang='pt-br' onclick='bodyClick()'>
<head>
<meta http-equiv='Content-Type' content='text/html;charset=utf-8'>
<meta name='viewport' content='width=device-width,initial-scale=1,maximum-scale=3,minimum-scale=1'>
<meta property='og:title' content='HSK'>
<meta property='og:description' content='Teste de proficiência em chinês'>
<meta property='og:image' content='http://biodiversus.com.br/hsk/hsk.png'>
<meta property='og:url' content='http://biodiversus.com.br/hsk/'>
<link rel=icon href='hsk.png' type='image/png'>
<title>HSK</title>
<style>
body {
	background:#8a8;
	margin:0;
	position:relative;
}
nav {
	background:#484;
	display:flex;
	justify-content:space-evenly;
	flex-wrap:wrap;
}
.hsk {
	border:1px solid white;
	color:white;
	margin:0.5em;
	padding:0.5em;
	cursor:pointer;
}
div.sel {
	border-width:3px;
}
div.err {
	border-color:red;
}
main {
	background:#fd8;
}
p {
	margin:0.5em;
	text-align:center;
}
p.sel {
	font-weight:bold;
}
p.err {
	color:red;
}
.cartas {
	display:flex;
	justify-content:space-evenly;
	flex-wrap:wrap;
	font-size:2em;
}
.carta {
	display:flex;
	flex-direction:column;
	justify-content:center;
	align-items:center;
	border:1px solid black;
	margin:0.25em;
	padding:0.25em;
	cursor:pointer;
	line-height:1.2em;
}
.red {
	color:red;
}
.blue {
	color:blue;
}
.gray {
	color:#666;
}
.big {
	font-size:1.5em;
	display:flex;
	justify-content:center;
	flex-wrap:wrap;
}
.und {
	border-bottom:3px solid red;
}
.py {
	font-size:0.5em;
	line-height:1em;
}
aside {
	background:#cca;
	align-self:center;
	display:flex;
	align-items:center;
	cursor:default;
	padding:0.5em;
}
article {
	background:#ecc;
}
h3 {
	background:#fff8;
	text-align:center;
}
.frase {
	margin:1em;
	text-align:center;
}
.frase span {
	cursor:pointer;
}
.frase svg {
	cursor:pointer;
}
.hid {
	display:none;
}
svg {
	stroke-width:5;
	stroke-linejoin:round;
	stroke-linecap:round;
	stroke:#0008;
	fill:#fff0;
	width:1.25em;
	height:1.25em;
}
#box {
	background:white;
	min-width:300px;
	max-width:600px;
	position:absolute;
	display:none;
	border:1px solid black;
}
</style>
<script>
var divDest,main,article,box,boxX,boxY,HSK,hskFrases,hskMax,zhFrases,
	ziBox=null,rounds=0,tries=0,pontos=0,nivel;
function update() {
	if (HttpReq.readyState == 4) {
		if (HttpReq.status == 200) {
			if (divDest == article) {
				divDest.innerHTML = divDest.innerHTML+HttpReq.responseText;
				if (HttpReq.responseText != '') {
					main.style.paddingBottom = '0.25em';
					article.style.padding = '0.25em 0';
				}
				if (hskFrases <= hskMax) {
					conecta('frases.php?hsk='+hskFrases+'&zh='+zhFrases);
					hskFrases++;
				} else {
					if (article.getElementsByClassName('frase').length < 10 && hskMax < 7) {
						conecta('frases.php?hsk='+hskFrases+'&zh='+zhFrases);
						hskFrases++;
						hskMax++;
					} else
					if (divDest.innerHTML == '') {
						article.style.padding = '0';
					}
				}
			} else {
				divDest.innerHTML = HttpReq.responseText;
				if (divDest == box && HttpReq.responseText != '') {
					ziBox.style.border = '1px solid red';
					if (ziBox.classList.contains('und')) {
						ziBox.style.borderBottom = '3px solid red';
					}
					box.style.left = 0;
					box.style.display = 'block';
					if (box.offsetWidth > 300 && document.body.clientWidth-boxX < 300) {
						box.style.left = (document.body.clientWidth-box.offsetWidth)+'px';
					} else {
						box.style.left = boxX+'px';
					}
					box.style.top = (boxY-box.offsetHeight-10)+'px';
				}
			}
		} else {
			console.log('Erro: ' + HttpReq.statusText + ' ['+HttpReq.status+']');
		}
	}
}
function conecta(url) { // makes AJAX connection
	if (document.getElementById && window.XMLHttpRequest) { // If Browser supports DHTML, Firefox, etc.
		HttpReq = new XMLHttpRequest();
		HttpReq.onreadystatechange = update;
		HttpReq.open('GET',url,true);
		HttpReq.send(null);
	}
}
function hsk(w) {
	var i,hs = document.getElementsByClassName('hsk');
	for (i=0; i<hs.length; i++) {
		hs[i].classList.remove('sel');
	}
	w.classList.add('sel');
	HSK = w.id;
	nivel = parseInt(HSK,10);
	if (nivel == 7)
		nivel++;
	rounds += nivel;
	document.getElementsByTagName('aside')[0].innerHTML = pontos+'/'+rounds;
	tries = 0;
	article.innerHTML = '';
	article.style.padding = '0';
	main.style.paddingBottom = '0.25em';
	divDest = main;
<?php
if (isset($_GET['debug'])) {
	echo "	conecta('hsk.php?hsk='+HSK+'&debug');\n";
} else
if (isset($_GET['pos'])) {
	$pos = $_GET['pos'];
	echo "	conecta('hsk.php?hsk='+HSK+'&pos=$pos');\n";
} else {
	echo "	conecta('hsk.php?hsk='+HSK);\n";
}
?>
}
function frases(w) {
	zhFrases = '';
	var i,ds=w.getElementsByTagName('div');
	for (i=0; i<ds.length; i++) {
		zhFrases = zhFrases+ds[i].innerHTML;
		if (i < ds.length-1)
			zhFrases = zhFrases+'|';
	}
	divDest = article;
	article.innerHTML = '';
	hskMax = parseInt(HSK,10);
	hskMax += 2;
	if (hskMax > 7) hskMax = 7;
	conecta('frases.php?hsk=1&zh='+zhFrases);
	hskFrases = 2;
}
function frase(w) {
	w = w.parentNode.parentNode;
	var d = w.getElementsByClassName('hid')[0];
	var s1 = w.getElementsByClassName('svg1')[0];
	var s2 = w.getElementsByClassName('svg2')[0];
	if (d) {
		d.className = 'shown';
		s1.style.display = 'none';
		s2.style.display = 'block';
	} else {
		d = w.getElementsByClassName('shown')[0];
		if (d) {
			d.className = 'hid';
			s1.style.display = 'block';
			s2.style.display = 'none';
		}
	}
}
function card(w) {
	var i,ds = document.getElementsByClassName('carta');
	for (i=0; i<ds.length; i++) {
		ds[i].classList.remove('sel');
	}
	ds = document.getElementsByTagName('p');
	for (i=0; i<ds.length; i++) {
		ds[i].classList.remove('sel');
	}
	w.classList.add('sel');
	frases(w);
	var trad = document.getElementsByTagName('p')[0];
	var py;
	if (w.dataset['trad'] == trad.innerHTML) {
		if (tries >= 0) {
			pontos += nivel * (1 - tries/4);
			document.getElementsByTagName('aside')[0].innerHTML = pontos+'/'+rounds;
			tries = -1;
			py = document.createElement('span');
			py.className = 'py';
			py.innerHTML = w.title;
			w.appendChild(py);
		}
		trad.classList.add('sel');
	} else {
		var p = document.getElementById('p'+w.id.substr(1));
		if (!p) {
			if (tries >= 0)
				tries++;
			p = document.createElement('p');
			p.innerHTML = w.dataset['trad'];
			p.id = 'p'+w.id.substr(1);
			p.className = 'err sel';
			main.appendChild(p);
			w.classList.add('err');
			py = document.createElement('span');
			py.className = 'py';
			py.innerHTML = w.title;
			w.appendChild(py);
		} else {
			p.classList.add('sel');
		}
	}
}
function boxClick(e) {
	e.stopPropagation();
}
function bodyClick() {
	if (ziBox)
		ziBox.style.border = '';
	box.style.display = 'none';
}
function zi(e) {
	var w = e.target;
	if (w.tagName != 'SPAN') {
		bodyClick();
		return;
	}
	if (['，','、','。','？','！'].indexOf(w.innerHTML) >= 0)
		return;
	divDest = box;
	var i,iw,nch=0,fr='',sp=w.parentNode.getElementsByTagName('span');
	for (i=0; i<sp.length; i++) {
		fr = fr+sp[i].innerHTML;
		if (w == sp[i]) {
			iw = nch;
		}
		nch += sp[i].innerHTML.length;
	}
	boxX = window.scrollX + w.getBoundingClientRect().left;
	boxY = window.scrollY + w.getBoundingClientRect().top;
	if (ziBox)
		ziBox.style.border = '';
	ziBox = w;
	conecta('lookup.php?zi='+w.innerHTML+'&frase='+fr+'&pos='+iw);
	e.stopPropagation();
}
function load() {
	main = document.getElementsByTagName('main')[0];
	article = document.getElementsByTagName('article')[0];
	box = document.getElementById('box');
	alert('Programa de treinamento para o HSK — Teste de Proficiência em Chinês.\n\n\
Escolha um nível de HSK (1 a 7-9).\
 Cinco cartas serão apresentadas, correspondentes ao nível escolhido, junto com a tradução (ou traduções) de uma delas.\
 Clique na carta que corresponde à tradução dada.\n\n\
Cada rodada tem um valor de pontos proporcional à dificuldade.\
 Se você acertar de primeira, leva todos os pontos da rodada.\
 A cada tentativa errada você perde 25% dos pontos da rodada.\n\n\
Ao clicar numa carta, sua tradução aparecerá em negrito (em preto se for a carta certa, caso contrário em vermelho).\
 Aparecerão também frases de exemplo (quando disponíveis).\
 Clique nos caracteres ou no ⨁ ao final da frase para ver seu pinyin e tradução.\
 Depois de clicar na carta certa, clicar nas outras não altera o placar, permitindo estudá-las à vontade.\n\n\
Clique novamente em qualquer dos níveis HSK para começar a próxima rodada.\
 A pontuação aparece no canto superior esquerdo.\n\n\
Bom treino!');
}
</script>
</head>
<body onload='load()'>
	<nav>
		<aside>0</aside>
<?php
for ($i=0; $i<7; $i++) {
	if ($i < 6) {
		echo "		<div id='".($i+1)."' class='hsk' onclick='hsk(this)'>HSK ".($i+1)."</div>\n";
	} else {
		echo "		<div id='7' class='hsk' onclick='hsk(this)'>HSK 7-9</div>\n";
	}
}
?>
	</nav>
	<main></main>
	<article></article>
	<div id='box' onclick='boxClick(event)'></div>
</body>
</html>
