<?php
    session_start();
    include_once "config.php";
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if(!empty($email) && !empty($password)){
        // Let's check users entered email & password matched to database any table row email & password
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}'");
        if(mysqli_num_rows($sql) > 0){ // If users credentials matched
            $row = mysqli_fetch_assoc($sql);
            // $status = "Active now"; // Once user logged in then his status will be active now
            // // Let's update user status to active now
            // $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
            // if($sql2){
            $_SESSION['unique_id'] = $row['unique_id']; // Using this session we used user unique_id in other php file
                echo "success";
            // }
        }else{
            echo "Email or Password is incorrect!";
        }
    }else{
        echo "All input fields are required!";
    }
?>