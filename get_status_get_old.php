<?php

var_dump(get_doc(5,806));

// $docid  - ID врача
// $specid - ID специальности
function get_doc($docid,$specid) {

		$html = get_post($specid);

		if(preg_match('#<div[^>]*class="yb_checked" id="'. $docid . '"#',$html)) {
			//echo "Врач недоступен";
			return false;
		} elseif (preg_match('#<div[^>]*class="yellow_button" id="'. $docid . '"#',$html)) {
            		//echo "Врач ДОСТУПЕН";
			return true;
		} else {
			//echo "Врач не найден";
			return null;
		}
}
		

function get_cookie() {

	$url = "http://kdcd.spb.ru/samozapis/speciality.php?mode=1&dms=0&flag=1";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:43.0) Gecko/20100101 Firefox/43.0");
	curl_setopt($ch, CURLOPT_REFERER, $referer);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . "/cookies.txt");
	curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . "/cookies.txt");

	curl_exec($ch);
	curl_close($ch);

}		


function get_post ($specid) {

	get_cookie();

	$referer = "http://kdcd.spb.ru/samozapis/speciality.php?mode=1&dms=0&flag=1";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://kdcd.spb.ru/samozapis/doctors_lpu.php');
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:43.0) Gecko/20100101 Firefox/43.0");
	curl_setopt($ch, CURLOPT_REFERER, $referer);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . "/cookies.txt");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "specid=".$specid);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
 
}
		

?>