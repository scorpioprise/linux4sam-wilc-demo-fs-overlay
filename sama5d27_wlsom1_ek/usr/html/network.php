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
if (isset($_POST['applyNetwork'])) {
		sleep(2);
    $args = '';
    foreach ($_POST as $k => $v) $args = $args . " $k='$v'";
		echo"<!DOCTYPE html><html lang='it'><head><title>DKC E.CHARGER | REBOOTING</title><meta charset='utf-8' /><meta content='IE=edge' http-equiv='X-UA-Compatible' /><meta content='width=device-width, initial-scale=1' name='viewport' />
		<link href='css/bootstrap.min.css' rel='stylesheet'><link href='css/signin.css' rel='stylesheet'><link href='favicon.ico' rel='icon' type='image/x-icon' />
		<link href='favicon.png' rel='icon' type='image/png' /></head><body class='text-center text-white'><div class='container-fluid'><div class='row justify-content-center'><div class='col-12 col-md-6 my-5'>
		<img src='img/dkcenergyportal.png'><h3 class='display-6 my-5'>RIAVVIO E.CHARGER</h3><div class='spinner-border text-danger' role='status'><span class='visually-hidden'>Rebooting...</span></div>
		<p class='mt-5'>se hai modificato i parametri di rete, cambia indirizzo nella barra del browser per trovare il tuo E.CHARGER</p><p class='text-dkc'>registrati sulla nostra piattaforma per tutti i servizi aggiuntivi</p></div></div></div></body></html>";
    $response = exec('issue_command 9008' . $args);
		die;
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
		sleep(2);
		echo"<!DOCTYPE html><html lang='it'><head><title>DKC E.CHARGER | REBOOTING</title><meta charset='utf-8' /><meta content='IE=edge' http-equiv='X-UA-Compatible' /><meta content='width=device-width, initial-scale=1' name='viewport' />
		<link href='css/bootstrap.min.css' rel='stylesheet'><link href='css/signin.css' rel='stylesheet'><link href='favicon.ico' rel='icon' type='image/x-icon' />
		<link href='favicon.png' rel='icon' type='image/png' /></head><body class='text-center text-white'><div class='container-fluid'><div class='row justify-content-center'><div class='col-12 col-md-6 my-5'>
		<img src='img/dkcenergyportal.png'><h3 class='display-6 my-5'>RIAVVIO E.CHARGER</h3><div class='spinner-border text-danger' role='status'><span class='visually-hidden'>Rebooting...</span></div>
		<p class='mt-5'>quando i led saranno verdi, il tuo E.CHARGER sara' pronto</p><p class='text-muted'>puoi chiudere questa finestra</p></div></div></div></body></html>";
    $response = exec("issue_command 9008 ssid='' pass='' wifidhcp='' wifiipaddress='' wifinetmask='' wifigateway='' wifidns='' dhcp='' ipaddress='' netmask='' gateway='' dns='' applyNoNetwork='apply'");
		die;
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
// 0=admin 1=installer 2=user
if ($auth == 0) {
    $utente = 'admin';
} elseif ($auth == 1) {
    $utente = 'installer';
} else {
    $utente = 'user';
    $configuration_menu = "";
}
?>
<!--# if expr="$internetenabled=false" -->
<!--# include file="session.php" -->
<!--# include file="index_provisioning.php" -->
<!--# else -->
<!DOCTYPE html>
<html lang="it">

<head>
    <title>DKC E.CHARGER | RETE</title>
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
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        </button>
        <div class="dropdown me-2">
            <button type="button" class="btn btn-sm dropdown-toggle" style="background-color:#d91a15; color:#fff;" id="dropdownUser" data-bs-toggle="dropdown" data-toggle="tooltip" data-bs-placement="left" title="<?php echo htmlspecialchars($utente); ?>">
                <img src="img/ico_user.png" class="me-3">
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="index_dashboard.php">HOME</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-primary" href="logout.php">LOGOUT</a></li>
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
                            OVERVIEW
                        </h5>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="index_dashboard.php">
                                <img src="img/ico_wallbox.png" width="25px" class="me-3">
                                E.CHARGER
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="telemetry.php">
                                <img src="img/ico_inverter.png" width="25px" class="me-3">
                                TELEMETRIA
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="cards.php">
                                <img src="img/ico_card.png" width="25px" class="me-3">
                                CARTE RFID
                            </a>
                        </div>
                    </li>
                    <hr class="border border-secondary border-1 opacity-75 ms-2">
                    <li class="list-group-item bg-dkcenergy">
                        <h5 class="fw-bolder" style="color:#b0b0b0;">
                            <img src="img/ico_statistiche.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            STATISTICHE
                        </h5>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="transactions.php">
                                <img src="img/ico_service.png" width="25px" class="me-3">
                                TRANSAZIONI
                            </a>
                        </div>
                    </li>
                    <hr class="border border-secondary border-1 opacity-75 ms-2">
                    <li class="list-group-item bg-dkcenergy">
                        <h5 class="fw-bolder" style="color:#b0b0b0;">
                            <img src="img/ico_settings.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            IMPOSTAZIONI
                        </h5>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="commands.php">
                                <img src="img/ico_notifiche.png" width="25px" class="me-3">
                                COMANDI
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="configurations.php">
                                <img src="img/ico_portale.png" width="25px" class="me-3">
                                CONFIGURAZIONI
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="errors.php">
                                <img src="img/ico_error.png" width="25px" class="me-3">
                                ERRORI
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="network.php" class="dkc-selected">
                                <img src="img/ico_network.png" width="25px" class="me-3">
                                RETE
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
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_overview.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">OVERVIEW</h5>
            </div>
            <div class="col-2 text-nowrap" style="font-size:12px">
                <b>CHIUDI </b><button type="button" class="btn-close btn-close-white text-reset my-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="index_dashboard.php">
                            <img src="img/ico_wallbox.png" width="25px" class="me-3">
                            E.CHARGER
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="telemetry.php">
                            <img src="img/ico_inverter.png" width="25px" class="me-3">
                            TELEMETRIA
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="cards.php">
                            <img src="img/ico_card.png" width="25px" class="me-3">
                            CARTE RFID
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
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_statistiche.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">STATISTICHE</h5>
            </div>
            <div class="col-2 text-nowrap" style="font-size:12px">
                <b>CHIUDI </b><button type="button" class="btn-close btn-close-white text-reset my-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="transactions.php">
                            <img src="img/ico_service.png" width="25px" class="me-3">
                            TRANSAZIONI
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
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_settings.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">IMPOSTAZIONI</h5>
            </div>
            <div class="col-2 text-nowrap" style="font-size:12px">
                <b>CHIUDI </b><button type="button" class="btn-close btn-close-white text-reset my-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="commands.php">
                            <img src="img/ico_notifiche.png" width="25px" class="me-3">
                            COMANDI
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="configurations.php">
                            <img src="img/ico_portale.png" width="25px" class="me-3">
                            CONFIGURAZIONI
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="errors.php">
                            <img src="img/ico_error.png" width="25px" class="me-3">
                            ERRORI
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="network.php" class="dkc-selected">
                            <img src="img/ico_network.png" width="25px" class="me-3">
                            RETE
                        </a>
                    </h4>
                </li>
            </ul>
        </div>
    </div>
    <div class="smartphone-padding d-none d-md-block"></div>
    <!-- ################################# FINE MENU MOBILE ################################################ -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-4">
        <div class="container-fluid mt-1 ms-auto">
            <!-- ################################# INIZIO PAGINA ################################################ -->
            <div class="row ms-2">
                <div class="justify-content-between flex-wrap flex-md-nowrap align-items-center pt-0">
                    <div class="d-flex align-items-start">
                        <div class="col d-flex align-items-start">
                            <img src="img/icon_title.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            <h3 class="bold" style="color:#d91a15; font-weight:900;">IMPOSTAZIONI DI RETE</h3>
                        </div>
                        <div class="col d-flex justify-content-end">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /////////////////////////////////////// PROVISIONING ////////////////////////////////////////////////////////// -->
            <form name="network" id="network" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="row mt-1 ms-2 rounded shadow-sm py-2 bg-wifi">
                    <div class="col-lg-4 mt-1">
                        <h3>RETE WIRELESS</h3>
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
                                <input type="text" class="form-control" name="wifinetmask" maxlength="64" pattern="^(((255\.){3}(255|254|252|248|240|224|192|128|0+))|((255\.){2}(255|254|252|248|240|224|192|128|0+)\.0)|((255\.)(255|254|252|248|240|224|192|128|0+)(\.0+){2})|((255|254|252|248|240|224|192|128|0+)(\.0+){3}))$" value=<!--# echo var="wifinetmask" default="" --> >
                            </div>
                            <div class="mb-3">
                                <label for="wifigateway" class="form-label">gateway rete wireless</label>
                                <input type="text" class="form-control" name="wifigateway" maxlength="64" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" value=<!--# echo var="wifigateway" default="" --> >
                            </div>
                            <div class="mb-3">
                                <label for="wifidns" class="form-label">server DNS rete wireless</label>
                                <input type="text" class="form-control" name="wifidns" maxlength="64" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" value=<!--# echo var="wifidns" default="" --> >
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-2">
                <div class="row mt-1 ms-2 rounded shadow-sm py-2 bg-lan">
                    <div class="col-lg-4 mt-1">
                        <h3>RETE</h3>
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
                <div class="row mt-1 ms-2 py-2">
                    <div class="col-lg-4 mt-1">
                        <button class="w-100 btn btn-lg btn-primary my-2" type="submit" name="applyNetwork" id="applyNetwork" value="apply" onclick="checkOne(this.id)">applica</button>
                    </div>
                </div>
                <!-- ############################################## CONTINUE WITHOUT NETWORKl ############################################## -->
                <hr class="my-2">
                <div class="row mt-1 ms-2 py-2">
                    <div class="col-lg-4 mt-1">
                        <button class="w-100 btn btn-lg btn-danger my-2" type="button" data-bs-toggle="modal" data-bs-target="#withoutNetwork">
                            CONTINUA SENZA RETE
                        </button>
                    </div>
                    <div class="modal fade" id="withoutNetwork" tabindex="-1" aria-labelledby="withoutNetworkLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="withoutNetworkLabel">CONTINUA SENZA CONFIGURARE LA RETE</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">SEI SICURO DI VOLER CONTINUARE SENZA RETE?</div>
																<h6 class="modal-body text-center text-danger"><b>--- ATTENZIONE ---<br>--- IL TUO E.CHARGER SI RIAVVIERA' ---<b></h6>
                                <div class="modal-footer btn-group">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">NO</button>
                                    <button class="btn btn-danger" type="submit" name="applyNoNetwork" id="applyNoNetwork" value="apply">SI</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- ################################# MODALE PER MISSING DETAILS ################################################ -->
            <div class="modal fade" id="missingDetails" tabindex="-1" aria-labelledby="missingDetails" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="missingDetails">DATI MANCANTI</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">COMPILA TUTTI I CAMPI NECESSARI!</div>
                        <div class="modal-footer btn-group">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CHIUDI</button>
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
    <script src="js/jquery.slim.min.js"></script>
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
                    if (oneFilled) {
                        //almeno 1 campo compilato
                    } else {
                        //nessun campo compilato
                        e.preventDefault();
                        clicked_id = '';
                        $('#missingDetails').modal('show');
                    }
                } else {
                    //NIENTE RETE
                };
            });
        };
        //############################################## TOOLTIP ##############################################
        $(document).ready(function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
</body>

</html>
<!--# endif -->
