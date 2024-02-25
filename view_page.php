<?php
include 'connection.php';
session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }
    
    if (empty($user_id)) {
        $user_id = '';
    } else {
        $user_id = $_SESSION['user_id'];;
    }
    
    if(isset($_POST['add_to_cart'])) {
        if($user_id == '') {
            $message[] = 'Please log in to do this';
        } else {
            $product_id = $_POST['id'];
            $product_name = $_POST['name'];
            $product_price = $_POST['price'];
            $product_image = $_POST['image'];
            $product_quantity = $_POST['product_quantity'];
            $quantity = $_POST['quantity'];
             
            $cart_result = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id' ") or die('Query Fail');
            if ($quantity == 0) {
                $message[] = "Sản phẩm hiện đã hết hàng";
            } else {
                if (mysqli_num_rows($cart_result) > 0) {
                    $existing_cart_item = mysqli_fetch_assoc($cart_result);
                    $new_quantity = $existing_cart_item['quantity'] + $product_quantity;
                    mysqli_query($conn, "UPDATE `cart` SET quantity = '$new_quantity' WHERE name = '$product_name' AND user_id = '$user_id' ") or die('Update Query Failed');
                    $message[] = 'Quantity updated in your cart';
                } else {
                    mysqli_query ($conn,"INSERT INTO `cart` (`user_id`,`pid`,`name`,`price`,`quantity`,`image`) VALUES ('$user_id','$product_id','$product_name','$product_price','$product_quantity','$product_image')") or die('Insert Query Failed');
                    $message[] = 'Product successfully added to your cart';
                }
            }
        }
            
    }

    if(isset($_POST['add_to_wishlist'])) {
        if($user_id == '') {
            $message[] = 'Please log in to do this';
        } else {
            $product_id = $_POST['id'];
            $product_name = $_POST['name'];
            $product_price = $_POST['price'];
            $product_image = $_POST['image'];

            $wishlist_number = mysqli_query($conn, "SELECT *FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id' ") or die('Query Fail');
            $cart_number = mysqli_query($conn, "SELECT *FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id' ") or die('Query Fail');
            if (mysqli_num_rows($wishlist_number)>0) {
                $message[] = 'Product already exist in wishlist';
            } else {
                mysqli_query ($conn,"INSERT INTO `wishlist` (`user_id`,`pid`,`name`,`price`,`image`) VALUES
                ('$user_id','$product_id','$product_name','$product_price','$product_image')") or die('Query Failed');
                $message[] = 'Product successfully added in your wishlist'; 
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
    <div class="container">
        <?php 
            if(isset($_GET['pid'])) {
                $pid = $_GET['pid'];
                $select_product = mysqli_query($conn, "SELECT *FROM `product` WHERE id = '$pid'") or die ("Querry Failed");
                if(mysqli_num_rows($select_product)>0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_product)) {

             
        ?>
        <form action="" method="post">
            <div class="container my-5">
                <div class="row">
                    <div class="col-md-5">
                        <div class="main-img">
                            <img class="img-fluid" src="image/<?php echo $fetch_product['image'] ?>" alt="ProductS">
                            <div class="row my-3 previews">
                                <div class="col-md-3">
                                    <img class="w-100" src="image/<?php echo $fetch_product['image'] ?>" alt="Sale">
                                </div>
                                <div class="col-md-3">
                                    <img class="w-100" src="image/<?php echo $fetch_product['image'] ?>" alt="Sale">
                                </div>
                                <div class="col-md-3">
                                    <img class="w-100" src="image/<?php echo $fetch_product['image'] ?>" alt="Sale">
                                </div>
                                <div class="col-md-3">
                                    <img class="w-100" src="image/<?php echo $fetch_product['image'] ?>" alt="Sale">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="main-description px-2">
                            <div class="category text-bold">
                                Category: <?php echo $fetch_product['option'] ?>
                            </div>
                            <div class="product-title text-bold my-3">
                                <?php echo $fetch_product['name'] ?>
                            </div>


                            <div class="price-area my-4">
                                <p class="new-price text-bold mb-1"><?php echo $fetch_product['price'] ?>$</p>
                                <p class="text-secondary mb-1">(Additional tax may apply on checkout)</p>
                                <p class="old-price mb-1">Remaining products : <span class="old-price-discount text-danger"><?php echo $fetch_product['quantity'] ?></span></p>
                            </div>


                            <div class="buttons d-flex my-5">
                                <div class="block">
                                    <button name="add_to_wishlist" class="shadow btn custom-btn ">Wishlist</button>
                                </div>
                                <div class="block">
                                    <button name="add_to_cart" class="shadow btn custom-btn">Add to cart</button>
                                </div>

                                <div class="block quantity">
                                    <input type="number" name="product_quantity" class="form-control"  value="1" min="0" max="5" placeholder="Enter email" >
                                </div>
                            </div>




                        </div>

                        <div class="product-details my-4">
                            <p class="details-title text-color mb-1">Product Details</p>
                            <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat excepturi odio recusandae aliquid ad impedit autem commodi earum voluptatem laboriosam? </p>
                        </div>
                    
                                <div class="row questions bg-light p-3">
                            <div class="col-md-1 icon">
                                <i class="fa-brands fa-rocketchat questions-icon"></i>
                            </div>
                            <div class="col-md-11 text">
                                Have a question about our products at E-Store? Feel free to contact our representatives via live chat or email.
                            </div>
                        </div>

                        <div class="delivery my-4">
                            <p class="font-weight-bold mb-0"><span><i class="fa-solid fa-truck"></i></span> <b>Delivery done in 3 days from date of purchase</b> </p>
                            <p class="text-secondary">Order now to get this product delivery</p>
                        </div>
                        <div class="delivery-options my-4">
                            <p class="font-weight-bold mb-0"><span><i class="fa-solid fa-filter"></i></span> <b>Delivery options</b> </p>
                            <p class="text-secondary">View delivery options here</p>
                        </div>
                        
                    
                    </div>
                </div>
            </div>
            <input type="hidden" name="quantity" value="<?php echo $fetch_product['quantity'] ?>">
            <input type="hidden" name="id" value="<?php echo $fetch_product['id'] ?>">
            <input type="hidden" name="name" value="<?php echo $fetch_product['name'] ?>">
            <input type="hidden" name="price" value="<?php echo $fetch_product['price'] ?>">
            <input type="hidden" name="image" value="<?php echo $fetch_product['image'] ?>">
            </div>
        </form>
        <?php 
        
                }
            }
        }
        ?>
    </div>
    <?php 
            include 'homeshop.php';
    ?>

    <?php 
            include 'footer.php';
    ?>
</body>
</html>