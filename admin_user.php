<?php 
    include 'connection.php';
    session_start();
    $admin_id = $_SESSION['admin_name'];

    if (!isset($admin_id)) {
        header('location:login.php');
    }

    if (isset($_GET['delete'])) {
        $product_id_to_delete = $_GET['delete'];
    
        $delete_query = mysqli_query($conn, "DELETE FROM `user` WHERE id = '$product_id_to_delete'") or die('Query Failed: ' . mysqli_error($conn));
        if ($delete_query) {
            header('location: admin_user.php?messageg=User delete success');
        } else {
            header('location: admin_user.php?messageg=User delete failed');
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
    <title>Dashboards_Page</title>
</head>
<body>
    <?php 
        include 'admin_header.php';
    ?>
    <?php
        if(isset($errors)) {
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
    <div class="banner">
        <h1>My User</h1>
    </div>
    <div class="container">
        
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">NAME</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">USER_TYPE</th>
                    <th scope="col">ACTION</th>
                </tr>
                <?php 
                    $select_message = mysqli_query($conn,"SELECT *FROM `user`") or die ('Query Failed');
                    if (mysqli_num_rows($select_message)>0) {
                        while($fetch_message = mysqli_fetch_assoc($select_message)) {
                ?>
            <tbody>
                <tr>
                    <td><?php echo $fetch_message['name']; ?></td>
                    <td><?php echo $fetch_message['email']; ?></td>
                    <td><?php echo $fetch_message['user_type']; ?></td>
                    <td>
                        <div class="group">

                        </div>
                        <a href="admin_user.php?delete=<?php echo $fetch_message['id']; ?>" class="btn btn-primary" onclick = 
                        "return confirm('Delete this product')">Delete</a>
                    </td>
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
</body>
</html>