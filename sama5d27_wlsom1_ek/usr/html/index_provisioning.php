<?php
if (isset($_POST['linguaIt'])) {
    include "inc/config.php";
    $sql = "UPDATE `configuration` SET `value` = 'it_IT' WHERE `name` = 'language'";
    if ($stmt = mysqli_prepare($link, $sql)) {
        if (mysqli_stmt_execute($stmt)) {
            $result = $stmt->get_result();
            $nrows = 0;
            if ($nrows == 0) {
            }
        } else {
            echo "Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
    include "inc/l_it.php";
} else if (isset($_POST['linguaEn'])) {
    $sql = "UPDATE `configuration` SET `value` = 'en_EN' WHERE `name` = 'language'";
    include "inc/config.php";
    if ($stmt = mysqli_prepare($link, $sql)) {
        if (mysqli_stmt_execute($stmt)) {
            $result = $stmt->get_result();
            $nrows = 0;
            if ($nrows == 0) {
            }
        } else {
            echo "Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
    include "inc/l_en.php";
} else if (isset($_POST['linguaRu'])) {
    $sql = "UPDATE `configuration` SET `value` = 'ru_RU' WHERE `name` = 'language'";
    include "inc/config.php";
    if ($stmt = mysqli_prepare($link, $sql)) {
        if (mysqli_stmt_execute($stmt)) {
            $result = $stmt->get_result();
            $nrows = 0;
            if ($nrows == 0) {
            }
        } else {
            echo "Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
    include "inc/l_ru.php";
} else if (isset($_POST['linguaRuEn'])) {
    $sql = "UPDATE `configuration` SET `value` = 'user_RU-EN' WHERE `name` = 'language'";
    include "inc/config.php";
    if ($stmt = mysqli_prepare($link, $sql)) {
        if (mysqli_stmt_execute($stmt)) {
            $result = $stmt->get_result();
            $nrows = 0;
            if ($nrows == 0) {
            }
        } else {
            echo "Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
    include "inc/l_ru.php";
} else if (isset($_POST['linguaEnRu'])) {
    $sql = "UPDATE `configuration` SET `value` = 'user_EN-RU' WHERE `name` = 'language'";
    include "inc/config.php";
    if ($stmt = mysqli_prepare($link, $sql)) {
        if (mysqli_stmt_execute($stmt)) {
            $result = $stmt->get_result();
            $nrows = 0;
            if ($nrows == 0) {
            }
        } else {
            echo "Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
    include "inc/l_en-ru.php";
}
require_once "inc/config.php";
if (trovaLingua() == 'it') {
    include "inc/l_it.php";
    $mostra_lingua = '<button class="btn" name="linguaIt" type="submit">IT</button><div class="vr"></div><button class="btn" name="linguaEn" type="submit">EN</button>';
    $logo = 'logo_menu.png';
    $logocontinue = 'dkcenergyportal.png';
} else if (trovaLingua() == 'en') {
    include "inc/l_en.php";
    $mostra_lingua = '<button class="btn" name="linguaIt" type="submit">IT</button><div class="vr"></div><button class="btn" name="linguaEn" type="submit">EN</button>';
    $logo = 'logo_menu.png';
    $logocontinue = 'dkcenergyportal.png';
} else if (trovaLingua() == 'ru') {
    include "inc/l_ru.php";
    $mostra_lingua = '<button class="btn" name="linguaRuEn" type="submit">RU</button><div class="vr"></div><button class="btn" name="linguaEnRu" type="submit">EN</button>';
    $logo = 'logo_menu_dkc.png';
    $logocontinue = 'dkc.png';
} else if (trovaLingua() == 'userruen') {
    include "inc/l_ru.php";
    $mostra_lingua = '<button class="btn" name="linguaRuEn" type="submit">RU</button><div class="vr"></div><button class="btn" name="linguaEnRu" type="submit">EN</button>';
    $logo = 'logo_menu_dkc.png';
    $logocontinue = 'dkc.png';
} else if (trovaLingua() == 'userenru') {
    include "inc/l_en-ru.php";
    $mostra_lingua = '<button class="btn" name="linguaRuEn" type="submit">RU</button><div class="vr"></div><button class="btn" name="linguaEnRu" type="submit">EN</button>';
    $logo = 'logo_menu_dkc.png';
    $logocontinue = 'dkc.png';
}
if (isset($_POST['applyNetwork'])) {
    $args = '';
    foreach ($_POST as $k => $v) $args = $args . " $k='$v'";
    echo "<!DOCTYPE html><html lang='it'><head><title>" . _TITLENETWORKREBOOT . "</title><meta charset='utf-8' /><meta content='IE=edge' http-equiv='X-UA-Compatible' /><meta content='width=device-width, initial-scale=1' name='viewport' />
<link href='css/bootstrap.min.css' rel='stylesheet'><link href='css/logged.css' rel='stylesheet'><link href='favicon.ico' rel='icon' type='image/x-icon' />
<link href='favicon.png' rel='icon' type='image/png' /></head><body class='text-center text-white bg-dkcenergy'><div class='container-fluid'><div class='row justify-content-center'><div class='col-12 col-md-6 my-5'>
<img src='img/". $logocontinue ."'><h3 class='display-6 my-5'>" . _NETWORKREBOOTING . "</h3><div class='spinner-border text-danger' role='status'><span class='visually-hidden'>" . _NETWORKREBOOTINGMESSAGE1 . "</span></div>
<p class='mt-5'>" . _NETWORKREBOOTINGMESSAGE2 . "</p><p class='text-dkc'>" . _NETWORKREBOOTINGMESSAGE3 . "</p></div></div></div></body></html>";
    $response = exec('issue_command 9008' . $args);
    die;
    if ($response == 'RESPONSE_MESSAGE_FAILED') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-ko fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDKO . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_OK') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-ok fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDOK . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_TODO') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-kk fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDNOTAVAILABLE . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'SKIP SERIAL') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-ok fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDSKIPSERIAL . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_NOT_APPLICABLE') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-kk fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDNOUPDATE . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } else {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-kk fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDERROR . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    }
}
if (isset($_POST['applyNoNetwork'])) {
    echo "<!DOCTYPE html><html lang='it'><head><title>" . _TITLENETWORKREBOOT . "</title><meta charset='utf-8' /><meta content='IE=edge' http-equiv='X-UA-Compatible' /><meta content='width=device-width, initial-scale=1' name='viewport' />
		<link href='css/bootstrap.min.css' rel='stylesheet'><link href='css/logged.css' rel='stylesheet'><link href='favicon.ico' rel='icon' type='image/x-icon' />
		<link href='favicon.png' rel='icon' type='image/png' /></head><body class='text-center text-white bg-dkcenergy'><div class='container-fluid'><div class='row justify-content-center'><div class='col-12 col-md-6 my-5'>
		<img src='img/". $logocontinue ."'><h3 class='display-6 my-5'>" . _NETWORKREBOOTING . "</h3><div class='spinner-border text-danger' role='status'><span class='visually-hidden'>" . _NETWORKREBOOTINGMESSAGE1 . "</span></div>
		<p class='mt-5'>" . _NETWORKREBOOTINGMESSAGE4 . "</p><p class='text-muted'>" . _NETWORKREBOOTINGMESSAGE5 . "</p></div></div></div></body></html>";
    $response = exec("issue_command 9008 ssid='' pass='' wifidhcp='' wifiipaddress='' wifinetmask='' wifigateway='' wifidns='' dhcp='' ipaddress='' netmask='' gateway='' dns='' applyNoNetwork='apply'");
    die;
    if ($response == 'RESPONSE_MESSAGE_FAILED') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-ko fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDKO . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_OK') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-ok fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDOK . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_TODO') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-kk fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDNOTAVAILABLE . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'SKIP SERIAL') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-ok fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDSKIPSERIAL . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_NOT_APPLICABLE') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-kk fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDNOUPDATE . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } else {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-kk fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDERROR . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    }
}
?>
<!--# if expr="$internetenabled=true" -->
<!--# include file="session.php" -->
<!--# include file="login.php" -->
<!--# else -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= _TITLENETWORK ?></title>
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
            <img class="ms-2" src="img/<?php echo $logo ?>" width="164" height="50">
        </span>
    </header>

    <div class="container-fluid">
        <div class="row ms-0 me-1 mt-2">
            <div class="col-md-6 d-flex justify-content-between align-items-center text-break rounded-4 bg-grigiochiaro" style="min-height: 80px;">
                <div class="icon-square flex-shrink-0 mt-1 me-3">
                    <img src="img/ico_network_grande.png">
                    <img class="d-none" src='img/dkc.png'>
                    <img class="d-none" src='img/dkcenergyportal.png'>
                </div>
                <form class="float-end" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="fw-bold mt-3 text-decoration-none">
                        <img src="img/ico_tr_language.png">
                        <?php echo $mostra_lingua ?>
                    </div>
                </form>
            </div>
        </div>

        <form name="network" id="network" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row ms-0 me-1">
                <div class="col-md-6 mt-3 rounded-4 bg-wifi py-4">
                    <h3 class="display-6"><?= _PROVISIONINGWIFI ?></h3>
                    <div class="mb-3">
                        <label for="ssid" class="form-label"><?= _PROVISIONINGSSIDNAME ?></label>
                        <input type="text" class="form-control" name="ssid" id="ssid" maxlength="32" value=<!--# echo var="ssid" default="" --> >
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label"><?= _PROVISIONINGPASSWORD ?></label>
                        <input type="password" class="form-control" name="pass" maxlength="64" value=<!--# echo var="pass" default="" --> >
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="wifidhcp" id="wifidhcp" class="wifidhcp form-check-input" maxlength="64" onchange="wifidhcp_checked()" <!--# echo var="wifidhcp" -->>
                        <label class="form-check-label" for="wifidhcp"><?= _PROVISIONINGWIFIDHCP ?></label>
                    </div>
                    <div class="wifistatic_ip mb-3">
                        <div class="mb-3">
                            <label for="wifiipaddress" class="form-label"><?= _PROVISIONINGWIFISTATICIP ?></label>
                            <input type="text" class="form-control" name="wifiipaddress" maxlength="64" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" value=<!--# echo var="wifiipaddress" default="" --> >
                        </div>
                        <div class="mb-3">
                            <label for="wifinetmask" class="form-label"><?= _PROVISIONINGWIFINETMASK ?></label>
                            <input type="text" class="form-control" name="wifinetmask" maxlength="64" value=<!--# echo var="wifinetmask" default="" --> >
                        </div>
                        <div class="mb-3">
                            <label for="wifigateway" class="form-label"><?= _PROVISIONINGWIFIGATEWAY ?></label>
                            <input type="text" class="form-control" name="wifigateway" maxlength="64" value=<!--# echo var="wifigateway" default="" --> >
                        </div>
                        <div class="mb-3">
                            <label for="wifidns" class="form-label"><?= _PROVISIONINGWIFIDNS ?></label>
                            <input type="text" class="form-control" name="wifidns" maxlength="64" value=<!--# echo var="wifidns" default="" --> >
                        </div>
                    </div>
                    <!-- ############################################## SCAN RESULT ##############################################-->
                    <div id="scanresult" class="mb-3" style="display:none;">
                        <div class="list-group">
                            <div class="list-group-item list-group-item-action bg-warning fw-bold"><?= _SELECTWIFINETWORK ?></div>
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
                    <div class="me-4">
                        <input type="button" class="btn btn-custom-giallo rounded-5 w-100" name="scan" value="<?= _FINDWIFINETWORK ?>" onClick="scanDiv()">
                    </div>
                </div>
            </div>
            <div class="row ms-0 me-1">
                <div class="col-md-6 mt-4 rounded-4 bg-lan py-4">
                    <h3 class="display-6"><?= _PROVISIONINGNETWORK ?></h3>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="dhcp" id="dhcp" class="dhcp form-check-input" maxlength="64" onchange="dhcp_checked()" <!--# echo var="dhcp" -->>
                        <label class="form-check-label" for="dhcp"><?= _PROVISIONINGNETWORKDHCP ?></label>
                    </div>
                    <div class="static_ip mb-3">
                        <div class="mb-3">
                            <label for="ipaddress" class="form-label"><?= _PROVISIONINGNETWORKSTATICIP ?></label>
                            <input type="text" class="form-control" name="ipaddress" maxlength="64" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" value=<!--# echo var="ipaddress" default="" --> >
                        </div>
                        <div class="mb-3">
                            <label for="netmask" class="form-label"><?= _PROVISIONINGNETWORKNETMASK ?></label>
                            <input type="text" class="form-control" name="netmask" maxlength="64" value=<!--# echo var="netmask" default="" --> >
                        </div>
                        <div class="mb-3">
                            <label for="gateway" class="form-label"><?= _PROVISIONINGNETWORKGATEWAY ?></label>
                            <input type="text" class="form-control" name="gateway" maxlength="64" value=<!--# echo var="gateway" default="" --> >
                        </div>
                        <div class="mb-3">
                            <label for="dns" class="form-label"><?= _PROVISIONINGNETWORKDNS ?></label>
                            <input type="text" class="form-control" name="dns" maxlength="64" value=<!--# echo var="dns" default="" --> >
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 me-3">
                <div class="col-md-6">
                    <button class="btn btn-custom rounded-5 w-100" type="submit" name="applyNetwork" id="applyNetwork" value="apply" onclick="checkOne(this.id)"><?= _PROVISIONINGAPPLY ?></button>
                </div>
            </div>
            <!-- ############################################## CONTINUE WITHOUT NETWORK ############################################## -->
            <div class="row mt-4 me-3">
                <div class="col-md-6">
                    <button class="btn btn-custom-rosso rounded-5 w-100" type="button" data-bs-toggle="modal" data-bs-target="#withoutNetwork"><?= _PROVISIONINGNONETWORK ?></button>
                </div>
            </div>
            <div class="modal fade" id="withoutNetwork" tabindex="-1" aria-labelledby="withoutNetworkLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="withoutNetworkLabel"><?= _MODALNETWORK ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body"><?= _MODALWARNING ?></div>
                        <h6 class="modal-body text-center text-danger"><b><?= _MODALMESSAGEROW1 ?><br><br><?= _MODALMESSAGEROW2 ?><b></h6>
                        <div class="modal-footer btn-group">
                            <button class="btn btn-custom-grigio" type="button" data-bs-dismiss="modal"><?= _MODALNO ?></button>
                            <button class="btn btn-custom-rosso" type="submit" name="applyNoNetwork" id="applyNoNetwork" value="apply"><?= _MODALYES ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ################################# MODALE PER MISSING DETAILS ################################################ -->
            <div class="modal fade" id="missingDetails" tabindex="-1" aria-labelledby="missingDetails" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="missingDetails"><?= _MODALMISSINGDATA ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body"><?= _MODALMISSINGDATAMESSAGE ?></div>
                        <div class="modal-footer btn-group">
                            <button type="button" class="btn btn-custom-grigio" data-bs-dismiss="modal"><?= _MENUCLOSE ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
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
                    if (oneFilled) {} else {
                        e.preventDefault();
                        clicked_id = '';
                        $('#missingDetails').modal('show');
                    }
                } else {};
            });
        };
        setTimeout(() => {
            $('.toast').toast('hide');
        }, 4000);
    </script>
</body>

</html>
<!--# endif -->