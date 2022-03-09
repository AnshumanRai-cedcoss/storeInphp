<?php
session_start();
include "config.php";
include "classes/DB.php";
$stmt = App\DB::getInstance()->prepare("SELECT * FROM orders");
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
if (isset($_POST["submit1"])) {
    $id = $_POST["oid"];
    $status = $_POST["status"];
    $stmt1 = App\DB::getInstance()->prepare("UPDATE orders SET status='$status' WHERE order_id=$id");
    $stmt1->execute();
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
  <title>Dashboard Template · Bootstrap v5.1</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">



  <!-- Bootstrap core CSS -->
  <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">


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
  <link href="./assets/css/dashboard.css" rel="stylesheet">
</head>

<body>

  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Company name</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" 
    type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" 
    aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" 
    aria-label="Search">
    <div class="navbar-nav">
      <div class="nav-item text-nowrap">
        <a class="nav-link px-3" href="signout.php">Sign out</a>
      </div>
    </div>
  </header>

  <div class="container-fluid">
    <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link"  href="dashboard.php">
                <span data-feather="home"></span>
                Dashboard
              </a>
            </li>
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="">
                <span data-feather="file"></span>
                Orders
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="products.php">
                <span data-feather="shopping-cart"></span>
                Products
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="bar-chart-2"></span>
                Reports
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="layers"></span>
                Integrations
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center
         pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Orders</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
              <span data-feather="calendar"></span>
              This week
            </button>
          </div>
        </div>


        <br>
        <div class="table-responsive">
        <?php
          $html = "";
          $html .= '<table class="table table-striped table-sm">     
        <tr>
          <th scope="col">order_id</th>
          <th scope="col">user_id</th>
          <th scope="col-4">Product name</th>
          <th scope="col">Date of Order</th>
          <th> Current Status </th>
          <th scope="col">Change Status</th>
        </tr>
      ';
        foreach ($stmt->fetchAll() as $k => $v) {
            $html .= '<tr>
    <td>' . $v["order_id"] . '</td>
    <td>' . $v["user_id"] . '</td>
    <td>' . $v["product_details"] . '</td>
    <td>' . $v["order_date"] . '</td>
    <td>' .$v["status"].'</td>
    <td> <form action="" method="POST">
    <select name="status" id="">
              <option value="" >---- Status ----</option>
              <option value="In Transit" >In Transit</option>
              <option value="dispatched" >Dispatched</option>
              <option value="delivered" >Delivered</option>
              <input type = "hidden" value ='.$v["order_id"].' name="oid">
              <input type="submit" class="btn-primary" name="submit1" value="Update Status">
    </form>
    </tr>
    ';
        }
          $html .= '</table>';
          echo $html;
            ?>

          </tbody>
          </table>

        </div>
      </main>
    </div>
  </div>


  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js" 
  integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
  crossorigin="anonymous"></script>
</body>

</html>