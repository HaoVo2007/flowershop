<!DOCTYPE html>
<?php
    include 'connection.php'
?>
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
    <section class="popular-brands">
        <h2>POPULAR BRAND</h2>
        <div class="popular-brands-content">
            <div class="container-fluid bg-trasparent my-4 p-3" style="position: relative">
                <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">
                    <?php 
                        $select_product = mysqli_query($conn, "SELECT *FROM `product` LIMIT 4") or die ("Querry Failled");
                        if(mysqli_num_rows($select_product)>0) {
                            while($fetch_product = mysqli_fetch_assoc($select_product)) { 
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
                        <input type="hidden" name="id" value="<?php echo $fetch_product['id'] ?>">
                        <input type="hidden" name="name" value="<?php echo $fetch_product['name'] ?>">
                        <input type="hidden" name="price" value="<?php echo $fetch_product['price'] ?>">
                        <input type="hidden" name="product_quantity" value="1" min="1">
                        <input type="hidden" name="image" value="<?php echo $fetch_product['image'] ?>">
                        <input type="hidden" name="quantity" value="<?php echo $fetch_product['quantity'] ?>">

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
    </section>

</body>
</html>