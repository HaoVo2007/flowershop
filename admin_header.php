<?php
if (isset($_POST['logout']) && $_POST['logout'] == 1) {
    session_destroy();
    header('Location: login.php');
    exit();
} else {
    
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
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <h1 class="Logo">Teleflora</h1>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="fa-solid fa-list"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link fs-5" aria-current="page" href="admin_panel.php">Home</a>
                </li>
                <li class="nav-item ms-3">
                    <a class="nav-link fs-5" href="admin_product.php">Product</a>
                </li>
                <li class="nav-item ms-3">
                    <a class="nav-link fs-5" href="admin_user.php">User</a>
                </li>
                <li class="nav-item ms-3">
                    <a class="nav-link fs-5" href="admin_order.php">Order</a>
                </li>
                <li class="nav-item ms-3">
                    <a class="nav-link fs-5" href="admin_message.php">Message</a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            <div class="icons" id="icons-1">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="user-box" id="user-box-1">
                <p>Username : <span><?php echo $_SESSION['admin_name'] ?></span></p>
                <p>Email : <span><?php echo $_SESSION['admin_email'] ?></span></p>
                <form action="" method="post">
                    <input type="hidden" name="logout" value="1">
                    <button type="submit" class="logout-btn btn btn-primary">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="main.js"></script>
</body>
</html>
