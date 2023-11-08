<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$id = $_SESSION["id"];
$auth = $_SESSION["auth"];
$firstlogin = $_SESSION["firstlogin"];
$tipoecharger = $_SESSION["echargertipo"];
switch ($tipoecharger) {
    case '0':
    case '4':
    case '8':
    case '12':
        $iconaTipo = 'img/ico_wb_mono_cable.png';
        break;
    case '1':
    case '5':
    case '9':
    case '13':
        $iconaTipo = 'img/ico_wb_tri_cable.png';
        break;
    case '2':
    case '6':
    case '10':
    case '14':
        $iconaTipo = 'img/ico_wb_mono_nocable.png';
        break;
    case '3':
    case '7':
    case '11':
    case '15':
        $iconaTipo = 'img/ico_wb_tri_nocable.png';
        break;
    default:
        $iconaTipo = 'img/ico_wb_nodata.png';
}
if ($firstlogin == 1) {
    header("location: change_password.php");
    exit;
}
require_once "inc/config.php";
include_once "loader.php";
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
if (isset($_POST['response'])) {
    $response = exec('issue_command ' . $_POST['parameter'] . " " . $_POST['response']);
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
// 0=admin 1=installer 2=user
if ($auth == 0) {
    $utente = 'admin';
} elseif ($auth == 1) {
    $utente = 'installer';
} else {
    $utente = 'user';
}
##################### QUERY SQL CARTE #####################
$jsonDataH    = '[ {';
$jsonDataB    = '';
$jsonDataF    = '} ]';
$link   = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT, DB_SOCKET);
$sql = "SELECT `card_no`, `name` FROM cards";
if ($stmt = mysqli_prepare($link, $sql)) {
    if (mysqli_stmt_execute($stmt)) {
        $result = $stmt->get_result();
        $nrows = 0;
        while ($row = $result->fetch_assoc()) {
            $nrows++;
            $jsonDataB .= "numero:'" . $row["card_no"] . "',nome:'" . $row["name"] . "'},{";
        }
        if ($nrows == 0) {
            echo "Missing parameter.";
        }
    } else {
        echo "Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($link);
$jsonDataB = rtrim($jsonDataB, '{,}');
$json      = $jsonDataH . $jsonDataB . $jsonDataF;
?>
<!--# if expr="$internetenabled=false" -->
<!--# include file="session.php" -->
<!--# include file="index_provisioning.php" -->
<!--# else -->
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">

<head>
    <title><?= _TITLETELEMETRY ?></title>
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
                            <a href="telemetry.php" class="dkc-selected">
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
    <div class="offcanvas offcanvas-start" style="background-color: #0e1b35" tabindex="-1" id="offcanvasFunzioni" aria-labelledby="offcanvasFunzioniLabel" data-bs-toggle="offcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasFunzioniLabel"><img src="img/<?php echo $logo ?>" width="130" height="40"></h5>
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
                        <a href="telemetry.php" class="dkc-selected">
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
            <h5 class="offcanvas-title" id="offcanvasStatisticheLabel"><img src="img/<?php echo $logo ?>" width="130" height="40"></h5>
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
            <h5 class="offcanvas-title" id="offcanvasConfigurazioneLabel"><img src="img/<?php echo $logo ?>" width="130" height="40"></h5>
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
                    <div class=" d-flex align-items-justify">
                        <div class="col d-flex align-items-start">
                            <img src="img/icon_title.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            <h3 class="bold text-dkc"><?= _HEADTELEMETRY . '&nbsp;' ?></h3>
                            <img id="iconaInternet" src="img/offlineLight.png">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between py-2 ms-0">
                <div class="col-7 col-md-6 col-lg-4 d-flex align-items-center me-lg-1 mb-lg-0 mb-1 text-break rounded-4 bg-grigiochiaro" style="min-height: 80px;">
                    <div class="icon-square flex-shrink-0 mt-1 me-3">
                        <img src="img/ico_telemetria_grande.png">
                    </div>
                    <div>
                        <h6 class="fw-bold mt-3"><?= _MENUECHARGER ?> <span class="text-dkc"><?= $_SESSION["macaddress"] ?></span></h6>
                    </div>
                </div>
                <div class="col d-flex justify-content-end h-50">
                    <?php echo $response_toast; ?>
                </div>
            </div>
            <form id="statoWbClasse" class="row py-3 ms-0 rounded-4 shadow mt-2 mb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="parameter" value="3000">
                <div class="col-6 col-lg-5 d-flex align-items-center me-lg-1 mb-lg-0 mb-1 text-break">
                    <div class="icon-square flex-shrink-0 mt-0 me-3">
                        <img src="<?= $iconaTipo ?>">
                    </div>
                    <p class="mt-0 lh-sm"><span class="fwb-head">Stato:</span><br>
                        <input type="hidden" value="bg1-0">
                        <b class="fwb-text" id="statowallboxbottoni"></b>
                    </p>
                </div>
                <div class="col-3 col-lg-3 me-0 align-items-center text-center">
                    <div class="row d-flex align-items-center justify-content-end">
                        <button id="startWbClasse" type="submit" name="response" value="0" class="btn text-decoration-none icon-disabled">
                            <div class="col ms-1">
                                <img class="float-start" id="startWbImg" src="img/startIconDisabled.png">
                            </div>
                            <div class="col text-start d-none d-lg-block">
                                <h4 class="fw-bold mt-2 ps-5 ms-5"><?= _TABLE3000STARTCOMMANDS ?></h4>
                            </div>
                        </button>
                    </div>
                </div>
                <div class="col-3 col-lg-3 me-0 align-items-center text-center">
                    <div class="row d-flex align-items-center justify-content-end">
                        <button id="stopWbClasse" type="submit" name="response" value="2" class="btn text-decoration-none icon-disabled">
                            <div class="col ms-1">
                                <img class="float-start" id="stopWbImg" src="img/stopIconDisabled.png">
                            </div>
                            <div class="col text-start d-none d-lg-block">
                                <h4 class="fw-bold mt-2 ps-5 ms-5"><?= _TABLE3000STOPCOMMANDS ?></h4>
                            </div>
                        </button>
                    </div>
                </div>
            </form>
            <div class="row py-3 ms-0 rounded-4 shadow">
                <div class="row">
                    <div class="col mt-2 table-responsive ">
                        <table class="table table-sm table-hover table-borderless">
                            <thead class="thead-dark">
                                <tr>
                                    <th><?= _TABLEDATATELEMETRY ?></th>
                                    <th class="text-end"><?= _TABLEVALUETELEMETRY ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= _TABLEPOWERMETERTELEMETRY ?></td>
                                    <td class="text-end" id="potenzacarichidomestici"> W</td>
                                </tr>
                                <tr>
                                    <td><?= _TABLEINSTANTPOWERTELEMETRY ?></td>
                                    <td class="text-end" id="potenzawallbox"> W</td>
                                </tr>
                                <tr>
                                    <td><?= _TABLERPHASECURRENTRTELEMETRY ?></td>
                                    <td class="text-end" id="corrente"> A</td>
                                </tr>
                                <tr>
                                    <td><?= _TABLESPHASECURRENTRTELEMETRY ?></td>
                                    <td class="text-end" id="corrente2"> A</td>
                                </tr>
                                <tr>
                                    <td><?= _TABLETPHASECURRENTRTELEMETRY ?></td>
                                    <td class="text-end" id="corrente3"> A</td>
                                </tr>
                                <tr>
                                    <td><?= _TABLEVOLTAGETELEMETRY ?></td>
                                    <td class="text-end" id="tensione"> V</td>
                                </tr>
                                <tr>
                                    <td><?= _TABLEACTIVEUSERTELEMETRY ?></td>
                                    <td class="text-end" id="utenteattivo"></td>
                                </tr>
                                <tr>
                                    <td><?= _TABLECHARGINGTIMETELEMETRY ?></td>
                                    <td class="text-end" id="worktime"> hh:mm:ss</td>
                                </tr>
                                <tr>
                                    <td><?= _TABLESUPPLIEDENERGYTELEMETRY ?></td>
                                    <td class="text-end" id="energiacicloricarica"> kWh</td>
                                </tr>
                                <tr>
                                    <td><?= _TABLETEMPERATURETELEMETRY ?></td>
                                    <td class="text-end" id="temperatura"> °C</td>
                                </tr>
                                <tr>
                                    <td><?= _TABLEECHARGERSTATUSTELEMETRY ?></td>
                                    <td class="text-end" id="statowallbox"></td>
                                </tr>
                            </tbody>
                        </table>
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
    <script src="js/jquery.min.js"></script>
    <script src="js/pushstream.js" type="text/javascript" language="javascript" charset="utf-8"></script>
    <script type="text/javascript" language="javascript" charset="utf-8">
        function messageReceived(text, id, channel) {
            const phpArray = <?php echo $json; ?>;
            if (channel == 'map1') {
                const obj = JSON.parse(text);
                for (var key of Object.keys(obj)) {
                    if (key == 'potenzacarichidomestici') {
                        const potenzacarichidomesticiwb = obj[key];
                        obj[key] = potenzacarichidomesticiwb + ' W';
                    }
                    if (key == 'potenzawallbox') {
                        const potenzawallboxwb = obj[key];
                        obj[key] = potenzawallboxwb + ' W';
                    }
                    if (key == 'corrente') {
                        const correntewb = obj[key];
                        obj[key] = correntewb + ' A';
                    }
                    if (key == 'corrente2') {
                        const corrente2wb = obj[key];
                        obj[key] = corrente2wb + ' A';
                    }
                    if (key == 'corrente3') {
                        const corrente3wb = obj[key];
                        obj[key] = corrente3wb + ' A';
                    }
                    if (key == 'tensione') {
                        const tensionewb = obj[key].toFixed();
                        obj[key] = tensionewb + ' V';
                    }
                    if (key == 'utenteattivo') {
                        const utentewb = obj[key];
                        obj[key] = '<?= _TABLEACTIVEUSERTELEMETRYNOBODY ?>';
                        for (var i = 0; i < phpArray.length; i++) {
                            if (phpArray[i].numero == utentewb) {
                                obj[key] = phpArray[i].nome;
                            }
                        }
                    }
                    if (key == 'worktime') {
                        const tempolavoro = new Date(obj[key] * 1000).toISOString().slice(11, 19);
                        obj[key] = tempolavoro + ' hh:mm:ss';
                    }
                    if (key == 'energiacicloricarica') {
                        const energiacarica = obj[key].toFixed(2);
                        obj[key] = energiacarica + ' kWh';
                    }
                    if (key == 'temperatura') {
                        const temperaturawb = obj[key].toFixed();
                        obj[key] = temperaturawb + ' °C';
                    }
                    if (key == 'statowallbox' && obj[key] == 0) {
                        obj[key] = '<?= _ECHARGERSTATUSREADY ?>';
                        var statoecharger = '<?= _ECHARGERSTATUSREADY ?>';
                        $.post('set_type.php', {
                            'echargerstato': statoecharger
                        });
                        document.getElementById("statoWbClasse").className = "row py-3 ms-0 rounded-4 shadow mt-2 mb-3 bg1-0";
                        document.getElementById("startWbClasse").className = "btn text-decoration-none icon-disabled";
                        document.getElementById("startWbImg").src = 'img/startIconDisabled.png';
                        document.getElementById("stopWbClasse").className = "btn text-decoration-none icon-disabled";
                        document.getElementById("stopWbImg").src = 'img/stopIconDisabled.png';
                        document.getElementById("statowallboxbottoni").innerHTML = "<?= _ECHARGERSTATUSREADY ?>";
                    } else if (key == 'statowallbox' && obj[key] == 1) {
                        obj[key] = '<?= _ECHARGERSTATUSCONNECTED ?>';
                        var statoecharger = '<?= _ECHARGERSTATUSCONNECTED ?>';
                        $.post('set_type.php', {
                            'echargerstato': statoecharger
                        });
                        document.getElementById("statoWbClasse").className = "row py-3 ms-0 rounded-4 shadow mt-2 mb-3 bg1-1";
                        document.getElementById("startWbClasse").className = "btn text-decoration-none";
                        document.getElementById("startWbImg").src = 'img/startIconEnabled.png';
                        document.getElementById("stopWbClasse").className = "btn text-decoration-none icon-disabled";
                        document.getElementById("stopWbImg").src = 'img/stopIconDisabled.png';
                        document.getElementById("statowallboxbottoni").innerHTML = "<?= _ECHARGERSTATUSCONNECTED ?>";
                    } else if (key == 'statowallbox' && obj[key] == 2) {
                        obj[key] = '<?= _ECHARGERSTATUSCHARGING ?>';
                        var statoecharger = '<?= _ECHARGERSTATUSCHARGING ?>';
                        $.post('set_type.php', {
                            'echargerstato': statoecharger
                        });
                        document.getElementById("statoWbClasse").className = "row py-3 ms-0 rounded-4 mt-2 mb-3 bg1-2";
                        document.getElementById("startWbClasse").className = "btn text-decoration-none icon-disabled";
                        document.getElementById("startWbImg").src = 'img/startIconDisabled.png';
                        document.getElementById("stopWbClasse").className = "btn text-decoration-none";
                        document.getElementById("stopWbImg").src = 'img/stopIconEnabled.png';
                        document.getElementById("statowallboxbottoni").innerHTML = "<?= _ECHARGERSTATUSCHARGING ?>";
                    } else if (key == 'statowallbox' && obj[key] == 3) {
                        obj[key] = '<?= _ECHARGERSTATUSLOCKED ?>';
                        var statoecharger = '<?= _ECHARGERSTATUSLOCKED ?>';
                        $.post('set_type.php', {
                            'echargerstato': statoecharger
                        });
                        document.getElementById("statoWbClasse").className = "row py-3 ms-0 rounded-4 shadow mt-2 mb-3 bg1-3";
                        document.getElementById("startWbClasse").className = "btn text-decoration-none icon-disabled";
                        document.getElementById("startWbImg").src = 'img/startIconDisabled.png';
                        document.getElementById("stopWbClasse").className = "btn text-decoration-none icon-disabled";
                        document.getElementById("stopWbImg").src = 'img/stopIconDisabled.png';
                        document.getElementById("statowallboxbottoni").innerHTML = "<?= _ECHARGERSTATUSLOCKED ?>";
                    } else if (key == 'statowallbox' && obj[key] == 4) {
                        obj[key] = '<?= _ECHARGERSTATUSERROR ?>';
                        var statoecharger = '<?= _ECHARGERSTATUSERROR ?>';
                        $.post('set_type.php', {
                            'echargerstato': statoecharger
                        });
                        document.getElementById("statoWbClasse").className = "row py-3 ms-0 rounded-4 shadow mt-2 mb-3 bg1-4";
                        document.getElementById("startWbClasse").className = "btn text-decoration-none icon-disabled";
                        document.getElementById("startWbImg").src = 'img/startIconDisabled.png';
                        document.getElementById("stopWbClasse").className = "btn text-decoration-none icon-disabled";
                        document.getElementById("stopWbImg").src = 'img/stopIconDisabled.png';
                        document.getElementById("statowallboxbottoni").innerHTML = "<?= _ECHARGERSTATUSERROR ?>";
                    } else if (key == 'statowallbox' && obj[key] == 5) {
                        obj[key] = '<?= _ECHARGERSTATUSCONNECTED ?>';
                        var statoecharger = '<?= _ECHARGERSTATUSCONNECTED ?>';
                        $.post('set_type.php', {
                            'echargerstato': statoecharger
                        });
                        document.getElementById("statoWbClasse").className = "row py-3 ms-0 rounded-4 shadow mt-2 mb-3 bg1-5";
                        document.getElementById("startWbClasse").className = "btn text-decoration-none";
                        document.getElementById("startWbImg").src = 'img/startIconEnabled.png';
                        document.getElementById("stopWbClasse").className = "btn text-decoration-none icon-disabled";
                        document.getElementById("stopWbImg").src = 'img/stopIconDisabled.png';
                        document.getElementById("statowallboxbottoni").innerHTML = "<?= _ECHARGERSTATUSCONNECTED ?>";
                    } else if (key == 'statowallbox' && obj[key] > 5) {
                        obj[key] = '<?= _ECHARGERSTATUSERROR ?>';
                        var statoecharger = '<?= _ECHARGERSTATUSERROR ?>';
                        $.post('set_type.php', {
                            'echargerstato': statoecharger
                        });
                        document.getElementById("statoWbClasse").className = "row py-3 ms-0 rounded-4 shadow mt-2 mb-3 bg1-4";
                        document.getElementById("startWbClasse").className = "btn text-decoration-none icon-disabled";
                        document.getElementById("startWbImg").src = 'img/startIconDisabled.png';
                        document.getElementById("stopWbClasse").className = "btn text-decoration-none icon-disabled";
                        document.getElementById("stopWbImg").src = 'img/stopIconDisabled.png';
                        document.getElementById("statowallboxbottoni").innerHTML = "<?= _ECHARGERSTATUSERROR ?>";
                    };
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
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!--# endif -->