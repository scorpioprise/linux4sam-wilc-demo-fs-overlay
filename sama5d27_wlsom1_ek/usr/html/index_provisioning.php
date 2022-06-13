<!--# if expr="$internetenabled=true" -->
  <!--# include file="session.php" -->
  <!--# include file="login.php" -->
<!--# else -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>DKC wallbox network setup</title>
		<meta charset="utf-8" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="favicon.ico" rel="icon" type="image/x-icon" />
		<link href="favicon.png" rel="icon" type="image/png" />
  </head>
<!-- ############################################## JS PER SUBMIT ##############################################-->
<script type="text/javascript">
  function submitButton(act) {
    document.network.action = act;
    document.network.submit();
  }
</script>
<!-- ############################################## JS PER DIV ##############################################-->
<script type="text/javascript">
  function scanDiv() {
    var x = document.getElementById("scanresult");
    if (x.style.display === "none") {
      x.style.display = "block";
    }
  };
</script>
  <body>
		<nav class="navbar navbar-expand-md navbar-dark sticky-top bg-dark">
			<img src="img/dkc.png" width="54" height="30" class="ms-2">
      <div class="navbar-brand ms-3" href="#">wallbox network setup</div>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    </button>
    </nav>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-4">
					<form name="network" method="post">
      			<h3 class="display-6">Wi-Fi NETWORK</h3>
            <div class="mb-3">
							<label for="ssid" class="form-label">SSID network name</label>
              <input type="text" class="form-control" name="ssid" id="ssid" maxlength="32" value=<!--# echo var="ssid" default="" --> >
            </div>
						<div class="mb-3">
              <label for="pass" class="form-label">passphrase</label>
              <input type="password" class="form-control" name="pass" maxlength="64" value=<!--# echo var="pass" default="" --> >
						</div>
						<div class="form-check mb-3">
							<input type="checkbox" name="wifidhcp" class="wifidhcp form-check-input" maxlength="64" onchange="wifidhcp_checked()" <!--#  echo var="wifidhcp" -->>
							<label class="form-check-label" for="wifidhcp">WiFi network DHCP</label>
    	      </div>
    	      <div class="wifistatic_ip mb-3">
							<div class="mb-3">
								<label for="wifiipaddress" class="form-label">WiFi network static IP</label>
	    	        <input type="text" class="form-control" name="wifiipaddress" maxlength="64" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" value=<!--# echo var="wifiipaddress" --> >
							</div>
							<div class="mb-3">
								<label for="wifinetmask" class="form-label">WiFi network netmask</label>
	    	        <input type="text" class="form-control" name="wifinetmask" maxlength="64" value=<!--# echo var="wifinetmask" default="255.255.0.0" --> >
							</div>
							<div class="mb-3">
								<label for="wifigateway" class="form-label">WiFi network gateway</label>
	    	        <input type="text" class="form-control" name="wifigateway" maxlength="64" value=<!--# echo var="wifigateway" default="" --> >
							</div>
							<div class="mb-3">
								<label for="wifidns" class="form-label">WiFi network DNS server</label>
	    	        <input type="text" class="form-control" name="wifidns" maxlength="64" value=<!--# echo var="wifidns" default="" --> >
							</div>
    	      </div>
<!-- ############################################## SCAN RESULT ##############################################-->
            <div id="scanresult" class="mb-3" style="display:none;">
              <div class="list-group">
                <div class="list-group-item list-group-item-action text-info bg-dark">CHOOSE A WIRELESS NETWORK</div>
                <input type="button" class="list-group-item list-group-item-action" onclick="fillwifi('<!--#  echo var='wifi-ssid1' -->', 123456)" value="<!--#  echo var='wifi-ssid1' -->">
                <input type="button" class="list-group-item list-group-item-action" onclick="fillwifi('<!--#  echo var='wifi-ssid2' -->', 123456)" value="<!--#  echo var='wifi-ssid2' -->">
                <input type="button" class="list-group-item list-group-item-action" onclick="fillwifi('<!--#  echo var='wifi-ssid3' -->', 123456)" value="<!--#  echo var='wifi-ssid3' -->">
                <input type="button" class="list-group-item list-group-item-action" onclick="fillwifi('<!--#  echo var='wifi-ssid4' -->', 123456)" value="<!--#  echo var='wifi-ssid4' -->">
              </div>
            </div>
						<div>
							<input type="button" class="w-100 btn btn-lg btn-info my-2" name="scan" value="scan for wifi networks" onClick="scanDiv()">
			    	</div>
						<hr class="my-2">
	    	    <h3 class="display-6">ETHERNET NETWORK</h3>
    	      <div class="form-check mb-3">
							<input type="checkbox" name="dhcp" class="dhcp form-check-input" maxlength="64" onchange="dhcp_checked()" <!--#  echo var="dhcp" -->>
							<label class="form-check-label" for="dhcp">DHCP</label>
    	      </div>
    	      <div class="static_ip mb-3">
							<div class="mb-3">
								<label for="ipaddress" class="form-label">static IP</label>
	    	        <input type="text" class="form-control" name="ipaddress" maxlength="64" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" value=<!--# echo var="ipaddress" --> >
							</div>
							<div class="mb-3">
								<label for="netmask" class="form-label">netmask</label>
	    	        <input type="text" class="form-control" name="netmask" maxlength="64" value=<!--# echo var="netmask" default="255.255.0.0" --> >
							</div>
							<div class="mb-3">
								<label for="gateway" class="form-label">gateway</label>
	    	        <input type="text" class="form-control" name="gateway" maxlength="64" value=<!--# echo var="gateway" default="" --> >
							</div>
							<div class="mb-3">
								<label for="dns" class="form-label">DNS server</label>
	    	        <input type="text" class="form-control" name="dns" maxlength="64" value=<!--# echo var="dns" default="" --> >
							</div>
    	      </div>
						<hr class="my-2">
			    	<div>
							<button class="w-100 btn btn-lg btn-primary my-2" type="submit" name="apply" value="apply" onClick="submitButton('reload_index.php')">apply</button>
			    	</div>
<!-- ############################################## CONTINUE WITHOUT NETWORKl ############################################## -->
            <hr class="my-2">
            <button class="w-100 btn btn-lg btn-danger my-2" type="button" data-bs-toggle="modal" data-bs-target="#withoutNetwork">
              CONTINUE WITHOUT NETWORK
            </button>
            <div class="modal fade" id="withoutNetwork" tabindex="-1" aria-labelledby="withoutNetworkLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="withoutNetworkLabel">ARE YOU SURE?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">YOU CANNOT UNDO THIS ACTION!</div>
                  <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">NO</button>
                    <button class="btn btn-danger" type="submit" name="apply" value="apply" onClick="submitButton('nonetwork.php')">YES</button>
                  </div>
                </div>
              </div>
            </div>
			    </form>
				</div>
			</div>
		</div>
    <script src="js/bootstrap.bundle.min.js"></script>
		<script src="js/jquery.slim.min.js"></script>
    <script src="js/pushstream.js" type="text/javascript" language="javascript" charset="utf-8"></script>
    <script type="text/javascript" language="javascript" charset="utf-8">
			function wifidhcp_checked() {
        if ($('.wifidhcp').is(":checked")) {
          $(".wifistatic_ip").hide();
        } else {
          $(".wifistatic_ip").show();
        }
      };
      function dhcp_checked() {
        if ($('.dhcp').is(":checked")) {
          $(".static_ip").hide();
        } else {
          $(".static_ip").show();
        }
      };
      window.onload = function() {
        wifidhcp_checked();
        dhcp_checked();
      };
      function fillwifi(wifissid, wifipassword) {
        var wifissid = wifissid;
        var wifipassword = wifipassword;
        document.getElementById("ssid").value = wifissid;
//        document.getElementById("password").value = wifipassword;
      };
      // <![CDATA[
      function messageReceived(text, id, channel) {
        document.getElementById('messages').innerHTML += id + ': ' + text + '<br>';
      };
      var pushstream = new PushStream({
        host: window.location.hostname,
        port: window.location.port,
        modes: "eventsource"
      });
      pushstream.onmessage = messageReceived;
      pushstream.addChannel('ch1');
      pushstream.connect();
      // ]]>
    </script>
  </body>
</html>
<!--# endif -->
