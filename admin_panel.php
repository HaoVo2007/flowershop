<?php 
    include 'connection.php';
    session_start();
    $admin_id = $_SESSION['admin_name'];

    if (!isset($admin_id)) {
        header ('location:login.php');
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
    <div class="banner">
        <h1>My Dashboard</h1>
    </div>
    <div class="container">
        <div class="box bg-primary">
            <?php 
                $total_pending = 0;
                $select_pending = mysqli_query($conn, "SELECT *FROM `order` WHERE payment_status = 'Pending'") or die ('Querry Failed');
                while ($fetch_pending = mysqli_fetch_assoc($select_pending)) {
                    $total_pending = $total_pending + $fetch_pending['total_price'];
                }
            ?>
            <h3>$ <?php echo $total_pending; ?>/-</h3>
            <p>Total Pending</p>
        </div>

        <div class="box bg-primary">
            <?php 
                $total_complete = 0;
                $select_complete = mysqli_query($conn, "SELECT *FROM `order` WHERE payment_status = 'Complete'") or die ('Querry Failed');
                while ($fetch_complete = mysqli_fetch_assoc($select_complete)) {
                    $total_complete = $total_complete + $fetch_complete['total_price'];
                }
            ?>
            <h3>$ <?php echo $total_complete; ?>/-</h3>
            <p>Total Complete</p>
        </div>

        <div class="box bg-primary">
            <?php 
                $select_order = mysqli_query($conn, "SELECT *FROM `order`") or die ('Querry Failed');
                $num_of_order = mysqli_num_rows($select_order);
            ?>
            <h3>$ <?php echo $num_of_order; ?>/-</h3>
            <p>Order Placed</p>
        </div>

        <div class="box bg-primary">
            <?php 
                $select_product = mysqli_query($conn, "SELECT *FROM `product`") or die ('Querry Failed');
                $num_of_product = mysqli_num_rows($select_product);
            ?>
            <h3>$ <?php echo $num_of_product; ?>/-</h3>
            <p>Product Added</p>
        </div>

        <div class="box bg-primary">
            <?php 
                $select_user = mysqli_query($conn, "SELECT *FROM `user` WHERE user_type = 'user'") or die ('Querry Failed');
                $num_of_user = mysqli_num_rows($select_user);
            ?>
            <h3>$ <?php echo $num_of_user; ?>/-</h3>
            <p>Total Normal User</p>
        </div>

        <div class="box bg-primary">
            <?php 
                $select_admin = mysqli_query($conn, "SELECT *FROM `user` WHERE user_type = 'admin'") or die ('Querry Failed');
                $num_of_admin = mysqli_num_rows($select_admin);
            ?>
            <h3>$ <?php echo $num_of_admin; ?>/-</h3>
            <p>Total Normal Admin</p>
        </div>

        <div class="box bg-primary">
            <?php 
                $select_users = mysqli_query($conn, "SELECT *FROM `user`") or die ('Querry Failed');
                $num_of_users = mysqli_num_rows($select_users);
            ?>
            <h3>$ <?php echo $num_of_users; ?>/-</h3>
            <p>Total Register User</p>
        </div>

        <div class="box bg-primary">
            <?php 
                $select_message = mysqli_query($conn, "SELECT *FROM `message`") or die ('Querry Failed');
                $num_of_message = mysqli_num_rows($select_message);
            ?>
            <h3>$ <?php echo $num_of_message; ?>/-</h3>
            <p>New Message</p>
        </div> 
    </div>
</body>
</html>