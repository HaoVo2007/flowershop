<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    require_once('connection.php');

    if(isset($_POST['submit'])) {
        $email = $_POST['email'];
    
        // Kiểm tra xem email có tồn tại trong cơ sở dữ liệu hay không
        $result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
        $row = mysqli_fetch_assoc($result);
    
        if ($row) {
            // Tạo mã đặt lại mật khẩu ngẫu nhiên
            $reset_token = bin2hex(random_bytes(32));
    
            // Cập nhật mã đặt lại mật khẩu vào cơ sở dữ liệu
            mysqli_query($conn, "UPDATE user SET reset_token = '$reset_token' WHERE email = '$email'");
    
            // Gửi email chứa liên kết đặt lại mật khẩu
            $mail = new PHPMailer(true);
            
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'hao01638081724@gmail.com'; // Thay thế bằng địa chỉ email của bạn
                $mail->Password = 'kuwkfyulydyntkeq'; // Thay thế bằng mật khẩu email của bạn
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
    
                $mail->setFrom('hao01638081724@gmail.com', 'Your Name'); // Thay thế bằng thông tin của bạn
                $mail->addAddress($email);
    
                $mail->isHTML(true);
                $mail->Subject = 'Đặt Lại Mật Khẩu';
                $mail->Body    = 'Bạn nhận được email này vì bạn hoặc ai đó đã yêu cầu đặt lại mật khẩu tại trang web của chúng tôi.
                                   <br>Vui lòng nhấp vào liên kết sau đây để đặt lại mật khẩu của bạn:
                                   <a href="http://localhost/FlowerShop_Project/reset_password.php?token=' . $reset_token . '">Đặt Lại Mật Khẩu</a>';
                
                $mail->send();
                echo "
                    <div class='message success l2'>
                        <span>The email was sent successfully.</span>
                    </div>
                ";
            } catch (Exception $e) {
                echo "
                    <div class='message success l2'>
                        <span>Error when sending an email.</span>
                    </div>
                ";
            }
        } else {
                echo "
                    <div class='message success l2'>
                        <span>No email address found in database.</span>
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