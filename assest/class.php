<?php

/*
	Created By Kutay Ertuğ Ateş
	Github => 00kutay00
	Copyright © 2023
*/

/*
	This file should be in the same directory as the "simplehtmldom_1_9_1" folder.
	Check out line 21 to change this.
*/

class AfadApi {
	
	private $lang = "";
	
	function __construct($language) {
		$this->lang = strlower($language);
		
		include_once "simplehtmldom_1_9_1/simple_html_dom.php";
		
	}
	
	public function get_curl_data($url) {
		$ch = curl_init();
		
		curl_setopt_array($ch,[
			CURLOPT_URL => $url,
			CURLOPT_USERAGENT => $_SERVER["HTTP_USER_AGENT"],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_SSL_VERIFYPEER => false,
		]);
		
		$result = curl_exec($ch);
		
		if (curl_errno($ch)) {
			return 'Error:' . curl_error($ch);
		}
		else {
			return $result;
		}
		
		curl_close($ch);
	}
	
	public function get_curl_quakes() {
		$url = "https://deprem.afad.gov.tr/last-earthquakes.html";
		$where = "table.content-table tbody tr";
		
		$site_content = $this->get_curl_data($url);
		$html = str_get_html($site_content);
		
		return $html->find($where);
	}
	
	public function select_quakes() {
		$quas = array(
			"return" => array(
				"durum" => true, // tr
				"status" => true // en
			),
			"result" => array()
		);

		if ()
		switch ($this->lang) {
			case "tr":
				$select_qua = $this->get_curl_quakes();
				foreach ($select_qua as $qua_elem) {
					$qua = array(
						"tarih" => $qua_elem->find("td")[0]->innertext,
						"enlem" => $qua_elem->find("td")[1]->innertext,
						"boylam" => $qua_elem->find("td")[2]->innertext,
						"derinlik" => $qua_elem->find("td")[3]->innertext,
						"tip" => $qua_elem->find("td")[4]->innertext,
						"buyukluk" => $qua_elem->find("td")[5]->innertext,
						"yer" => $qua_elem->find("td")[6]->innertext,
					);
					array_push($quas["result"],$qua);
				}
				break;
			case "en":
				$select_qua = $this->get_curl_quakes();
				foreach ($select_qua as $qua_elem) {
					$qua = array(
						"status" => true,
						"date" => $qua_elem->find("td")[0]->innertext,
						"latitude" => $qua_elem->find("td")[1]->innertext,
						"longitude" => $qua_elem->find("td")[2]->innertext,
						"depth" => $qua_elem->find("td")[3]->innertext,
						"type" => $qua_elem->find("td")[4]->innertext,
						"magnitude" => $qua_elem->find("td")[5]->innertext,
						"location" => $qua_elem->find("td")[6]->innertext,
					);
					array_push($quas["result"],$qua);
				}
				break;
			default:
				$quas = array(
					"durum" => false,
					"mesaj" => "Böyle bir dil seçeneği bulunmamaktadır!",
					
					"status" => false,
					"message" => "There is no such language option!"
				);
				break;
		}
		
		return $quas;
	}
	
}
?>
