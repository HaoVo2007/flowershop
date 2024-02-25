<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    require_once('connection.php');
    if(isset($_POST['submit'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        $token = $_POST['token'];
    
        // Kiểm tra xác nhận mật khẩu và cập nhật trong cơ sở dữ liệu
        if ($new_password === $confirm_password) {
            // Kiểm tra token
            $result = mysqli_query($conn, "SELECT * FROM user WHERE reset_token = '$token'");
            $row = mysqli_fetch_assoc($result);
    
            if ($row) {
                // Cập nhật mật khẩu mới và xóa token trong cơ sở dữ liệu
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                mysqli_query($conn, "UPDATE user SET password = '$hashed_new_password', reset_token = NULL WHERE reset_token = '$token'");
    
                // Hiển thị thông báo cho người dùng
                echo "
                    <div class='message success l2'>
                        <span>Password Reset Successfully.</span>
                    </div>
                ";
            } else {
                echo "
                    <div class='message success l2'>
                        <span>Invalid password reset link.</span>
                    </div>
                ";
            }
        } else {
                echo "
                    <div class='message success l2'>
                        <span>Password and password confirmation do not match.</span>
                    </div>
                ";
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
    
</body>
</html>