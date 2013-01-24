<?php
header("Content-type: text/plain");

require_once "../mercadopago.php";
require_once "../config.php";

$mp = new MP ($client_id, $client_secret);

$payment_info = $mp->get_payment_info($_GET["id"]);

print_r(json_encode ($payment_info["response"]));
?>
