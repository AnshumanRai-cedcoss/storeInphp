<?php
include "classes/DB.php";
include "config.php";
session_start();
$id = $_SESSION["userdata"]["user_id"];
$stm = App\DB::getInstance()->prepare("SELECT * FROM orders  where user_id = $id");
$stm->execute();
$res =   $stm->setFetchMode(PDO::FETCH_ASSOC);
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
  <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
   <div class="container-fluid">
       <h1 class="text-primary">Your Orders</h1>
       
        <?php
        foreach ($stm->fetchAll() as $k => $v) {
                $arr=json_decode($v["product_details"]) ;
                // echo $prod["name"];
                ?> <p style="font-weight: 900;">Order No:</p><?php echo $k+1;
                ?> 
              
              <div class="row p-5">
              <div class="col bg-dark text-white">
                  <p><b>Your Order Id : </b> <?php echo $v["order_id"]; ?></p>
                  <h4>Product Details</h4>
                    <?php for ($i=0; $i < count($arr); $i++) {
                    //    print_r($arr[$i]);
                        echo $i+1;
                        ?> <p><b>Product Name: </b> <?php echo $arr[$i]->name;?></p> 
                         <p><b>Product Price: </b> <?php echo $arr[$i]->price;?></p> 
                        <?php
} ?> <p>Total amount:</p>   <?php echo $v["total_amount"] ?>
                   
               </div>
                
               </div> 
                <?php
        }
        
        ?>
   </div>
</body>
</html>