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


var_dump(get_doc(2627167,819));

// $docid  - ID врача
// $specid - ID специальности
function get_doc($docid,$specid) {

		$html = get_post($specid);

		$dom = str_get_html($html);

		$docs = 	$dom->find('.yb_checked');

		$docs_hide = 	$dom->find('.yellow_button');
		
		$docname = "";
		$arr = array();

//		file_put_contents('1.txt', $html);

		
               	foreach($docs as $doc){
			
	        	$a = $doc -> find('span',0);

			$doc1 = $a->plaintext;	
		
			
			if ($doc->attr['id'] == $docid) {
				$docname = $doc1;

			}
			
//			print "DOCNAME ".$doc->attr['id'];
		
		
//			print $a->plaintext . " - doc1<br>";

	               	foreach($docs_hide as $doc_hide){
		
	        		$a_hide = $doc_hide -> find('span',0);
				$a_id   = $doc_hide ->attr['id'];
				

	        		if ($doc1 ==  $a_hide->plaintext) {
					
					if ($doc_hide->attr['id'] == $docid) {
						$docname = $doc1;

					}

					$dom->find('div[id='. $a_id . ']',0) -> outertext = "";
				}
				
			}

		}


		print $docname;

//		file_put_contents('2.txt', $dom);


		if(preg_match('#<div[^>]*class="yb_checked" id="'. $docid . '"#',$dom)) {
			return false;
		} elseif (preg_match('#<div[^>]*class="yellow_button" id="'. $docid . '"#',$dom)) {
			return true;
		} else {
			return null;
		}


}


function get_number($docid,$docname) {




}



function get_cookie() {

$proxy = '10.247.19.22:9090';
$proxyauth = 'spb\eav:recf40vehf}|';

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

	curl_setopt($ch, CURLOPT_PROXY, $proxy);
	curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);

	curl_exec($ch);
	curl_close($ch);

}		

function get_post ($specid) {

$proxy = '10.247.19.22:9090';
$proxyauth = 'spb\eav:recf40vehf}|';

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

	curl_setopt($ch, CURLOPT_PROXY, $proxy);
	curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);


	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
 
}
		

?>