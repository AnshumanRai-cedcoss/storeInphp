<?php
session_start();
include "classes/DB.php";
include "classes/user.php";
include "config.php";
$msg = "";
if (isset($_POST["submit"])) {
  $email = $_POST["email"];
  $password = $_POST["password"];
  // echo $email;
  $stm = DB::getInstance()->prepare("SELECT * FROM Users");
  $stm->execute();
  foreach ($stm->fetchAll() as $k => $v) {
    if ($v["email"] == $email && $v["password"] == $password) {
      if (!isset($_SESSION["userdata"])) {
        $_SESSION["userdata"] = array(
          "fname" => $v["firstname"],
          "lname" => $v["lastname"],
          "email" => $v["email"],
          "password" => $v["password"],
          "username" => $v["username"],
          "role" => $v["role"]
        );
      }
      if ($v["role"] == "Admin") {
        header("location:dashboard.php");
      } else {
        if ($v["status"] == "Approved") {
          header("location:dashboardUser.php");
        } else {
          $msg = "You are not approved";
        }
      }
    } else {
      $msg = "Wrong email or password";
    }
  }
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.88.1">
  <title>Signin Template · Bootstrap v5.1</title>

  <!-- Bootstrap core CSS -->
  <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="./assets/css/signin.css" rel="stylesheet">
</head>

<body class="text-center">

  <main class="form-signin">
    <form action="" method="POST">
      <h1 class="h3 mb-3 fw-normal">Sign In</h1>

      <div class="form-floating">
        <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>

      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button id="signInBtn" class="w-100 btn btn-lg btn-primary" name="submit" type="submit">Sign in</button>
      <a id="createAcc" href="signUp.php">Create New Account</a>
      <p class="mt-5 mb-3 text-muted">&copy; CEDCOSS Technologies</p>
      <div class="message text-danger">
        <?php echo $msg ?>
      </div>
    </form>
  </main>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>