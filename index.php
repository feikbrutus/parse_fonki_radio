<?php
	include_once('lib/simple_html_dom.php');
	include_once('lib/curl_querry.php');
	$name_file_radiostations = "radio.fonki.pro.".date("m.d.y,h,m,s").".m3u";
	

	//$dom = str_get_html(curl_get('http://radio.fonki.pro/main/1'));

	$coun = 1;
	function get_radio($dom){

		$co = 0;
		$names = $dom->find('div[class=radio_block]');
		foreach($names as $name) {
			if($co > 9){
				
				$title = $name->find('.radio_block__title', 0);
				echo $GLOBALS["coun"]++ .' ' . $title->plaintext . '<br>';
				add_to_m3u("#EXTINF:-1,".$title->plaintext .PHP_EOL);
				
				$a = $name->find('a', 0);
				echo $a->href . '<br>';	
				add_to_m3u($a->href .PHP_EOL );
			}
			$co++;
			
		}
	}
	file_put_contents($GLOBALS["name_file_radiostations"], "#EXTM3U".PHP_EOL);
	function add_to_m3u($content){
		file_put_contents($GLOBALS["name_file_radiostations"], $content, FILE_APPEND);
		
	}
	for ($i = 1; $i <= 8; $i++) {
		$dom1 = str_get_html(curl_get('http://radio.fonki.pro/main/'.$i));
		get_radio($dom1);
	}
?>