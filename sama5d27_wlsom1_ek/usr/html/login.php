<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: telemetry.php");
    exit;
}
$click = 0;
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
    $lang = 'it';
    $click = 1;
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
    $lang = 'en';
    $click = 2;
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
    $lang = 'ru';
    $click = 3;
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
    $lang = 'ru';
    $click = 4;
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
    $lang = 'en';
    $click = 5;
}
require_once "inc/config.php";
if (trovaLingua() == 'it') {
    include "inc/l_it.php";
    $mostra_lingua = '<button class="btn text-white" name="linguaIt" type="submit">IT</button><div class="vr"></div><button class="btn text-white" name="linguaEn" type="submit">EN</button>';
    $logo = 'dkcenergyportal.png';
    $lang = 'it';
} else if (trovaLingua() == 'en') {
    include "inc/l_en.php";
    $mostra_lingua = '<button class="btn text-white" name="linguaIt" type="submit">IT</button><div class="vr"></div><button class="btn text-white" name="linguaEn" type="submit">EN</button>';
    $logo = 'dkcenergyportal.png';
    $lang = 'en';
} else if (trovaLingua() == 'ru') {
    include "inc/l_ru.php";
    $mostra_lingua = '<button class="btn text-white" name="linguaRuEn" type="submit">RU</button><div class="vr"></div><button class="btn text-white" name="linguaEnRu" type="submit">EN</button>';
    $logo = 'dkc.png';
    $lang = 'ru';
} else if (trovaLingua() == 'userruen') {
    include "inc/l_ru.php";
    $mostra_lingua = '<button class="btn text-white" name="linguaRuEn" type="submit">RU</button><div class="vr"></div><button class="btn text-white" name="linguaEnRu" type="submit">EN</button>';
    $logo = 'dkc.png';
    $lang = 'ru';
} else if (trovaLingua() == 'userenru') {
    include "inc/l_en-ru.php";
    $mostra_lingua = '<button class="btn text-white" name="linguaRuEn" type="submit">RU</button><div class="vr"></div><button class="btn text-white" name="linguaEnRu" type="submit">EN</button>';
    $logo = 'dkc.png';
    $lang = 'en';
}
/*if (isset($_POST['username'])) {
    $username = $password = "";
} else {
    $username = $password = "";
}*/
$username = $password = "";
$username_err = $password_err = "";
$auth = "";
$firstlogin = "";
$toast = "";
$echargerpot = '';
$echargerstato = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim(isset($_POST["username"])))) {
        $username_err = '';
    } else {
        $username = trim($_POST["username"]);
    }
    if (empty(trim(isset($_POST["password"])))) {
        $password_err = '';
    } else {
        $password = trim($_POST["password"]);
    }
    if (empty($username_err) && empty($password_err)) {
        $sql2 = "SELECT id, username, password, auth, firstlogin FROM users WHERE username = ?";
        if ($stmt2 = mysqli_prepare($link, $sql2)) {
            mysqli_stmt_bind_param($stmt2, "s", $param_username);
            $param_username = $username;
            if (mysqli_stmt_execute($stmt2)) {
                mysqli_stmt_store_result($stmt2);
                if (mysqli_stmt_num_rows($stmt2) == 1) {
                    mysqli_stmt_bind_result($stmt2, $id, $username, $hashed_password, $auth, $firstlogin);
                    if (mysqli_stmt_fetch($stmt2)) {
                        if (password_verify($password, $hashed_password)) {
                            session_destroy();
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $usernameSolo = strstr($username, '@', true);
                            $_SESSION["username"] = $usernameSolo;
                            $_SESSION["auth"] = $auth;
                            $_SESSION["firstlogin"] = $firstlogin;
                            $_SESSION["change"] = $password;
                            $_SESSION["toast"] = $toast;
                            $_SESSION["echargerpot"] = $echargerpot;
                            $_SESSION["echargerstato"] = $echargerstato;
                            header("location: telemetry.php");
                        } else {
                            $password_err = "<div class='alert alert-warning' role='alert'>" . _FORMMESSAGE3 . "</div>";
                        }
                    }
                } else {
                    if ($click != 0) {
                        $click = 0;
                    } else {
                        $username_err = "<div class='alert alert-warning' role='alert'>" . _FORMMESSAGE3 . "</div>";
                    }
                }
            } else {
                echo "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt2);
        }
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">

<head>
    <title><?= _TITLELOGIN ?></title>
    <meta charset="utf-8" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
    <link href="favicon.ico" rel="icon" type="image/x-icon" />
    <link href="favicon.png" rel="icon" type="image/png" />
</head>

<body class="text-center">
    <div class="container-fluid">
        <div class="row text-end mb-2">
            <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="fw-bold mt-3 text-decoration-none">
                    <img src="img/ico_tr_language_dark.png">
                    <?php echo $mostra_lingua ?>
                </div>
            </form>
        </div>
        <div class="row justify-content-center mb-2">
            <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <img class="img-fluid" src="img/<?php echo $logo ?>">
                <h1 class="h3 my-3 fw-normal text-dkc"><?= _HEADLOGIN ?></h1>
                <div class="form-floating <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <input type="text" name="username" class="form-control" placeholder="username" id="floatingInput" value="<?php echo $username; ?>" required>
                    <label for="floatingInput"><?= _USERNAME ?></label>
                </div>
                <div class="form-floating <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <input type="password" name="password" class="form-control" placeholder="password" id="floatingPassword" required>
                    <label for="floatingPassword"><?= _PASSWORD ?></label>
                    <span><?php echo $username_err; ?></span>
                    <span><?php echo $password_err; ?></span>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit"><?= _SUBMITLOGIN ?></button>
                <p class="mt-4 text-muted">&copy; 2023 DKC Europe S.r.l.</p>
            </form>
        </div>
    </div>
</body>

</html>