<?php

$scheme = "http://";
$domain = $_SERVER['SERVER_NAME'];
$port = ":8080"; // for Localhost
$api_dir = "/dep/api.php";
$api_request = "?lang=en";
/*
	EN:
	URL of API
	
	TR:
	APİ'nin URL yapısı
*/
$api_url = $scheme.$domain.$port.$api_dir.$api_request;

$ch = curl_init();
curl_setopt_array($ch,[
	CURLOPT_URL => $api_url,
	CURLOPT_USERAGENT => $_SERVER["HTTP_USER_AGENT"],
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => false,
	CURLOPT_SSL_VERIFYPEER => false,
]);
if (curl_errno($ch)) {
	echo 'Error:' . curl_error($ch);
}
$result = curl_exec($ch);
curl_close($ch);

/*
	EN:
	Getting data with curl
	You can also do this with PHP file_get_contents() function.
	
	TR:
	Curl ile veri alma
	Bunu isterseniz php nin file_get_contents() fonksiyonu ile de yapabilirsiniz.
*/

$json = json_decode($result,true);
$api_return = $json["return"];
$data = $json["result"];

?>
<table border="1">
	<thead>
		<tr>
			<th colspan="7">
				Last 100 Earthquakes In Turkey
			</th>
		</tr>
		<tr>
			<th>Date</th>
			<th>Latitude</th>
			<th>Longitude</th>
			<th>Depth(KM)</th>
			<th>Type</th>
			<th>Magnitude</th>
			<th>Location</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($data as $quake) {
		?>
			<tr>
				<td><?= $quake["date"] ?></td>
				<td><?= $quake["latitude"] ?></td>
				<td><?= $quake["longitude"] ?></td>
				<td><?= $quake["depth"] ?></td>
				<td><?= $quake["type"] ?></td>
				<td><?= $quake["magnitude"] ?></td>
				<td><?= $quake["location"] ?></td>
			</tr>
		<?php
			}
		?>
	</tbody>
</table>