<?php
session_start();
include "config.php";
include "classes/DB.php";
if(isset($_POST["submit"])){
   $_SESSION["userdata"]["fname"] = $_POST["fname"];
   $_SESSION["userdata"]["lname"] = $_POST["lname"];
   $_SESSION["userdata"]["password"] = $_POST["password"]; 
   $firstname =  $_SESSION["userdata"]["fname"];
   $lastname =  $_SESSION["userdata"]["lname"];
   $pass =  $_SESSION["userdata"]["password"];
   $umail = $_SESSION["userdata"]["email"];
   $stm = DB::getInstance()->prepare("UPDATE Users SET 
   firstname = '$firstname',
   lastname = '$lastname' ,
   password = '$pass' 
   where email = '$umail'");
   $stm->execute();
} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">
    <!-- Bootstrap core CSS -->
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

</head>

<body>
    <h1 class="text-primary p-5">Hello <?php echo $_SESSION["userdata"]["fname"]?></h1>
    <div class="row">
                <div class="col-lg-4">
                <label for="email" class="p-5"> <h4>Username:</h4> <h5 class="text-danger"><?php echo $_SESSION["userdata"]["username"]?></h5</label>
                </div>
      </div>
    <h5 class="text-success p-5">Edit Your profile</h5>
    <div class="container mt-3">
        <form action="" method="POST">
            <div class="row">
                <div class="col-lg-3">
                <label for="fname"> <b>Your First Name:</b> </label>
                </div>
                <div class="col-lg-3">
                <input type="text" class="form-control" id="fname" name="fname" value= <?php echo $_SESSION["userdata"]["fname"]?>>
                </div>
                <div class="col-lg-4">
             
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                <label for="lname"> <b>Your Last Name:</b></label>
                </div>
                <div class="col-lg-3">
                <input type="text" class="form-control" id="lname"  name="lname" value= <?php echo $_SESSION["userdata"]["lname"]?>>
                </div>
                <div class="col-lg-4">
               
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                <label for="password"> <b>Password:</b></label>
                </div>
                <div class="col-lg-3">
                <input type="password" class="form-control" id="password"  name="password" value = "<?php echo $_SESSION["userdata"]["password"]?>">
                </div>
                <div class="col-lg-4">
               
                </div>
            </div>
            <button class="btn btn-danger" type="button"> Edit </button>
            <button id="update" style="display: none;" class ="btn-primary" name="submit" type="submit">Update</button>
        </form>
    </div>

    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js" ></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./assets/js/dUser.js"></script>
</body>

</html>