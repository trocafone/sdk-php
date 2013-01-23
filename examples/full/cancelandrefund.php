<?php

	require_once "mercadopago.php";

			$client_id=14804;
			$client_secret="zw2npS0b12F3AsSGRxO2tn0y5rSJhXcb";
			$mp = new MP ($client_id,$client_secret);

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