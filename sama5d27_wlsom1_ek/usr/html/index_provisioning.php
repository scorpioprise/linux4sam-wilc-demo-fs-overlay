<?php
if (isset($_POST['applyNetwork'])) {
    $args = '';
    foreach ($_POST as $k => $v) $args = $args . " $k='$v'";
    $response = exec('issue_command 9008' . $args);
    echo $response;
    if ($response == 'RESPONSE_MESSAGE_FAILED') {
        $response_toast = '<div class="toast align-items-center fade show bg-danger fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ERRORE - COMANDO NON ESEGUITO</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_OK') {
        $response_toast = '<div class="toast align-items-center fade show bg-info fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        COMANDO ESEGUITO</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_TODO') {
        $response_toast = '<div class="toast align-items-center fade show bg-secondary text-white fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        COMANDO NON DISPONIBILE</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'SKIP SERIAL') {
        $response_toast = '<div class="toast align-items-center fade show bg-info fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        COMMAND ESEGUITO - SKIP SERIAL</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } else {
        $response_toast = '<div class="toast align-items-center fade show bg-warning fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ERRORE</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    }
}
if (isset($_POST['applyNoNetwork'])) {
    $response = exec("issue_command 9008 ssid='' pass='' wifidhcp='' wifiipaddress='' wifinetmask='' wifigateway='' wifidns='' dhcp='' ipaddress='' netmask='' gateway='' dns='' applyNoNetwork='apply'");
    echo $response;
    if ($response == 'RESPONSE_MESSAGE_FAILED') {
        $response_toast = '<div class="toast align-items-center fade show bg-danger fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ERRORE - COMANDO NON ESEGUITO</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_OK') {
        $response_toast = '<div class="toast align-items-center fade show bg-info fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        COMANDO ESEGUITO</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_TODO') {
        $response_toast = '<div class="toast align-items-center fade show bg-secondary text-white fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        COMANDO NON DISPONIBILE</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'SKIP SERIAL') {
        $response_toast = '<div class="toast align-items-center fade show bg-info fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        COMMAND ESEGUITO - SKIP SERIAL</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } else {
        $response_toast = '<div class="toast align-items-center fade show bg-warning fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ERRORE</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    }
}
?>
<!--# if expr="$internetenabled=true" -->
<!--# include file="session.php" -->
<!--# include file="login.php" -->
<!--# else -->
<!DOCTYPE html>
<html lang="it">

<head>
    <title>DKC E.CHARGER | IMPOSTAZIONI RETE</title>
    <meta charset="utf-8" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/logged.css" rel="stylesheet" type="text/css" />
    <link href="favicon.ico" rel="icon" type="image/x-icon" />
    <link href="favicon.png" rel="icon" type="image/png" />
</head>

<body>
    <header class="navbar sticky-top bg-dkcenergy flex-md-nowrap p-0 shadow">
        <span class="navbar-brand col-md-3 col-lg-2 me-0 px-1">
            <img src="img/logo_menu.png" width="164" height="50">
        </span>
    </header>

    <div class="container-fluid">

        <form name="network" id="network" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row mt-1 ms-2 me-1 rounded shadow-sm py-2 bg-wifi">
                <div class="col-md-6 me-5">
                    <h3 class="display-6">RETE WIRELESS</h3>
                    <div class="mb-3">
                        <label for="ssid" class="form-label">nome rete SSID</label>
                        <input type="text" class="form-control" name="ssid" id="ssid" maxlength="32" value=<!--# echo var="ssid" default="" --> >
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">password</label>
                        <input type="password" class="form-control" name="pass" maxlength="64" value=<!--# echo var="pass" default="" --> >
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="wifidhcp" id="wifidhcp" class="wifidhcp form-check-input" maxlength="64" onchange="wifidhcp_checked()" <!--# echo var="wifidhcp" -->>
                        <label class="form-check-label" for="wifidhcp">DHCP rete wireless</label>
                    </div>
                    <div class="wifistatic_ip mb-3">
                        <div class="mb-3">
                            <label for="wifiipaddress" class="form-label">indirizzo IP statico rete wireless</label>
                            <input type="text" class="form-control" name="wifiipaddress" maxlength="64" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" value=<!--# echo var="wifiipaddress" default="" --> >
                        </div>
                        <div class="mb-3">
                            <label for="wifinetmask" class="form-label">maschera sottorete - rete wireless</label>
                            <input type="text" class="form-control" name="wifinetmask" maxlength="64" value=<!--# echo var="wifinetmask" default="" --> >
                        </div>
                        <div class="mb-3">
                            <label for="wifigateway" class="form-label">gateway rete wireless</label>
                            <input type="text" class="form-control" name="wifigateway" maxlength="64" value=<!--# echo var="wifigateway" default="" --> >
                        </div>
                        <div class="mb-3">
                            <label for="wifidns" class="form-label">server DNS rete wireless</label>
                            <input type="text" class="form-control" name="wifidns" maxlength="64" value=<!--# echo var="wifidns" default="" --> >
                        </div>
                    </div>
                    <!-- ############################################## SCAN RESULT ##############################################-->
                    <div id="scanresult" class="mb-3" style="display:none;">
                        <div class="list-group">
                            <div class="list-group-item list-group-item-action text-info bg-dark">SCEGLI UNA RETE WIRELESS</div>
                            <input id="wifi1" type="button" class="list-group-item list-group-item-action" onclick="" value="">
                            <input id="wifi2" type="button" class="list-group-item list-group-item-action" onclick="" value="">
                            <input id="wifi3" type="button" class="list-group-item list-group-item-action" onclick="" value="">
                            <input id="wifi4" type="button" class="list-group-item list-group-item-action" onclick="" value="">
                            <input id="wifi5" type="button" class="list-group-item list-group-item-action" onclick="" value="">
                            <input id="wifi6" type="button" class="list-group-item list-group-item-action" onclick="" value="">
                            <input id="wifi7" type="button" class="list-group-item list-group-item-action" onclick="" value="">
                            <input id="wifi8" type="button" class="list-group-item list-group-item-action" onclick="" value="">
                        </div>
                    </div>
                    <div>
                        <input type="button" class="w-100 btn btn-lg btn-dark my-2" name="scan" value="trova reti wireless" onClick="scanDiv()">
                    </div>
                </div>
            </div>
            <hr class="my-2">
            <div class="row mt-1 ms-2 me-1 rounded shadow-sm py-2 bg-lan">
                <div class="col-md-6 me-5">
                    <h3 class="display-6">RETE</h3>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="dhcp" id="dhcp" class="dhcp form-check-input" maxlength="64" onchange="dhcp_checked()" <!--# echo var="dhcp" -->>
                        <label class="form-check-label" for="dhcp">DHCP</label>
                    </div>
                    <div class="static_ip mb-3">
                        <div class="mb-3">
                            <label for="ipaddress" class="form-label">indirizzo IP statico</label>
                            <input type="text" class="form-control" name="ipaddress" maxlength="64" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" value=<!--# echo var="ipaddress" default="" --> >
                        </div>
                        <div class="mb-3">
                            <label for="netmask" class="form-label">maschera sottorete</label>
                            <input type="text" class="form-control" name="netmask" maxlength="64" value=<!--# echo var="netmask" default="" --> >
                        </div>
                        <div class="mb-3">
                            <label for="gateway" class="form-label">gateway</label>
                            <input type="text" class="form-control" name="gateway" maxlength="64" value=<!--# echo var="gateway" default="" --> >
                        </div>
                        <div class="mb-3">
                            <label for="dns" class="form-label">server DNS</label>
                            <input type="text" class="form-control" name="dns" maxlength="64" value=<!--# echo var="dns" default="" --> >
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-2">
            <div class="row mt-1 ms-2 me-1 py-2">
                <div class="col-md-6 me-5">
                    <button class="w-100 btn btn-lg btn-primary my-2" type="submit" name="applyNetwork" id="applyNetwork" value="apply" onclick="checkOne(this.id)">applica</button>
                </div>
            </div>
            <!-- ############################################## CONTINUE WITHOUT NETWORKl ############################################## -->
            <hr class="my-2">
            <div class="row mt-1 ms-2 me-1 py-2">
                <div class="col-md-6 me-5">
                    <button class="w-100 btn btn-lg btn-danger my-2" type="button" data-bs-toggle="modal" data-bs-target="#withoutNetwork">
                        CONTINUA SENZA RETE
                    </button>
                </div>
            </div>
            <div class="modal fade" id="withoutNetwork" tabindex="-1" aria-labelledby="withoutNetworkLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="withoutNetworkLabel">CONTINUA SENZA CONFIGURARE LA RETE</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">SEI SICURO DI VOLER CONTINUARE SENZA RETE?</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">NO</button>
                            <button class="btn btn-danger" type="submit" name="applyNoNetwork" id="applyNoNetwork" value="apply">SI</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ################################# MODALE PER MISSING DETAILS ################################################ -->
            <div class="modal fade" id="missingDetails" tabindex="-1" aria-labelledby="missingDetails" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="missingDetails">DATI MANCANTI</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">COMPILA TUTTI I CAMPI NECESSARI!</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CHIUDI</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.slim.min.js"></script>
    <script src="js/pushstream.js" type="text/javascript" language="javascript" charset="utf-8"></script>
    <script type="text/javascript" language="javascript" charset="utf-8">
        //############################################## PUSHSTREAM ##############################################
        function messageReceived(text, id, channel) {
            if (channel == 'ch1') {
                const obj = JSON.parse(text);
                for (var key of Object.keys(obj)) {
                    var el = document.getElementById(key).value = obj[key];
                    var el = document.getElementById(key).setAttribute('onClick', "fillwifi('" + obj[key] + "')");
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
        pushstream.addChannel('ch1');
        pushstream.connect();
        //############################################## JS PER SUBMIT ##############################################
        function submitButton(act) {
            document.network.action = act;
            document.network.submit();
        };
        //############################################## JS PER DIV ##############################################
        function scanDiv() {
            var x = document.getElementById("scanresult");
            if (x.style.display === "none") {
                x.style.display = "block";
            }
        };
        //############################################## CHECK WIFI ##############################################
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
        //############################################## RIEMPI WIFI ##############################################
        function fillwifi(wifissid, wifipassword) {
            var wifissid = wifissid;
            var wifipassword = wifipassword;
            document.getElementById("ssid").value = wifissid;
        };
        //############################################## ALMENO 1 CAMPO FORM ##############################################
        function checkFields(form) {
            var checks_radios = form.find(':checkbox, :radio'),
                inputs = form.find(':input').not(checks_radios).not('[type="submit"],[type="button"],[type="reset"]');
            var checked = checks_radios.filter(':checked');
            var filled = inputs.filter(function() {
                return $.trim($(this).val()).length > 0;
            });
            if (checked.length + filled.length === 0) {
                return false;
            }
            return true;
        };

        function checkOne(clicked_id) {
            $('#network').on('submit', function(e) {
                if (clicked_id == 'applyNetwork') {
                    oneFilled = checkFields($(this));
                    if (oneFilled) {
                        //almeno 1 campo compilato
                    } else {
                        e.preventDefault();
                        clicked_id = '';
                        $('#missingDetails').modal('show');
                        //nessun campo compilato
                    }
                } else {
                    //NIENTE RETE
                };
            });
        };
    </script>
</body>

</html>
<!--# endif -->
