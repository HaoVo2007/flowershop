<?php
include 'connection.php';
session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }
    
    if (empty($user_id)) {
        $_SESSION['user_name'] = '';
        $_SESSION['user_email'] = '';
    } else {

    }

    if(isset($_POST['minus'])) {
        $newQuantity = $_POST['product_quantity'] - 1;
        $product_id = $_POST['id'];
    
        if ($newQuantity >= 1) {

            $updateQuantityQuery = mysqli_query($conn, "UPDATE `cart` SET `quantity` = '$newQuantity' WHERE id = '$product_id'");
            
            if ($updateQuantityQuery) {

            } else {
                echo "Update failed: " . mysqli_error($conn);
            }
        }
    }

    if(isset($_POST['plus'])) {
        $newQuantity = $_POST['product_quantity'] + 1;
        $product_id = $_POST['id'];
    
        $updateQuantityQuery = mysqli_query($conn, "UPDATE `cart` SET `quantity` = '$newQuantity' WHERE id = '$product_id'");
        
        if ($updateQuantityQuery) {

        } else {
            echo "Update failed: " . mysqli_error($conn);
        }
    }

    if (isset($_GET['delete'])) {
        $product_id_to_delete = $_GET['delete'];
    
        $delete_query = mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$product_id_to_delete'") or die('Query Failed: ' . mysqli_error($conn));
        if ($delete_query) {
            header('location: cart.php?messageg=Product delete success');
        } else {

            header('location: cart.php?messageg=Product delete failed');
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Document</title>
</head>
<body>
    
    <?php 
        include 'header.php';
    ?>
    <?php
            if (isset($_GET['messageg'])) {
                $messageg = $_GET['messageg'];
                echo '
                        <div class="message success">
                            <span>'. $messageg .'</span>
                            <i class="fa-solid fa-xmark" onclick="this.parentElement.remove()"></i>
                        </div>
                    ';
            }
            if (isset($message)) {
                foreach ($message as $msg) {
                    echo '
                        <div class="message success">
                            <span>' . $msg . '</span>
                            <i class="fa-solid fa-xmark" onclick="this.parentElement.remove()"></i>
                        </div>
                    ';
                }
            }
    ?>
    <section class="h-100 h-custom" style="background-color: #d2c9ff;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12">
            <div class="card card-registration card-registration-2" style="border-radius: 15px;">
            <div class="card-body p-0">
                <div class="row g-0">
                <div class="col-lg-8">
                    <div class="p-5">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                        <?php
                            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id ='$user_id'") or die ("Query Failed");
                            $cart_count = mysqli_num_rows($select_cart);
                        ?>
                        <h6 class="mb-0 text-muted"><?php echo $cart_count ?> items</h6>
                    </div>
                    <?php
                         $total = 0;
                         if(mysqli_num_rows($select_cart)>0) {
                            while($fetch_cart = mysqli_fetch_assoc($select_cart)) { 
                    ?>
    
                    <hr class="my-4">

                    <div class="row mb-4 d-flex justify-content-between align-items-center">
                        <div class="col-md-2 col-lg-2 col-xl-2">
                        <img
                            src="image/<?php echo $fetch_cart['image'] ?>"
                            class="img-fluid rounded-3" alt="Cotton T-shirt">
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-3">
                        <h6 class="text-muted">Name</h6>
                        <h6 class="text-black mb-0"><?php echo $fetch_cart['name'] ?></h6>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                        <form action="cart.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $fetch_cart['id'] ?>">
                            <input type="hidden" name="name" value="<?php echo $fetch_cart['name'] ?>">
                            <input type="hidden" name="price" value="<?php echo $fetch_cart['price'] ?>">
                            <input type="hidden" name="product_quantity" value="<?php echo $fetch_cart['quantity'] ?>" min="1">
                            <input type="hidden" name="image" value="<?php echo $fetch_cart['image'] ?>">
                            <button class="btn btn-link px-2" name="minus">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                                            
                            <span><?php echo $fetch_cart['quantity']?></span>

                            <button class="btn btn-link px-2" name="plus">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </form>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                        <h6 class="mb-0"><?php echo $fetch_cart['price'] ?>$</h6>
                        </div>
                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                        <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class=" text-muted" onclick = 
                        "return confirm('Delete this product')"><i class="fas fa-times"></i></a>
                        </div>
                    </div>
                    <?php 
                                $total =$total + $fetch_cart['price']*$fetch_cart['quantity'];
                            }
                        }
                    ?>

                    <div class="pt-5">
                        <h6 class="mb-0"><a href="product.php" class="text-body"><i
                            class="fas fa-long-arrow-alt-left me-2"></i>Back to shop</a></h6>
                    </div>
                    </div>
                </div>
                <div class="col-lg-4 bg-grey">
                    <div class="p-5">
                    <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                    <hr class="my-4">

                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="text-uppercase">items <?php echo $cart_count ?></h5>
                        <h5><?php echo $total ?>$</h5>
                    </div>

                    <h5 class="text-uppercase mb-3">Shipping</h5>

                    <div class="mb-4 pb-2">
                        <select class="select">
                        <option value="1">ShopeeExpress</option>
                        <option value="2">Ninja Van</option>
                        <option value="3">GHTK</option>
                        <option value="4">J&T</option>
                        </select>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between mb-5">
                        <h5 class="text-uppercase">Total price :</h5>
                        <h5><?php echo $total ?>$</h5>
                    </div>

                    <?php
                        $cart_check_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Query Failed');
                        if (mysqli_num_rows($cart_check_query) > 0) {
                            echo '<a href="checkout.php" class="btn btn-dark btn-block btn-lg" data-mdb-ripple-color="dark">Process to checkout</a>';
                        } else {
                            echo '<p>Your cart is empty. Please add some items before proceeding to checkout.</p>';
                        }
                        ?>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
    <?php 
            include 'footer.php';
    ?>
</body>
</html>