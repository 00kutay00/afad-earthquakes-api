# afad-api

## Licence
> MIT Licence

## Setup
1. Extract the ZIP file named `simplehtmldom_1_9_1` to the folder it is in
2. `simplehtmldom_1_9_1` and `class.php` must be in the same directory.
3. `api.php` is the file to send requests.
This file should normally be located in a parent directory of `class.php` file.
See Line 3 in `api.php` to change this.

*class.php;*
```php
1 | <?php
2 |
3 | include "assest/class.php";
4 |
5 | //...
```
4. The variable $api_url in the *example.php* file is the full path to the file to which the api requests will be sent. Do not forget to change this.

## How to Use

**URL Structure**
`http://www.domain.com/api.php?lang=tr`

**Request Structure;**

| Request | Reply | Answer |
| -- | -- | -- |
| ?lang= | `Tr` or `En` | Tr: return data in Turkish - En: return data in English

## Return Data (JSON)

**If successful**
```JSON
{
	"return" : {
		"durum": true,
		"status" : true
	},
	"result" : [
		/* result */
	]
}
```

**If unsuccessful**
```JSON
{
	"durum" => false,
	"mesaj" => "Böyle bir dil seçeneği bulunmamaktadır!",

	"status" => false,
	"message" => "There is no such language option!"
}
```

## Request Example (example.php)
```PHP
$api_url = "https://www.domain.com/api.php?lang=en" // Change it according to you

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

$json = json_decode($result,true);
$api_return = $json["return"];
$data = $json["result"];
```


