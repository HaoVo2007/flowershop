<?php 
    include 'connection.php';

    if (isset($_POST['submit-btn'])) {
        $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $name = mysqli_real_escape_string($conn, $filter_name);
    
        $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $email = mysqli_real_escape_string($conn, $filter_email);
    
        $filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $password = mysqli_real_escape_string($conn, $filter_password);
    
        $filter_cpassword = filter_var($_POST['cpassword'], FILTER_SANITIZE_STRING);
        $cpassword = mysqli_real_escape_string($conn, $filter_cpassword);
    
        if (empty($name) || empty($email) || empty($password) || empty($cpassword)) {
            $errors[] = 'All fields are required';
        }

        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        elseif ($password != $cpassword) {
            $errors[] = 'Passwords do not match';
        }

        $select_user = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email'");
        if (mysqli_num_rows($select_user) > 0) {
            $errors[] = 'User already exists';
        }
    
        if (empty($errors)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); 
    
            mysqli_query($conn, "INSERT INTO `user`(`name`,`email`,`password`) VALUES ('$name','$email','$hashed_password')") or die ('Query Failed');
    
            $message[] = 'Registration successful';
            header('location: register.php?messageg=Register successfully');
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
    <title>Register_Page</title>
</head>
<body>

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
         else if(isset($errors)) {
            foreach ($errors as $error) {
                echo '
                    <div class="message error">
                        <span>'. $error .'</span>
                        <i class="fa-solid fa-xmark" onclick="this.parentElement.remove()"></i>
                    </div>
                ';
            }
        } elseif(isset($message)) {
            foreach ($message as $msg) {
                echo '
                    <div class="message success">
                        <span>'. $msg .'</span>
                        <i class="fa-solid fa-xmark" onclick="this.parentElement.remove()"></i>
                    </div>
                ';
            }
        }
    ?>


    <section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
            <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
                <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                    <form class="mx-1 mx-md-4" method="post">

                        <div class="d-flex flex-row align-items-center mb-4">
                            <div class="form-outline flex-fill mb-0">
                                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                <label class="form-label" for="form3Example1c">Your Name</label>
                                <input type="text" id="form3Example1c" name="name" class="form-control" require />
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <div class="form-outline flex-fill mb-0">
                                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                <label class="form-label" for="form3Example3c">Your Email</label>
                                <input type="email" id="form3Example3c" name="email" class="form-control" require />
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <div class="form-outline flex-fill mb-0">
                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                <label class="form-label" for="form3Example4c">Password</label>
                                <input type="password" id="form3Example4c" name="password" class="form-control" require />
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <div class="form-outline flex-fill mb-0">
                                <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                <label class="form-label" for="form3Example4cd">Repeat your password</label>
                                <input type="password" id="form3Example4cd" name="cpassword" class="form-control" require />
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <div class="form-outline flex-fill mb-0">
                                <span>Already have an account ? <a href="login.php">Login</a></span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                            <input type="submit" name="submit-btn" class="btn btn-primary btn-lg" value="Register" />
                        </div>

                    </form>

                </div>
                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                    <img src="image/login.jpg"
                    class="img-fluid" alt="Sample image">
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
</body>
</html>