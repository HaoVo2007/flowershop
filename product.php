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
    <section class="popular-brands">
        <h2>PRODUCT FOR YOUR</h2>
        <form action="" method="post" class="form-4">
            <button name="des" type="submit" class="btn btn-dark">Sort $<i class="fa-solid fa-arrow-up"></i></button>
            <button name="ins" type="submit" class="btn btn-dark">Sort $<i class="fa-solid fa-arrow-down"></i></button>
        </form>
        <div class="popular-brands-content">
            <div class="container-fluid bg-trasparent my-4 p-3" style="position: relative">
                <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">
                    <?php
                        $productsPerPage = 8;
                        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                        $startFrom = ($currentPage - 1) * $productsPerPage;
                        
                        $sortOrder = "ASC";

                        if (isset($_POST['ins'])) {
                            $sortOrder = "ASC";
                        } elseif (isset($_POST['des'])) {
                            $sortOrder = "DESC";
                        }
                        
                        $selectProductQuery = "SELECT * FROM `product` ORDER BY `price` $sortOrder LIMIT $startFrom, $productsPerPage";
                        $selectProductResult = mysqli_query($conn, $selectProductQuery) or die ("Query Failed");
                        if(mysqli_num_rows($selectProductResult)>0) {
                            while($fetch_product = mysqli_fetch_assoc($selectProductResult)) { 
                    ?>
                    <div class="col hp">
                        <form action="" method="post">
                            <div class="card h-100 shadow-sm">
                                <a href="#" class="center-aligh">
                                <img src="image/<?php echo $fetch_product['image']; ?>" class="card-img-top" alt="product.title" />
                                </a>
                                <div class="card-body">
                                <div class="clearfix mb-3">
                                    <span class="float-start badge rounded-pill bg-success"><?php echo $fetch_product['price'];?> $</span>
                                    <span class="float-end"><a href="view_page.php?pid=<?php echo $fetch_product['id'] ?>" class="small text-muted text-uppercase aff-link">reviews</a></span>
                                </div>
                                <h5 class="card-title">
                                    <a target="_blank" href="#"><?php echo $fetch_product['name']; ?></a>
                                </h5>
                        
                                <div class="d-grid gap-2 my-4">
                        
                                    <button type="submit" name="add_to_cart" class="btn btn-warning bold-btn">Add To Cart</button>
                        
                                </div>
                                <div class="clearfix mb-1">
                        
                                    <span class="float-start"><a href="#"><i class="fas fa-question-circle"></i></a></span>
                        
                                    <span class="float-end">
                                    <button class="none" type="submit" name="add_to_wishlist"><i class="far fa-heart" style="cursor: pointer"></i></button>
                                    </span>
                                </div>
                                </div>
                                <input type="hidden" name="quantity" value="<?php echo $fetch_product['quantity'] ?>">
                                <input type="hidden" name="id" value="<?php echo $fetch_product['id'] ?>">
                                <input type="hidden" name="name" value="<?php echo $fetch_product['name'] ?>">
                                <input type="hidden" name="price" value="<?php echo $fetch_product['price'] ?>">
                                <input type="hidden" name="product_quantity" value="1" min="1">
                                <input type="hidden" name="image" value="<?php echo $fetch_product['image'] ?>">

                            </div>
                        </form>
                    </div>
                    <?php 
                        }
                        }
                    ?>
               </div>
            </div>
        </div>
        <ul class="pagination">
            <?php

                $totalProductsQuery = "SELECT COUNT(*) as total FROM `product`";
                $totalProductsResult = mysqli_query($conn, $totalProductsQuery);
                $totalProducts = mysqli_fetch_assoc($totalProductsResult)['total'];
                $totalPages = ceil($totalProducts / $productsPerPage);
                if ($currentPage > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage - 1) . '">&laquo; </a></li>';
                }

                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                }
                if ($currentPage < $totalPages) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage + 1) . '"> &raquo;</a></li>';
                }
            ?>
        </ul>
    </section>
    <?php 
            include 'footer.php';
    ?>
</body>
</html>

