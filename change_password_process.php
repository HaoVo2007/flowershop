<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if (empty($user_id)) {
    $user_id = '';
} else {
    $user_id = $_SESSION['user_id'];;
}

require_once('connection.php');

if (!$conn) {
    die("Kết nối không thành công: " . mysqli_connect_error());
}





if (isset($_POST['change_password'])) {
    // Lấy dữ liệu từ form
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];


    if ($new_password != $confirm_password) {
                echo "
                    <div class='message success l2'>
                        <span>New password and confirmation of mismatched password.</span>
                    </div>
                ";
    } else {


        $result = mysqli_query($conn, "SELECT password FROM user WHERE id = '$user_id'");

        if ($result !== false) {
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                $hashed_current_password = $row['password'];

                if (password_verify($current_password, $hashed_current_password)) {

                    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                    mysqli_query($conn, "UPDATE user SET password = '$hashed_new_password' WHERE id = '$user_id'");

                    echo "
                        <div class='message success l2'>
                            <span>Successful password change.</span>
                        </div>
                    ";
                } else {
                    echo "
                        <div class='message success l2'>
                            <span>Incorrect current password.</span>
                        </div>
                    ";
                }
            } else {
                    echo "
                        <div class='message success l2'>
                            <span>User data not found.</span>
                        </div>
                    ";
            }
        } else {

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
    
</body>
</html>