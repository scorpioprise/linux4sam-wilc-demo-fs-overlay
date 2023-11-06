<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$id = $_SESSION["id"];
$auth = $_SESSION["auth"];
$firstlogin = $_SESSION["firstlogin"];
$toast = $_SESSION["toast"];
$echargerpot = $_SESSION["echargerpot"];
$statoecharger = $_SESSION["echargerstato"];
if ($firstlogin == 1) {
    header("location: change_password.php");
    exit;
}
require_once "inc/config.php";
if (trovaLingua() == 'it') {
    include "inc/l_it.php";
    $logo = 'logo_menu.png';
    $lang = 'it';
} else if (trovaLingua() == 'en') {
    include "inc/l_en.php";
    $logo = 'logo_menu.png';
    $lang = 'en';
} else if (trovaLingua() == 'ru') {
    include "inc/l_ru.php";
    $logo = 'logo_menu_dkc.png';
    $lang = 'ru';
} else if (trovaLingua() == 'userruen') {
    include "inc/l_ru.php";
    $logo = 'logo_menu_dkc.png';
    $lang = 'ru';
} else if (trovaLingua() == 'userenru') {
    include "inc/l_en-ru.php";
    $logo = 'logo_menu_dkc.png';
    $lang = 'en';
}
##################### DATI IN CLOUD #####################
if (isset($_POST['refresh'])) {
    $response = exec('issue_command ' . $_POST['parameter'] . " " . $_POST['valore']);
    if ($response == 'RESPONSE_MESSAGE_FAILED') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-ko fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">' . _TOASTCOMMANDKO . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_OK') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-ok fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">' . _TOASTCOMMANDOK . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_TODO') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-kk fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">' . _TOASTCOMMANDNOTAVAILABLE . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'SKIP SERIAL') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-ok fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">' . _TOASTCOMMANDSKIPSERIAL . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_NOT_APPLICABLE') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-kk fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">' . _TOASTCOMMANDNOUPDATE . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } else {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-kk fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">' . _TOASTCOMMANDERROR . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    }
    $_SESSION["toast"] = $response_toast;
    usleep(1500);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
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
<html lang="<?php echo $lang; ?>">

<head>
    <title><?= _TITLESYSTEM ?></title>
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
            <button type="button" class="btn btn-sm dropdown-toggle" style="background-color:#d91a15; color:#fff;" id="dropdownUser" data-bs-toggle="dropdown">
                <span data-bs-toggle="tooltip" title="<?php echo htmlspecialchars($utente); ?>" data-bs-placement="left">
                    <img src="img/ico_user.png" class="me-3">
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="telemetry.php"><?= _MENUHOME ?></a></li>
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
                            <a href="telemetry.php">
                                <img src="img/ico_telemetria.png" width="25px" class="me-3">
                                <?= _MENUTELEMETRY ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1 item-disabled" style="color:#fff;font-size:12px;">
                            <a href="topology.php">
                                <img src="img/ico_topologia.png" width="25px" class="me-3">
                                <?= _MENUTOPOLOGY ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="system.php" class="dkc-selected">
                                <img src="img/ico_inverter.png" width="25px" class="me-3">
                                <?= _MENUINVERTER ?>
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
                        <div class="fw-bolder ms-1 " style="color:#fff;font-size:12px;">
                            <a href="analytics.php">
                                <img src="img/ico_transazioni.png" width="25px" class="me-3">
                                <?= _MENUANALYTICS ?>
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
                    <hr class="border border-secondary border-1 opacity-75 ms-2">
                    <li class="list-group-item bg-dkcenergy">
                        <h5 class="fw-bolder" style="color:#b0b0b0;">
                            <img src="img/ico_settings.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            <?= _MENUSETTINGS ?>
                        </h5>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1 item-disabled" style="color:#fff;font-size:12px;">
                            <a href="commands.php">
                                <img src="img/ico_comandi.png" width="25px" class="me-3">
                                <?= _MENUPOWERMODE ?>
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
                            <a href="network.php">
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
    <div class="offcanvas offcanvas-start bg-dkcenergy" tabindex="-1" id="offcanvasFunzioni" aria-labelledby="offcanvasFunzioniLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasFunzioniLabel"><img src="img/<?php echo $logo ?>" width="130" height="40"></h5>
        </div>
        <div class="row ms-1 mt-3 text-white flex-nowrap">
            <div class="col-8">
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_overview.png" width="35px" class="me-2" style="font-size:1.35em;" alt=""><?= _MENUOVERVIEW ?></h5>
            </div>
            <div class="col-2 text-nowrap">
                <button class="btn btn-link text-decoration-none text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                    <b><?= _MENUCLOSE ?> </b>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                    </svg>
                </button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="telemetry.php">
                            <img src="img/ico_telemetria.png" width="25px" class="me-3">
                            <?= _MENUTELEMETRY ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder item-disabled" style="color:#fff;font-size:12px;">
                        <a href="topology.php">
                            <img src="img/ico_topologia.png" width="25px" class="me-3">
                            <?= _MENUTOPOLOGY ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="system.php" class="dkc-selected">
                            <img src="img/ico_inverter.png" width="25px" class="me-3">
                            <?= _MENUINVERTER ?>
                        </a>
                    </h4>
                </li>
            </ul>
        </div>
    </div>
    <div class="offcanvas offcanvas-start bg-dkcenergy" tabindex="-1" id="offcanvasStatistiche" aria-labelledby="offcanvasStatisticheLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasStatisticheLabel"><img src="img/<?php echo $logo ?>" width="130" height="40"></h5>
        </div>
        <div class="row ms-1 mt-3 text-white flex-nowrap">
            <div class="col-8">
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_statistiche.png" width="35px" class="me-2" style="font-size:1.35em;" alt=""><?= _MENUSTATISTICS ?></h5>
            </div>
            <div class="col-2 text-nowrap">
                <button class="btn btn-link text-decoration-none text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                    <b><?= _MENUCLOSE ?> </b>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                    </svg>
                </button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="analytics.php">
                            <img src="img/ico_transazioni.png" width="25px" class="me-3">
                            <?= _MENUANALYTICS ?>
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
            </ul>
        </div>
    </div>
    <div class="offcanvas offcanvas-start bg-dkcenergy" tabindex="-1" id="offcanvasConfigurazione" aria-labelledby="offcanvasConfigurazioneLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasConfigurazioneLabel"><img src="img/<?php echo $logo ?>" width="130" height="40"></h5>
        </div>
        <div class="row ms-1 mt-3 text-white flex-nowrap">
            <div class="col-8">
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_settings.png" width="35px" class="me-2" style="font-size:1.35em;" alt=""><?= _MENUSETTINGS ?></h5>
            </div>
            <div class="col-2 text-nowrap">
                <button class="btn btn-link text-decoration-none text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                    <b><?= _MENUCLOSE ?> </b>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                    </svg>
                </button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder item-disabled" style="color:#fff;font-size:12px;">
                        <a href="commands.php">
                            <img src="img/ico_comandi.png" width="25px" class="me-3">
                            <?= _MENUPOWERMODE ?>
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
                        <a href="network.php">
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
                            <h3 class="bold text-dkc"><?= _HEAD . '&nbsp;' ?></h3>
                            <img id="iconaInternet" src="img/offlineLight.png">
                        </div>
                        <div class="col d-flex justify-content-end align-items-start mt-0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between py-2 ms-0">
                <div class="col-7 col-md-6 col-lg-4 d-flex align-items-center me-lg-1 mb-lg-0 mb-1 text-break rounded-4 bg-grigiochiaro" style="min-height: 80px;">
                    <div class="icon-square flex-shrink-0 mt-1 me-3">
                        <img id="iconaTipo" src="img/ico_inv.png">
                    </div>
                    <div>
                        <h6 class="fw-bold mt-3"><?= _MENUINVERTER ?> <span class="text-dkc"><?= $_SESSION["macaddress"] ?></span></h6>
                    </div>
                </div>
                <div class="col d-flex justify-content-end h-50">
                    <?php echo $toast;
                    $_SESSION["toast"] = '';
                    //unset($_SESSION["toast"]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col d-flex justify-content-end align-items-end">
                    <div class="d-flex flex-nowrap text-nowrap">
                        <a href="/datasheet.pdf" download class="d-flex btn btn-sm btn-link fw-bold text-black text-decoration-none pt-0" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="<?= _DATASHEET ?>" name="datasheet">
                            <img src="img/ico_tr_pdf.png">
                        </a>
                    </div>
                </div>
            </div>

            <div id="recapInverter" class="row rounded-4 py-2 ms-0 shadow bg-object" style="min-width: 220px;">
                <div class="col-3 d-flex align-items-center">
                    <div class="d-flex align-items-center my-2 ms-0 ms-xl-3">
                        <div class="icon-square flex-shrink-0 me-0 d-none d-lg-block">
                            <img src="img/ico_solar.png" alt="solar value">
                        </div>
                        <p class="lh-sm" style="min-width: 70px;"><span class="fwb-head text-capitalize"><br><?= _SOLAR ?>: </span><br class="d-block d-lg-none"><b id="totalSolarPower"> W</b>
                            <br><span class="d-flex align-items-center my-1"><span class="fwb-head text-capitalize d-none d-lg-block"><?= _VOLTAGE ?>: </span><b class="ms-lg-1" id="solarVolt1"> V,</b><b id="solarVolt2"> V</b></span>
                            <span class="d-flex align-items-center my-1"><span class="fwb-head text-capitalize d-none d-lg-block"><?= _CURRENT ?>: </span><b class="ms-lg-1" id="solarCurr1"> A,</b><b id="solarCurr2"> A</b></span>
                        </p>
                    </div>
                </div>
                <div class="col-3 d-flex align-items-center">
                    <div class="d-flex align-items-center my-2 ms-0 ms-xl-3">
                        <div class="icon-square flex-shrink-0 me-0 d-none d-lg-block">
                            <img src="img/ico_grid.png" alt="grid value">
                        </div>
                        <p class="lh-sm" style="min-width: 70px;"><span class="fwb-head text-capitalize"><br><?= _GRID ?>: </span><br class="d-block d-lg-none"><b id="PMPower"> W</b>
                            <br><span class="d-flex align-items-center my-1"><span class="fwb-head text-capitalize d-none d-lg-block"><?= _VOLTAGE ?>: </span><b class="ms-lg-1" id="PMVolt"> V</b></span>
                            <span class="d-flex align-items-center my-1"><span class="fwb-head text-capitalize d-none d-lg-block"><?= _CURRENT ?>: </span><b class="ms-lg-1" id="PMCurr"> A</b></span>
                        </p>
                    </div>
                </div>
                <div class="col-3 d-flex align-items-center">
                    <div class="d-flex align-items-center my-2 ms-0 ms-xl-3">
                        <div class="icon-square flex-shrink-0 me-0 d-none d-lg-block">
                            <img src="img/ico_domestic.png" alt="domestic value">
                        </div>
                        <p class="lh-sm" style="min-width: 70px;"><span class="fwb-head text-capitalize"><br><?= _DOMESTIC ?>: </span><br class="d-block d-lg-none"><b id="DomesticPower"> W</b>
                            <br><span class="d-flex align-items-center my-1"><span class="fwb-head text-capitalize d-none d-lg-block"><?= _VOLTAGE ?>: </span><b class="ms-lg-1" id="domesticVolt"> V</b></span>
                            <span class="d-flex align-items-center my-1"><span class="fwb-head text-capitalize d-none d-lg-block"><?= _CURRENT ?>: </span><b class="ms-lg-1" id="domesticCurr"> A</b></span>
                        </p>
                    </div>
                </div>
                <div class="col-3 d-flex align-items-center">
                    <div class="d-flex align-items-center my-2 ms-0 ms-xl-3">
                        <div class="icon-square flex-shrink-0 me-0 d-none d-lg-block">
                            <img src="img/ico_battery.png" alt="battery value">
                        </div>
                        <p class="lh-sm" style="min-width: 70px;"><span class="fwb-head text-capitalize"><br><?= _STORAGE ?>: </span><br class="d-block d-lg-none"><b id="batteryPower"> W</b>
                            <br><span class="d-flex align-items-center my-1"><span class="fwb-head text-capitalize d-none d-lg-block"><?= _VOLTAGE ?>: </span><b class="ms-lg-1" id="batteryVoltage"> V</b></span>
                            <span class="d-flex align-items-center my-1"><span class="fwb-head text-capitalize d-none d-lg-block"><?= _CHARGE ?>: </span><b class="ms-lg-1" id="batteryStateCharge">%</b></span>
                        </p>
                    </div>
                </div>
            </div>


            <div class="row ms-0 py-2 justify-content-between">
                <div class="col-12 col-xl-auto rounded-4 shadow bg-object mt-2 mt-lg-0">
                    <div class="col-12 d-flex align-items-center text-break">
                        <div class="icon-square flex-shrink-0 mt-3 me-3">
                            <img src="img/ico_systemdata.png">
                        </div>
                        <h6 class="fw-bold mt-3 text-uppercase"><?= _HEADDATA ?></h6>
                    </div>
                    <p class="lh-md" style="min-width: 90px;">
                        <span class="fwb-head"><?= _MACAddr ?>: </span><b><!--# echo var='MACAddr' --></b><br>
                        <span class="fwb-head"><?= _Manufacturer ?>: </span><b><!--# echo var='Manufacturer' --></b><br>
                        <span class="fwb-head"><?= _ModbusAddr ?>: </span><b><!--# echo var='ModbusAddr' --></b><br>
                        <span class="fwb-head"><?= _LANIP ?>: </span><b><!--# echo var='LANIP' --></b><br>
                        <span class="fwb-head"><?= _WLANIP ?>: </span><b><!--# echo var='WLANIP' --></b><br>
                        <span class="fwb-head"><?= _DATE ?>: </span><b id="datetime"></b><br>
                        <script>
                            var dataServer = new Date("<!--# echo var='DATE' -->" * 1000);
                            var showData =
                                dataServer.getFullYear() + "-" +
                                ("00" + (dataServer.getMonth() + 1)).slice(-2) + "-" +
                                ("00" + dataServer.getDate()).slice(-2) + " " +
                                ("00" + (dataServer.getHours())).slice(-2) + ":" +
                                ("00" + dataServer.getMinutes()).slice(-2) + ":" +
                                ("00" + dataServer.getSeconds()).slice(-2);
                            document.getElementById("datetime").innerHTML = showData;
                        </script>
                        <span class="fwb-head"><?= _Language ?>: </span><b><!--# echo var='Language' --></b><br>
                        <span class="fwb-head"><?= _MQTTFreq ?>: </span><b><!--# echo var='MQTTFreq' --> s</b><br>
                        <span class="fwb-head"><?= _SerialNum ?>: </span><b><!--# echo var='SerialNum' --></b><br>
                        <span class="fwb-head"><?= _SWVer ?>: </span><b><!--# echo var='SWVer' --></b><br>
                    </p>
                </div>

                <div class="col-xl-8 d-xl-none d-block"></div>

                <div class="col-12 col-sm-auto col-xl-3 rounded-4 shadow bg-object mt-2 mt-lg-0">
                    <div class="col-12 d-flex align-items-center text-break">
                        <div class="icon-square flex-shrink-0 mt-3 me-3">
                            <img src="img/ico_dkcinverter.png">
                        </div>
                        <h6 class="fw-bold mt-3 text-uppercase"><?= _INVERTER ?></h6>
                    </div>
                    <p class="lh-md" style="min-width: 90px;">
                        <span class="fwb-head"><?= _NominalPower ?>: </span><b><!--# echo var='NominalPower' --> W</b><br>
                        <span class="fwb-head"><?= _MaxActPower ?>: </span><b><!--# echo var='MaxActPower' --> W</b><br>
                        <span class="fwb-head"><?= _MaxAppPower ?>: </span><b><!--# echo var='MaxAppPower' --> W</b><br>
                        <span class="fwb-head"><?= _MaxReaPower ?>: </span><b><!--# echo var='MaxReaPower' --> W</b><br>
                        <span class="fwb-head"><?= _InverterConfig ?>: </span><b><!--# echo var='InverterConfig' --></b><br>
                        <span class="fwb-head"><?= _MaxCurr ?>: </span><b><!--# echo var='MaxCurr' --> A</b><br>
                        <span class="fwb-head"><?= _MaxPF ?>: </span><b><!--# echo var='MaxPF' --></b><br>
                        <span class="fwb-head"><?= _MinPF ?>: </span><b><!--# echo var='MinPF' --></b><br>
                        <span class="fwb-head"><?= _MaxNetVolt ?>: </span><b><!--# echo var='MaxNetVolt' --> V</b><br>
                        <span class="fwb-head"><?= _MinNetVolt ?>: </span><b><!--# echo var='MinNetVolt' --> V</b><br>
                        <span class="fwb-head"><?= _MaxNetFreq ?>: </span><b><!--# echo var='MaxNetFreq' --> Hz</b><br>
                        <span class="fwb-head"><?= _MinNetFreq ?>: </span><b><!--# echo var='MinNetFreq' --> Hz</b>
                    </p>
                </div>
                <div class="col-12 col-sm-auto col-xl-3 rounded-4 shadow bg-object mt-2 mt-lg-0">
                    <div class="col-12 d-flex align-items-center text-break">
                        <div class="icon-square flex-shrink-0 mt-3 me-3">
                            <img src="img/ico_solar.png">
                        </div>
                        <h6 class="fw-bold mt-3 text-uppercase"><?= _SOLAR ?></h6>
                    </div>
                    <p class="lh-md" style="min-width: 90px;">
                        <span class="fwb-head"><?= _MaxPVPower ?>: </span><b><!--# echo var='MaxPVPower' --> W</b><br>
                        <span class="fwb-head"><?= _MaxPVVolt ?>: </span><b><!--# echo var='MaxPVVolt' --> V</b><br>
                        <span class="fwb-head"><?= _MaxPVCurr ?>: </span><b><!--# echo var='MaxPVCurr' --> A</b><br>
                        <span class="fwb-head"><?= _PVSeriesNum ?>: </span><b><!--# echo var='PVSeriesNum' --></b><br>
                        <span class="fwb-head"><?= _PVStringNum ?>: </span><b><!--# echo var='PVStringNum' --></b>
                    </p>
                </div>
                <div class="col-12 col-sm-auto col-xl-3 rounded-4 shadow bg-object mt-2 mt-lg-0">
                    <div class="col-12 d-flex align-items-center text-break">
                        <div class="icon-square flex-shrink-0 mt-3 me-3">
                            <img src="img/ico_battery.png">
                        </div>
                        <h6 class="fw-bold mt-3 text-uppercase"><?= _STORAGE ?></h6>
                    </div>
                    <p class="lh-md" style="min-width: 90px;">
                        <span class="fwb-head"><?= _BattNominalCappacity ?>: </span><b><!--# echo var='BattNominalCappacity' --> Wh</b><br>
                        <span class="fwb-head"><?= _BattMaxChargPower ?>: </span><b><!--# echo var='BattMaxChargPower' --> W</b><br>
                        <span class="fwb-head"><?= _BattMaxDischarPower ?>: </span><b><!--# echo var='BattMaxDischarPower' --> W</b><br>
                        <span class="fwb-head"><?= _BattType ?>: </span><b><!--# echo var='BattType' --></b><br>
                        <span class="fwb-head"><?= _BattNumSeries ?>: </span><b><!--# echo var='BattNumSeries' --></b><br>
                        <span class="fwb-head"><?= _BattStringNum ?>: </span><b><!--# echo var='BattStringNum' --></b><br>
                        <span class="fwb-head"><?= _CellMaxVolt ?>: </span><b><!--# echo var='CellMaxVolt' --> V</b><span class="ms-1 vr"></span>
                        <span class="fwb-head"><?= _CellMaxVoltID ?>: </span><b><!--# echo var='CellMaxVoltID' --></b><br>
                        <span class="fwb-head"><?= _CellMinVolt ?>: </span><b><!--# echo var='CellMinVolt' --> V</b><span class="ms-1 vr"></span>
                        <span class="fwb-head"><?= _CellMinVoltID ?>: </span><b><!--# echo var='CellMinVoltID' --></b><br>
                        <span class="fwb-head"><?= _CellMaxTemp ?>: </span><b><!--# echo var='CellMaxTemp' --> °C</b><span class="ms-1 vr"></span>
                        <span class="fwb-head"><?= _CellMaxTempID ?>: </span><b><!--# echo var='CellMaxTempID' --></b><br>
                        <span class="fwb-head"><?= _CellMinTemp ?>: </span><b><!--# echo var='CellMinTemp' --> °C</b><span class="ms-1 vr"></span>
                        <span class="fwb-head"><?= _CellMinTempID ?>: </span><b><!--# echo var='CellMinTempID' --></b><br>
                        <span class="fwb-head"><?= _ModMaxVolt ?>: </span><b><!--# echo var='ModMaxVolt' --> V</b><span class="ms-1 vr"></span>
                        <span class="fwb-head"><?= _ModMaxVoltID ?>: </span><b><!--# echo var='ModMaxVoltID' --></b><br>
                        <span class="fwb-head"><?= _ModMinVolt ?>: </span><b><!--# echo var='ModMinVolt' --> V</b><span class="ms-1 vr"></span>
                        <span class="fwb-head"><?= _ModMinVoltID ?>: </span><b><!--# echo var='ModMinVoltID' --></b><br>
                        <span class="fwb-head"><?= _ModMaxTemp ?>: </span><b><!--# echo var='ModMaxTemp' --> °C</b><span class="ms-1 vr"></span>
                        <span class="fwb-head"><?= _ModMaxTempID ?>: </span><b><!--# echo var='ModMaxTempID' --></b><br>
                        <span class="fwb-head"><?= _ModMinTemp ?>: </span><b><!--# echo var='ModMinTemp' --> °C</b><span class="ms-1 vr"></span>
                        <span class="fwb-head"><?= _ModMinTempID ?>: </span><b><!--# echo var='ModMinTempID' --></b>
                    </p>
                </div>
            </div>

            <div class="row d-none ms-0 py-2 justify-content-between">
                <div id="flussi" class="col-12 col-xl-2 rounded-4 shadow bg-object" style="max-height: 400px; max-width: 400px;"><svg width="100%" height="100%" viewBox="0 0 400 400">
                        <g width="400" height="400">
                            <!-- 100 da oggetto ad inverter -->
                            <!-- -100 da inverter ad oggetto -->
                            <!-- 0 fermo -->
                            <!-- 100 lento -->
                            <!-- 200 veloce -->
                            <!-- 300 molto veloce -->
                            <path d="M108.2842712474619,108.2842712474619L171.7157287525381,171.7157287525381" stroke-miterlimit="10" fill="none" stroke="#f7931e" stroke-width="10" stroke-dasharray="10" stroke-dashoffset="1">
                                <animate id="animSolar" attributeName="stroke-dashoffset" values="0;0" dur="5s" calcMode="linear" repeatCount="indefinite"></animate>
                            </path>
                            <path d="M108.2842712474619,291.7157287525381L171.7157287525381,228.2842712474619" stroke-miterlimit="10" fill="none" stroke="#a646db" stroke-width="10" stroke-dasharray="10" stroke-dashoffset="1">
                                <animate id="animGrid" attributeName="stroke-dashoffset" values="0;0" dur="5s" calcMode="linear" repeatCount="indefinite"></animate>
                            </path>
                            <path d="M291.7157287525381,108.2842712474619L228.2842712474619,171.7157287525381" stroke-miterlimit="10" fill="none" stroke="#667eff" stroke-width="10" stroke-dasharray="10" stroke-dashoffset="1">
                                <animate id="animDomestic" attributeName="stroke-dashoffset" values="0;0" dur="5s" calcMode="linear" repeatCount="indefinite"></animate>
                            </path>
                            <path d="M291.7157287525381,291.7157287525381L228.2842712474619,228.2842712474619" stroke-miterlimit="10" fill="none" stroke="#22b573" stroke-width="10" stroke-dasharray="10" stroke-dashoffset="1">
                                <animate id="animStorage" attributeName="stroke-dashoffset" values="0;0" dur="5s" calcMode="linear" repeatCount="indefinite"></animate>
                            </path>
                            <g id="solarContainer" transform="translate(-120, -120) scale(1,1)" style="cursor: pointer;">
                                <circle id="solarOuterCircle" cx="200" cy="200" r="58" fill-opacity="1" fill="#ffffff" stroke-width="5" stroke="#f7931e"></circle>
                                <circle cx="200" cy="200" r="40" id="solarCircle" fill="#ffffff" stroke-width="1" stroke="#f7931e">
                                </circle>
                                <image x="158" y="157" id="solarImage" xlink:href="img/ico_solar.svg?crq=202305" width="85" height="85">
                                </image>
                            </g>
                            <g id="gridContainer" transform="translate(-120, 120) scale(1,1)" style="cursor: pointer;">
                                <circle id="gridOuterCircle" cx="200" cy="200" r="58" fill-opacity="1" fill="#ffffff" stroke-width="5" stroke="#a646db"></circle>
                                <circle cx="200" cy="200" r="40" id="gridCircle" fill="#ffffff" stroke-width="1" stroke="#a646db">
                                </circle>
                                <image x="158" y="157" id="gridImage" xlink:href="img/ico_grid.svg?crq=202305" width="85" height="85">
                                </image>
                            </g>
                            <g id="domesticContainer" transform="translate(120, -120) scale(1,1)" style="cursor: pointer;">
                                <circle id="domesticOuterCircle" cx="200" cy="200" r="58" fill-opacity="1" fill="#ffffff" stroke-width="5" stroke="#667eff"></circle>
                                <circle cx="200" cy="200" r="40" id="domesticCircle" fill="#ffffff" stroke-width="1" stroke="#667eff">
                                </circle>
                                <image x="158" y="157" id="domesticImage" xlink:href="img/ico_domestic.svg?crq=202305" width="85" height="85"></image>
                            </g>
                            <g id="batteryContainer" transform="translate(120, 120) scale(1,1)" style="cursor: pointer;">
                                <circle id="batteryOuterCircle" cx="200" cy="200" r="58" fill-opacity="1" fill="#ffffff" stroke-width="5" stroke="#22b573"></circle>
                                <circle cx="200" cy="200" r="40" id="batteryCircle" fill="#ffffff" stroke-width="1" stroke="#22b573">
                                </circle>
                                <image x="158" y="157" id="batteryImage" xlink:href="img/ico_battery.svg?crq=202305" width="85" height="85">
                                </image>

                            </g>
                            <g id="inverterContainer" transform="" style="cursor: pointer;">
                                <circle id="inverterOuterCircle" cx="200" cy="200" r="58" fill-opacity="1" fill="#ffffff" stroke-width="5" stroke="#8d00a4"></circle>
                                <circle cx="200" cy="200" r="40" id="inverterCircle" fill="#ffffff" stroke-width="1" stroke="#8d00a4">
                                </circle>
                                <image x="158" y="157" id="inverterImage" xlink:href="img/ico_inverter.svg?crq=202305" width="85" height="85"></image>
                            </g>
                        </g>
                    </svg>
                </div>

                <div class="col-xl-8 d-xl-none d-block"></div>

                <div class="col-12 col-sm-auto col-xl-3 rounded-4 shadow bg-object mt-2 mt-lg-0">
                    <div class="col-12 d-flex align-items-center text-break">
                        <div class="icon-square flex-shrink-0 mt-3 me-3">
                            <img src="img/ico_dkcinverter.png">
                        </div>
                        <h6 class="fw-bold mt-3 text-uppercase"><?= _INVERTER ?></h6>
                    </div>
                    <p class="lh-md" style="min-width: 90px;">
                        <span class="fwb-head"><?= _INVERTERPOWER ?>: </span><b id="ActPower"> W</b>
                        <br><span class="fwb-head"><?= _INVERTERVOLT ?>: </span><b id="RVolt"> V</b>
                        <br><span class="fwb-head"><?= _INVERTERCURR ?>: </span><b id="InverterCurr"> A</b>
                        <br><span class="fwb-head"><?= _NETWORKFREQ ?>: </span><b id="NetworkFreq"> Hz</b>
                        <br><span class="fwb-head"><?= _POWERFACTOR ?>: </span><b id="PF"> </b>
                        <br><span class="fwb-head"><?= _CABINETTEMP ?>: </span><b id="CabinetTemp"> °C</b>
                        <br><span class="fwb-head"><?= _HEATSINKTEMP ?>: </span><b id="HeatsinkTemp"> °C</b>
                        <br><span class="fwb-head"><?= _INVERTERSTATUS ?>: </span><b id="InverterStat"> </b>
                        <br><span class="fwb-head"><?= _STORAGESTATUS ?>: </span><b id="StorageStat"> </b>
                    </p>
                </div>
                <div class="col-12 col-sm-auto col-xl-3 rounded-4 shadow bg-object mt-2 mt-lg-0">
                    <div class="col-12 d-flex align-items-center text-break">
                        <div class="icon-square flex-shrink-0 mt-3 me-3">
                            <img src="img/ico_solar.png">
                        </div>
                        <h6 class="fw-bold mt-3 text-uppercase"><?= _SOLAR ?></h6>
                    </div>
                    <p class="lh-md" style="min-width: 90px;">
                        <span class="fwb-head"><?= _MPPTPOWER1 ?>: </span><b id="MPPTPower1"> W</b>
                        <br><span class="fwb-head"><?= _MPPTPOWER2 ?>: </span><b id="MPPTPower2"> W</b>
                        <br><span class="fwb-head"><?= _MPPTVOLT1 ?> </span><b id="MPPTVolt1"> V</b>
                        <br><span class="fwb-head"><?= _MPPTVOLT2 ?>: </span><b id="MPPTVolt2"> V</b>
                        <br><span class="fwb-head"><?= _MPPTCURR1 ?>: </span><b id="MPPTCurr1"> A</b>
                        <br><span class="fwb-head"><?= _MPPTCURR2 ?>: </span><b id="MPPTCurr2"> A</b>
                        <br><span class="fwb-head"><?= _RICEVALUE ?>: </span><b id="RICEvalue"> </b>
                        <br><span class="fwb-head"><?= _PVTEMP ?>: </span><b id="PVTemp"> °C</b>
                        <br><span class="fwb-head"><?= _PVSTAT ?>: </span><b id="PVStat"> </b>
                    </p>
                </div>
                <div class="col-12 col-sm-auto col-xl-3 rounded-4 shadow bg-object mt-2 mt-lg-0">
                    <div class="col-12 d-flex align-items-center text-break">
                        <div class="icon-square flex-shrink-0 mt-3 me-3">
                            <img src="img/ico_battery.png">
                        </div>
                        <h6 class="fw-bold mt-3 text-uppercase"><?= _STORAGE ?></h6>
                    </div>
                    <p class="lh-md" style="min-width: 90px;">
                        <span class="fwb-head"><?= _BATTPOWER ?>: </span><b id="BattPower"> W</b>
                        <br><span class="fwb-head"><?= _BATTVOLT ?>: </span><b id="BattVolt"> V</b>
                        <br><span class="fwb-head"><?= _BATTCURR ?>: </span><b id="BattCurr"> A</b>
                        <br><span class="fwb-head"><?= _BATTSOC ?>: </span><b id="BattSoC"> %</b>
                        <br><span class="fwb-head"><?= _BATTSOH ?>: </span><b id="BattSoH"> %</b>
                        <br><span class="fwb-head"><?= _BATTCYCLENUM ?>: </span><b id="BattCycleNum"> </b>
                        <br><span class="fwb-head"><?= _BATTMAXCHARGPOWER ?>: </span><b id="BattMaxChargPower"> W</b>
                        <br><span class="fwb-head"><?= _BATTMAXDICHARGPOWER ?>: </span><b id="BattMaxDischarPower"> W</b>
                        <br><span class="fwb-head"><?= _BATTSTAT ?>: </span><b id="BattStat"> </b>
                    </p>
                </div>
            </div>

        </div>
    </main>
    <div id="missing" hidden></div>
    <div id="PowerRef" hidden></div>
    <div id="WorkProfile" hidden></div>
    <div id="RCurr" hidden></div>
    <div id="SCurr" hidden></div>
    <div id="TCurr" hidden></div>
    <div id="RSVolt" hidden></div>
    <div id="STVolt" hidden></div>
    <div id="TRVolt" hidden></div>
    <div id="SVolt" hidden></div>
    <div id="TVolt" hidden></div>
    <div id="AppPower" hidden></div>
    <div id="ReaPower" hidden></div>
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
    <script src="js/jquery.min.js"></script>
    <script src="js/pushstream.js" type="text/javascript" language="javascript" charset="utf-8"></script>
    <script type="text/javascript" language="javascript" charset="utf-8">
        function messageReceived(text, id, channel) {
            solarPower1 = localStorage.getItem("solarPower1");
            solarPower2 = localStorage.getItem("solarPower2");
            if (typeof solarPower1 !== 'undefined' && solarPower1 !== null) {
                //solarPower1 = localStorage.getItem("solarPower1");
            } else {
                var solarPower1 = 0;
            }
            if (typeof solarPower2 !== 'undefined' && solarPower2 !== null) {
                //solarPower2 = localStorage.getItem("solarPower2");
            } else {
                var solarPower2 = 0;
            }
            //solarVolt1 = 0;
            //solarVolt2 = 0;
            solarVolt1 = localStorage.getItem("solarVolt1");
            solarVolt2 = localStorage.getItem("solarVolt2");
            if (typeof solarVolt1 !== 'undefined' && solarVolt1 !== null) {
                //solarVolt1 = localStorage.getItem("solarVolt1");
            } else {
                var solarVolt1 = 0;
            }
            if (typeof solarVolt2 !== 'undefined' && solarVolt2 !== null) {
                //solarVolt2 = localStorage.getItem("solarVolt2");
            } else {
                var solarVolt2 = 0;
            }
            //solarCurr1 = 0;
            //solarCurr2 = 0;
            solarCurr1 = localStorage.getItem("solarCurr1");
            solarCurr2 = localStorage.getItem("solarCurr2");
            if (typeof solarCurr1 !== 'undefined' && solarCurr1 !== null) {
                //solarCurr1 = localStorage.getItem("solarCurr1");
            } else {
                var solarCurr1 = 0;
            }
            if (typeof solarCurr2 !== 'undefined' && solarCurr2 !== null) {
                //solarCurr2 = localStorage.getItem("solarCurr2");
            } else {
                var solarCurr2 = 0;
            }
            //grigliaPotenza = 0;
            grigliaPotenza = localStorage.getItem("grigliaPotenza");
            if (typeof grigliaPotenza !== 'undefined' && grigliaPotenza !== null) {
                //grigliaPotenza = localStorage.getItem("grigliaPotenza");
            } else {
                var grigliaPotenza = 0;
            }
            //domesticVolt = 0;
            domesticVolt = localStorage.getItem("domesticVolt");
            if (typeof domesticVolt !== 'undefined' && domesticVolt !== null) {
                //domesticVolt = localStorage.getItem("domesticVolt");
            } else {
                var domesticVolt = 0;
            }
            //domesticCurr = 0;
            domesticCurr = localStorage.getItem("domesticCurr");
            if (typeof domesticCurr !== 'undefined' && domesticCurr !== null) {
                //domesticCurr = localStorage.getItem("domesticCurr");
            } else {
                var domesticCurr = 0;
            }
            //casaPotenza = 0;
            casaPotenza = localStorage.getItem("casaPotenza");
            if (typeof casaPotenza !== 'undefined' && casaPotenza !== null) {
                //casaPotenza = localStorage.getItem("casaPotenza");
            } else {
                var casaPotenza = 0;
            }
            //batteryPower = 0
            batteryPower = localStorage.getItem("batteryPower");
            if (typeof batteryPower !== 'undefined' && batteryPower !== null) {
                //batteryPower = localStorage.getItem("batteryPower");
            } else {
                var batteryPower = 0;
            }
            //batteryStateCharge = 0;
            batteryStateCharge = localStorage.getItem("batteryStateCharge");
            if (typeof batteryStateCharge !== 'undefined' && batteryStateCharge !== null) {
                //batteryStateCharge = localStorage.getItem("batteryStateCharge");
            } else {
                var batteryStateCharge = 0;
            }
            //batteryVoltage = 0;
            batteryVoltage = localStorage.getItem("batteryVoltage");
            if (typeof batteryVoltage !== 'undefined' && batteryVoltage !== null) {
                //batteryVoltage = localStorage.getItem("batteryVoltage");
            } else {
                var batteryVoltage = 0;
            }
            if (channel == 'telemetry') {
                const obj = JSON.parse(text);
                for (var key of Object.keys(obj)) {
                    //console.log(key);
                    if (key == 'ActPower') {
                        const ActPower = obj[key];
                        obj[key] = ActPower + ' W';
                    } else if (key == 'RVolt') {
                        const RVolt = obj[key];
                        obj[key] = RVolt + ' V';
                    } else if (key == 'InverterCurr') {
                        const InverterCurr = obj[key];
                        obj[key] = InverterCurr + ' A';
                    } else if (key == 'NetworkFreq') {
                        const NetworkFreq = obj[key];
                        obj[key] = NetworkFreq + ' Hz';
                    } else if (key == 'PF') {
                        const PF = obj[key];
                        obj[key] = PF + ' ';
                    } else if (key == 'CabinetTemp') {
                        const CabinetTemp = obj[key];
                        obj[key] = CabinetTemp + ' °C';
                    } else if (key == 'HeatsinkTemp') {
                        const HeatsinkTemp = obj[key];
                        obj[key] = HeatsinkTemp + ' °C';
                    } else if (key == 'InverterStat') {
                        const InverterStat = obj[key];
                        obj[key] = InverterStat + ' ';
                    } else if (key == 'StorageStat') {
                        const StorageStat = obj[key];
                        obj[key] = StorageStat + ' ';
                    } else if (key == 'MPPTPower1') {
                        const MPPTPower1 = obj[key];
                        solarPower1 = MPPTPower1;
                        localStorage.setItem("solarPower1", MPPTPower1);
                        obj[key] = MPPTPower1 + ' W';
                    } else if (key == 'MPPTPower2') {
                        const MPPTPower2 = obj[key];
                        solarPower2 = MPPTPower2;
                        localStorage.setItem("solarPower2", MPPTPower2);
                        obj[key] = MPPTPower2 + ' W';
                    } else if (key == 'MPPTVolt1') {
                        const MPPTVolt1 = obj[key];
                        solarVolt1 = MPPTVolt1;
                        localStorage.setItem("solarVolt1", solarVolt1);
                        obj[key] = MPPTVolt1 + ' V';
                    } else if (key == 'MPPTVolt2') {
                        const MPPTVolt2 = obj[key];
                        solarVolt2 = MPPTVolt2;
                        localStorage.setItem("solarVolt2", solarVolt2);
                        obj[key] = MPPTVolt2 + ' V';
                    } else if (key == 'MPPTCurr1') {
                        const MPPTCurr1 = obj[key];
                        solarCurr1 = MPPTCurr1;
                        localStorage.setItem("solarCurr1", solarCurr1);
                        obj[key] = MPPTCurr1 + ' A';
                    } else if (key == 'MPPTCurr2') {
                        const MPPTCurr2 = obj[key];
                        solarCurr2 = MPPTCurr2;
                        localStorage.setItem("solarCurr2", solarCurr2);
                        obj[key] = MPPTCurr2 + ' A';
                    } else if (key == 'RICEvalue') {
                        const RICEvalue = obj[key];
                        obj[key] = RICEvalue + ' ';
                    } else if (key == 'PVTemp') {
                        const PVTemp = obj[key];
                        obj[key] = PVTemp + ' °C';
                    } else if (key == 'PVStat') {
                        const PVStat = obj[key];
                        obj[key] = PVStat + ' ';
                    } else if (key == 'BattPower') {
                        const BattPower = obj[key];
                        batteryPower = BattPower;
                        localStorage.setItem("batteryPower", batteryPower);
                        obj[key] = BattPower + ' W';
                    } else if (key == 'BattVolt') {
                        const BattVolt = obj[key];
                        batteryVoltage = BattVolt;
                        localStorage.setItem("batteryVoltage", batteryVoltage);
                        obj[key] = BattVolt + ' V';
                    } else if (key == 'BattCurr') {
                        const BattCurr = obj[key];
                        obj[key] = BattCurr + ' A';
                    } else if (key == 'BattSoC') {
                        const BattSoC = obj[key];
                        batteryStateCharge = BattSoC;
                        localStorage.setItem("batteryStateCharge", batteryStateCharge);
                        obj[key] = BattSoC + ' %';
                    } else if (key == 'BattSoH') {
                        const BattSoH = obj[key];
                        obj[key] = BattSoH + ' %';
                    } else if (key == 'BattCycleNum') {
                        const BattCycleNum = obj[key];
                        obj[key] = BattCycleNum + ' ';
                    } else if (key == 'BattMaxChargPower') {
                        const BattMaxChargPower = obj[key];
                        obj[key] = BattMaxChargPower + ' W';
                    } else if (key == 'BattMaxDischarPower') {
                        const BattMaxDischarPower = obj[key];
                        obj[key] = BattMaxDischarPower + ' W';
                    } else if (key == 'BattStat') {
                        const BattStat = obj[key];
                        obj[key] = BattStat + ' ';
                    } else if (key == 'PMPower') {
                        const PMPower = obj[key];
                        grigliaPotenza = PMPower;
                        localStorage.setItem("grigliaPotenza", grigliaPotenza);
                        obj[key] = PMPower + ' W';
                    } else if (key == 'PowerRef') {
                        const PowerRef = obj[key];
                        obj[key] = PowerRef + ' ';
                    } else if (key == 'WorkProfile') {
                        const WorkProfile = obj[key];
                        obj[key] = WorkProfile + ' ';
                    } else if (key == 'DomesticPower') {
                        const DomesticPower = obj[key];
                        casaPotenza = DomesticPower;
                        localStorage.setItem("casaPotenza", casaPotenza);
                        obj[key] = DomesticPower + ' W';
                    } else if (key == 'PMVolt') {
                        const PMVolt = obj[key];
                        domesticVolt = PMVolt;
                        localStorage.setItem("domesticVolt", domesticVolt);
                        obj[key] = PMVolt + ' V';
                    } else if (key == 'PMCurr') {
                        const PMCurr = obj[key];
                        domesticCurr = PMCurr;
                        localStorage.setItem("domesticCurr", domesticCurr);
                        obj[key] = PMCurr + ' A';
                    } else if (key == 'RCurr') {
                        const RCurr = obj[key];
                        obj[key] = RCurr + ' ';
                    } else if (key == 'SCurr') {
                        const SCurr = obj[key];
                        obj[key] = SCurr + ' ';
                    } else if (key == 'TCurr') {
                        const TCurr = obj[key];
                        obj[key] = TCurr + ' ';
                    } else if (key == 'RSVolt') {
                        const RSVolt = obj[key];
                        obj[key] = RSVolt + ' ';
                    } else if (key == 'STVolt') {
                        const STVolt = obj[key];
                        obj[key] = STVolt + ' ';
                    } else if (key == 'TRVolt') {
                        const TRVolt = obj[key];
                        obj[key] = TRVolt + ' ';
                    } else if (key == 'SVolt') {
                        const SVolt = obj[key];
                        obj[key] = SVolt + ' ';
                    } else if (key == 'TVolt') {
                        const TVolt = obj[key];
                        obj[key] = TVolt + ' ';
                    } else if (key == 'AppPower') {
                        const AppPower = obj[key];
                        obj[key] = AppPower + ' ';
                    } else if (key == 'ReaPower') {
                        const ReaPower = obj[key];
                        obj[key] = ReaPower + ' ';
                    } else {
                        key = 'missing';
                        obj[key] = null;
                    }
                    totalSolarPower = parseFloat(solarPower1) + parseFloat(solarPower2);
                    var el = document.getElementById(key).innerHTML = obj[key];
                    if (el) {
                        el.value = obj[key];
                    }
                }
                if (totalSolarPower > 0) {
                    animSolarValue = '200;0';
                } else if (totalSolarPower < 0) {
                    animSolarValue = '-200;0';
                } else {
                    animSolarValue = '0;0';
                }
                if (grigliaPotenza > 0) {
                    animGridValue = '200;0';
                } else if (grigliaPotenza < 0) {
                    animGridValue = '-200;0';
                } else {
                    animGridValue = '0;0';
                }
                //opposta rispetto alle altre
                if (casaPotenza > 0) {
                    animDomesticValue = '-200;0';
                } else if (casaPotenza < 0) {
                    animDomesticValue = '200;0';
                } else {
                    animDomesticValue = '0;0';
                }
                if (batteryPower > 0) {
                    animStorageValue = '200;0';
                } else if (batteryPower < 0) {
                    animStorageValue = '-200;0';
                } else {
                    animStorageValue = '0;0';
                }
                const potenze = {
                    solare: Math.abs(totalSolarPower),
                    griglia: Math.abs(grigliaPotenza),
                    casa: Math.abs(casaPotenza),
                    batterie: Math.abs(batteryPower)
                };
                const potenzaMassima = Math.max(...Object.values(potenze));
                for (const key of Object.keys(potenze)) {
                    if (potenze[key] == potenzaMassima) {
                        if (`'${key}'` == `'solare'`) {
                            localStorage.setItem("recapInverter", "row rounded-4 py-2 ms-0 shadow bg-solar");
                            document.getElementById("recapInverter").className = "row rounded-4 py-2 ms-0 shadow bg-solar";
                        } else if (`'${key}'` == `'griglia'`) {
                            localStorage.setItem("recapInverter", "row rounded-4 py-2 ms-0 shadow bg-grid");
                            document.getElementById("recapInverter").className = "row rounded-4 py-2 ms-0 shadow bg-grid";
                        } else if (`'${key}'` == `'casa'`) {
                            continue;
                            //localStorage.setItem("recapInverter", "row rounded-4 py-2 ms-0 shadow bg-domestic");
                            //document.getElementById("recapInverter").className = "row rounded-4 py-2 ms-0 shadow bg-domestic";
                        } else if (`'${key}'` == `'batterie'`) {
                            localStorage.setItem("recapInverter", "row rounded-4 py-2 ms-0 shadow bg-battery");
                            document.getElementById("recapInverter").className = "row rounded-4 py-2 ms-0 shadow bg-battery";
                        } else {
                            localStorage.setItem("recapInverter", "row rounded-4 py-2 ms-0 shadow bg-object");
                            document.getElementById("recapInverter").className = "row rounded-4 py-2 ms-0 shadow bg-object";
                        }
                        break;
                    }
                }
                document.getElementById('animSolar').setAttribute('values', animSolarValue);
                document.getElementById('animGrid').setAttribute('values', animGridValue);
                document.getElementById('animDomestic').setAttribute('values', animDomesticValue);
                document.getElementById('animStorage').setAttribute('values', animStorageValue);
                document.getElementById("totalSolarPower").innerHTML = totalSolarPower + ' W';
                document.getElementById("solarVolt1").innerHTML = solarVolt1 + ' V,&nbsp;';
                document.getElementById("solarVolt2").innerHTML = solarVolt2 + ' V';
                document.getElementById("solarCurr1").innerHTML = solarCurr1 + ' A,&nbsp;';
                document.getElementById("solarCurr2").innerHTML = solarCurr2 + ' A';
                document.getElementById("PMPower").innerHTML = grigliaPotenza + ' W';
                document.getElementById("PMVolt").innerHTML = domesticVolt + ' V';
                document.getElementById("PMCurr").innerHTML = domesticCurr + ' A';
                document.getElementById("DomesticPower").innerHTML = casaPotenza + ' W';
                document.getElementById("domesticVolt").innerHTML = domesticVolt + ' V';
                document.getElementById("domesticCurr").innerHTML = domesticCurr + ' A';
                document.getElementById("batteryStateCharge").innerHTML = batteryStateCharge + '%';
                document.getElementById("batteryPower").innerHTML = batteryPower + ' W';
                document.getElementById("batteryVoltage").innerHTML = batteryVoltage + ' V';
            }
        };
        var pushstream = new PushStream({
            host: window.location.hostname,
            port: window.location.port,
            modes: "eventsource"
        });
        pushstream.onmessage = messageReceived;
        pushstream.addChannel('telemetry');
        pushstream.connect();
    </script>
    <script>
        $(document).ready(function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
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
    <script>
        solarPower1 = localStorage.getItem("solarPower1");
        solarPower2 = localStorage.getItem("solarPower2");
        if (typeof solarPower1 !== 'undefined' && solarPower1 !== null) {
            //solarPower1 = localStorage.getItem("solarPower1");
        } else {
            var solarPower1 = 0;
        }
        if (typeof solarPower2 !== 'undefined' && solarPower2 !== null) {
            //solarPower2 = localStorage.getItem("solarPower2");
        } else {
            var solarPower2 = 0;
        }
        //solarVolt1 = 0;
        //solarVolt2 = 0;
        solarVolt1 = localStorage.getItem("solarVolt1");
        solarVolt2 = localStorage.getItem("solarVolt2");
        if (typeof solarVolt1 !== 'undefined' && solarVolt1 !== null) {
            //solarVolt1 = localStorage.getItem("solarVolt1");
        } else {
            var solarVolt1 = 0;
        }
        if (typeof solarVolt2 !== 'undefined' && solarVolt2 !== null) {
            //solarVolt2 = localStorage.getItem("solarVolt2");
        } else {
            var solarVolt2 = 0;
        }
        //solarCurr1 = 0;
        //solarCurr2 = 0;
        solarCurr1 = localStorage.getItem("solarCurr1");
        solarCurr2 = localStorage.getItem("solarCurr2");
        if (typeof solarCurr1 !== 'undefined' && solarCurr1 !== null) {
            //solarCurr1 = localStorage.getItem("solarCurr1");
        } else {
            var solarCurr1 = 0;
        }
        if (typeof solarCurr2 !== 'undefined' && solarCurr2 !== null) {
            //solarCurr2 = localStorage.getItem("solarCurr2");
        } else {
            var solarCurr2 = 0;
        }
        //grigliaPotenza = 0;
        grigliaPotenza = localStorage.getItem("grigliaPotenza");
        if (typeof grigliaPotenza !== 'undefined' && grigliaPotenza !== null) {
            //grigliaPotenza = localStorage.getItem("grigliaPotenza");
        } else {
            var grigliaPotenza = 0;
        }
        //domesticVolt = 0;
        domesticVolt = localStorage.getItem("domesticVolt");
        if (typeof domesticVolt !== 'undefined' && domesticVolt !== null) {
            //domesticVolt = localStorage.getItem("domesticVolt");
        } else {
            var domesticVolt = 0;
        }
        //domesticCurr = 0;
        domesticCurr = localStorage.getItem("domesticCurr");
        if (typeof domesticCurr !== 'undefined' && domesticCurr !== null) {
            //domesticCurr = localStorage.getItem("domesticCurr");
        } else {
            var domesticCurr = 0;
        }
        //casaPotenza = 0;
        casaPotenza = localStorage.getItem("casaPotenza");
        if (typeof casaPotenza !== 'undefined' && casaPotenza !== null) {
            //casaPotenza = localStorage.getItem("casaPotenza");
        } else {
            var casaPotenza = 0;
        }
        //batteryPower = 0
        batteryPower = localStorage.getItem("batteryPower");
        if (typeof batteryPower !== 'undefined' && batteryPower !== null) {
            //batteryPower = localStorage.getItem("batteryPower");
        } else {
            var batteryPower = 0;
        }
        //batteryStateCharge = 0;
        batteryStateCharge = localStorage.getItem("batteryStateCharge");
        if (typeof batteryStateCharge !== 'undefined' && batteryStateCharge !== null) {
            //batteryStateCharge = localStorage.getItem("batteryStateCharge");
        } else {
            var batteryStateCharge = 0;
        }
        //batteryVoltage = 0;
        batteryVoltage = localStorage.getItem("batteryVoltage");
        if (typeof batteryVoltage !== 'undefined' && batteryVoltage !== null) {
            //batteryVoltage = localStorage.getItem("batteryVoltage");
        } else {
            var batteryVoltage = 0;
        }

        recapInverter = localStorage.getItem("recapInverter");
        if (typeof recapInverter !== 'undefined' && recapInverter !== null) {
            //recapInverter = localStorage.getItem("recapInverter");
        } else {
            var recapInverter = "row rounded-4 py-2 ms-0 shadow bg-object";
        }
        document.getElementById("recapInverter").className = recapInverter;
        totalSolarPower = parseFloat(solarPower1) + parseFloat(solarPower2);
        document.getElementById("totalSolarPower").innerHTML = totalSolarPower + ' W';
        document.getElementById("solarVolt1").innerHTML = solarVolt1 + ' V,&nbsp;';
        document.getElementById("solarVolt2").innerHTML = solarVolt2 + ' V';
        document.getElementById("solarCurr1").innerHTML = solarCurr1 + ' A,&nbsp;';
        document.getElementById("solarCurr2").innerHTML = solarCurr2 + ' A';
        document.getElementById("PMPower").innerHTML = grigliaPotenza + ' W';
        document.getElementById("PMVolt").innerHTML = domesticVolt + ' V';
        document.getElementById("PMCurr").innerHTML = domesticCurr + ' A';
        document.getElementById("DomesticPower").innerHTML = casaPotenza + ' W';
        document.getElementById("domesticVolt").innerHTML = domesticVolt + ' V';
        document.getElementById("domesticCurr").innerHTML = domesticCurr + ' A';
        document.getElementById("batteryStateCharge").innerHTML = batteryStateCharge + '%';
        document.getElementById("batteryPower").innerHTML = batteryPower + ' W';
        document.getElementById("batteryVoltage").innerHTML = batteryVoltage + ' V';
    </script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!--# endif -->