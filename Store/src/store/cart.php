<?php
session_start();
include "../classes/DB.php";
include "../config.php";
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = array();
}
if (isset($_POST["cartBtn"])) {
    $proId = $_POST["id"];
    $stm = App\DB::getInstance()->prepare("SELECT * FROM products  where product_id =   $proId");
    $stm->execute();
    $res =   $stm->setFetchMode(PDO::FETCH_ASSOC);
    if (!isPresent($proId)) {
        foreach ($stm->fetchAll() as $v) {
            $a =       $v;
            $v['quantity'] = 1;
            array_push($_SESSION["cart"], $v);
        }
    }
}
function isPresent($id)
{
    foreach ($_SESSION["cart"] as $k => $v) {
        if ($id == $v["product_id"]) {
             $_SESSION["cart"][$k]['quantity']++;
             return true;
        }
    }
    return false;
}
//  echo "<pre>";
//  print_r($_SESSION["cart"]);
//  echo "</pre>";


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
  <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">


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
        <h2>Cart</h2>
      </div>

      <div class="row g-5">
        <div class="col order-md-last">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Your Cart</span>
            <span class="badge bg-primary rounded-pill"><?php echo count($_SESSION["cart"]) ?></span>
          </h4>
            <?php
          // displayCart();
            if (isset($_POST["delete"])) {
                $key = $_POST["delKey"];
                array_splice($_SESSION["cart"], $key, 1);
                displayCart();
            } elseif (isset($_POST["updateQuant"])) {
                $id = $_POST["inpId"];
            // echo $id ;
            // die();
                $quant = $_POST["inpVal"];
                foreach ($_SESSION["cart"] as $k => $v) {
                    if ($v["product_id"] == $id) {
                        $_SESSION["cart"][$k]['quantity'] += $quant;
                        displayCart();
                    }
                }
            } else {
                displayCart();
            }
            function displayCart()
            {
                $html = "";
                $html = '<table class="table">
                <tr>
                   <th>Product</th>
                   <th>Price</th>
                   <th>Qty</th>
                   <th>DELETE</th>
                   <th>Total</th>
                </tr>';
                foreach ($_SESSION["cart"] as $k => $v) {
                    $tPrice = 0;
                    $tPrice = $v["quantity"] * $v["product_list_price"];
                    $html .= '<tr>
                                  <td>' . $v["product_name"] . '</td>
                                  <td>' . $v["product_list_price"] . '</td>
                                  <td>
                                      <form action="" method="POST">
                                          <input type="text" class="w-20" name="inpVal" value=' . $v["quantity"] . '>
                                          <input type="hidden" name="inpId" value=' . $v["product_id"] . '>
                                          <input type="submit" class="btn btn-secondary ms-1 w-20" name="updateQuant" 
                                          value="update">
                                       </form>   
                                  </td>
                                  <td>
                                      <form action="" method="POST">
                                          <input type="hidden" name="delKey" value=' . $k . '>
                                          <input type="submit" class="btn btn-danger ms-1 w-20" name="delete"
                                           value="DELETE">
                                       </form>
                                 </td>
                    
                                 <td>$' . $tPrice . '</td>
                               </tr>';
                }
                $html .= '</table>';
                echo $html;
            }
            ?>

        </div>
      </div>
      <div class="row g-5 align-items-right">
        <div class="col-3">
          <form action="../store/checkout.php" method="POST">
            <button type="submit" class="btn btn-primary">Checkout</button>
          </form>
        </div>
      </div>
      <a href="../signout.php">Sign Out</a>
    </main>

    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">&copy; 2017–2021 Company Name</p>
      <ul class="list-inline">
        <li class="list-inline-item"><a href="#">Privacy</a></li>
        <li class="list-inline-item"><a href="#">Terms</a></li>
        <li class="list-inline-item"><a href="#">Support</a></li>
      </ul>
    </footer>
  </div>


  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="../assets/js/cart.js"></script>
  <script src="./assets/js/form-validation.js"></script>
</body>

</html>