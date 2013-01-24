<?php
	require_once "../mercadopago.php";
	require_once "../config.php";

	$mp = new MP ($client_id, $client_secret);

	$id=$_POST['id']; 
	$action=$_POST['action']; 

	if($action=="refund"){
		$result = $mp->refund_payment($id);
		echo json_encode($result);
	}

	if($action=="cancel"){
		$result = $mp->cancel_payment($id);
		echo json_encode($result);
	}
?>