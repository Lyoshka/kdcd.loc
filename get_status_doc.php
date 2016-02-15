<?php

require_once dirname(__FILE__) . '/lib/simple_html_dom.php';



// 802  = "Аллерголог"
// 805  = "Гастроэнтеролог"
// 806  = "Гематолог"
// 815  = "Кардиолог"
// 818  = "Невролог"
// 819  = "Нефролог"
// 824  = "Педиатр"
// 826  = "Пульмонолог"
// 174  = "Ревматолог"
// 844  = "Эндокринолог"


//var_dump(get_doc(2627227,174));

// $docid  - ID врача
// $specid - ID специальности
function get_doc($docid,$specid) {

		$html = get_post($specid);

		$dom = str_get_html($html);

		$docs = 	$dom->find('.yb_checked');

		$docs_hide = 	$dom->find('.yellow_button');
		
		$docname = "";
		$arr = array();

		
            foreach($docs as $doc){
			
	        $a = $doc -> find('span',0);

			$doc1 = $a->plaintext;	
		
			
			if ($doc->attr['id'] == $docid) {
				$docname = $doc1;
				
				}

				foreach($docs_hide as $doc_hide){
	
					$a_hide = $doc_hide -> find('span',0);
					$a_id   = $doc_hide ->attr['id'];
					
					if ($doc1 ==  $a_hide->plaintext) {
					
						$dom->find('div[id='. $a_id . ']',0) -> outertext = "";
						
						}
			
				}

			}


		if(preg_match('#<div[^>]*class="yb_checked" id="'. $docid . '"#',$dom)) {
			$dom->clear();
			unset($dom);
			return false;
		} elseif (preg_match('#<div[^>]*class="yellow_button" id="'. $docid . '"#',$dom)) {
			
			foreach($docs_hide as $doc_hide){
			
	        $a = $doc_hide -> find('span',0);

			$doc1 = $a->plaintext;	
		
			
			if ($doc_hide->attr['id'] == $docid) {
				$docname = $doc1;
				}
			
			}
			
			$num = get_number($docid,$docname);
			
			$dom->clear();
			unset($dom);
			return $num;
			
		} else {
			$dom->clear();
			unset($dom);
			return null;
			
		}


}




function get_number($docid,$docname) {


	$url = "http://kdcd.spb.ru/samozapis/doctors_lpu.php?docid=".$docid."&docname=".$docname."&cab=0";


	$html = get_curl($url);
	$dom  = str_get_html($html);
	$docs = $dom->find('.count_numbs_yellow');
	
	$i=0;
	
	foreach($docs as $doc){
			
	        $a = $doc->find('input[id="specid"]',0);
			$specid = $a->attr['value'];

	        $a = $doc->find('input[id="docid"]',0);
			$docid = $a->attr['value'];

	        $a = $doc->find('input[id="date_str"]',0);
			$date_str = urlencode ($a->attr['value']);

	        $a = $doc->find('input[id="dayweek"]',0);
			$dayweek = urlencode ($a->attr['value']);

	        $a = $doc->find('input[id="strdat"]',0);
			$strdat = $a->attr['value'];

	        $a = $doc->find('input[id="range"]',0);
			$range = $a->attr['value'];

	        $a = $doc->find('input[id="survid"]',0);
			$survid = 'undefined';

	        $a = $doc->find('input[id="room"]',0);
			$room = $a->attr['value'];
			
			$url = "http://kdcd.spb.ru/samozapis/numbers_free_time.php?specid=".$specid."&docid=".$docid."&date_str=".$date_str."&dayweek=".$dayweek."&strdat=".$strdat."&range=".$range."&survid=".$survid."&room=".$room;

			$html = get_curl($url);
			$dom  = str_get_html($html);
			$items = $dom->find('.times_numbs_yellow');
			
			foreach($items as $item) {
				
				$i += 1;
			}	
			
	}
	
return $i;

}

function get_curl($url) {

	$referer = "http://kdcd.spb.ru/samozapis/doctors_lpu.php";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:43.0) Gecko/20100101 Firefox/43.0");
	curl_setopt($ch, CURLOPT_REFERER, $referer);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . "/cookies.txt");
	curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . "/cookies.txt");

	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
	
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