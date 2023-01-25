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
if (isset($_POST['response'])) {
    $response = exec('issue_command 7002 ' . $_REQUEST['parameter'] . " " . $_REQUEST['valore']);
    if ($_REQUEST['valore'] == 'it-IT') {
        include "inc/config.php";
        include "inc/l_it.php";
    } else if ($_REQUEST['valore'] == 'en-EN') {
        include "inc/config.php";
        include "inc/l_en.php";
    } else if ($_REQUEST['valore'] == 'ru-RU') {
        include "inc/config.php";
        include "inc/l_ru.php";
    }
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
require_once "inc/config.php";
if (trovaLingua() == 'it') {
    include "inc/l_it.php";
} else if (trovaLingua() == 'en') {
    include "inc/l_en.php";
} else if (trovaLingua() == 'ru') {
    include "inc/l_ru.php";
}
// 0=admin 1=installer 2=user
if ($auth == 0) {
    $utente = 'admin';
    $listConf = '0, 1, 2';
} elseif ($auth == 1) {
    $utente = 'installer';
    $listConf = '1, 2';
} else {
    $utente = 'user';
    $listConf = '2';
    //    $configuration_menu = "";
}
?>
<!--# if expr="$internetenabled=false" -->
<!--# include file="session.php" -->
<!--# include file="index_provisioning.php" -->
<!--# else -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= _TITLECONFIGURATIONS ?></title>
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
                                <img src="img/ico_inverter.png" width="25px" class="me-3">
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
                                <img src="img/ico_service.png" width="25px" class="me-3">
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
                                <img src="img/ico_notifiche.png" width="25px" class="me-3">
                                <?= _MENUCOMMANDS ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="configurations.php" class="dkc-selected">
                                <img src="img/ico_portale.png" width="25px" class="me-3">
                                <?= _MENUCONFIGURATIONS ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="errors.php">
                                <img src="img/ico_error.png" width="25px" class="me-3">
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
                            <img src="img/ico_inverter.png" width="25px" class="me-3">
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
                            <img src="img/ico_service.png" width="25px" class="me-3">
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
                            <img src="img/ico_notifiche.png" width="25px" class="me-3">
                            <?= _MENUCOMMANDS ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="configurations.php" class="dkc-selected">
                            <img src="img/ico_portale.png" width="25px" class="me-3">
                            <?= _MENUCONFIGURATIONS ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="errors.php">
                            <img src="img/ico_error.png" width="25px" class="me-3">
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
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container-fluid mt-1 ms-auto">
            <!-- ################################# INIZIO PAGINA ################################################ -->
            <div class="row ms-2">
                <div class="justify-content-between flex-wrap flex-md-nowrap align-items-center pt-0">
                    <div class="d-flex align-items-start">
                        <div class="col d-flex align-items-start">
                            <img src="img/icon_title.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            <h3 class="bold text-dkc"><?= _HEADCONFIGURATIONS ?></h3>
                        </div>
                        <div class="col d-flex justify-content-end">
                        </div>
                    </div>
                    <?php echo $response_toast; ?>
                </div>
            </div>
            <div class="row mt-1 ms-2 rounded shadow-sm py-2">
                <div class="col mt-1">
                    <table class="table table-light table-sm table-responsive table-hover text-break">
                        <thead class="thead-dark">
                            <tr>
                                <th><?= _TABLENAMECONFIGURATIONS ?></th>
                                <th><?= _TABLEVALUECONFIGURATIONS ?></th>
                                <th><?= _TABLEUOMCONFIGURATIONS ?></th>
                                <th><?= _TABLEMODIFYCONFIGURATIONS ?></th>
                                <th class="d-none"><?= _TABLEHELPCONFIGURATIONS ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            ##################### QUERY SQL TRANSAZIONI #####################
                            $sql = "SELECT * FROM configuration WHERE visibility IN ($listConf) ORDER BY id ASC";
                            if ($stmt = mysqli_prepare($link, $sql)) {
                                if (mysqli_stmt_execute($stmt)) {
                                    $result = $stmt->get_result();
                                    $nrows = 0;
                                    while ($row = $result->fetch_assoc()) {
                                        $nrows++;
                                        if ($row['tipo'] == 'bool') {
                                            $formtipo = "<select class='form-select form-select-sm' name='valore' required><option selected disabled value=''>" . _TABLESELCONFIGURATIONS . "</option><option value='true' >" . _TABLETRUECONFIGURATIONS . "</option><option value='false'>" . _TABLEFALSECONFIGURATIONS . "</option></select>";
                                        } elseif ($row['tipo'] == 'float') {
                                            $formtipo = "<input class='form-control form-control-sm' type='number' step= '0.1' min= '0' placeholder='' name='valore' required>";
                                        } elseif ($row['tipo'] == 'int') {
                                            $formtipo = "<input class='form-control form-control-sm' type='number' step= '1' min= '0' placeholder='' name='valore' required>";
                                        } elseif ($row['tipo'] == 'string') {
                                            $formtipo = "<input class='form-control form-control-sm' type='text' maxlength='255' placeholder='' name='valore' required>";
                                        } elseif ($row['tipo'] == 'uint8_t') {
                                            $formtipo = "<input class='form-control form-control-sm' type='number' step= '1' min= '0' max= '255' placeholder='' name='valore' required>";
                                        } elseif ($row['tipo'] == 'uint16_t') {
                                            $formtipo = "<input class='form-control form-control-sm' type='number' step= '1' min= '0' max= '65535' placeholder='' name='valore' required>";
                                        } elseif ($row['tipo'] == 'uint32_t') {
                                            $formtipo = "<input class='form-control form-control-sm' type='number' step= '1' min= '0' max= '4294967295' placeholder='' name='valore' required>";
                                        } else {
                                            $formtipo = "<div>Missing parameter</div>";
                                        }
                                        if ($row['name'] == 'minimum_available_power') {
                                            $formnome = _TABLECONF1;
                                        } else if ($row['name'] == 'rfid_validity_timeout') {
                                            $formnome = _TABLECONF2;
                                        } else if ($row['name'] == 'userstop_long_press') {
                                            $formnome = _TABLECONF3;
                                        } else if ($row['name'] == 'userstop_verylong_press') {
                                            $formnome = _TABLECONF4;
                                        } else if ($row['name'] == 'minimum_current_available_vehicle') {
                                            $formnome = _TABLECONF5;
                                        } else if ($row['name'] == 'builder_name') {
                                            $formnome = _TABLECONF6;
                                        } else if ($row['name'] == 'modbus_address') {
                                            $formnome = _TABLECONF7;
                                        } else if ($row['name'] == 'activation_timestamp') {
                                            $formnome = _TABLECONF8;
                                        } else if ($row['name'] == 'language') {
                                            $formnome = _TABLECONF9;
                                            $formtipo = "<select class='form-select form-select-sm' name='valore' required><option selected disabled value=''>" . _TABLESELCONFIGURATIONS . "</option><option value='it-IT' >" . _TABLEITCONFIGURATIONS . "</option><option value='en-EN'>" . _TABLEENCONFIGURATIONS . "</option><option value='ru-RU'>" . _TABLERUCONFIGURATIONS . "</option></select>";
                                        } else if ($row['name'] == 'polling_period_realtime_mqtt_data') {
                                            $formnome = _TABLECONF10;
                                        } else if ($row['name'] == 'wallbox_serial_number') {
                                            $formnome = _TABLECONF11;
                                        } else if ($row['name'] == 'max_temperature_on') {
                                            $formnome = _TABLECONF12;
                                        } else if ($row['name'] == 'min_temperature_off') {
                                            $formnome = _TABLECONF13;
                                        } else if ($row['name'] == 'min_voltage') {
                                            $formnome = _TABLECONF14;
                                        } else if ($row['name'] == 'max_voltage') {
                                            $formnome = _TABLECONF15;
                                        } else if ($row['name'] == 'wallbox_connection_timeout') {
                                            $formnome = _TABLECONF16;
                                        } else if ($row['name'] == 'wallbox_ocpp_server_ip_address') {
                                            $formnome = _TABLECONF17;
                                        } else if ($row['name'] == 'wallbox_ocpp_ip_server_port') {
                                            $formnome = _TABLECONF18;
                                        } else if ($row['name'] == 'wallbox_ocpp_url_server') {
                                            $formnome = _TABLECONF19;
                                        } else if ($row['name'] == 'has_car_powermeter_mid') {
                                            $formnome = _TABLECONF20;
                                        } else if ($row['name'] == 'has_domestic_powermeter') {
                                            $formnome = _TABLECONF21;
                                        } else if ($row['name'] == 'inverter_presence') {
                                            $formnome = _TABLECONF22;
                                        } else if ($row['name'] == 'charge_paused_at_startup') {
                                            $formnome = _TABLECONF23;
                                        } else if ($row['name'] == 'led_intensity_factor') {
                                            $formnome = _TABLECONF24;
                                        } else if ($row['name'] == 'timezone') {
                                            $formnome = _TABLECONF25;
                                        } else {
                                            $formnome = _TABLECONF26;
                                        }

                                        echo "</td><td>" . $formnome .
                                            "</td><td>" . $row['value'] .
                                            "</td><td>" . $row['unit'] .
                                            "</td><td>" .
                                            "<form class='row g-3 me-1' action='" . ($_SERVER["PHP_SELF"]) . "' method='post'>
<div class='col-8 col-sm-6'>
<input type='hidden' name= 'parameter' value='" . $row['id'] . "'>
<input type='hidden' name= 'type' value='" . $row['tipo'] . "'>" .
                                            $formtipo .
                                            "</div>
<div class='col-4 col-sm-6'><button type='submit' name='response' class='btn btn-primary btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-check-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'></path></svg><span class='d-none d-lg-block'>" . _TABLEUPDATECONFIGURATIONS . "</span></button></div></form>" .
                                            "</td><td class='d-none'><button type='button' class='btn btn-warning btn-sm' data-toggle='tooltip' data-bs-placement='left' title='" . $row['description'] . "'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-info-circle-fill' viewBox='0 0 16 16'><path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'></path></svg><span class='d-none d-lg-block'>" . _TABLEHELPCONFIGURATIONS . "</span></button></td></tr>";
                                    }
                                    if ($nrows == 0) {
                                        echo "<tr><td colspan='5'>" . _TABLENOCONFIGURATIONS . "</td></tr>";
                                    }
                                } else {
                                    echo "Something went wrong. Please try again later.";
                                }
                                mysqli_stmt_close($stmt);
                            }
                            mysqli_close($link);
                            ?>
                        </tbody>
                    </table>

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

    <script src="js/jquery.slim.min.js"></script>
    <script>
        $(document).ready(function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!--# endif -->
