<?php
 include "../classes/DB.php";
 include "../config.php";
if (isset($_POST["inputBtn"])) {
    $inp = $_POST["searchInput"];
    $filInp = $_POST["filter"];
    if ($inp != "" && $filInp == "") {
        $stm = App\DB::getInstance()->prepare("SELECT * FROM products INNER JOIN category 
        where products.category_id = category.category_id 
        AND( product_name= '$inp' OR product_id= '$inp' OR category.category_name='$inp')");
        $stm->execute() ;
    } elseif ($filInp != "" && $inp == "") {
        $stm = App\DB::getInstance()->prepare("SELECT * FROM products  
        ORDER BY LPAD(lower(product_sale_price), 6,0) asc");
        $stm->execute();
    } elseif ($inp != "" && $filInp !="") {
        $stm = App\DB::getInstance()->prepare("SELECT * FROM products INNER JOIN category where 
        products.category_id = category.category_id AND
        ( product_name= '$inp' OR product_id= '$inp' OR category.category_name='$inp')
        ORDER BY LPAD(lower(product_sale_price),6,0) asc");
        $stm->execute();
    }
} else {
    $stm = App\DB::getInstance()->prepare("SELECT * FROM products");
    $stm->execute();
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Home · Bootstrap v5.1</title>
    

    <!-- Bootstrap core CSS -->
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftj/DbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


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
  <body>
    
<header>
  <div class="collapse bg-dark" id="navbarHeader">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-md-7 py-4">
          <h4 class="text-white">Cart</h4>
          <p class="text-muted">Cart is empty now.</p>
        </div>
        <div class="col-sm-4 offset-md-1 py-4">
          <h4 class="text-white">Contact</h4>
          <ul class="list-unstyled">
            <li><a href="#" class="text-white">Follow on Twitter</a></li>
            <li><a href="#" class="text-white">Like on Facebook</a></li>
            <li><a href="#" class="text-white">Email me</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a href="#" class="navbar-brand d-flex align-items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" 
        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
        aria-hidden="true" class="me-2" viewBox="0 0 24 24">
        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
        <circle cx="12" cy="13" r="4"/></svg>
        <strong>Shop</strong>
      </a>
       <button class="navbar-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" 
       aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>
</header>

<main>

  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">My Shop</h1>
        <p class="lead text-muted">Something short and leading about the collection below—its 
          contents, the creator, etc. Make it short and sweet, but not too short so folks dont 
          simply skip over it entirely.</p>
        <p>
          <a href="#" class="btn btn-primary my-2">Shop Now</a>
          <a href="#" class="btn btn-secondary my-2">Subscribe</a>
        </p>
      </div>
    </div>
  </section>

  <div class="album py-5 bg-light">
      <div class="container overflow-hidden">
        <form class="row row-cols-lg-auto align-items-center mt-0 mb-3" method="POST">
            <div class="col-lg-6 col-12">
              <label class="visually-hidden" for="inlineForm">Search</label>
              <div class="input-group">
                <input type="text" class="form-control" id="inlineForm" name="searchInput" 
                placeholder="Product, SKU, Category">
              </div>
            </div>
          
            <div class="col-lg-3 col-12">
              <label class="visually-hidden" for="inlineFormSelectPref">Sort By</label>
              <select class="form-select" name="filter" id="inlineFormSelectPref">
                <option selected>Sort By</option>
                <option value="product_sale_price">Price</option>
                <option value="2">Recently Added</option>
                <option value="3">Popularity</option>
              </select>
            </div>
          
            <div class="col-lg-3 col-12">
              <button type="submit" name="inputBtn" class="btn btn-primary w-100">Search</button>
            </div>
          </form>
      </div>
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php
                display($stm);
                function display($stm)
                {
                    $html="";
                    foreach ($stm->fetchAll() as $k => $v) {
                        $html.= ' <div class="col">
                            <div class="card shadow-sm">
                            <img src="../images/'.$v["product_image"].'" alt="" width="90%" 
                            height="300px">
                  
                            <div class="card-body">
                                <h5>'.$v["product_name"].'</h5>
                              <p class="card-text">Product ID :'.$v["product_id"].'</p>
                              <div class="d-flex justify-content-between align-items-center">
                                <p><strong>'.$v["product_list_price"].'</strong>&nbsp;<del>
                                  <small class="link-danger">'. $v["product_sale_price"].'</small></del></p>
                                  <form action="../store/single-product.php" method="post">
                                    <input type="hidden" name="pro_id" value="'.$v["product_id"].'">
                                <button class="btn btn-secondary" type="submit" name="submit">View Details</button>
                                </form>
                                <form action="cart.php" method="post">
                                <input type="hidden" name="id" id="pro_id" value="'.$v["product_id"].'">
                                <input class="btn btn-primary" id="add-to-cart" type="submit" 
                                name="cartBtn" value="Add to Cart">
                                  </form>
                              </div>
                            </div>
                          </div>
                        </div> ';
                    }
                    echo $html;
                }
                
                ?>
          <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                  <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
              </nav>
          </div>
        
      </div>
    </div>
  </div>

</main>

<footer class="text-muted py-5">
  <div class="container">
    <p class="float-end mb-1">
      <a href="#">Back to top</a>
    </p>
    <p class="mb-1">&copy; CEDCOSS Technologies</p>
  </div>
</footer>


    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="../assets/js/cart.js"></script>  
  </body>
</html>
