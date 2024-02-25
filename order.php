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
    <div class="container d-flex align-items-center justify-content-center popular-brands">
        <h2 class="text-center">MY ORDER</h2>
    </div>
    <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">NAME</th>
                    <th scope="col">NUMBER</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">METHOD</th>
                    <th scope="col">ADDRESS</th>
                    <th scope="col">TOTAL_PRODUCT</th>
                    <th scope="col">TOTAL_PRICE</th>
                    <th scope="col">PAYMENT</th>
                </tr>
                <?php 
                    $select_message = mysqli_query($conn,"SELECT *FROM `order` WHERE user_id = '$user_id'") or die ('Query Failed');
                    if (mysqli_num_rows($select_message)>0) {
                        while($fetch_message = mysqli_fetch_assoc($select_message)) {
                ?>
            <tbody>
                <tr>
                    <td><?php echo $fetch_message['name']; ?></td>
                    <td><?php echo $fetch_message['number']; ?></td>
                    <td><?php echo $fetch_message['email']; ?></td>
                    <td><?php echo $fetch_message['method']; ?></td>
                    <td><?php echo $fetch_message['address']; ?></td>
                    <td><?php echo $fetch_message['total_products']; ?></td>
                    <td><?php echo $fetch_message['total_price']; ?></td>
                    <td><?php echo $fetch_message['payment_status']; ?></td>
                   
                    
                </tr>
                <tr>
            </tbody>
            
                <?php 

                        }
                    }

                ?>
            </thead>
        </table>
    </div>
    <?php 
            include 'footer.php';
    ?>
</body>
</html>