<?php
session_start();
include "../classes/DB.php";
include "../config.php";
if (!isset($_SESSION["userdata"])) {
    header("location: ../login.php");
}
$t =  0;
// echo "<pre>";
// print_r($_SESSION["userdata"]);
// echo "</pre>";

$cartItems = array();
$cartDetails = array();
foreach ($_SESSION["cart"] as $k => $v) {
    $cartItems["id"]=$v["product_id"];
    $cartItems["name"]=$v["product_name"];
    $cartItems["quantity"]=$v["quantity"];
    $cartItems["price"]=$v["product_list_price"]*$v["quantity"];
    $t+=$cartItems["price"];
    array_push($cartDetails, $cartItems);
}
$var = json_encode($cartDetails);
// echo $var;
$id= $_SESSION["userdata"]["user_id"];
$address = "";
if (isset($_POST["orderBtn"])) {
    $add = $_POST["add1"];
    $add2 = $_POST["add2"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];
    $address = $add." ".$add2." ".$state." ".$zip;
        $stm = DB::getInstance()->prepare("INSERT INTO `orders`(`user_id`, `status`, `product_details`,
                                  `shipping_address`,`total_amount`)  
                                  VALUES ($id,'pending','$var','$address','$t')");
    $stm->execute();
    $msg = "Order Placed sucessfully";
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
    <title>Checkout example · Bootstrap v5.1</title>
    

    <!-- Bootstrap core CSS -->
<link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" 
integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


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
  </head>
  <body class="bg-light">
    
<div class="container">
  <main>
    <div class="py-5 text-center">
      <h2>Checkout form</h2>
      <p class="lead">Below is an example form built entirely with Bootstraps form controls. Each required form
         group has a validation state that can be triggered by attempting to submit the form without completing it.</p>
    </div>

    <div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your cart</span>
          <span class="badge bg-primary rounded-pill"><?php echo count($_SESSION["cart"])?></span>
        </h4>
        <ul class="list-group mb-3">
          
            <?php
            $html = "";
            $total =  0;
            foreach ($_SESSION["cart"] as $k => $v) {
                $html.= '<li class="list-group-item d-flex justify-content-between lh-sm">
                <div>
                <h6 class="my-0">'.$v["product_name"].'</h6>
                <small class="text-muted">Brief description</small>
                </div>
                <span class="text-muted">'.$v["product_list_price"]*$v["quantity"].'</span>
                </li>';
                $total+= $v["product_list_price"]*$v["quantity"] ;
            }
              echo $html ;
            ?>
            <li class="list-group-item d-flex justify-content-between bg-light">
            <div class="text-success">
            <h6 class="my-0">Promo code</h6>
            <small>EXAMPLECODE</small>
            </div>
            <span class="text-success">$5</span>
           </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Total (USD)</span>
            <strong>$<?php echo $total ;?></strong>
          </li>
        </ul>

        <form class="card p-2">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Promo code">
            <button type="submit" class="btn btn-secondary">Redeem</button>
          </div>
        </form>
      </div>
      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Billing address</h4>
        <form action="" class="needs-validation" method="POST" >
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">First name</label>
              <input type="text" class="form-control" name="fname" id="firstName" required placeholder="" 
              value="<?php echo $_SESSION["userdata"]["fname"]?>" >
              <div class="invalid-feedback">
                Valid first name is .
              </div>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Last name</label>
              <input type="text" class="form-control" name="lname" id="lastName" required placeholder="" 
              value="<?php echo $_SESSION["userdata"]["lname"]?>" >
              <div class="invalid-feedback">
                Valid last name is .
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
              <input type="email" class="form-control" name="email" 
              value="<?php echo $_SESSION["userdata"]["email"]?>" id="email" disabled>
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" name="add1" id="address" required placeholder="1234 Main St" >
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="col-12">
              <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
              <input type="text" class="form-control" name="add2" id="address2" placeholder="Apartment or suite">
            </div>

            <div class="col-md-5">
              <label for="country" class="form-label">Country</label>
              <select class="form-select" name="country" id="country" >
                <option value="">Choose...</option>
                <option>India</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid country.
              </div>
            </div>

            <div class="col-md-4">
              <label for="state" class="form-label">State</label>
              <select class="form-select" name="state" id="state" >
                <option value="">Choose...</option>
                <option>Uttar Pradesh</option>
              </select>
              <div class="invalid-feedback">
                Please provide a valid state.
              </div>
            </div>

            <div class="col-md-3">
              <label for="zip" class="form-label">Zip</label>
              <input type="text" class="form-control" name="zip" id="zip" required placeholder="" >
              <div class="invalid-feedback">
                Zip code .
              </div>
            </div>
          </div>
          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" name="orderBtn" type="submit">Place Order</button>
        </form>
        <div class="row">
        <h2 class=" col p-5 m-5 text-success border"><?php if (isset($msg)) {
            echo $msg ;
} ?></h2>
        </div>
      </div>
    </div>
    <form action="" method="post">
          <input type="submit" name="dashboard" value="Your dashboard">
    </form>
  </main>

  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2017-2021 Company Name</p>
    <ul class="list-inline">
      <li class="list-inline-item"><a href="#">Privacy</a></li>
      <li class="list-inline-item"><a href="#">Terms</a></li>
      <li class="list-inline-item"><a href="#">Support</a></li>
    </ul>
  </footer>
</div>


    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/form-validation.js"></script>
  </body>
</html>
