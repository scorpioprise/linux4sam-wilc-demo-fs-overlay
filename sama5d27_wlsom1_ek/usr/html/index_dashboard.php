<?php
session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: login.php");
	    exit;
	}
	$id = $_SESSION["id"];
?>
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
						<a class="nav-link disabled" href="reset-password.php">reset password</a>
					</li>
          <li class="nav-item">
            <a class="nav-link disabled" href="add-user.php">add user</a>
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
								<tr><td>DOMESTIC LOADS CONSUMPTION</td><td id="potenzacarichidomestici">--- waiting for data ---</td></tr>
								<tr><td>WALLBOX POWER</td><td id="potenzawallbox">--- waiting for data ---</td></tr>
								<tr><td>WALLBOX CURRENT</td><td id="corrente">--- waiting for data ---</td></tr>
								<tr><td>WALLBOX VOLTAGE</td><td id="tensione">--- waiting for data ---</td></tr>
								<tr><td>ACTIVE USER</td><td id="utenteattivo">--- waiting for data ---</td></tr>
								<tr><td>WORK TIME</td><td id="worktime">--- waiting for data ---</td></tr>
								<tr><td>CHARGING CYCLE ENERGY</td><td id="energiacicloricarica">--- waiting for data ---</td></tr>
								<tr><td>TEMPERATURE</td><td id="temperatura">--- waiting for data ---</td></tr>
								<tr><td>WALLBOX STATUS</td><td id="statowallbox">--- waiting for data ---</td></tr>
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
									<th>RFID card name</th>
									<th>function</th>
						    </tr>
						  </thead>
							<tbody>
<?php
$db = new SQLite3('access.sqlite');
$results = $db->query('SELECT * FROM cards');
$nrows = 0;
	while ($row = $results->fetchArray()) {
	  $nrows++;
		echo "<tr><td>".$row['id']."</td><td>".$row['card_no']."</td><td>".$row['name']."</td><td><form action='delete.php'><button type='submit' class='btn btn-primary btn-sm' name='id' value='".$row['card_no']."'>delete card</button></form></td></tr>";
	}
	if ($nrows == 0) {
		echo "<tr><td>no RFID card found</td><td></td><td></td><td></td></tr>";
	}
?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
    </div>
    <script>window.jQuery || document.write('<script src="js/jquery.slim.min.js"><\/script>')</script>
		<script src="js/pushstream.js" type="text/javascript" language="javascript" charset="utf-8"></script>
		<script type="text/javascript" language="javascript" charset="utf-8">
    function messageReceived(text, id, channel) {
			if (channel == 'map1') {
		    const obj = JSON.parse(text);
		    for (var key of Object.keys(obj)) {
					var el = document.getElementById(key).innerHTML = obj[key];
					if (el) {
					    el.value = obj[key];
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
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
