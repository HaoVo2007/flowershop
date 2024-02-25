<?php
  if (isset($_POST['logout']) && $_POST['logout'] == 1) {
      session_destroy();
      header('Location: login.php');
      exit();
  } 

  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
  }

  if (empty($user_id)) {
    $user_id = '';
  } else {
    $user_id = $_SESSION['user_id'];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <h1 class="Logo">Teleflora</h1>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link fs-5" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item ms-3">
          <a class="nav-link fs-5" href="product.php">Product</a>
        </li>
        <li class="nav-item ms-3">
          <a class="nav-link fs-5" href="order.php">Order</a>
        </li>
        <li class="nav-item ms-3">
          <a class="nav-link fs-5" href="about.php">About</a>
        </li>
        <li class="nav-item ms-3">
          <a class="nav-link fs-5" href="contact.php">Message</a>
        </li>
      </ul>
      <form method="post" action="search.php" class="d-flex">
        <input class="form-control me-2" name="key" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" name="search" type="submit">Search</button>
      </form>
      <div class="icons">
          <?php
            if ($user_id=='') {
              $wishlist_num_row = 0;
            } else {
              $select_wishlist = mysqli_query($conn, "SELECT *FROM `wishlist` WHERE user_id ='$user_id'") or die('Query Failed');
              $wishlist_num_row = mysqli_num_rows($select_wishlist);
            }
          ?>
          <?php 
            if($user_id=='') {
              $cart_num_row = 0;
            } else {
              $select_cart = mysqli_query($conn, "SELECT *FROM `cart` WHERE user_id ='$user_id'") or die('Query Failed');
              $cart_num_row = mysqli_num_rows($select_cart);
            }
          ?>
          <a href="cart.php" id="cart-icon">
              <i class="fa-brands fa-shopify"></i>
              <sup><?php echo $cart_num_row ?></sup>
          </a>
          <a href="wishlist.php" id="wishlist-icon">
            <i class="fa-solid fa-heart"></i>
            <sup><?php echo $wishlist_num_row ?></sup>
          </a>
          <i id="icons-1" class="fa-solid fa-user"></i>
      </div>
      <div class="user-box" id="user-box-1">
        <?php if(empty($user_id)) : ?>
        <p>Username : <span><?php echo '' ?></span></p>
        <p>Email : <span><?php echo '' ?></span></p>
        <a href="register.php" class="logout-btn btn btn-primary">Sign in</a>
        <?php else : ?>
        <p>Username : <span><?php echo $_SESSION['user_name'] ?></span></p>
        <p>Email : <span><?php echo $_SESSION['user_email'] ?></span></p>
        <form action="" method="post">
            <input type="hidden" name="logout" value="1">
            <button type="submit" class="logout-btn btn btn-primary">Logout</button>
            <a href="change_password.php" class="btn btn-primary">Change Password</a>
        </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="main.js"></script>
</body>
</html>
