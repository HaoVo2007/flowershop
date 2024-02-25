<?php 
    include 'connection.php';
    session_start();
    $admin_id = $_SESSION['admin_name'];

    if (!isset($admin_id)) {
        header('location:login.php');
    }

    if (isset($_POST["add_product"])) {
        $productName = isset($_POST["productName"]) ? trim($_POST["productName"]) : '';
        $productPrice = isset($_POST["productPrice"]) ? trim($_POST["productPrice"]) : '';
        $productDetail = isset($_POST["product_detail"]) ? trim($_POST["product_detail"]) : '';
        $productCategory = isset($_POST["productCategory"]) ? trim($_POST["productCategory"]) : '';
        $quantity = isset($_POST["quantity"]) ? trim($_POST["quantity"]) : '';
        if (empty($productName) || empty($productPrice) || empty($productDetail) || empty($productCategory) || empty($quantity)) {
            $message[] = 'All fields must be filled';
        } else {
            if (!is_numeric($productPrice)) {
                $message[] = 'Invalid price. Please enter a valid number.';
            } else {
                if (isset($_FILES['image'])) {
                    $image = $_FILES['image']['name'];
                    $image_size = $_FILES['image']['size'];
                    $image_tmp_name = $_FILES['image']['tmp_name'];
                    $image_folder = 'image/' . $image;

                    $select_product_name = mysqli_query($conn, "SELECT name FROM `product` WHERE name = '$productName'") or die('Query Failed: ' . mysqli_error($conn));
            
                    if (mysqli_num_rows($select_product_name) > 0) {
                        $message[] = 'Product name already exists';
                    } else {

                        $insert_product = mysqli_query ($conn, "INSERT INTO `product` (`name`, `price`, `product_detail`, `option`, `quantity`, `image`) 
                        VALUES ('$productName', '$productPrice', '$productDetail', '$productCategory', '$quantity', '$image')") or die ('Query Failed: ' . mysqli_error($conn));
                        
                        if ($insert_product) {
                            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                                $message[] = 'Product added successfully';
                            } else {
                                $message[] = 'Failed to move the uploaded file';
                            }
                        } else {
                            $message[] = 'Failed to add product';
                        }
                    }
                } else {
                    $message[] = 'No image uploaded';
                }
            }
        }
    }

    if (isset($_GET['delete'])) {
        $product_id_to_delete = $_GET['delete'];
    
        $delete_query = mysqli_query($conn, "DELETE FROM `product` WHERE id = '$product_id_to_delete'") or die('Query Failed: ' . mysqli_error($conn));
        mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$product_id_to_delete'") or die('Query Failed: ' . mysqli_error($conn));
        mysqli_query($conn, "DELETE FROM `wishlist` WHERE id = '$product_id_to_delete'") or die('Query Failed: ' . mysqli_error($conn));
        if ($delete_query) {
            header('location: admin_product.php?messageg=Product delete success');
        } else {

            header('location: admin_product.php?messageg=Product delete failed');
        }
    }

    if(isset($_POST['update_product'])) {
        
        $update_id = $_POST['update_id'];
        $update_name = $_POST['update_name'];
        $update_price = $_POST['update_price'];
        $update_detail = $_POST['update_detail'];
        $update_option = $_POST['update_option'];
        $update_quantity = $_POST['update_quantity'];
        $update_image_folder = $_FILES['update_image']['name'];

        $check_query = mysqli_query($conn, "SELECT * FROM `product` WHERE `id` = '$update_id'");
        if (mysqli_num_rows($check_query) > 0) {
            $update_query = mysqli_query($conn, "UPDATE `product` SET `name` = '$update_name', `price` = '$update_price',
                `product_detail` = '$update_detail', `option` = '$update_option', `quantity` = '$update_quantity', `image` = '$update_image_folder' WHERE `id` = '$update_id'") or die(mysqli_error($conn));
            
            if ($update_query) {
                header('location: admin_product.php?messageg=Product update successfully');
            } else {
                header('location:  admin_product.php?messageg=Product update Failed');
            }
        } else {
            $insert_query = mysqli_query($conn, "INSERT INTO `product` (`id`, `name`, `price`, `product_detail`, `option`, `quantity`, `image`)
                VALUES ('$update_id', '$update_name', '$update_price', '$update_detail', '$update_option', '$update_quantity', '$update_image_folder')") or die(mysqli_error($conn));
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
    <title>Dashboards_Page</title>
</head>
<body>
    <?php 
        include 'admin_header.php';
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
    <div class="banner">
        <h1>My Product</h1>
    </div>
    <div class="container">
        <form action=" " method="post" class="form-1"  enctype="multipart/form-data">
            <label for="productName">Product Name :</label>
            <input type="text" id="name" name="productName" required>

            <label for="productPrice">Product Price :</label>
            <input type="number" min="0" id="price" name="productPrice" required>

            <label for="productDetails">Product Detail :</label>
            <textarea id="productDetails" name="product_detail" rows="4" required></textarea>

            <label for="productCategory">Option :</label>
            <select id="productCategory" name="productCategory" required>
                <option value="Flower">Flower</option>
                <option value="Vegetable">Vegetable</option>
            </select>

            <label for="productQuantity">Quantity :</label>
            <input type="number" id="productQuantity" name="quantity" required>

            <label for="productImage">Product Image :</label>
            <input type="file" name="image" accept = 'image/jpg, image/jpeg, image/png, image/wepb,' required>

            <button type="submit" name="add_product" class="btn btn-primary mt-3" >Add Product</button>
        </form>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">NAME</th>
                    <th scope="col">PRICE</th>
                    <th scope="col">QUANTITY</th>
                    <th scope="col">PRODUCT_TYPE</th>
                    <th scope="col">ACTION</th>
                </tr>
                <?php 
                    $select_product = mysqli_query($conn,"SELECT *FROM `product`") or die ('Query Failed');
                    if (mysqli_num_rows($select_product)>0) {
                        while($fetch_propduct = mysqli_fetch_assoc($select_product)) {
                ?>
            <tbody>
                <tr>
                    <td><?php echo $fetch_propduct['name']; ?></td>
                    <td><?php echo $fetch_propduct['price']; ?></td>
                    <td><?php echo $fetch_propduct['quantity']; ?></td>
                    <td><?php echo $fetch_propduct['option']; ?></td>
                    <td>
                        <a href="admin_product.php?edit=<?php echo $fetch_propduct['id']; ?>" class="btn btn-secondary">Update</a>
                        <a href="admin_product.php?delete=<?php echo $fetch_propduct['id']; ?>" class="btn btn-primary" onclick = 
                        "return confirm('Delete this product')">Delete</a>
                    </td>
                </tr>
                <tr>
            </tbody>
            
                <?php 

                        }
                    }

                ?>
            </thead>
        </table>
        
        <section class="update-product">
            <?php 
                if(isset($_GET['edit'])) {
                    $edit_id = $_GET['edit'];
                    $edit_query = mysqli_query($conn, "SELECT * FROM `product` WHERE id = '$edit_id'") or die ('Query Failed');

                    if(mysqli_num_rows($edit_query) > 0) {
                        while($fetch_edit = mysqli_fetch_assoc($edit_query)) {
                ?>
                        <form action="" method="post" class="form-1 form-2" enctype="multipart/form-data">
                            <img src="image/<?php echo $fetch_edit['image']; ?>" alt="">
                            <label for="productName">Product Name :</label>
                            <input type="hidden" name="update_id" value="<?php echo $fetch_edit['id']; ?>">
                            <input type="text" name="update_name" value="<?php echo $fetch_edit['name'];?>" id="">
                            <label for="productPrice">Product Price :</label>
                            <input type="number" min="0" id="price" name="update_price" value="<?php echo $fetch_edit['price'];?>" required>
                            <label for="productDetails">Product Detail :</label>
                            <textarea id="productDetails" name="update_detail" rows="4" column ="30" required><?php echo $fetch_edit['product_detail']; ?></textarea>
                            <label for="productCategory">Option :</label>
                            <select id="productCategory"  name="update_option" required>
                                <option value="<?php echo $fetch_edit['option'];?>">Flower</option>
                                <option value="<?php echo $fetch_edit['option'];?>">Vegetable</option>
                            </select>
                            <label for="productQuantity">Quantity :</label>
                            <input type="number" id="productQuantity" name="update_quantity" value="<?php echo $fetch_edit['quantity'];?>" required>
                            <label for="productImage">Product Image :</label>
                            <input type="file" name="update_image" accept = 'image/jpg, image/jpeg, image/png, image/wepb,' required>
                            <input type="submit" value="Update" name="update_product" class="update btn btn-secondary">
                            <input type="reset" value="Cancel" id="close-form" class="reset btn btn-primary">
                        </form>
                <?php 
                        }
                    }

                    echo "<script>document.querySelector('.update-product').style.display='block'</script>";
                }
            ?>
        </section>
        
    </div>   
</body>
</html>