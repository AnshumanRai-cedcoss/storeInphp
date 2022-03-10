<?php
include "classes/DB.php";
include "classes/user.php";
include "config.php";
error_reporting(0);
if (isset($_POST["submit"])) {
    $userName = $_POST["uName"];
    $fnamme = $_POST["fName"];
    $lName = $_POST["lName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $user = new App\user($userName, $fnamme, $lName, $email, $password);
    $msg1 = $user->addUser();
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

    <main class="form-signup">
        <form action="" method="post">
            <h1 class="h3 mb-3 fw-normal text-primary">User Details</h1>
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingUname" name="uName" 
                placeholder="User Name" required>
                <label for="floatingPassword">User Name</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingFname" name="fName" 
                placeholder="First Name" required>
                <label for="floatingPassword">First Name</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control m-0" id="floatingLName" name="lName" 
                placeholder="Last Name" required>
                <label for="floatingPassword">Last Name</label>
            </div>
            <div class="form-floating">
                <input type="email" class="form-control" id="floatingEmail" name="email" 
                placeholder="name@example.com" required>
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control m-0" id="floatingPassword" 
                name="password" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-success" name="submit" type="submit">Register User</button>
            <p class="mt-5 mb-3 text-muted">&copy; CEDCOSS Technologies</p>
            <p class="text-primary"> <?php echo $msg1 ?> </p>
        </form>
    </main>
</body>
</html>