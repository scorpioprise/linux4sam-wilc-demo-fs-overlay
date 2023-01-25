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
} else if (trovaLingua() == 'en') {
    include "inc/l_en.php";
} else if (trovaLingua() == 'ru') {
    include "inc/l_ru.php";
}
if (isset($_POST['response'])) {
    $response = exec('issue_command ' . $_POST['parameter'] . " " . $_POST['valore']);
    if ($response == 'RESPONSE_MESSAGE_FAILED') {
        $response_toast = '<div class="toast align-items-center fade show bg-danger fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        '._TOASTCOMMANDKO.'</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_OK') {
        $response_toast = '<div class="toast align-items-center fade show bg-info fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        '._TOASTCOMMANDOK.'</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_TODO') {
        $response_toast = '<div class="toast align-items-center fade show bg-secondary text-white fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        '._TOASTCOMMANDNOTAVAILABLE.'</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'SKIP SERIAL') {
        $response_toast = '<div class="toast align-items-center fade show bg-info fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        '._TOASTCOMMANDSKIPSERIAL.'</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_NOT_APPLICABLE') {
        $response_toast = '<div class="toast align-items-center fade show bg-primary fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        '._TOASTCOMMANDNOUPDATE.'</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } else {
        $response_toast = '<div class="toast align-items-center fade show bg-warning fw-bold" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        '._TOASTCOMMANDERROR.'</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    }
}
// 0=admin 1=installer 2=user
if ($auth == 0) {
    $utente = 'admin';
    $commands_menu = "<tr><td>"._TABLE3009COMMANDS."</td><td><form class='row g-3 me-1' action='" . ($_SERVER["PHP_SELF"]) . "' method='post'><div class='col-8 col-sm-6'>
    <input type='hidden' name='parameter' value='3009'><select class='form-select form-select-sm' name='valore' required><option value=''>"._TABLE3009SELCOMMANDS."</option><option value='0'>"._TABLE3009DISABLECOMMANDS."</option><option value='1'>"._TABLE3009ENABLECOMMANDS."</option></select>
    </div><div class='col-4 col-sm-6'><button type='submit' name='response' class='btn btn-primary btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-check-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'></path></svg><span class='d-none d-lg-block'>"._TABLEAPPLYCOMMANDS."</span></button></div></form></td>
    <td><button type='button' class='btn btn-warning btn-sm' data-toggle='tooltip' data-bs-placement='left' data-bs-original-title='"._HELPOCPPCOMMANDS."'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-info-circle-fill' viewBox='0 0 16 16'><path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'></path></svg><span class='d-none d-lg-block'>"._TABLEHELPCOMMANDS."</span></button></td></tr>
    <tr><td>"._TABLE3010COMMANDS."</td><td><form class='row g-3 me-1' action='" . ($_SERVER["PHP_SELF"]) . "' method='post'><div class='col-8 col-sm-6'><input type='hidden' name='parameter' value='3010'>
    <select class='form-select form-select-sm' name='valore' required><option value=''>"._TABLE3010SELCOMMANDS."</option><option value='0'>"._TABLE3010DISABLECOMMANDS."</option><option value='1'>"._TABLE3010ENABLECOMMANDS."</option></select></div><div class='col-4 col-sm-6'>
    <button type='submit' name='response' class='btn btn-primary btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-check-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'></path></svg><span class='d-none d-lg-block'>"._TABLEAPPLYCOMMANDS."</span></button></div></form></td><td>
    <button type='button' class='btn btn-warning btn-sm' data-toggle='tooltip' data-bs-placement='left' data-bs-original-title='"._HELPMODBUSCOMMANDS."'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-info-circle-fill' viewBox='0 0 16 16'><path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'></path></svg><span class='d-none d-lg-block'>"._TABLEHELPCOMMANDS."</span></button></td></tr><tr><td>"._TABLE3017COMMANDS."</td><td>
    <form class='row g-3 me-1' action='" . ($_SERVER["PHP_SELF"]) . "' method='post'><div class='col-8 col-sm-6'><input type='hidden' name='parameter' value='3017'>
    <select class='form-select form-select-sm' name='valore' required><option value=''>"._TABLE3017SELCOMMANDS."</option><option value='0'>"._TABLE3017REBOOTCOMMANDS."</option><option value='1'>"._TABLE3017RESTARTCOMMANDS."</option></select></div>
    <div class='col-4 col-sm-6'><button type='submit' name='response' class='btn btn-primary btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-check-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'></path></svg><span class='d-none d-lg-block'>"._TABLEAPPLYCOMMANDS."</span></button></div></form></td><td>
    <button type='button' class='btn btn-warning btn-sm' data-toggle='tooltip' data-bs-placement='left' data-bs-original-title='"._HELPREBOOT."'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-info-circle-fill' viewBox='0 0 16 16'><path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'></path></svg><span class='d-none d-lg-block'>"._TABLEHELPCOMMANDS."</span></button></td></tr>";
} elseif ($auth == 1) {
    $utente = 'installer';
    $commands_menu = "<tr><td>"._TABLE3009COMMANDS."</td><td><form class='row g-3 me-1' action='" . ($_SERVER["PHP_SELF"]) . "' method='post'><div class='col-8 col-sm-6'>
    <input type='hidden' name='parameter' value='3009'><select class='form-select form-select-sm' name='valore' required><option value=''>"._TABLE3009SELCOMMANDS."</option><option value='0'>"._TABLE3009DISABLECOMMANDS."</option><option value='1'>"._TABLE3009ENABLECOMMANDS."</option></select>
    </div><div class='col-4 col-sm-6'><button type='submit' name='response' class='btn btn-primary btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-check-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'></path></svg><span class='d-none d-lg-block'>"._TABLEAPPLYCOMMANDS."</span></button></div></form></td>
    <td><button type='button' class='btn btn-warning btn-sm' data-toggle='tooltip' data-bs-placement='left' data-bs-original-title='"._HELPOCPPCOMMANDS."'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-info-circle-fill' viewBox='0 0 16 16'><path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'></path></svg><span class='d-none d-lg-block'>"._TABLEHELPCOMMANDS."</span></button></td></tr>
    <tr><td>"._TABLE3010COMMANDS."</td><td><form class='row g-3 me-1' action='" . ($_SERVER["PHP_SELF"]) . "' method='post'><div class='col-8 col-sm-6'><input type='hidden' name='parameter' value='3010'>
    <select class='form-select form-select-sm' name='valore' required><option value=''>"._TABLE3010SELCOMMANDS."</option><option value='0'>"._TABLE3010DISABLECOMMANDS."</option><option value='1'>"._TABLE3010ENABLECOMMANDS."</option></select></div><div class='col-4 col-sm-6'>
    <button type='submit' name='response' class='btn btn-primary btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-check-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'></path></svg><span class='d-none d-lg-block'>"._TABLEAPPLYCOMMANDS."</span></button></div></form></td><td>
    <button type='button' class='btn btn-warning btn-sm' data-toggle='tooltip' data-bs-placement='left' data-bs-original-title='"._HELPMODBUSCOMMANDS."'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-info-circle-fill' viewBox='0 0 16 16'><path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'></path></svg><span class='d-none d-lg-block'>"._TABLEHELPCOMMANDS."</span></button></td></tr><tr><td>"._TABLE3017COMMANDS."</td><td>
    <form class='row g-3 me-1' action='" . ($_SERVER["PHP_SELF"]) . "' method='post'><div class='col-8 col-sm-6'><input type='hidden' name='parameter' value='3017'>
    <select class='form-select form-select-sm' name='valore' required><option value=''>"._TABLE3017SELCOMMANDS."</option><option value='0'>"._TABLE3017REBOOTCOMMANDS."</option><option value='1'>"._TABLE3017RESTARTCOMMANDS."</option></select></div>
    <div class='col-4 col-sm-6'><button type='submit' name='response' class='btn btn-primary btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-check-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'></path></svg><span class='d-none d-lg-block'>"._TABLEAPPLYCOMMANDS."</span></button></div></form></td><td>
    <button type='button' class='btn btn-warning btn-sm' data-toggle='tooltip' data-bs-placement='left' data-bs-original-title='"._HELPREBOOT."'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-info-circle-fill' viewBox='0 0 16 16'><path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'></path></svg><span class='d-none d-lg-block'>"._TABLEHELPCOMMANDS."</span></button></td></tr>";
} else {
    $utente = 'user';
    $commands_menu = "";
}
?>
<!--# if expr="$internetenabled=false" -->
<!--# include file="session.php" -->
<!--# include file="index_provisioning.php" -->
<!--# else -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= _TITLECOMMANDS ?></title>
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
                            <a href="commands.php" class="dkc-selected">
                                <img src="img/ico_notifiche.png" width="25px" class="me-3">
                                <?= _MENUCOMMANDS ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="configurations.php">
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
                        <a href="commands.php" class="dkc-selected">
                            <img src="img/ico_notifiche.png" width="25px" class="me-3">
                            <?= _MENUCOMMANDS ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="configurations.php">
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
                            <h3 class="bold text-dkc"><?= _HEADCOMMANDS ?></h3>
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
                                <th><?= _TABLEPARAMETERCOMMANDS ?></th>
                                <th><?= _TABLEVALUECOMMANDS ?></th>
                                <th><?= _TABLEHELPCOMMANDS ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= _TABLE3000COMMANDS ?></td>
                                <td>
                                    <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="col-8 col-sm-6">
                                            <input type="hidden" name="parameter" value="3000">
                                            <select class="form-select form-select-sm" name="valore" required>
                                                <option value=""><?= _TABLE3000SELCOMMANDS ?></option>
                                                <option value="0"><?= _TABLE3000STARTCOMMANDS ?></option>
                                                <option value="2"><?= _TABLE3000STOPCOMMANDS ?></option>
                                            </select>
                                        </div>
                                        <div class="col-4 col-sm-6"><button type="submit" name="response" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path></svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button></div>
                                    </form>
                                </td>
                                <td><button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= _HELPOPERATECOMMANDS ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path></svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                            </tr>
                            <tr>
                                <td><?= _TABLE3003COMMANDS ?></td>
                                <td>
                                    <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="col-8 col-sm-6">
                                            <input type="hidden" name="parameter" value="3003">
                                            <input class="form-control form-control-sm" type="number" min="0" placeholder="<?= _TABLEINSERTVALUECOMMANDS ?>" name="valore" required="">
                                        </div>
                                        <div class="col-4 col-sm-6"><button type="submit" name="response" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path></svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button></div>
                                    </form>
                                </td>
                                <td><button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= _HELPMAXPOWERCOMMANDS ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path></svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                            </tr>
                            <tr class="d-none">
                                <td>3004 - ADD AUTHORIZED USER (swipe RFID card)</td>
                                <td>
                                    <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="col-8 col-sm-6">
                                            <input type="hidden" name="parameter" value="3004">
                                            <input class="form-control form-control-sm" type="number" min="0" placeholder="<?= _TABLEINSERTVALUECOMMANDS ?>" name="valore" required="" value="1" readonly>
                                        </div>
                                        <div class="col-4 col-sm-6"><button type="submit" name="response" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path></svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button></div>
                                    </form>
                                </td>
                                <td><button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-bs-placement="left" data-bs-original-title="help 3004"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path></svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                            </tr>
                            <tr class="d-none">
                                <td>3005 - REMOVE AUTHORIZED USER (swipe RFID card)</td>
                                <td>
                                    <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="col-8 col-sm-6">
                                            <input type="hidden" name="parameter" value="3005">
                                            <input class="form-control form-control-sm" type="number" min="0" placeholder="<?= _TABLEINSERTVALUECOMMANDS ?>" name="valore" required="" value="1" readonly>
                                        </div>
                                        <div class="col-4 col-sm-6"><button type="submit" name="response" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path></svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button></div>
                                    </form>
                                </td>
                                <td><button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-bs-placement="left" data-bs-original-title="help 3005"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path></svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                            </tr>
                            <tr>
                                <td><?= _TABLE3006COMMANDS ?></td>
                                <td>
                                    <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="col-8 col-sm-6">
                                            <input type="hidden" name="parameter" value="3006">
                                            <select class="form-select form-select-sm" name="valore" required>
                                                <option value=""><?= _TABLE3006SELCOMMANDS ?></option>
                                                <option value="0"><?= _TABLE3006DISABLECOMMANDS ?></option>
                                                <option value="1"><?= _TABLE3006ENABLECOMMANDS ?></option>
                                            </select>
                                        </div>
                                        <div class="col-4 col-sm-6"><button type="submit" name="response" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path></svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button></div>
                                    </form>
                                </td>
                                <td><button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= _HELPFIXEDPOWERCOMMANDS ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path></svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                            </tr>
                            <tr>
                                <td><?= _TABLE3007COMMANDS ?></td>
                                <td>
                                    <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="col-8 col-sm-6">
                                            <input type="hidden" name="parameter" value="3007">
                                            <select class="form-select form-select-sm" name="valore" required>
                                                <option value=""><?= _TABLE3007SELCOMMANDS ?></option>
                                                <option value="0"><?= _TABLE3007DISABLECOMMANDS ?></option>
                                                <option value="1"><?= _TABLE3007ENABLECOMMANDS ?></option>
                                            </select>
                                        </div>
                                        <div class="col-4 col-sm-6"><button type="submit" name="response" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path></svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button></div>
                                    </form>
                                </td>
                                <td><button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= _HELPRFIDREADERCOMMANDS ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path></svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                            </tr>

                            <?php echo $commands_menu; ?>

                            <tr>
                                <td><?= _TABLE3012COMMANDS ?></td>
                                <td>
                                    <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="col-8 col-sm-6">
                                            <input type="hidden" name="parameter" value="3012">
                                            <input class="form-control form-control-sm" type="hidden" min="0" placeholder="<?= _TABLEINSERTVALUECOMMANDS ?>" name="valore" required="" value="1" readonly>
                                            <p style="min-width:200px;"></p>
                                        </div>
                                        <div class="col-4 col-sm-6">
                                            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#softwareUpdate"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path></svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button>
                                        </div>
                                        <div class="modal fade" id="softwareUpdate" tabindex="-1" aria-labelledby="softwareUpdateLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="softwareUpdateLabel"><?= _MODALSWUPDATECOMMANDS ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body"><?= _MODALSWUPDATEWARNINGCOMMANDS ?></div>
                                                    <div class="modal-footer btn-group">
                                                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><?= _MODALNOCOMMANDS ?></button>
                                                        <button class="btn btn-danger" type="submit" name="response" value="apply"><?= _MODALYESCOMMANDS ?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td><button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= _HELPSWUPDATECOMMANDS ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path></svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                            </tr>
                            <tr>
                                <td><?= _TABLE3013COMMANDS ?></td>
                                <td>
                                    <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="col-8 col-sm-6">
                                            <input type="hidden" name="parameter" value="3013">
                                            <input class="form-control form-control-sm" type="hidden" min="0" placeholder="<?= _TABLEINSERTVALUECOMMANDS ?>" name="valore" required="" value="1" readonly>
                                            <p style="min-width:200px;"></p>
                                        </div>
                                        <div class="col-4 col-sm-6"><button type="submit" name="response" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path></svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button></div>
                                    </form>
                                </td>
                                <td><button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= _HELPSENDCLOUDCOMMANDS ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path></svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                            </tr>
                            <tr>
                                <td><?= _TABLE3014COMMANDS ?></td>
                                <td>
                                    <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="col-8 col-sm-6">
                                            <input type="hidden" name="parameter" value="3014">
                                            <input class="form-control form-control-sm" type="hidden" min="0" placeholder="<?= _TABLEINSERTVALUECOMMANDS ?>" name="valore" required="" value="1" readonly>
                                            <p style="min-width:200px;"></p>
                                        </div>
                                        <div class="col-4 col-sm-6"><button type="submit" name="response" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path></svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button></div>
                                    </form>
                                </td>
                                <td><button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= _HELPERRORCOMMANDS ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path></svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                            </tr>
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
