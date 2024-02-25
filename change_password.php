
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Change Password</title>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center popular-brands">
        <h2 class="text-center">CHANGE PASSWORD</h2>
    </div>

    <div class="content-1">
        <div class="row align-items-stretch no-gutters contact-wrap">
            <div class="col-md-8 mx-auto">
                <div class="form h-100">
                    <form action="change_password_process.php" method="post">
                        <div class="form-group mb-3">
                            <label for="current_password" class="col-form-label">Current password</label>
                            <input type="text" class="form-control" name="current_password" id="current_password" placeholder="Current password">
                        </div>

                        <div class="form-group mb-3">
                            <label for="new_password" class="col-form-label">New Password</label>
                            <input type="text" class="form-control" name="new_password" id="new_password" placeholder="New Password">
                        </div>

                        <div class="form-group mb-3">
                            <label for="confirm_password" class="col-form-label">Confirm New Password</label>
                            <input type="text" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm New Password">
                        </div>
                        
                        <div class="form-group">
                            <input name="change_password" type="submit" value="Change Password" class="btn btn-primary rounded-0 py-2 px-4">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>