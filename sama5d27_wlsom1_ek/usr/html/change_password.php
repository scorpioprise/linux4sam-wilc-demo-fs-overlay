<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$id = $_SESSION["id"];
$firstLogin = $_SESSION["firstLogin"];
$change = $_SESSION["change"];
require_once "inc/config.php";
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "please enter the new password";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "password must have at least 6 characters";
    } elseif ($_POST["new_password"] == $change) {
        $new_password_err = "password must be different than the old one";
    } else {
        $new_password = trim($_POST["new_password"]);
    }
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "please confirm the password";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "password did not match";
        }
    }
    if (empty($new_password_err) && empty($confirm_password_err)) {
        $sql = "UPDATE users SET password = ?, firstlogin = 0 WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            if (mysqli_stmt_execute($stmt)) {
                session_destroy();
                header("location: login.php");
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
<html lang="en">
<head>
    <title>DKC wallbox FIRST LOGIN</title>
    <meta charset="utf-8" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/change.css" rel="stylesheet">
    <link href="favicon.ico" rel="icon" type="image/x-icon" />
    <link href="favicon.png" rel="icon" type="image/png" />
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark sticky-top bg-dark">
        <img src="img/dkc.png" width="54" height="30" class="ms-2">
        <div class="navbar-brand ms-3" href="#">wallbox webserver</div>
    </nav>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 my-5">
                <h3 class="display-6">CHANGE PASSWORD AT FIRST LOGIN</h3>
                <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-floating my-2 <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" name="new_password" class="form-control" placeholder="new password" id="floatingPassword" value="<?php echo $new_password; ?>">
                        <label for="new_password" class="sr-only">new password</label>
                        <span class="help-block"><?php echo $new_password_err; ?></span>
                    </div>
                    <div class="form-floating my-2 <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" name="confirm_password" class="form-control" placeholder="confirm password" id="floatingPassword">
                        <label for="password" class="sr-only">confirm password</label>
                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <button class="w-100 btn btn-lg btn-primary my-2" type="submit">submit</button>
                    <a class="w-100 btn btn-lg btn-secondary" href="login.php">cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<!--# endif -->
