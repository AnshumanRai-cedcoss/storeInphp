<?php
session_start();
include "config.php";
include "classes/DB.php";

if (isset($_POST["update"])) {
    $pid = $_POST["pid"];
    $pname = $_POST["pname"];
    $pCat = $_POST["pCat"];
    $psale = $_POST["psl"];
    $plist = $_POST["plp"];
}
if (isset($_POST["submit2"])) {
    $pid = $_POST["prodID"];
    $pname = $_POST["pname"];
    $psale = $_POST["sale"];
    $plist = $_POST["list"];
    try {
        $stmt = App\DB::getInstance()->prepare("UPDATE Products SET product_name='$pname'
        ,sales_price='$psale',list_price='$plist' WHERE product_id='$pid';");
        $stmt->execute();
        header("location: products.php");
    } catch (Exception $e) {
        header("location:updateProduct.php");
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
  <title>Dashboard Template · Bootstrap v5.1</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">



  <!-- Bootstrap core CSS -->
  <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" 
  crossorigin="anonymous">


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
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" 
    data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" 
    aria-expanded="false" aria-label="Toggle navigation">
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
              <a class="nav-link active" aria-current="page" href="dashboard.php">
                <span data-feather="home"></span>
                Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
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
                <span data-feather="users"></span>
                Customers
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
          <h1 class="h2">Update Product</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
              <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
              <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
              <span data-feather="calendar"></span>
              This week
            </button>
          </div>
        </div>


        <form class="row g-3" action="updateProduct.php" method="POST">
          <div class="col-md-6">
            <label for="prodID" class="form-label">Product_ID</label>
            <input type="text" disabled class="form-control" id="prodID" value="<?php echo $pid; ?>">
          </div>
          <div class="col-md-6">
            <input type="hidden" class="form-control" name="prodID" value="<?php echo $pid; ?>">
          </div>
          <div class="col-md-6">
            <label for="pname" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="pname" name="pname" required value="<?php echo $pname; ?>">
          </div>
          <div class="col-md-6">
            <label for="sale" class="form-label">Sales Price</label>
            <input type="text" class="form-control" id="sale" name="sale" required value="<?php echo $psale; ?>">
          </div>
          <div class="col-md-6">
            <label for="list" class="form-label">List Price</label>
            <input type="text" class="form-control" id="list" name="list" required value="<?php echo $plist; ?>">
          </div>


          <div class="col-md-4">
            <label for="prodCat" class="form-label">Product Category</label>
            <select id="prodCat" class="form-select" name="prodCat">
              <option selected>Choose...</option>
                <?php
                $stmt = App\DB::getInstance()->prepare("SELECT * FROM Product_category");
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $html = "";
                foreach ($stmt->fetchAll() as $k => $v) {
                    $html .= '<option>' . $v["category_name"] . '</option>';
                }
                $html .= '</select>';
                echo $html;
                ?>

          </div>

          <div class="col-12">
            <button type="submit" class="btn btn-primary" name="submit2">Update Product</button>
          </div>
        </form>
      </main>
    </div>
  </div>


  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js" 
  integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
  crossorigin="anonymous"></script>
</body>

</html>