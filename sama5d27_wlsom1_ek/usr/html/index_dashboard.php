<?php
session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: login.php");
	    exit;
	}
	$id = $_SESSION["id"];
	$auth = $_SESSION["auth"];
	require_once "inc/config.php";
	include "loader.php";
	// 0=admin 1=installer 2=user
	if ($auth == 0) {
		$configuration_menu = "<li class='nav-item' role='presentation'><a href='#configurazioni' class='nav-link' id='configurazioni-tab' data-bs-toggle='tab' data-bs-target='#configurazioni' type='button' role='tab' aria-controls='configurazioni' aria-selected='false'><b>CONFIGURATION</b></a></li>
		<li class='nav-item' role='presentation'><a href='#errori' class='nav-link' id='errori-tab' data-bs-toggle='tab' data-bs-target='#errori' type='button' role='tab' aria-controls='errori' aria-selected='false'><b>ERRORS</b></a></li>";
		$configuration_tmpl = "admin_configuration.tmpl";
	} elseif ($auth == 1) {
		$configuration_menu = "<li class='nav-item' role='presentation'><a href='#configurazioni' class='nav-link' id='configurazioni-tab' data-bs-toggle='tab' data-bs-target='#configurazioni' type='button' role='tab' aria-controls='configurazioni' aria-selected='false'><b>CONFIGURATION</b></a></li>";
		$configuration_tmpl = "installer_configuration.tmpl";
	} else {
		$configuration_menu = "";
	}
?>
<!--# if expr="$internetenabled=false" -->
  <!--# include file="session.php" -->
  <!--# include file="index_provisioning.php" -->
<!--# else -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>DKC wallbox</title>
    <meta charset="utf-8" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="favicon.ico" rel="icon" type="image/x-icon" />
		<link href="favicon.png" rel="icon" type="image/png" />
  </head>
  <body>
		<nav class="navbar navbar-expand-md navbar-dark sticky-top bg-dark">
			<img src="img/dkc.png" width="54" height="30" class="ms-2">
      <div class="navbar-brand ms-3" href="#">wallbox webserver</div>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="navbar-toggler-icon"></span>
	    </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
					<li class="nav-item">
						<a class="nav-link" href="reset-password.php">reset password</a>
					</li>
					<li class="nav-item me-2">
            <a class="nav-link active" href="logout.php">sign out</a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="container-fluid mt-1">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
			  <li class="nav-item" role="presentation">
			    <a href="#info" class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true"><b>INFO</b></a>
			  </li>
				<li class="nav-item" role="presentation">
			    <a href="#comandi" class="nav-link" id="comandi-tab" data-bs-toggle="tab" data-bs-target="#comandi" type="button" role="tab" aria-controls="comandi" aria-selected="false"><b>COMMAND</b></a>
			  </li>
			  <li class="nav-item" role="presentation">
			    <a href="#letture" class="nav-link" id="letture-tab" data-bs-toggle="tab" data-bs-target="#letture" type="button" role="tab" aria-controls="letture" aria-selected="false"><b>TELEMETRY</b></a>
			  </li>
				<li class="nav-item" role="presentation">
			    <a href="#utenti" class="nav-link" id="utenti-tab" data-bs-toggle="tab" data-bs-target="#utenti" type="button" role="tab" aria-controls="utenti" aria-selected="false"><b>USERS</b></a>
			  </li>
				<li class="nav-item" role="presentation">
					<a href="#transazioni" class="nav-link" id="transazioni-tab" data-bs-toggle="tab" data-bs-target="#transazioni" type="button" role="tab" aria-controls="transazioni" aria-selected="false"><b>TRANSACTIONS</b></a>
				</li>
<?php echo $configuration_menu; ?>
			</ul>
			<div class="tab-content" id="myTabContent">
<!-- /////////////////////////////////////// INFO ////////////////////////////////////////////////////////// -->
			  <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
					<div class="col mt-1">
						<div class="alert alert-primary" role="alert">
	          <b>SYSTEM</b>
						</div>
						<table class="table table-dark table-sm table-responsive table-striped table-hover border-primary">
						  <thead class="thead-dark">
						    <tr>
	                <th>data</th>
						      <th>value</th>
						    </tr>
						  </thead>
							<tbody>
								<tr><td>SERVER TIME</td><td><!--#  echo var="timestamp" --></td></tr>
								<tr><td>WALLBOX TIME</td><td><!--#  echo var="timewallbox" --></td></tr>
								<tr><td>MAC ADDRESS</td><td><!--#  echo var="macaddress" --></td></tr>
								<tr><td>INSTALLATION ID</td><td><!--#  echo var="idimpianto" --></td></tr>
								<tr><td>MANUFACTURER</td><td><!--#  echo var="costruttore" --></td></tr>
								<tr><td>MACHINE CONFIGURATION</td><td><!--#  echo var="configurazione" --></td></tr>
								<tr><td>EMETER NOMINAL POWER</td><td><!--#  echo var="potenzanominalecontatore" --></td></tr>
								<tr><td>MODBUS DEVICE ADDRESS</td><td><!--#  echo var="indirizzomodbus" --></td></tr>
								<tr><td>LOCAL IP ADDRESS</td><td><!--#  echo var="indirizzoiplocale" --></td></tr>
								<tr><td>WLAN IP ADDRESS</td><td><!--#  echo var="indirizzoipwlan" --></td></tr>
								<tr><td>DATE/TIME</td><td><!--#  echo var="dataora" --></td></tr>
								<tr><td>LANGUAGE</td><td><!--#  echo var="lingua" --></td></tr>
								<tr><td>REALTIME DATA SAMPLING INTERVAL</td><td><!--#  echo var="frequenzainviorealtime" --></td></tr>
								<tr><td>WALLBOX TYPE</td><td><!--#  echo var="tipologiawallbox" --></td></tr>
								<tr><td>WALLBOX ID</td><td><!--#  echo var="idwallbox" --></td></tr>
								<tr><td>SERIAL NUMBER</td><td><!--#  echo var="numeroserie" --></td></tr>
								<tr><td>FIRMWARE VERSION</td><td><!--#  echo var="versionefw" --></td></tr>
								<tr><td>SOFTWARE VERSION</td><td><!--#  echo var="versionesw" --></td></tr>
								<tr><td>POWER RATING</td><td><!--#  echo var="potenzatarga" --></td></tr>
							</tbody>
						</table>
					</div>
				</div>
<!-- /////////////////////////////////////// COMANDI ////////////////////////////////////////////////////////// -->
			  <div class="tab-pane fade" id="comandi" role="tabpanel" aria-labelledby="comandi-tab">
					<div class="col mt-1">
						<div class="alert alert-warning" role="alert">
	          <b>COMMAND</b>
						</div>
						<form action='command.php' method='post'>
		          <div class='row g-3'>
		            <div class='col'>
									<div class="input-group">
									  <select class="form-select" name="parameter" aria-label="select parameter">
									    <option selected>please select a parameter</option>
									    <option value="3000">3000 - OPERATE WALLBOX</option>
									    <option value="3001">3001 - BOOK WALLBOX</option>
									    <option value="3002">3002 - CANCEL BOOKING</option>
											<option value="3003">3003 - SET MAX POWER</option>
											<option value="3004">3004 - ADD AUTHORIZED USER</option>
											<option value="3005">3005 - REMOVE AUTHORIZED USER</option>
											<option value="3006">3006 - CONSTANT POWER MODE</option>
											<option value="3007">3007 - ENABLE/DISABLE RFID</option>
											<option value="3008">3008 - ENABLE/DISABLE LOAD BALANCING</option>
											<option value="3009">3009 - ENABLE/DISABLE OCPP 1.6</option>
											<option value="3010">3010 - ENABLE/DISABLE MODBUS</option>
											<option value="3011">3011 - FIRMWARE UPDATE</option>
											<option value="3012">3012 - SOFTWARE UPDATE</option>
											<option value="3013">3013 - DEVICE INFO</option>
											<option value="3014">3014 - RESET ERROR</option>
									  </select>
										<input type="text" class="form-control" name="valore" placeholder="please insert a value" aria-label="please insert a value" required>
									  <button class="btn btn-outline-secondary" type='submit'>APPLY</button>
									</div>
								</div>
		          </div>
		        </form>
					</div>
				</div>
<!-- /////////////////////////////////////// LETTURE ////////////////////////////////////////////////////////// -->
			  <div class="tab-pane fade" id="letture" role="tabpanel" aria-labelledby="letture-tab">
					<div class="col mt-1">
						<div class="alert alert-success" role="alert">
	          <b>TELEMETRY</b>
						</div>
	          <table class="table table-dark table-sm table-responsive table-striped table-hover border-success">
						  <thead class="thead-dark">
						    <tr>
	                <th>data</th>
						      <th>value</th>
						    </tr>
						  </thead>
							<tbody>
								<tr><td>DOMESTIC LOADS CONSUMPTION</td><td id="potenzacarichidomestici"></td></tr>
								<tr><td>WALLBOX POWER</td><td id="potenzawallbox"></td></tr>
								<tr><td>WALLBOX CURRENT</td><td id="corrente"></td></tr>
								<tr><td>WALLBOX VOLTAGE</td><td id="tensione"></td></tr>
								<tr><td>ACTIVE USER</td><td id="utenteattivo"></td></tr>
								<tr><td>WORK TIME</td><td id="worktime"></td></tr>
								<tr><td>CHARGING CYCLE ENERGY</td><td id="energiacicloricarica"></td></tr>
								<tr><td>TEMPERATURE</td><td id="temperatura"></td></tr>
								<tr><td>WALLBOX STATUS</td><td id="statowallbox"></td></tr>
							</tbody>
						</table>
					</div>
				</div>
<!-- /////////////////////////////////////// UTENTI ////////////////////////////////////////////////////////// -->
			  <div class="tab-pane fade" id="utenti" role="tabpanel" aria-labelledby="utenti-tab">
					<div class="col mt-1">
						<div class="alert alert-info" role="alert">
	          <b>USERS</b>
						</div>
<!-- /////////////////////////////////////// AGGIUNGI UTENTE ////////////////////////////////////////////////////////// -->
						<div class="row g-3">
							<div class="col">
								<form action="insert.php">
									<button class="btn btn-primary mt-2" type="submit">ADD A NEW RFID CARD</button>
									<hr class="my-2">
								</form>
							</div>
						</div>
						<table class="table table-dark table-sm table-responsive table-striped table-hover border-success">
						  <thead class="thead-dark">
						    <tr>
	                <th>id</th>
						      <th>RFID card number</th>
									<th>cardholder name</th>
									<th>date</th>
									<th colspan="2">functions</th>
						    </tr>
						  </thead>
							<tbody>
<?php
##################### UPDATE SQL CARTE UTENTI #####################
if($_SERVER["REQUEST_METHOD"] == "POST"){
$nuovonome = $_POST['newname'];
$numerocarta = $_POST['cardnumber'];
	$sql2 = "UPDATE cards SET name='$nuovonome' WHERE card_no='$numerocarta'";
	if($stmt = mysqli_prepare($link, $sql2)){
			if(mysqli_stmt_execute($stmt)){
				$result = $stmt->get_result();
				$nrows = 0;
				if ($nrows == 0) {
				}
			} else{
				echo "Something went wrong. Please try again later. ";
			}
			mysqli_stmt_close($stmt);
	}
}
##################### QUERY SQL UTENTI #####################
$sql = "SELECT * FROM cards ORDER BY id DESC";
if($stmt = mysqli_prepare($link, $sql)){
		if(mysqli_stmt_execute($stmt)){
			$result = $stmt->get_result();
			$nrows = 0;
			while ($row = $result->fetch_assoc()) {
				$nrows++;
				echo "<tr><td>".$row['id']."</td><td>".$row['card_no']."</td><td>".$row['name']."</td><td>".$row['tempo']."</td>
				<td><button type='submit' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#changeModal' data-bs-change='".$row['name']."' name='change' data-bs-value='".$row['card_no']."'>change cardholder name</button></td>
				<td><form action='delete.php'><button type='submit' class='btn btn-warning btn-sm' name='id' value='".$row['card_no']."'>delete card</button></form></td></tr>";
			}
			if ($nrows == 0) {
				echo "<tr><td>no RFID card found</td><td></td><td></td><td></td><td></td><td></td></tr>";
			}
		} else{
			echo "Something went wrong. Please try again later. ";
		}
		mysqli_stmt_close($stmt);
}
?>

							</tbody>
						</table>
					</div>
				</div>
				<div class="modal fade" id="changeModal" tabindex="-1" aria-labelledby="changeModalLabel" aria-hidden="true">
				  <div class="modal-dialog modal-dialog-centered">
				    <div class="modal-content">
				      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					      <div class="modal-header">
					        <h5 class="modal-title" id="changeModalLabel">change cardholder name</h5>
					        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					      </div>
								<div class="modal-prebody">
									<input type="hidden" id="cardnumber" name="cardnumber" value="">
								</div>
					      <div class="modal-body">
				          <div class="mb-3">
				            <label for="cardholdername-name" class="col-form-label">old name:</label>
				            <input type="text" class="form-control" id="cardholdername-name" name="oldname" readonly>
				          </div>
				          <div class="mb-3">
				            <label for="newname" class="col-form-label">new name:</label>
				            <input type="text" class="form-control" id="newname" name="newname" required>
				          </div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">close</button>
					        <button type="submit" class="btn btn-primary">OK</button>
					      </div>
			        </form>
				    </div>
				  </div>
				</div>
				<script>
				var changeModal = document.getElementById('changeModal')
				changeModal.addEventListener('show.bs.modal', function (event) {
					var button = event.relatedTarget
					var cardholdername = button.getAttribute('data-bs-change')
					var cardnumber = button.getAttribute('data-bs-value')
					var modalTitle = changeModal.querySelector('.modal-title')
					var modalBody = changeModal.querySelector('.modal-prebody input')
					var modalBodyInput = changeModal.querySelector('.modal-body input')
					modalTitle.textContent = 'change cardholder name for ' + cardnumber
					modalBody.value = cardnumber
					modalBodyInput.value = cardholdername
				})
				</script>
<!-- /////////////////////////////////////// TRANSAZIONI ////////////////////////////////////////////////////////// -->
			  <div class="tab-pane fade" id="transazioni" role="tabpanel" aria-labelledby="transazioni-tab">
					<div class="col mt-1">
						<div class="alert alert-info" role="alert">
	          <b>TRANSACTIONS</b>
						</div>
						<div class="table-responsive">
							<table class="table table-dark table-sm table-responsive table-striped table-hover border-success">
							  <thead class="thead-dark">
							    <tr>
		                <th>id</th>
							      <th>date</th>
										<th>RFID card number</th>
										<th>cardholder name</th>
										<th>wallbox status</th>
										<th>start time</th>
										<th>end time</th>
										<th>duration</th>
										<th>delivered kWh</th>
										<th>error</th>
							    </tr>
							  </thead>
								<tbody>
<?php
##################### QUERY SQL TRANSAZIONI #####################
$sql = "SELECT transactions.id, transactions.tempo, transactions.card_no, cards.name, transactions.status, transactions.start_time, transactions.end_time, transactions.duration, transactions.delivered_kwh, transactions.error FROM transactions JOIN cards ON transactions.card_no=cards.id ORDER BY id DESC";
if($stmt = mysqli_prepare($link, $sql)){
		if(mysqli_stmt_execute($stmt)){
			$result = $stmt->get_result();
			$nrows = 0;
			while ($row = $result->fetch_assoc()) {
				$nrows++;
				echo "<tr><td>".$row['id']."</td><td>".$row['tempo']."</td><td>".$row['card_no']."</td><td>".$row['name']."</td><td>".$row['wallbox_status']."</td><td>".$row['start_time']."</td><td>".$row['end_time']."</td><td>".$row['duration']."</td><td>".$row['delivered_kwh']."</td><td>".$row['error']."</td></tr>";
			}
			if ($nrows == 0) {
				echo "<tr><td>no TRANSACTIONS found</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
			}
		} else{
			echo "Something went wrong. Please try again later. ";
		}
		mysqli_stmt_close($stmt);
}
?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
<?php if(isset($configuration_tmpl)){include($configuration_tmpl);} ?>
			</div>
    </div>
    <script src="js/jquery.slim.min.js"></script>
		<script src="js/pushstream.js" type="text/javascript" language="javascript" charset="utf-8"></script>
		<script type="text/javascript" language="javascript" charset="utf-8">
    function messageReceived(text, id, channel) {
			if (channel == 'map1') {
		    const obj = JSON.parse(text);
		    for (var key of Object.keys(obj)) {
					var el = document.getElementById(key).innerHTML = obj[key];
					if (el) {
					    el.innerHTML = obj[key];
					}
		    }
			}
    };
    var pushstream = new PushStream({
      host: window.location.hostname,
      port: window.location.port,
      modes: "eventsource"
    });
    pushstream.onmessage = messageReceived;
    pushstream.addChannel('map1');
    pushstream.connect();
    </script>
		<script>
		$(function() {
	    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
	        localStorage.setItem('lastTab', $(this).attr('href'));
	    });
	    var lastTab = localStorage.getItem('lastTab');
	    if (lastTab) {
	        $('[href="' + lastTab + '"]').tab('show');
	    }
		});
		</script>
		<script>
		$(document).ready(function(){
			var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
			var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
				return new bootstrap.Tooltip(tooltipTriggerEl)
			})
		});
		</script>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
<!--# endif -->
