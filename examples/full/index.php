<!DOCTYPE html>
<!--[if lt IE 7]>
	<html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7 ie6"></html>
	<![endif]--><!--[if IE 7]><html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8 ie7"></html>
	<![endif]--><!--[if IE 8]><html lang="en" class="no-js lt-ie10 lt-ie9 ie8"></html><![endif]-->
<!--[if IE 9]><html lang="en" class="no-js lt-ie10 ie9"></html><![endif]--><!--[if gt IE 9] <!-->
<html lang="es" class="no-js">
	<!--<![endif]-->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="https://a248.e.akamai.net/secure.mlstatic.com/org-img/ch/ui/0.11.1/chico-mesh.min.css">
		<link href="style.css" rel="stylesheet" type="text/css">
		<title>
			Payments Search
		</title>
	</head>
	<body>
		<header>
			<a class="logo" href="http://www.mercadopago.com/mp-argentina/" alt="MercadoPago">MercadoPago</a>
		</header>
		<form class="ch-form ch-box-lite" method="post">
			<legend>Payments Search</legend>
			<p class="ch-form-row">
				<label for="from">Date From:</label> <input type="date" id="from" name="from">
			</p>
			<p class="ch-form-row">
				<label for="to">Date To:</label> <input type="date" id="to" name="to">
			</p>
			<p class="ch-form-row">
				<label for="status">Status:</label> <select id="status" name="status">
					<option>Select one...</option>
					<option value="pending">Pending</option>
					<option value="approved">Approved</option>
					<option value="in_process">In_process</option>
					<option value="rejected">Rejected</option>
					<option value="cancelled">Cancelled</option>
					<option value="refunded">Refunded</option>
					<option value="in_mediation">In_mediation</option>
				</select>
			</p>
			<p class="ch-form-actions">
				<input class="ch-btn ch-btn-small" type="submit" value="Search">
			</p>
		</form>
		<?php
			require_once "mercadopago.php";

			$mp = new MP (14804, "zw2npS0b12F3AsSGRxO2tn0y5rSJhXcb");

			$filters = array();
			$date_format = "Y-m-d";

			if(isset($_POST["from"]) || isset($_POST["to"])) {

					$from = DateTime::createFromFormat($date_format, $_POST["from"]);

					$from_iso= $from->format("Y-m-d\T00:00:00\Z");

					echo $from_iso;

					$to =$_POST["to"];

					$anio=substr( $to, 0, 4); 
					$mes=substr( $to, 5,-3);
					$dia=substr( $to, 8, 10 );

					$to_iso=$anio."-".$mes."-".$dia."T00:00:00Z";

					$filters = array (

						"site_id" => "MLB",
					   "range"=>"date_created",
					   "begin_date"=>$from_iso,
					   "end_date"=>$to_iso
					);

				if(isset($_POST["status"]) ) { 

					$status=$_POST["status"];

					$filters = array (

					   "site_id" => "MLB",
					   "range"=>"date_created",
					   "begin_date"=>$from_iso,
					   "end_date"=>$to_iso,
					   "status"=>$status
					);
				}
			}

			else {

				if(isset($_POST["status"]) ) { 

					$status=$_POST["status"];

					$filters = array (

					   "site_id" => "MLB",
					   "status"=>$status
					);
				}

				$filters = array (

						"site_id" => "MLB",
					   
					);
				}


			$searchResult = $mp->search_payment ($filters,0,20);


		?>
		<table class="ch-datagrid-controls">
			<legend><?php echo "Total pays found: ".$searchResult["response"]["paging"]["total"];?></legend>
			<thead>
				<tr>
					<th class="ch-datagrid-selected">Pay Id</th>
					<th class="ch-datagrid-selected">Payer Email</th>
					<th class="ch-datagrid-selected">Date Created</th>
					<th class="ch-datagrid-selected">Money Release Date</th>
					<th class="ch-datagrid-selected">Transaction Amount</th>
					<th class="ch-datagrid-selected">Currency</th>
					<th class="ch-datagrid-selected">Status</th>
					<th class="ch-datagrid-selected">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if ($searchResult["status"]!=404) {
						foreach ($searchResult["response"]["results"] as $payment) {
							?>
							<tr>
								<td>
									<?php echo $payment["collection"]["id"];?>
								</td>
								<td>
									<?php echo ($payment["collection"]["payer"]["email"]) ? $payment["collection"]["payer"]["email"] : "-";?>
								</td>
								<td>
									<?php echo $payment["collection"]["date_created"];?>
								</td>
								<td>
									<?php echo $payment["collection"]["money_release_date"];?>
								</td>
								<td>
									<?php echo $payment["collection"]["transaction_amount"];?>
								</td>
								<td>
									<?php echo $payment["collection"]["currency_id"];?>
								</td>
								<td>
									<?php echo $payment["collection"]["status"];?>
								</td>
								<td>
									<?php if ($payment["collection"]["status"]=="approved"){ ?>
										<input class="ch-btn-skin ch-btn-small" type="button" value="Refund" name="refund_button" collectionid="<?php echo $payment['collection']['id']?>"><span class="ch-icon-ok" name="icon_ok" collectionid="<?php echo $payment['collection']['id']?>"></span>
									<?php  }?>
									<?php if ($payment["collection"]["status"]=="pending" || $payment["collection"]["status"]=="in_process" || $payment["collection"]["status"]=="rejected" || $payment["collection"]["status"]=="in_mediation"){ ?>
										<input class="ch-btn-skin ch-btn-small" type="button" value="Cancel" name="cancel_button" collectionid="<?php echo $payment['collection']['id']?>"><span class="ch-icon-ok" name="icon_ok" collectionid="<?php echo $payment['collection']['id']?>"></span>
									<?php }?>
								</td>
							</tr><?php
						}
					} else {
						?>
							<tr>
								<td colspan="8">No results found</td>
							</tr>
						<?php
					}
				?>
			</tbody>
		</table>
		<footer>
		</footer>
		<script src="https://a248.e.akamai.net/secure.mlstatic.com/org-img/ch/ui/0.11.1/chico-jquery.min.js" type="text/javascript"></script>
		<script type="text/javascript">

		var foo = $("#from").datePicker({
		 "format": "YYYY/MM/DD",
		 "selected": "today",
		 "from": "2000/12/25",
		 "to": "2015/12/25",
		 "monthsNames": ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
		 "weekdays": ["Su", "Mo", "Tu", "We", "Thu", "Fr", "Sa"]
		});

		var foo = $("#to").datePicker({
		 "format": "YYYY/MM/DD",
		 "selected": "today",
		 "from": "2000/12/25",
		 "to": "2015/12/25",
		 "monthsNames": ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
		 "weekdays": ["Su", "Mo", "Tu", "We", "Thu", "Fr", "Sa"]
		});


		</script><script type="text/javascript">

		var processComunication=$("<a>").transition();
		$("[name='icon_ok']").hide();


		$(function(){

			$("[name='refund_button']").click(function (){

				processComunication.show();

				var btn = $(this);
				var id=btn.attr("collectionid");
				var icon=$("span[collectionid='"+id+"']");

				$.ajax({

					  type: "POST",
					  url: "cancelandrefund.php",
					  data: {"id":id,"action":"refund"},
					 
					  success: function(data, textStatus, jqXHR){

						processComunication.hide();
						data = typeof data == "string" ? JSON.parse(data) : data;
						if (data.status == 205) {
						
							btn.hide();
							icon.show();

						} else {

							btn.show();
						}
					}
				});             
		});

			

			$("[name='cancel_button']").click(function (){

				processComunication.show();

				var btn = $(this);
				var id=btn.attr("collectionid");
				var icon=$("span[collectionid='"+id+"']");

				$.ajax({

					  type: "POST",
					  url: "cancelandrefund.php",
					  data: {"id":id,"action":"cancel"},
					 
					  success: function(data, textStatus, jqXHR){
						processComunication.hide();
						data = typeof data == "string" ? JSON.parse(data) : data;
						if (data.status == 205) {
							btn.hide();
							icon.show();
						}else {
							
							btn.show();
							}
						}
					});
			});
		});

		</script>
	</body>
</html>