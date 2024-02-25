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

    if (isset($_POST['order-btn'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $number = $_POST['number'];
        $address = $_POST['address'];
        $option = $_POST['option'];
        $placed_on = date('d-M-Y');
        $cart_total = 0;
        $cart_product = array();
    
        if (empty($email)) {
            $message[] = 'Please enter your email.';
        }
    
        $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Query Failed');
    
        if (mysqli_num_rows($cart_query) > 0) {
            while ($cart_item = mysqli_fetch_assoc($cart_query)) {
                $cart_product[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ')';
                $sub_total = ($cart_item['price'] * $cart_item['quantity']);
                $cart_total = $cart_total + $sub_total;
            }
        }
    
        $totals_product = implode(', ', $cart_product);
    
        if (empty($message) && $option !== 'Select payment method') {

            $canCheckout = true;
            foreach ($cart_product as $cart_query) {
                list($product_name, $quantity) = explode('(', $cart_query);
                $product_name = trim($product_name);
                $quantity = intval($quantity);
    
                $check_quantity_query = mysqli_query($conn, "SELECT `quantity` FROM `product` WHERE `name` = '$product_name'");
                if ($check_quantity_query) {
                    $product_info = mysqli_fetch_assoc($check_quantity_query);
                    $remaining_quantity = $product_info['quantity'];
    
                    if ($quantity > $remaining_quantity) {
                        $message[] = "Not enough stock for '$product_name'. Remaining: $remaining_quantity ";
                        $canCheckout = false;
                        break;
                    }
                } else {
                    $message[] = 'Error checking product quantity.';
                    $canCheckout = false;
                    break;
                }
            }
    
            if ($canCheckout) {
                mysqli_query($conn, "INSERT INTO `order` (`user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`) 
                VALUES ('$user_id', '$name', '$number', '$email', '$option', '$address', '$totals_product', '$cart_total', '$placed_on')") or die('Query Failed ' . mysqli_error($conn));
    
                $order_id = mysqli_insert_id($conn);
    
                foreach ($cart_product as $cart_query) {
                    list($product_name, $quantity) = explode('(', $cart_query);
                    $product_name = trim($product_name);
                    $quantity = intval($quantity);

                    mysqli_query($conn, "UPDATE `product` SET `quantity` = `quantity` - $quantity WHERE `name` = '$product_name'") or die('Query Failed' . mysqli_error($conn));
                }
    
                mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id' ") or die('Query Failed' . mysqli_error($conn));
    
                header('location: checkout.php?messageg=Order added successfully.');
            }
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
    <body class="bg-light">
    <div class="container">

    <div class="container d-flex align-items-center justify-content-center popular-brands">
        <h2 class="text-center">GO TO THE CHECKOUT</h2>
    </div>
    <?php
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id ='$user_id'") or die ("Query Failed");
        $cart_count = mysqli_num_rows($select_cart);
    ?>
    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span class="badge badge-secondary badge-pill"><?php echo $cart_count ?></span>
        </h4>
        <ul class="list-group mb-3">
            <?php 
                 $total = 0;
                 if(mysqli_num_rows($select_cart)>0) {
                    while($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            ?>

            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <h6 class="my-0">Product name</h6>
                    <small class="text-muted"><?php echo $fetch_cart['name']?></small>
                </div>
                <span class="text-muted"><?php echo $fetch_cart['price']?>$</span>
            </li>

            <?php 
                        $total =$total + $fetch_cart['price']*$fetch_cart['quantity'];
                    }
                }
            ?>
            <li class="list-group-item d-flex justify-content-between">
            <span>Total (USD)</span>
            <strong><?php echo $total ?>$</strong>
            </li>
        </ul>

        </div>
        <div class="col-md-8 order-md-1">
        <h4 class="mb-3">Billing address</h4>
        <form method="post"  class="needs-validation" >
            <div class="row">
            <div class="col-md-6 mb-3">
                <label for="firstName">Name</label>
                <input type="text" name="name" class="form-control" id="firstName" placeholder="" value="" required>
                <div class="invalid-feedback">
                Valid first name is required.
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="lastName">Number</label>
                <input type="number" class="form-control" name="number" id="lastName" placeholder="" value="" required>
                <div class="invalid-feedback">
                Valid last name is required.
                </div>
            </div>
            </div>

            <div class="mb-3">
            <label for="email">Email <span class="text-muted">(Optional)</span></label>
            <input type="email" class="form-control" name="email" id="email" placeholder="you@example.com">
            <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
            </div>
            </div>

            <div class="mb-3">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" id="address" placeholder="1234 Main St" required>
            <div class="invalid-feedback">
                Please enter your shipping address.
            </div>
            </div>


            <div class="row">
            <h4 class="mb-3">Payment</h4>
                <select class="form-select" name="option" aria-label="Default select example">
                    <option selected>Select payment method</option>
                    <option value="Cash on delivery">Cash on delivery</option>
                    <option value="Cradit card">Cradit card</option>
                    <option value="Payatm">Payatm</option>
                    <option value="Paypal">Paypal</option>
                </select>
            </div>
            <hr class="mb-4">
            <button name="order-btn" class="btn btn-primary btn-lg btn-block" type="submit">Order now</button>
        </form>
        </div>
    </div>
</div>
    
    <?php 
            include 'footer.php';
    ?>
</body>
</html>

