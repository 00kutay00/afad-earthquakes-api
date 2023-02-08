<?php

include "assest/class.php";

$afadapi = "";
if (isset($_GET["lang"])) {
	$afadapi = new AfadApi($_GET["lang"]);
}
else {
	$afadapi = new AfadApi("tr");
}
$quas = $afadapi->select_quakes();

echo json_encode($quas,JSON_UNESCAPED_UNICODE);

?>