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
    $response = exec('issue_command ' . $_POST['parameter'] . " " . $_POST['valore']);
    //echo ('issue_command ' . $_POST['parameter'] . " " . $_POST['valore']);
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
$response_toast = '';
// 0=admin 1=installer 2=user
if ($auth == 0) {
    $utente = 'admin';
} elseif ($auth == 1) {
    $utente = 'installer';
} else {
    $utente = 'user';
}
$_SESSION["macaddress"] = '<!--#  echo var="MACAddr" -->';
##################### QUERY DATI GIORNO O SETTIMANA #####################
$day = 7;
$week = 1;
if (isset($_POST['timeInput'])) {
    //echo 'MOSTRO LA SETTIMANA';
    $timeSwitch = 'checked';
    $chartTitle = _WEEKLYCHART;
    $sqlChart = sprintf("SELECT Time, PMPower,DomesticPower,ActPower,MPPTPower1,MPPTPower2,BattPower,BattSoC,CabinetTemp FROM weekly_datas WHERE `Time` >= NOW() - INTERVAL $week WEEK");
    //    $sqlSum = sprintf("SELECT SUM(MPPTPower1),SUM(MPPTPower2),SUM(PMPower),SUM(BattPower),SUM(DomesticPower),SUM(ActPower) FROM (SELECT FROM_UNIXTIME((UNIX_TIMESTAMP(Time) div (60*60))*(60*60)+(60*60)) as FinalStamps, round(avg(MPPTPower1),3) as MPPTPower1, round(avg(MPPTPower2),3) as MPPTPower2, round(avg(PMPower),3) as PMPower, round(avg(BattPower),3) as BattPower, round(avg(DomesticPower),3) as DomesticPower, round(avg(ActPower),3) as ActPower FROM weekly_datas GROUP by 1 ) src;");
    $sqlSum = sprintf("SELECT SUM(MPPTPower1),SUM(MPPTPower2),SUM(PMPower),SUM(case when PMPower > 0 then PMPower else 0 end),SUM(case when PMPower < 0 then PMPower else 0 end),SUM(BattPower),SUM(DomesticPower),SUM(ActPower) FROM (SELECT FROM_UNIXTIME((UNIX_TIMESTAMP(Time) div (60*60))*(60*60)+(60*60)) as FinalStamps, round(avg(MPPTPower1),3) as MPPTPower1, round(avg(MPPTPower2),3) as MPPTPower2, round(avg(PMPower),3) as PMPower, round(avg(BattPower),3) as BattPower, round(avg(DomesticPower),3) as DomesticPower, round(avg(ActPower),3) as ActPower FROM weekly_datas GROUP by 1 ) src;");
} else {
    $chartTitle = _DAILYCHART;
    $sqlChart = sprintf("SELECT Time, PMPower,DomesticPower,ActPower,MPPTPower1,MPPTPower2,BattPower,BattSoC,CabinetTemp FROM daily_datas WHERE `Time` >= NOW() - INTERVAL $day DAY");
    //    $sqlSum = sprintf("SELECT SUM(MPPTPower1),SUM(MPPTPower2),SUM(PMPower),SUM(BattPower),SUM(DomesticPower),SUM(ActPower) FROM (SELECT FROM_UNIXTIME((UNIX_TIMESTAMP(Time) div (60*60))*(60*60)+(60*60)) as FinalStamps, round(avg(MPPTPower1),3) as MPPTPower1, round(avg(MPPTPower2),3) as MPPTPower2, round(avg(PMPower),3) as PMPower, round(avg(BattPower),3) as BattPower, round(avg(DomesticPower),3) as DomesticPower, round(avg(ActPower),3) as ActPower FROM daily_datas WHERE Time NOT IN (SELECT Time FROM weekly_datas) GROUP BY 1 ) src;");
    $sqlSum = sprintf("SELECT SUM(MPPTPower1),SUM(MPPTPower2),SUM(PMPower),SUM(case when PMPower > 0 then PMPower else 0 end),SUM(case when PMPower < 0 then PMPower else 0 end),SUM(BattPower),SUM(DomesticPower),SUM(ActPower) FROM (SELECT FROM_UNIXTIME((UNIX_TIMESTAMP(Time) div (60*60))*(60*60)+(60*60)) as FinalStamps, round(avg(MPPTPower1),3) as MPPTPower1, round(avg(MPPTPower2),3) as MPPTPower2, round(avg(PMPower),3) as PMPower, round(avg(BattPower),3) as BattPower, round(avg(DomesticPower),3) as DomesticPower, round(avg(ActPower),3) as ActPower FROM daily_datas WHERE Time NOT IN (SELECT Time FROM weekly_datas) GROUP BY 1 ) src;");
}
//echo 'MOSTRO LA GIORNATA';
$tempo = '';
$meter = '';
$home = '';
$active = '';
$mppt1 = '';
$mppt2 = '';
$batterypower = '';
$batterysoc = '';
$temperature = '';
if ($stmt = mysqli_prepare($link, $sqlChart)) {
    if (mysqli_stmt_execute($stmt)) {
        $result = $stmt->get_result();
        foreach ($result as $row) {
            $tempo  .= '\'' . substr($row['Time'], 11, 5) . '\', ';
            $meter .= $row['PMPower'] . ', ';
            $home   .= $row['DomesticPower'] . ', ';
            $active   .= $row['ActPower'] . ', ';
            $mppt1   .= $row['MPPTPower1'] . ', ';
            $mppt2   .= $row['MPPTPower2'] . ', ';
            $batterypower   .= $row['BattPower'] . ', ';
            $batterysoc   .= $row['BattSoC'] . ', ';
            $temperature   .= $row['CabinetTemp'] . ', ';
        }
    } else {
        echo "Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt);
}
if ($stmt = mysqli_prepare($link, $sqlSum)) {
    if (mysqli_stmt_execute($stmt)) {
        $result = $stmt->get_result();
        foreach ($result as $row) {
            $SumMPPTPower1 = $row['SUM(MPPTPower1)'];
            $SumMPPTPower2 = $row['SUM(MPPTPower2)'];
            $SumPMPower = $row['SUM(PMPower)'];
            $SumMajor = $row['SUM(case when PMPower > 0 then PMPower else 0 end)'];
            $SumMinor = $row['SUM(case when PMPower < 0 then PMPower else 0 end)'];
            $SumBattPower = $row['SUM(BattPower)'];
            $SumDomesticPower = $row['SUM(DomesticPower)'];
            $SumActPower = $row['SUM(ActPower)'];
        }
    } else {
        echo "Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($link);
$chartData['Time']  = rtrim($tempo, ', ');
$chartData['PMPower'] = rtrim($meter, ', ');
$chartData['DomesticPower']   = rtrim($home, ', ');
$chartData['ActPower']   = rtrim($active, ', ');
$chartData['MPPTPower1']   = rtrim($mppt1, ', ');
$chartData['MPPTPower2']   = rtrim($mppt2, ', ');
$chartData['BattPower']   = rtrim($batterypower, ', ');
$chartData['BattSoC']   = rtrim($batterysoc, ', ');
$chartData['CabinetTemp']   = rtrim($temperature, ', ');
$SumMPPTPower1 = round(number_format((float)$SumMPPTPower1, 2, '.', '') / 1000, 2);
$SumMPPTPower2 = round(number_format((float)$SumMPPTPower2, 2, '.', '') / 1000, 2);
$SumPMPower = round(number_format((float)$SumPMPower, 2, '.', '') / 1000, 2);
$SumMajor = round(number_format((float)$SumMajor, 2, '.', '') / 1000, 2);
$SumMinor = round(number_format((float)$SumMinor, 2, '.', '') / 1000, 2);
$SumBattPower = round(number_format((float)$SumBattPower, 2, '.', '') / 1000, 2);
$SumDomesticPower = round(number_format((float)$SumDomesticPower, 2, '.', '') / 1000, 2);
$SumActPower = round(number_format((float)$SumActPower, 2, '.', '') / 1000, 2);
$PV = $SumMPPTPower1 + $SumMPPTPower2 - $SumBattPower - $SumMinor ;
$LOAD = $SumDomesticPower - ($SumActPower + $SumPMPower - $SumDomesticPower) + $SumMajor;
$ratingResult = $PV / $LOAD;
/*
#44ce1b //verde scuro
#bbdb44 //verde chiaro
#f7e379 //giallo chiaro
#f2a134 //giallo scuro
#e51f1f //rosso
*/
switch (true) {
    case ($ratingResult > 1.3):
        $rating = 'A+';
        $ratingColor = 'text-rating-aplus';
        $ratingCircle = 'ratingCircleAplus';
        break;
    case ($ratingResult > 1):
        $rating = 'A';
        $ratingColor = 'text-rating-a';
        $ratingCircle = 'ratingCircleA';
        break;
    case ($ratingResult > 0.8):
        $rating = 'B';
        $ratingColor = 'text-rating-b';
        $ratingCircle = 'ratingCircleB';
        break;
    case ($ratingResult > 0.6):
        $rating = 'C';
        $ratingColor = 'text-rating-c';
        $ratingCircle = 'ratingCircleC';
        break;
    case ($ratingResult > 0.4):
        $rating = 'D';
        $ratingColor = 'text-rating-d';
        $ratingCircle = 'ratingCircleD';
        break;
    default:
        $rating = 'F';
        $ratingColor = 'text-rating';
        $ratingCircle = 'ratingCircle';
}
$co2 = round(number_format((float)0.384 * ($SumMPPTPower1 + $SumMPPTPower2), 2, '.', ''), 2);
$coal = round(number_format((float)0.360 * ($SumMPPTPower1 + $SumMPPTPower2), 2, '.', ''), 2);
$tree = round(number_format((float)0.0124 * ($SumMPPTPower1 + $SumMPPTPower2), 2, '.', ''), 2);
?>
<!--# if expr="$internetenabled=false" -->
<!--# include file="session.php" -->
<!--# include file="index_provisioning.php" -->
<!--# else -->
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">

<head>
    <title><?= _TITLEANALYTICS ?></title>
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
                <li><a class="dropdown-item active"><?= _MENUHOME ?></a></li>
                <!--<li><a class="dropdown-item" href="change_password.php">CHANGE PASSWORD</a></li>-->
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
                            <a href="system.php">
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
                            <a href="analytics.php" class="dkc-selected">
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
                        <a href="system.php">
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
                        <a href="analytics.php" class="dkc-selected">
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
                            <h3 class="bold text-dkc"><?= _HEADANALYTICS . '&nbsp;' ?></h3>
                            <img id="iconaInternet" src="img/offlineLight.png">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between py-2 ms-0">
                <div class="col-7 col-md-6 col-lg-4 d-flex align-items-center me-lg-1 mb-lg-0 mb-1 text-break rounded-4 bg-grigiochiaro" style="min-height: 80px;">
                    <div class="icon-square flex-shrink-0 mt-1 me-3">
                        <img src="img/ico_analisi_grande.png">
                    </div>
                    <div>
                        <h6 class="fw-bold mt-3"><?= _MENUINVERTER ?> <span class="text-dkc"><?= $_SESSION["macaddress"] ?></span></h6>
                    </div>
                </div>
                <div class="col d-flex justify-content-end h-50">
                    <?php echo $response_toast; ?>
                </div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-end align-items-end">
                    <form id="timeSwitchForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="d-flex flex-nowrap text-nowrap">
                            <label class="form-check-label me-2 fw-bold" for="selectTimeSwitch"><?= _DAY ?></label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="timeInput" type="checkbox" role="switch" id="selectTimeSwitch" onchange="submit()" <?= $timeSwitch ?>>
                                <label class="form-check-label fw-bold" for="selectTimeSwitch"><?= _WEEK ?></label>
                            </div>
                        </div>
                    </form>
                    <script>
                        function submit() {
                            let form = document.getElementById("timeSwitchForm");
                            form.submit();
                        }
                    </script>
                </div>
            </div>
            <div class="row justify-content-between py-2 ms-0">
                <div class="col-12 rounded-4 shadow mt-2 mt-lg-0" style="max-height: 376px;">
                    <script src="js/chart.min.js"></script>
                    <canvas id="daily" width="400" height="400" aria-label="chart" role="img"></canvas>
                    <script>
                        var ctx = document.getElementById('daily').getContext('2d');
                        const colors = {
                            purple: {
                                default: "#667eff",
                                half: "#667eff",
                                quarter: "#667eff",
                                zero: "#a646dbff"
                            },
                            indigo: {
                                default: "rgba(80, 102, 120, 1)",
                                quarter: "rgba(80, 102, 120, 0.25)"
                            }
                        };
                        gradient = ctx.createLinearGradient(0, 25, 0, 300);
                        gradient.addColorStop(0, colors.purple.half);
                        gradient.addColorStop(0.35, colors.purple.quarter);
                        gradient.addColorStop(1, colors.purple.zero);
                        const onResize = (chart, size) => {
                            chart.options.scales.x.ticks.display = (size.width >= 400);
                        };
                        //parametro temporale
                        const xValues = [<?php print_r($chartData['Time']); ?>];

                        const grafico_giorno = new Chart(ctx, {
                            type: "line",
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                animation: true,
                                onResize,
                                plugins: {
                                    test: true,
                                    legend: {
                                        display: true
                                    },
                                    tooltip: {
                                        enabled: true
                                    },
                                    title: {
                                        display: true,
                                        text: '<?= $chartTitle ?>'
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            display: true,
                                            color: '#667eff',
                                            callback: function(value, index, ticks) {
                                                return value + ' W';
                                            }
                                        },
                                        title: {
                                            display: false,
                                            text: 'kW'
                                        },
                                        grid: {
                                            drawOnChartArea: false,
                                        },
                                    },
                                    y1: {
                                        beginAtZero: true,
                                        position: 'right',
                                        ticks: {
                                            display: true,
                                            color: '#667eff',
                                            callback: function(value, index, ticks) {
                                                return value + ' % / °C';
                                            }
                                        },
                                        title: {
                                            display: false,
                                            text: 'kW'
                                        },
                                        grid: {
                                            drawOnChartArea: false,
                                        },
                                    },
                                    x: {
                                        ticks: {
                                            display: true,
                                            color: '#667eff',
                                            autoSkip: true,
                                            minRotation: 20,
                                        },
                                        title: {
                                            display: false,
                                            text: 'time'
                                        },
                                        grid: {
                                            drawOnChartArea: false,
                                        },
                                    },
                                }
                            },
                            data: {
                                labels: xValues,
                                //fill: true,
                                borderColor: '#a646db50',
                                borderWidth: 0,
                                datasets: [{
                                    label: '<?= _PMPOWER ?>',
                                    //meter
                                    data: [<?php print_r($chartData['PMPower']); ?>],
                                    borderColor: '#a646db',
                                    pointBorderWidth: 0,
                                    pointStyle: 'circle',
                                    pointRadius: 0,
                                    tension: 0.2,
                                    backgroundColor: '#a646db50',
                                    //backgroundColor: gradient,
                                    fill: true,
                                    yAxisID: 'y',
                                }, {
                                    label: '<?= _DOMESTICPOWER ?>',
                                    //home
                                    data: [<?php print_r($chartData['DomesticPower']); ?>],
                                    //borderColor: '#24d8ed',
                                    borderColor: '#4a67fb',
                                    pointBorderWidth: 0,
                                    pointStyle: 'circle',
                                    pointRadius: 0,
                                    backgroundColor: '#4a67fb50',
                                    tension: 0.2,
                                    fill: true,
                                    yAxisID: 'y',
                                }, {
                                    label: '<?= _ACTPOWER ?>',
                                    //active power
                                    data: [<?php print_r($chartData['ActPower']); ?>],
                                    borderColor: '#b5b5b5',
                                    pointBorderWidth: 0,
                                    pointStyle: 'circle',
                                    pointRadius: 0,
                                    //backgroundColor: '#24d8ed50',
                                    tension: 0.2,
                                    fill: false,
                                    borderDash: [5, 5],
                                    yAxisID: 'y',
                                }, {
                                    label: '<?= _MPPTPOWER1CHART ?>',
                                    //mppt1
                                    data: [<?php print_r($chartData['MPPTPower1']); ?>],
                                    borderColor: '#f7931e',
                                    pointBorderWidth: 0,
                                    pointStyle: 'circle',
                                    pointRadius: 0,
                                    backgroundColor: '#f7931e50',
                                    tension: 0.2,
                                    fill: true,
                                    yAxisID: 'y',
                                }, {
                                    label: '<?= _MPPTPOWER2CHART ?>',
                                    //mppt2
                                    data: [<?php print_r($chartData['MPPTPower2']); ?>],
                                    //borderColor: '#fcee21',
                                    borderColor: '#f7931e80',
                                    pointBorderWidth: 0,
                                    pointStyle: 'circle',
                                    pointRadius: 0,
                                    backgroundColor: '#f7931e30',
                                    tension: 0.2,
                                    fill: true,
                                    yAxisID: 'y',
                                }, {
                                    label: '<?= _BATTPOWERCHART ?>',
                                    //battery power
                                    data: [<?php print_r($chartData['BattPower']); ?>],
                                    //borderColor: '#22b573',
                                    borderColor: '#8cc63f',
                                    pointBorderWidth: 0,
                                    pointStyle: 'circle',
                                    pointRadius: 0,
                                    backgroundColor: '#8cc63f50',
                                    tension: 0.2,
                                    fill: true,
                                    yAxisID: 'y',
                                }, {
                                    label: '<?= _BATTSOCCHART ?> %',
                                    //battery state of charge
                                    data: [<?php print_r($chartData['BattSoC']); ?>],
                                    borderColor: '#8cc63f',
                                    pointBorderWidth: 0,
                                    pointStyle: 'circle',
                                    pointRadius: 0,
                                    //backgroundColor: '#8cc63f50',
                                    tension: 0.2,
                                    fill: false,
                                    borderDash: [5, 5],
                                    yAxisID: 'y1',
                                }, {
                                    label: '<?= _CABINETTEMP ?> °C',
                                    //temperature
                                    data: [<?php print_r($chartData['CabinetTemp']); ?>],
                                    borderColor: '#ff558a',
                                    pointBorderWidth: 0,
                                    pointStyle: 'circle',
                                    pointRadius: 0,
                                    //backgroundColor: '#ff558a50',
                                    tension: 0.2,
                                    fill: false,
                                    borderDash: [5, 5],
                                    yAxisID: 'y1',
                                }]
                            },
                        });
                        /*
                        if (grafico_giorno.data.datasets[0].data.length === 0) {
                            console.log("non ci sono dati");
                            //DA SEGARE
                            Chart.register({
                                id: 'test',
                                afterDraw: function(chart) {
                                    // No data is present
                                    var ctx = chart.chart.ctx;
                                    var width = chart.chart.width;
                                    var height = chart.chart.height
                                    chart.clear();
                                    ctx.save();
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'middle';
                                    ctx.font = "16px normal 'Helvetica Nueue'";
                                    ctx.fillText('No data to display', width / 2, height / 2);
                                    ctx.restore();
                                }
                            });
                            //SINO A QUI DA SEGARE
                        };
                        */
                    </script>
                </div>
                <?php $chartData = array(); ?>
            </div>

            <div class="row justify-content-between py-2 ms-0" style="min-height: 300px;">
                <div class="col-12 col-lg-4 mt-2 mt-lg-0 px-0 pe-lg-2 mh-100">
                    <div class="rounded-4 shadow p-1 h-100">
                        <div class="col-12 d-flex align-items-center text-break">
                            <div class="icon-square flex-shrink-0 mt-3 ms-2 me-3">
                                <img src="img/ico_tree_eco.png">
                            </div>
                            <h6 class="fw-bold mt-3 text-uppercase"><?= _ECORATING ?></h6>
                        </div>
                        <div class="row my-2 ms-2 me-0">
                            <div class="col-auto mt-2" style="width: 180px; height: 156px;">
                                <div class="<?= $ratingCircle ?> d-flex align-items-center">
                                    <h6 class="display-1 text-center <?= $ratingColor ?> w-100"><?= $rating ?></h6>
                                </div>
                            </div>
                            <div class="col-auto">
                                <p class="pt-2 my-0">
                                    <span class="fwb-head"><?= _CO2 ?><br>
                                        <h6 class="fw-bold text-solar"><?= $co2 ?> kg</h6>
                                    </span>
                                </p>
                                <p class="pt-2 my-0">
                                    <span class="fwb-head"><?= _COAL ?><br>
                                        <h6 class="fw-bold text-secondary"><?= $coal ?> kg</h6>
                                    </span>
                                </p>
                                <p class="pt-2 my-0">
                                    <span class="fwb-head"><?= _TREE ?><br>
                                        <h6 class="fw-bold text-battery"><?= $tree ?> trees</h6>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12 col-lg-4 mt-2 mt-lg-0 px-0 px-lg-2 mh-100">
                    <div class="rounded-4 shadow p-1 h-100">
                        <div class="col-12 d-flex align-items-center text-break">
                            <div class="icon-square flex-shrink-0 mt-3 ms-2 me-3">
                                <img src="img/ico_production_eco.png">
                            </div>
                            <h6 class="fw-bold mt-3 text-uppercase"><?= _PRODUCTION ?></h6>
                        </div>
                        <div class="row my-2 ms-2 me-0">
                            <div class="col-auto mt-2" style="width: 180px;">
                                <canvas id="produzione-chart"></canvas>
                            </div>
                            <div class="col-auto">
                                <p class="mt-2">
                                    <span class="fwb-head"><?= _PRODUCTION1 ?><br>
                                        <button id="grafico-primo" onclick="toggleData(0)" class="no_button_css">
                                            <h6 class="fw-bold" id="testo-primo"></h6>
                                        </button>
                                    </span>
                                </p>
                                <p class="mt-2">
                                    <span class="fwb-head"><?= _PRODUCTION2 ?><br>
                                        <button id="grafico-secondo" onclick="toggleData(1)" class="no_button_css">
                                            <h6 class="fw-bold" id="testo-secondo"></h6>
                                        </button>
                                    </span>
                                </p>
                                <p class="mt-2">
                                    <span class="fwb-head"><?= _PRODUCTION3 ?><br>
                                        <button id="grafico-terzo" onclick="toggleData(2)" class="no_button_css">
                                            <h6 class="fw-bold" id="testo-terzo"></h6>
                                        </button>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4 mt-2 mt-lg-0 px-0 ps-lg-2 mh-100">
                    <div class="rounded-4 shadow p-1 h-100">
                        <div class="col-12 d-flex align-items-center text-break">
                            <div class="icon-square flex-shrink-0 mt-3 ms-2 me-3">
                                <img src="img/ico_consumption_eco.png">
                            </div>
                            <h6 class="fw-bold mt-3 text-uppercase"><?= _CONSUMPTION ?></h6>
                        </div>
                        <div class="row my-2 ms-2 me-0">
                            <div class="col-auto mt-2" style="width: 180px;">
                                <canvas id="consumo-chart"></canvas>
                            </div>
                            <div class="col-auto">
                                <p class="mt-2">
                                    <span class="fwb-head"><?= _CONSUMPTION1 ?><br>
                                        <button id="grafico-quarto" onclick="toggleDataC(0)" class="no_button_css">
                                            <h6 class="fw-bold" id="testo-quarto"></h6>
                                        </button>
                                    </span>
                                </p>
                                <p class="mt-2">
                                    <span class="fwb-head"><?= _CONSUMPTION2 ?><br>
                                        <button id="grafico-quinto" onclick="toggleDataC(1)" class="no_button_css">
                                            <h6 class="fw-bold" id="testo-quinto"></h6>
                                        </button>
                                    </span>
                                </p>
                                <p class="mt-2">
                                    <span class="fwb-head"><?= _CONSUMPTION3 ?><br>
                                        <button id="grafico-sesto" onclick="toggleDataC(2)" class="no_button_css">
                                            <h6 class="fw-bold" id="testo-sesto"></h6>
                                        </button>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ############################################################################################################ -->
            <!-- PRODUZIONE -->
            <!-- ############################################################################################################ -->

            <script>
                // testo bottone
                let buttonCoordinates = [{
                    top: 0,
                    bottom: 0,
                    left: 0,
                    right: 0,
                }]

                let selectedDatasetIndex = undefined;
                let selectedIndex = undefined;

                const datapoints = [(<?= $SumMPPTPower1 ?> + <?= $SumMPPTPower2 ?> - <?= $SumBattPower ?> - <?= -$SumMinor ?>).toFixed(2), <?= $SumBattPower ?>, <?= -$SumMinor ?>];
                const centertext = [(<?= $SumMPPTPower1 ?> + <?= $SumMPPTPower2 ?>).toFixed(2) + ' kWh', 'XXX.XX A'];
                const bc = ['#f7931e', '#8cc63f', '#783c0e', '#a646db'];
                const data = {
                    labels: [
                        'primo',
                        'secondo',
                        'terzo'
                    ],
                    datasets: [{
                        label: 'produzione',
                        data: datapoints,
                        backgroundColor: [
                            '#f7931e', //giallo
                            '#8cc63f', // verde
                            '#783c0e', //marrone
                            '#a646db', //viola
                            '#4a67fb' //blu
                        ],
                        //borderColor: bc,
                        //borderWidth: 4, //bordo tra un elemento e l'altro
                        cutout: '85%', //spessore elementi
                        //borderRadius: 16,
                        //spacing: 20, //spazio tra elementi
                        borderAlign: 'center'
                    }]
                };
                //      console.log(data.datasets[0].backgroundColor[0]);
                // counter plugin
                const counter = {
                    id: 'counter',
                    beforeDraw(chart, args, options) {
                        const {
                            ctx,
                            chartArea: {
                                top,
                                right,
                                bottom,
                                left,
                                width,
                                height
                            }
                        } = chart;
                        ctx.save();
                        ctx.font = options.fontSize + 'px ' + options.fontFamily;
                        ctx.textAlign = 'center';
                        ctx.fillStyle = options.fontColor;
                        ctx.fillText('<?= _PRODUCTIONPV ?>' + centertext[0], width / 2, (height / 2) + (options.fontSize * 0.34)); ///////////SENZA LEGENDA
                        buttonCoordinates[0].top = 165;
                        buttonCoordinates[0].bottom = 205;
                        buttonCoordinates[0].left = 115;
                        buttonCoordinates[0].right = 255;
                        ctx.restore();
                        //      console.log(buttonCoordinates)
                    }
                };

                const clickLabel = {
                    id: 'clickLabel',
                    afterDraw: (chart, args, options) => {
                        //console.log(chart)
                        const {
                            ctx,
                            chartArea: {
                                width,
                                height,
                                top
                            }
                        } = chart;

                        //			console.log(selectedDatasetIndex);
                        //			console.log(selectedIndex);

                        if (selectedDatasetIndex >= 0) {
                            //				console.log(chart._metasets[selectedDatasetIndex]._parsed[selectedIndex]);
                            const sum = chart._metasets[selectedDatasetIndex].total;
                            const value = chart._metasets[selectedDatasetIndex]._parsed[selectedIndex];
                            const color = chart.data.datasets[selectedDatasetIndex].backgroundColor[selectedIndex];
                            ctx.save();
                            ctx.font = options.fontSize + 'px ' + options.fontFamily;
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            ctx.fillStyle = color;
                            ctx.fillText(value + ' kWh', width / 2, height / 2 + top - 50 + (options.fontSize * 0.34));
                            ctx.restore();
                        }
                    }
                };

                const config = {
                    type: 'doughnut',
                    data, // data = data,
                    options: {
                        onClick(click, element, chart) {
                            //				console.log(element[0].datasetIndex)
                            if (element[0]) {
                                selectedDatasetIndex = element[0].datasetIndex;
                                selectedIndex = element[0].index;
                                chart.draw();
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false // over sugli elementi
                            },
                            counter: {
                                //fontColor: bc[2],
                                fontColor: '#000',
                                fontSize: 14,
                                fontFamily: 'roboto-bold'
                            },
                            clickLabel: {
                                //fontColor: bc[2],
                                fontColor: '#000',
                                fontSize: 14,
                                fontStyle: 900,
                                fontFamily: 'roboto-bold'
                            }
                        }
                    },
                    plugins: [counter, clickLabel]
                };

                // render
                const ctx2 = document.getElementById('produzione-chart');
                const myChart = new Chart(
                    ctx2,
                    config
                );

                // nuova legenda
                document.getElementById('grafico-primo').style.color = data.datasets[0].backgroundColor[0];
                document.getElementById('grafico-secondo').style.color = data.datasets[0].backgroundColor[1];
                document.getElementById('grafico-terzo').style.color = data.datasets[0].backgroundColor[2];
                document.getElementById('testo-primo').innerText = datapoints[0] + ' kWh';
                document.getElementById('testo-secondo').innerText = datapoints[1] + ' kWh';
                document.getElementById('testo-terzo').innerText = datapoints[2] + ' kWh';

                function toggleData(value) {
                    const toggleVisibilityData = myChart.toggleDataVisibility(value);
                    const getVisibilityData = myChart.getDataVisibility(value);
                    myChart.update();
                    if (getVisibilityData === false) {
                        myChart.show(0, value);
                    }
                }

                function clickButtonHandler(ctx, click) {
                    const x = click.offsetX;
                    const y = click.offsetY;
                    //console.log(x)
                    //console.log(y)
                    const top = buttonCoordinates[0].top;
                    const bottom = buttonCoordinates[0].bottom;
                    const left = buttonCoordinates[0].left;
                    const right = buttonCoordinates[0].right;

                    if (x > left && x < right && y > top && y < bottom) {
                        //console.log('cliccato');
                        //  console.log(myChart.data.datasets[0].backgroundColor[0]);
                        //  console.log(centertext);
                        changeText();
                    }

                };

                ctx2.addEventListener('click', (e) => {
                    clickButtonHandler(ctx, e)
                })

                function changeText() {
                    myChart.update();
                }
            </script>

            <!-- ############################################################################################################ -->
            <!-- CONSUMO -->
            <!-- ############################################################################################################ -->

            <script>
                let selectedDatasetIndexConsumo = undefined;
                let selectedIndexConsumo = undefined;

                const datapointsConsumo = [<?= $SumDomesticPower ?>, -(<?= $SumActPower ?> + <?= $SumPMPower ?> - <?= $SumDomesticPower ?>).toFixed(2), <?= $SumMajor ?>];
                const centertextConsumo = [(<?= $SumDomesticPower ?> - (<?= $SumActPower ?> + <?= $SumPMPower ?> - <?= $SumDomesticPower ?>) + <?= $SumMajor ?>).toFixed(2) + ' kWh', 'XXX.XX A'];
                const bcConsumo = ['#4a67fb', '#888888', '#a646db'];
                const dataConsumo = {
                    labels: [
                        'quarto',
                        'quinto',
                        'sesto'
                    ],
                    datasets: [{
                        label: 'consumo',
                        data: datapointsConsumo,
                        backgroundColor: [
                            '#4a67fb', //blu
                            '#888888', //grigio
                            '#a646db' //viola
                        ],
                        cutout: '85%',
                        borderAlign: 'center'
                    }]
                };
                const counterConsumo = {
                    id: 'counterConsumo',
                    beforeDraw(chart, args, options) {
                        const {
                            ctx,
                            chartArea: {
                                top,
                                right,
                                bottom,
                                left,
                                width,
                                height
                            }
                        } = chart;
                        ctx.save();
                        ctx.font = options.fontSize + 'px ' + options.fontFamily;
                        ctx.textAlign = 'center';
                        ctx.fillStyle = options.fontColor;
                        ctx.fillText('<?= _CONSUMPTIONLOAD ?>' + centertextConsumo[0], width / 2, (height / 2) + (options.fontSize * 0.34));
                        buttonCoordinates[0].top = 165;
                        buttonCoordinates[0].bottom = 205;
                        buttonCoordinates[0].left = 115;
                        buttonCoordinates[0].right = 255;
                        ctx.restore();
                    }
                };

                const clickLabelConsumo = {
                    id: 'clickLabelConsumo',
                    afterDraw: (chart, args, options) => {
                        const {
                            ctx,
                            chartArea: {
                                width,
                                height,
                                top
                            }
                        } = chart;

                        if (selectedDatasetIndexConsumo >= 0) {
                            const sum3 = chart._metasets[selectedDatasetIndexConsumo].total;
                            const value3 = chart._metasets[selectedDatasetIndexConsumo]._parsed[selectedIndexConsumo];
                            const color3 = chart.data.datasets[selectedDatasetIndexConsumo].backgroundColor[selectedIndexConsumo];
                            ctx.save();
                            ctx.font = options.fontSize + 'px ' + options.fontFamily;
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            ctx.fillStyle = color3;
                            ctx.fillText(value3 + ' kWh', width / 2, height / 2 + top - 50 + (options.fontSize * 0.34));
                            ctx.restore();
                        }
                    }
                };

                const configConsumo = {
                    type: 'doughnut',
                    data: dataConsumo,
                    options: {
                        onClick(click, element, chart) {
                            if (element[0]) {
                                selectedDatasetIndexConsumo = element[0].datasetIndex;
                                selectedIndexConsumo = element[0].index;
                                chart.draw();
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            },
                            counterConsumo: {
                                fontColor: '#000',
                                fontSize: 14,
                                fontFamily: 'roboto-bold'
                            },
                            clickLabelConsumo: {
                                fontColor: '#000',
                                fontSize: 14,
                                fontStyle: 900,
                                fontFamily: 'roboto-bold'
                            }
                        }
                    },
                    plugins: [counterConsumo, clickLabelConsumo]
                };

                const ctx3 = document.getElementById('consumo-chart');
                const myChartConsumo = new Chart(
                    ctx3,
                    configConsumo
                );

                document.getElementById('grafico-quarto').style.color = dataConsumo.datasets[0].backgroundColor[0];
                document.getElementById('grafico-quinto').style.color = dataConsumo.datasets[0].backgroundColor[1];
                document.getElementById('grafico-sesto').style.color = dataConsumo.datasets[0].backgroundColor[2];
                document.getElementById('testo-quarto').innerText = datapointsConsumo[0] + ' kWh';
                document.getElementById('testo-quinto').innerText = datapointsConsumo[1] + ' kWh';
                document.getElementById('testo-sesto').innerText = datapointsConsumo[2] + ' kWh';

                function toggleDataC(value) {
                    const toggleVisibilityData3 = myChartConsumo.toggleDataVisibility(value);
                    const getVisibilityData3 = myChartConsumo.getDataVisibility(value);
                    myChartConsumo.update();
                    if (getVisibilityData3 === false) {
                        myChartConsumo.show(0, value);
                    }
                }

                function clickButtonHandlerC(ctx3, click) {
                    const x3 = click.offsetX;
                    const y3 = click.offsetY;
                    const top3 = buttonCoordinates[0].top;
                    const bottom3 = buttonCoordinates[0].bottom;
                    const left3 = buttonCoordinates[0].left;
                    const right3 = buttonCoordinates[0].right;

                    if (x3 > left3 && x3 < right3 && y3 > top3 && y3 < bottom3) {
                        //console.log('cliccato');
                        changeTextC();
                    }

                };

                ctx3.addEventListener('click', (e) => {
                    clickButtonHandlerC(ctx3, e)
                })

                function changeTextC() {
                    myChartConsumo.update();
                }
            </script>
            <!-- ############################################################################################################ -->

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