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

    if (isset($_GET['delete'])) {
        $product_id_to_delete = $_GET['delete'];
    
        $delete_query = mysqli_query($conn, "DELETE FROM `wishlist` WHERE id = '$product_id_to_delete'") or die('Query Failed: ' . mysqli_error($conn));
        if ($delete_query) {
            header('location: wishlist.php?messageg=Product delete success');
        } else {

            header('location: wishlist.php?messageg=Product delete failed');
        }
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
            $current_quantity_result = mysqli_query($conn, "SELECT `quantity` FROM `product` WHERE `name` = '$product_name'");
            
            if ($current_quantity_result) {
                $current_quantity_row = mysqli_fetch_assoc($current_quantity_result);
                $current_quantity = $current_quantity_row['quantity'];
            }
            $cart_result = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id' ") or die('Query Fail');
            if ($current_quantity == 0) {
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
    <div class="container mtt-20">
    <div class="col">
        <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `wishlist`") or die ("Query Failed");
            $wishlist_count = mysqli_num_rows($select_product);
        ?>
        <p>
            <span class="h2">My WishList</span>
            <span class="h4">(<?php echo $wishlist_count; ?> item in your wishlist)</span>
        </p>
        <?php 
            if(mysqli_num_rows($select_product)>0) {
                while($fetch_product = mysqli_fetch_assoc($select_product)) { 
        ?>
        <form action="" method="post">
        <div class="card mb-4">
          <div class="card-body p-4 ">

            <div class="row align-items-center justi-items-center">
              <div class="col-md-2">
                <img src="image/<?php echo $fetch_product['image'] ?>"
                  class="img-fluid" alt="Generic placeholder image">
              </div>
              <div class="col-md-2 d-flex justify-content-center">
                <div>
                  <p class="small text-muted mb-4 pb-2">Name</p>
                  <p class="lead fw-normal mb-0"><?php echo $fetch_product['name'] ?></p>
                </div>
              </div>
              
              <div class="col-md-2 d-flex justify-content-center">
                <div>
                  <p class="small text-muted mb-4 pb-2">Price</p>
                  <p class="lead fw-normal mb-0"><?php echo $fetch_product['price'] ?>$</p>
                </div>
              </div>
              <div class="col-md-2 d-flex justify-content-center">
                <div>
                  <p class="small text-muted mb-4 pb-2">Action</p>
                  <a href="wishlist.php?delete=<?php echo $fetch_product['id']; ?>" class="" onclick = 
                        "return confirm('Delete this product')"><i class="fa-solid fa-trash"></i></a>
                    <button type="submit" name="add_to_cart"  class="outline"><i class="fa-solid fa-cart-shopping"></i></button>
                </div>
              </div>
            </div>
            <input type="hidden" name="id" value="<?php echo $fetch_product['id'] ?>">
            <input type="hidden" name="product_quantity" value="1" min="1">
            <input type="hidden" name="name" value="<?php echo $fetch_product['name'] ?>">
            <input type="hidden" name="price" value="<?php echo $fetch_product['price'] ?>">
            <input type="hidden" name="image" value="<?php echo $fetch_product['image'] ?>">

          </div>
        </div>
        </form>
        
        <?php 
                }
            }
        ?>
        </div>
    </div>
    <form action="" method="post">
        <div class="container mtt-30">
            <div class="d-flex justify-content-end">
                <a href="product.php" class="btn btn-light btn-lg me-2">Continue shopping</a>
                <button type="submit" name="delete_all" onclick = 
                        "return confirm('Delete all product')" class="btn btn-primary btn-lg">Delete All</button>
            </div>
        </div>
    </form>
    <?php 
            include 'footer.php';
    ?>
</body>
</html>