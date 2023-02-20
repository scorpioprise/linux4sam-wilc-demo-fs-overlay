<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$id = $_SESSION["id"];
$auth = $_SESSION["auth"];
$firstlogin = $_SESSION["firstlogin"];
if ($firstlogin == 1) {
    header("location: change_password.php");
    exit;
}
require_once "inc/config.php";
if (trovaLingua() == 'it') {
    include "inc/l_it.php";
    $logo = 'logo_menu.png';
} else if (trovaLingua() == 'en') {
    include "inc/l_en.php";
    $logo = 'logo_menu.png';
} else if (trovaLingua() == 'ru') {
    include "inc/l_ru.php";
    $logo = 'logo_menu_dkc.png';
} else if (trovaLingua() == 'userruen') {
    include "inc/l_ru.php";
    $logo = 'logo_menu_dkc.png';
} else if (trovaLingua() == 'userenru') {
    include "inc/l_en-ru.php";
    $logo = 'logo_menu_dkc.png';
}
if (isset($_POST['applyNetwork'])) {
    sleep(2);
    $args = '';
    foreach ($_POST as $k => $v) $args = $args . " $k='$v'";
    echo "<!DOCTYPE html><html lang='it'><head><title>" . _TITLENETWORKREBOOT . "</title><meta charset='utf-8' /><meta content='IE=edge' http-equiv='X-UA-Compatible' /><meta content='width=device-width, initial-scale=1' name='viewport' />
<link href='css/bootstrap.min.css' rel='stylesheet'><link href='css/signin.css' rel='stylesheet'><link href='favicon.ico' rel='icon' type='image/x-icon' />
<link href='favicon.png' rel='icon' type='image/png' /></head><body class='text-center text-white'><div class='container-fluid'><div class='row justify-content-center'><div class='col-12 col-md-6 my-5'>
<img src='img/dkcenergyportal.png'><h3 class='display-6 my-5'>" . _NETWORKREBOOTING . "</h3><div class='spinner-border text-danger' role='status'><span class='visually-hidden'>" . _NETWORKREBOOTINGMESSAGE1 . "</span></div>
<p class='mt-5'>" . _NETWORKREBOOTINGMESSAGE2 . "</p><p class='text-dkc'>" . _NETWORKREBOOTINGMESSAGE3 . "</p></div></div></div></body></html>";
    $response = exec('issue_command 9008' . $args);
    die;
    if ($response == 'RESPONSE_MESSAGE_FAILED') {
        $response_toast = '<div class="toast align-items-center fade show bg-danger fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDKO . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_OK') {
        $response_toast = '<div class="toast align-items-center fade show bg-info fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDOK . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_TODO') {
        $response_toast = '<div class="toast align-items-center fade show bg-secondary text-white fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDNOTAVAILABLE . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'SKIP SERIAL') {
        $response_toast = '<div class="toast align-items-center fade show bg-info fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDSKIPSERIAL . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } else {
        $response_toast = '<div class="toast align-items-center fade show bg-warning fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDERROR . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    }
}
if (isset($_POST['applyNoNetwork'])) {
    sleep(2);
    echo "<!DOCTYPE html><html lang='it'><head><title>" . _TITLENETWORKREBOOT . "</title><meta charset='utf-8' /><meta content='IE=edge' http-equiv='X-UA-Compatible' /><meta content='width=device-width, initial-scale=1' name='viewport' />
		<link href='css/bootstrap.min.css' rel='stylesheet'><link href='css/signin.css' rel='stylesheet'><link href='favicon.ico' rel='icon' type='image/x-icon' />
		<link href='favicon.png' rel='icon' type='image/png' /></head><body class='text-center text-white'><div class='container-fluid'><div class='row justify-content-center'><div class='col-12 col-md-6 my-5'>
		<img src='img/dkcenergyportal.png'><h3 class='display-6 my-5'>" . _NETWORKREBOOTING . "</h3><div class='spinner-border text-danger' role='status'><span class='visually-hidden'>" . _NETWORKREBOOTINGMESSAGE1 . "</span></div>
		<p class='mt-5'>" . _NETWORKREBOOTINGMESSAGE4 . "</p><p class='text-muted'>" . _NETWORKREBOOTINGMESSAGE5 . "</p></div></div></div></body></html>";
    $response = exec("issue_command 9008 ssid='' pass='' wifidhcp='' wifiipaddress='' wifinetmask='' wifigateway='' wifidns='' dhcp='' ipaddress='' netmask='' gateway='' dns='' applyNoNetwork='apply'");
    die;
    if ($response == 'RESPONSE_MESSAGE_FAILED') {
        $response_toast = '<div class="toast align-items-center fade show bg-danger fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
            ' . _TOASTCOMMANDKO . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_OK') {
        $response_toast = '<div class="toast align-items-center fade show bg-info fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
            ' . _TOASTCOMMANDOK . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_TODO') {
        $response_toast = '<div class="toast align-items-center fade show bg-secondary text-white fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
            ' . _TOASTCOMMANDNOTAVAILABLE . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'SKIP SERIAL') {
        $response_toast = '<div class="toast align-items-center fade show bg-info fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
            ' . _TOASTCOMMANDSKIPSERIAL . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } else {
        $response_toast = '<div class="toast align-items-center fade show bg-warning fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
            ' . _TOASTCOMMANDERROR . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    }
}
// 0=admin 1=installer 2=user
if ($auth == 0) {
    $utente = 'admin';
} elseif ($auth == 1) {
    $utente = 'installer';
} else {
    $utente = 'user';
}
?>
<!--# if expr="$internetenabled=false" -->
<!--# include file="session.php" -->
<!--# include file="index_provisioning.php" -->
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
            <img src="img/<?php echo $logo ?>" width="164" height="50">
        </span>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        </button>
        <div class="dropdown me-2">
            <button type="button" class="btn btn-sm dropdown-toggle" style="background-color:#d91a15; color:#fff;" id="dropdownUser" data-bs-toggle="dropdown" data-toggle="tooltip" data-bs-placement="left" title="<?php echo htmlspecialchars($utente); ?>">
                <img src="img/ico_user.png" class="me-3">
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="index_dashboard.php"><?= _MENUHOME ?></a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-primary" href="logout.php"><?= _MENULOGOUT ?></a></li>
            </ul>
        </div>
    </header>
    <!-- ################################# INIZIO MENU DESKTOP ################################################ -->
    <nav role="navigation" class="d-none col-md-3 col-lg-2 d-md-block bg-dkcenergy sidebar dkc-laterale">
        <div class="position-sticky pt-3">
            <div class="nav flex-column me-3">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-dkcenergy">
                        <h5 class="fw-bolder" style="color:#b0b0b0;">
                            <img src="img/ico_overview.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            <?= _MENUOVERVIEW ?>
                        </h5>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="index_dashboard.php">
                                <img src="img/ico_wallbox.png" width="25px" class="me-3">
                                <?= _MENUECHARGER ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="telemetry.php">
                                <img src="img/ico_telemetria.png" width="25px" class="me-3">
                                <?= _MENUTELEMETRY ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="cards.php">
                                <img src="img/ico_card.png" width="25px" class="me-3">
                                <?= _MENURFIDCARDS ?>
                            </a>
                        </div>
                    </li>
                    <hr class="border border-secondary border-1 opacity-75 ms-2">
                    <li class="list-group-item bg-dkcenergy">
                        <h5 class="fw-bolder" style="color:#b0b0b0;">
                            <img src="img/ico_statistiche.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            <?= _MENUSTATISTICS ?>
                        </h5>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="transactions.php">
                                <img src="img/ico_transazioni.png" width="25px" class="me-3">
                                <?= _MENUTRANSACTIONS ?>
                            </a>
                        </div>
                    </li>
                    <hr class="border border-secondary border-1 opacity-75 ms-2">
                    <li class="list-group-item bg-dkcenergy">
                        <h5 class="fw-bolder" style="color:#b0b0b0;">
                            <img src="img/ico_settings.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            <?= _MENUSETTINGS ?>
                        </h5>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="commands.php">
                                <img src="img/ico_comandi.png" width="25px" class="me-3">
                                <?= _MENUCOMMANDS ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="configurations.php">
                                <img src="img/ico_configurazioni.png" width="25px" class="me-3">
                                <?= _MENUCONFIGURATIONS ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="errors.php">
                                <img src="img/ico_errori.png" width="25px" class="me-3">
                                <?= _MENUERRORS ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="network.php" class="dkc-selected">
                                <img src="img/ico_network.png" width="25px" class="me-3">
                                <?= _MENUNETWORK ?>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- ################################# FINE MENU DESKTOP ################################################ -->
    <!-- ################################# INIZIO MENU MOBILE ################################################ -->
    <div class="offcanvas offcanvas-start" style="background-color: #0e1b35" tabindex="-1" id="offcanvasFunzioni" aria-labelledby="offcanvasFunzioniLabel" data-bs-toggle="offcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasFunzioniLabel"><img src="img/logo_menu.png" width="130" height="40"></h5>
        </div>
        <div class="row ms-1 mt-3 text-white flex-nowrap">
            <div class="col-8">
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_overview.png" width="35px" class="me-2" style="font-size:1.35em;" alt=""><?= _MENUOVERVIEW ?></h5>
            </div>
            <div class="col-2 text-nowrap" style="font-size:12px">
                <b><?= _MENUCLOSE ?> </b><button type="button" class="btn-close btn-close-white text-reset my-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="index_dashboard.php">
                            <img src="img/ico_wallbox.png" width="25px" class="me-3">
                            <?= _MENUECHARGER ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="telemetry.php">
                            <img src="img/ico_telemetria.png" width="25px" class="me-3">
                            <?= _MENUTELEMETRY ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="cards.php">
                            <img src="img/ico_card.png" width="25px" class="me-3">
                            <?= _MENURFIDCARDS ?>
                        </a>
                    </h4>
                </li>
            </ul>
        </div>
    </div>
    <div class="offcanvas offcanvas-start" style="background-color: #0e1b35" tabindex="-1" id="offcanvasStatistiche" aria-labelledby="offcanvasStatisticheLabel" data-bs-toggle="offcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasStatisticheLabel"><img src="img/logo_menu.png" width="130" height="40"></h5>
        </div>
        <div class="row ms-1 mt-3 text-white flex-nowrap">
            <div class="col-8">
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_statistiche.png" width="35px" class="me-2" style="font-size:1.35em;" alt=""><?= _MENUSTATISTICS ?></h5>
            </div>
            <div class="col-2 text-nowrap" style="font-size:12px">
                <b><?= _MENUCLOSE ?> </b><button type="button" class="btn-close btn-close-white text-reset my-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="transactions.php">
                            <img src="img/ico_transazioni.png" width="25px" class="me-3">
                            <?= _MENUTRANSACTIONS ?>
                        </a>
                    </h4>
                </li>
            </ul>
        </div>
    </div>
    <div class="offcanvas offcanvas-start" style="background-color: #0e1b35" tabindex="-1" id="offcanvasConfigurazione" aria-labelledby="offcanvasConfigurazioneLabel" data-bs-toggle="offcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasConfigurazioneLabel"><img src="img/logo_menu.png" width="130" height="40"></h5>
        </div>
        <div class="row ms-1 mt-3 text-white flex-nowrap">
            <div class="col-8">
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_settings.png" width="35px" class="me-2" style="font-size:1.35em;" alt=""><?= _MENUSETTINGS ?></h5>
            </div>
            <div class="col-2 text-nowrap" style="font-size:12px">
                <b><?= _MENUCLOSE ?> </b><button type="button" class="btn-close btn-close-white text-reset my-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="commands.php">
                            <img src="img/ico_comandi.png" width="25px" class="me-3">
                            <?= _MENUCOMMANDS ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="configurations.php">
                            <img src="img/ico_configurazioni.png" width="25px" class="me-3">
                            <?= _MENUCONFIGURATIONS ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="errors.php">
                            <img src="img/ico_errori.png" width="25px" class="me-3">
                            <?= _MENUERRORS ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="network.php" class="dkc-selected">
                            <img src="img/ico_network.png" width="25px" class="me-3">
                            <?= _MENUNETWORK ?>
                        </a>
                    </h4>
                </li>
            </ul>
        </div>
    </div>
    <div class="smartphone-padding d-none d-md-block"></div>
    <!-- ################################# FINE MENU MOBILE ################################################ -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5">
        <div class="container-fluid">
            <!-- ################################# INIZIO PAGINA ################################################ -->
            <div class="row">
                <div class="justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <div class="d-flex align-items-justify">
                        <div class="col d-flex align-items-start">
                            <img src="img/icon_title.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            <h3 class="bold text-dkc"><?= _HEADNETWORK . '&nbsp;' ?></h3>
                            <img id="iconaInternet" src="img/offlineLight.png">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row py-2 ms-0">
                <div class="col-7 col-md-6 col-lg-4 d-flex align-items-center me-lg-1 mb-lg-0 mb-1 text-break rounded-4 bg-grigiochiaro" style="min-height: 80px;">
                    <div class="icon-square flex-shrink-0 mt-1 me-3">
                        <img src="img/ico_network_grande.png">
                    </div>
                    <div>
                        <h6 class="fw-bold mt-3"><?= _MENUECHARGER ?> <span class="text-dkc"><?= $_SESSION["macaddress"] ?></span></h6>
                    </div>
                </div>
            </div>
            <!-- /////////////////////////////////////// PROVISIONING ////////////////////////////////////////////////////////// -->
            <div class="row py-3 ms-0 rounded-4 shadow">
                <form name="network" id="network" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="row ms-0 me-1">
                        <div class="col-lg-4 mt-1 rounded-4 bg-wifi py-3">
                            <h3 class="fw-bold"><?= _PROVISIONINGWIFI ?></h3>
                            <div class="mb-3">
                                <label for="ssid" class="form-label"><?= _PROVISIONINGSSIDNAME ?></label>
                                <input type="text" class="form-control form-control-sm" name="ssid" id="ssid" maxlength="32" value=<!--# echo var="ssid" default="" --> >
                            </div>
                            <div class="mb-3">
                                <label for="pass" class="form-label"><?= _PROVISIONINGPASSWORD ?></label>
                                <input type="password" class="form-control form-control-sm" name="pass" maxlength="64" value=<!--# echo var="pass" default="" --> >
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" name="wifidhcp" id="wifidhcp" class="wifidhcp form-check-input" maxlength="64" onchange="wifidhcp_checked()" <!--# echo var="wifidhcp" -->>
                                <label class="form-check-label" for="wifidhcp"><?= _PROVISIONINGWIFIDHCP ?></label>
                            </div>
                            <div class="wifistatic_ip mb-3">
                                <div class="mb-3">
                                    <label for="wifiipaddress" class="form-label"><?= _PROVISIONINGWIFISTATICIP ?></label>
                                    <input type="text" class="form-control form-control-sm" name="wifiipaddress" maxlength="64" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" value=<!--# echo var="wifiipaddress" default="" --> >
                                </div>
                                <div class="mb-3">
                                    <label for="wifinetmask" class="form-label"><?= _PROVISIONINGWIFINETMASK ?></label>
                                    <input type="text" class="form-control form-control-sm" name="wifinetmask" maxlength="64" pattern="^(((255\.){3}(255|254|252|248|240|224|192|128|0+))|((255\.){2}(255|254|252|248|240|224|192|128|0+)\.0)|((255\.)(255|254|252|248|240|224|192|128|0+)(\.0+){2})|((255|254|252|248|240|224|192|128|0+)(\.0+){3}))$" value=<!--# echo var="wifinetmask" default="" --> >
                                </div>
                                <div class="mb-3">
                                    <label for="wifigateway" class="form-label"><?= _PROVISIONINGWIFIGATEWAY ?></label>
                                    <input type="text" class="form-control form-control-sm" name="wifigateway" maxlength="64" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" value=<!--# echo var="wifigateway" default="" --> >
                                </div>
                                <div class="mb-3">
                                    <label for="wifidns" class="form-label"><?= _PROVISIONINGWIFIDNS ?></label>
                                    <input type="text" class="form-control form-control-sm" name="wifidns" maxlength="64" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" value=<!--# echo var="wifidns" default="" --> >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ms-0 mt-3 me-1">
                        <div class="col-lg-4 mt-1 rounded-4 bg-lan py-3">
                            <h3 class="fw-bold"><?= _PROVISIONINGNETWORK ?></h3>
                            <div class="form-check mb-3">
                                <input type="checkbox" name="dhcp" id="dhcp" class="dhcp form-check-input" maxlength="64" onchange="dhcp_checked()" <!--# echo var="dhcp" -->>
                                <label class="form-check-label" for="dhcp"><?= _PROVISIONINGNETWORKDHCP ?></label>
                            </div>
                            <div class="static_ip mb-3">
                                <div class="mb-3">
                                    <label for="ipaddress" class="form-label"><?= _PROVISIONINGNETWORKSTATICIP ?></label>
                                    <input type="text" class="form-control form-control-sm" name="ipaddress" maxlength="64" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" value=<!--# echo var="ipaddress" default="" --> >
                                </div>
                                <div class="mb-3">
                                    <label for="netmask" class="form-label"><?= _PROVISIONINGNETWORKNETMASK ?></label>
                                    <input type="text" class="form-control form-control-sm" name="netmask" maxlength="64" value=<!--# echo var="netmask" default="" --> >
                                </div>
                                <div class="mb-3">
                                    <label for="gateway" class="form-label"><?= _PROVISIONINGNETWORKGATEWAY ?></label>
                                    <input type="text" class="form-control form-control-sm" name="gateway" maxlength="64" value=<!--# echo var="gateway" default="" --> >
                                </div>
                                <div class="mb-3">
                                    <label for="dns" class="form-label"><?= _PROVISIONINGNETWORKDNS ?></label>
                                    <input type="text" class="form-control form-control-sm" name="dns" maxlength="64" value=<!--# echo var="dns" default="" --> >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 me-1">
                        <div class="col-lg-4">
                            <button class="btn btn-custom rounded-5 w-100" type="submit" name="applyNetwork" id="applyNetwork" value="apply" onclick="checkOne(this.id)"><?= _PROVISIONINGAPPLY ?></button>
                        </div>
                        <button class="w-100 btn btn-primary d-none"></button>
                    </div>
                    <!-- ############################################## CONTINUE WITHOUT NETWORK ############################################## -->
                    <div class="row mt-4 me-1">
                        <div class="col-lg-4">
                            <button class="btn btn-custom-rosso rounded-5 w-100" type="button" data-bs-toggle="modal" data-bs-target="#withoutNetwork"><?= _PROVISIONINGNONETWORK ?></button>
                        </div>
                        <div class="modal fade" id="withoutNetwork" tabindex="-1" aria-labelledby="withoutNetworkLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="withoutNetworkLabel"><?= _MODALNETWORK ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body"><?= _MODALWARNING ?></div>
                                    <h6 class="modal-body text-center text-danger"><b><?= _MODALMESSAGEROW1 ?><br><br><?= _MODALMESSAGEROW2 ?></b></h6>
                                    <div class="modal-footer btn-group">
                                        <button class="btn btn-custom-grigio" type="button" data-bs-dismiss="modal"><?= _MODALNO ?></button>
                                        <button class="btn btn-custom-rosso" type="submit" name="applyNoNetwork" id="applyNoNetwork" value="apply"><?= _MODALYES ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
        </div>
    </main>
    <!-- ################################# INIZIO MENU FOOTER MOBILE ################################################ -->
    <footer class="footer d-md-none">
        <div class="container">
            <div class="row text-center">
                <div class="col text-white">
                    <img src="img/ico_overview.png" width="25px" class="me-2" alt="" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFunzioni" aria-controls="offcanvasFunzioni">
                </div>
                <div class="col text-white">
                    <img src="img/ico_statistiche.png" width="25px" class="me-2" alt="" data-bs-toggle="offcanvas" data-bs-target="#offcanvasStatistiche" aria-controls="offcanvasStatistiche">
                </div>
                <div class="col text-white">
                    <img src="img/ico_settings.png" width="25px" class="me-2" alt="" data-bs-toggle="offcanvas" data-bs-target="#offcanvasConfigurazione" aria-controls="offcanvasConfigurazione">
                </div>
            </div>
        </div>
    </footer>
    <!-- ################################# FINE MENU FOOTER MOBILE ################################################ -->
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
        //############################################## TOOLTIP ##############################################
        $(document).ready(function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
        var URL = 'https://data.madein.it/ping';
        var settings = {
            cache: false,
            dataType: "jsonp",
            async: true,
            crossDomain: true,
            url: URL,
            method: "GET",
            headers: {
                accept: "application/json",
                "Access-Control-Allow-Origin": "*",
            },
            statusCode: {
                200: function(response) {
                    document.getElementById("iconaInternet").src = 'img/onlineLight.png';
                },
                400: function(response) {
                    document.getElementById("iconaInternet").src = 'img/offlineLight.png';
                },
                0: function(response) {
                    document.getElementById("iconaInternet").src = 'img/offlineLight.png';
                },
            },
        };
        $.ajax(settings).done(function(response) {
            //					console.log(response);
        });
        setTimeout(() => {
            $('.toast').toast('hide');
        }, 4000);
    </script>
</body>

</html>
<!--# endif -->