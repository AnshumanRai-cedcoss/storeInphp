<?php
session_start();
include "config.php";
include "classes/DB.php";
include "classes/user.php";
include "classes/product.php";

if (isset($_POST["del"])) {
    $did = $_POST["delete"];
    $stm = DB::getInstance()->prepare("DELETE FROM products WHERE product_id = '$did'");
    $stm->execute();
}
if (isset($_POST["submit"])) {
    $productname = $_POST["prodName"];
    $productimage = $_POST["proImg"];
    $listPrice = $_POST["listPrice"];
    $salePrice = $_POST["salePrice"];
    $pcat = $_POST["cate"];
    $stm = DB::getInstance()->prepare("SELECT * FROM category");
    $stm->execute();
    foreach ($stm->fetchAll() as $k => $v) {
        if ($v["category_name"] == $pcat) {
            $pid = $v["category_id"];
        }
    }
    $product = new product($productname, $productimage, $salePrice, $listPrice, $pid);
    $msg1 = $product->addProduct();
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
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <div class="navbar-nav">
      <div class="nav-item text-nowrap">
        <a class="nav-link px-3" href="#">Sign out</a>
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
              <a class="nav-link" href="#">
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

          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Saved reports</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
              <span data-feather="plus-circle"></span>
            </a>
          </h6>
          <ul class="nav flex-column mb-2">
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="file-text"></span>
                Current month
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="file-text"></span>
                Last quarter
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="file-text"></span>
                Social engagement
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="file-text"></span>
                Year-end sale
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 
        border-bottom">
          <h1 class="h2">Products</h1>
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

        <form class="row row-cols-lg-auto g-3 align-items-center">
          <div class="col-12">
            <label class="visually-hidden" for="inlineFormInputGroupUsername">Search</label>
            <div class="input-group">
              <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="Enter id,name...">
            </div>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary">Search</button>
          </div>
          <div class="col-12">
            <a class="btn btn-success" href="add-product.php">Add Product</a>
          </div>
        </form>
        <div class="table-responsive">
            <?php
            $html = "";
            $html .= '<table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th scope="col">Product Id</th>
                  <th scope="col">Product Name</th>
                  <th scope="col">Product Image</th>
                  <th scope="col">Category Name</th>
                  <th scope="col">Sale Price</th>
                  <th scope="col">List Price</th>
                  <th scope="col">DELETE</th>
                </tr>
              </thead>
              <tbody>';
            $stm = DB::getInstance()->prepare("SELECT * FROM products INNER JOIN category 
            WHERE products.category_id = category.category_id ");
            $stm->execute();

            foreach ($stm->fetchAll() as $k => $v) {
                $html .= '<tr>
                    <td>' . $v["product_id"] . '</td>
                    <td>' . $v["product_name"] . '</td>
                    <td>' . $v["product_image"] . '</td>
                    <td>' . $v["category_name"] . '</td>
                    <td>' . $v["product_sale_price"] . '</td>
                    <td>' . $v["product_list_price"] . '</td>
                    <td class="d-inline-flex">
                    <form action="editProd.php"  method = "POST">
                    <input name="pid" type="hidden" value=' . $v["product_id"] . '>
                    <input name="pname" type="hidden" value=' . $v["product_name"] . '>
                    <input name="pCat" type="hidden" value=' . $v["category_name"] . '>
                    <input name="psl" type="hidden" value=' . $v["product_sale_price"] . '>
                    <input name="plp" type="hidden" value=' . $v["product_list_price"] . '>
                    <button name="update" class="btn btn-primary" type="submit">EDIT</button></form>
                    <form action="" method = "POST">
                    <input name="delete" type="hidden" value=' . $v["product_id"] . '>
                    <button name="del" class="btn btn-danger" type="submit">DELETE</button></form>
                    </td>
                    </tr>';
            }
            $html .=  '</tbody>
            </table>';
            echo $html;
            ?>
          <!-- <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item"><a class="page-link" href="#">Previous</a></li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
          </nav> -->
        </div>
      </main>
    </div>
  </div>


  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
</body>

</html>