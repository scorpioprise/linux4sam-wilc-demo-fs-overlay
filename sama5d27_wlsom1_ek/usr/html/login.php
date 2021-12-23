<?php
session_start();
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	    header("location: index_dashboard.html");
	    exit;
	}
	require_once 'conn.php';
	$username = $password = "";
	$username_err = $password_err = "";
	$auth = "";
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(empty(trim($_POST["username"]))){
        $username_err = "<div class='alert alert-warning' role='alert'>please enter your username</div>";
    } else{
        $username = trim($_POST["username"]);
    }
    if(empty(trim($_POST["password"]))){
        $password_err = "<div class='alert alert-warning' role='alert'>please enter your password</div>";
    } else{
        $password = trim($_POST["password"]);
    }
		if(empty($username_err) && empty($password_err)){
//	if(ISSET($_POST['login'])){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$query = "SELECT COUNT(*) as count FROM `users` WHERE `username` = :username AND `password` = :password";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':password', $password);
			$stmt->execute();
			$row = $stmt->fetch();
			$count = $row['count'];
			if($count > 0){
				$idresult = $conn->query("SELECT id FROM `users` WHERE `username` = 'admin'");
				$riga = $idresult->fetch();
			  $id= $riga['id'];
				session_start();
				$_SESSION["loggedin"] = true;
				$_SESSION["id"] = $id;
				header('location:index_dashboard.html');
			}else{
				//$_SESSION['error'] = "Invalid username or password";
				$password_err = "<div class='alert alert-danger' role='alert'>please check your credentials</div>";
				//header('location:login.php');
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>DKC wallbox login</title>
    <meta charset="utf-8" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/access.css" rel="stylesheet">
		<link href="favicon.ico" rel="icon" type="image/x-icon" />
		<link href="favicon.png" rel="icon" type="image/png" />
  </head>
  <body class="text-center">
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <img src="img/dkc_logo.png" width="300" height="47">
      <h1 class="h3 my-3 fw-normal">wallbox login</h1>
      <div class="form-floating <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
        <input type="text" name="username" class="form-control" placeholder="username" id="floatingInput" value="<?php echo $username; ?>" required>
        <label for="floatingInput">username</label>
      </div>
      <div class="form-floating <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
        <input type="password" name="password" class="form-control" placeholder="password" id="floatingPassword" required>
        <label for="floatingPassword">password</label>
        <span><?php echo $username_err; ?></span>
        <span><?php echo $password_err; ?></span>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">login</button>
      <p class="mt-4 text-muted">&copy; 2021 DKC Europe S.r.l.</p>
    </form>
  </body>
</html>
