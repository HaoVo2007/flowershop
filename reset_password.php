
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
    <title>Đặt Lại Mật Khẩu</title>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center popular-brands">
        <h2 class="text-center">RESET PASSWORD</h2>
    </div>
    <div class="content-1">
        <div class="row align-items-stretch no-gutters contact-wrap">
            <div class="col-md-8 mx-auto">
                <div class="form h-100">
                    <form action="reset_password_process.php" method="post">
                        <div class="form-group mb-3">
                            <label for="current_password" class="col-form-label">New password</label>
                            <input type="password" class="form-control" name="new_password" id="current_password" placeholder="New password">
                        </div>

                        <div class="form-group mb-3">
                            <label for="current_password" class="col-form-label">Confirm password</label>
                            <input type="password" class="form-control" name="confirm_password" id="current_password" placeholder="Confirm password">
                        </div>
                        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                        <div class="form-group">
                            <input name="submit" type="submit" value="Reset password" class="btn btn-primary rounded-0 py-2 px-4">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
