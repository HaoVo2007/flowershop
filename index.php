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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-yz9iH9e6de9YgSrVe4kGxC4NvA4Kc86CzFVScs5/J28mlCe81lC3UGFCaL6Lj7xj" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-oEVK7Z9w5kZ6e6Z1pLm/VzWU9xPfjsT97LDD9iI1qVThTZq4voL/99UJ7oF2b9iW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-MRDxROcb8pMeBqSoW2r7nqzbKnA5d6/CI5qO0Y7FqG5tAWVYDFHRalLWtW8VvY9F" crossorigin="anonymous"></script>
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
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img class="d-block w-100" src="image/slider1.jpg" alt="First slide">
                    </div>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Teleflora</h5>
                        <p>Where you can search for floral products, gorgeous and fresh every day</p>
                    </div>
                <div class="carousel-item">
                <img class="d-block w-100" src="image/slider3.jpg" alt="Second slide">
                </div>
                <div class="carousel-item">
                <img class="d-block w-100" src="image/slider1.jpg" alt="Third slide">
                </div>
            </div>
        </div>
    </div>
    <?php 
            include 'homeshop.php';
    ?>
    <div class="banner">
        <a href="product.php"><img class="img-fluid" src="image/banner1.jpg" alt=""></a>
        <a href="product.php"><img  class="img-fluid" src="image/banner2.jpg" alt=""></a>
    </div>

    <div class="container">
        <div class="contentt">
            <h1>Teleflora: Same-Day Local Flower Delivery</h1>
            <hr>
            <div class="contentt_1">
                <p>Order Flowers Online Always Delivered by Local Florists</p>
                <span>Teleflora is proud to offer beautiful flowers that are always 100% arranged and delivered by expert local florists! We make it easy to order flowers online and get flower delivery right to your loved one’s door. If you need to order plants or flower arrangements last-minute, we have same-day flower delivery.</span>
            </div>
            <div class="contentt_1">
                <p>Send Flowers to Loved Ones for Any Occasion</p>
                <span>We will help you send happy birthday flowers, get well bouquets, funeral flowers, and order everyday beautiful florals or plants just because. With a huge variety of fresh, local flower arrangements, we're sure you'll be able to find the right flowers to deliver for just about anyone!
                If you don't know what flowers to buy, you can shop flowers by type and choose from roses, carnations, daisies, tulips, lilies, and more. Visit the meaning of flowers glossary so you know exactly what you're saying with your online flower delivery.</span>
            </div>
            <div class="contentt_1">
                <p>Online Deals for Flowers Near You</p>
                <span>If you're looking for the best promo codes and deals for online flower delivery, we've got you covered! In addition to Teleflora coupons, we also have Deal of the Day bouquets. You pick a price and a local florist will create a one-of-a-kind flower arrangement with their own signature style using the season’s freshest blooms!</span>
            </div>
            <div class="contentt_1">
                <p>Who Offers the Best Local Flower Delivery Online?</p>
                <span>Teleflora has the best local flower delivery because we work with over 10,000 local florists all around the country to bring you local flower delivery. So, know that every bouquet you order from us supports a small business near you or your loved one. We couldn’t do it without our amazing florists!</span>
            </div>
            <div class="contentt_1">
                <p>How Will My Flowers Ordered Online Be Delivered?</p>
                <span>Teleflora flowers are 100% arranged and delivered by local florists in your area. That means every bouquet will be delivered right to your door with the utmost care. We are also utilizing contactless delivery for your safety and the safety of our local florists.</span>
            </div>
            <div class="contentt_1">
                <p>Do You Have Same-Day Flower Delivery for Last Minute Gifts?</p>
                <span>Same-day delivery is available on many of our flower arrangements! So, whether you send flowers in advance or need a last-minute gift, we’ve got you covered with the freshest flowers available!</span>
            </div>
            <div class="contentt_1">
                <p>How Much Does Sending Flowers Online Cost?</p>
                <span>We have fresh flower arrangements and plants for every budget and occasion, so you never have to worry about not being able to find something for your loved ones. Plus, our Deal of the Day bouquets allows you to name your own bouquet price for a one-of-a-kind arrangement.</span>
            </div>
        </div>
    </div>
    <?php 
            include 'footer.php';
    ?>
</body>
</html>