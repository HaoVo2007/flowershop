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

    if (isset($_POST['send'])) {
    if ($user_id == '') {
        $message[] = 'Please log in to do this';
    } else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $number = $_POST['number'];
        $address = $_POST['address'];
        $user_message = $_POST['message']; // Sử dụng tên biến khác

        $insert_message = mysqli_query($conn, "INSERT INTO `message` (`user_id`,`name`,`address`,`email`,`number`,`message`) VALUES ('$user_id','$name','$address','$email','$number','$user_message')") or die('Query Failed');
        if ($insert_message) {
            $message[] = 'Message send successfully';
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
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
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
    <div class="container d-flex align-items-center justify-content-center popular-brands">
        <h2 class="text-center">FEEDBACK FOR YOUR</h2>
    </div>
    <div class="container-fluid">
    <div class="content-1">
        <div class="row align-items-stretch no-gutters contact-wrap">
            <div class="col-md-12">
            <div class="form h-100">
                <form class="mb-5" method="post">
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                    <label for="" class="col-form-label">Name *</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Your name">
                    </div>
                    <div class="col-md-6 form-group mb-3">
                    <label for="" class="col-form-label">Email *</label>
                    <input type="text" class="form-control" name="email" id="email"  placeholder="Your email">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                    <label for="" class="col-form-label">Phone *</label>
                    <input type="text" class="form-control" name="number" id="name" placeholder="Your name">
                    </div>
                    <div class="col-md-6 form-group mb-3">
                    <label for="" class="col-form-label">Address *</label>
                    <input type="text" class="form-control" name="address" id="email"  placeholder="Your email">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group mb-3">
                    <label for="message" class="col-form-label">Message *</label>
                    <textarea class="form-control" name="message" id="message" cols="30" rows="4"  placeholder="Write your message"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                    <input name="send" type="submit" value="Send Message" class="btn btn-primary rounded-0 py-2 px-4">
                    </div>
                </div>
                </form>
            </div>
            </div>
        </div>

    </div>
    <?php 
            include 'footer.php';
    ?>
    </div>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>