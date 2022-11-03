<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$id = $_SESSION["id"];
$firstlogin = $_SESSION["firstlogin"];
$change = $_SESSION["change"];
require_once "inc/config.php";
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "inserisci la nuova password";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "la password deve contenere almeno 6 caratteri";
    } elseif ($_POST["new_password"] == $change) {
        $new_password_err = "la password deve essere differente da quella vecchia";
    } else {
        $new_password = trim($_POST["new_password"]);
    }
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "conferma la nuova password";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "le password non corrispondono";
        }
    }
    if (empty($new_password_err) && empty($confirm_password_err)) {
        $sql = "UPDATE users SET password = ?, firstlogin = 0 WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION["firstlogin"] = 0;
                header("location: index_dashboard.php");
                exit();
            } else {
                echo "something went wrong...";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>
<!--# if expr="$internetenabled=false" -->
<!--# include file="session.php" -->
<!--# include file="index_provisioning.php" -->
<!--# else -->
<!DOCTYPE html>
<html lang="it">

<head>
    <title>DKC E.CHARGER</title>
    <meta charset="utf-8" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
    <link href="favicon.ico" rel="icon" type="image/x-icon" />
    <link href="favicon.png" rel="icon" type="image/png" />
</head>

<body class="text-center text-white">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 my-5">
                <h3 class="display-6">CAMBIO PASSWORD AL PRIMO LOGIN</h3>
                <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <img src="img/dkcenergyportal.png">
                    <div class="form-floating my-2 <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" name="new_password" class="form-control" placeholder="new password" id="floatingPassword" value="<?php echo $new_password; ?>">
                        <label for="new_password" class="sr-only">nuova password</label>
                        <span class="help-block"><?php echo $new_password_err; ?></span>
                    </div>
                    <div class="form-floating my-2 <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" name="confirm_password" class="form-control" placeholder="confirm password" id="floatingPassword">
                        <label for="password" class="sr-only">conferma nuova password</label>
                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <button class="w-100 btn btn-lg btn-primary my-2" type="submit">aggiorna</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
<!--# endif -->