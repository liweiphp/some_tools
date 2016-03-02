<?php
/*
// ini_set("pcre.backtrack_limit",100000000);
$a = range(1,12636);
shuffle($a);
$d = print_r($a,true);
echo strlen($d)/1024,PHP_EOL;
$a = "<xml version='1.0'><pcc>header".$d."tail</pcc></xml>";
preg_match_all("/<pcc>(.*?)(\d*)<\/pcc>/s", $a, $m,PREG_SET_ORDER);
var_dump($m);
echo "had result:",PHP_EOL;
*/
$html = file_get_contents("./view.html");
preg_match_all("/u[1-9a-f]{4}/",$html, $matches);
function call_func($match){
	return iconv('UCS-2BE', 'UTF-8', pack('H4', $match[1]));
}
$result = preg_replace_callback("/u([0-9a-f]{4})/","call_func", $html);
file_put_contents("./view.html", $result);
foreach($matches[0] as $m){
	echo iconv('UCS-2BE', 'UTF-8', pack('H4', substr($m,1)));
	//iconv('UCS-2BE', 'UTF-8', pack('H4', '$1'))
	// iconv("uicode","utf-8", $m);
	// $m = mb_convert_encoding($m, "utf-8","gbk");
	
	// $m = mb_convert_encoding($m, "gbk","utf-8");

}