<?php
session_start();
include_once "config.php";
$user_id = $_SESSION['unique_id'];
$username = mysqli_real_escape_string($conn, $_POST['user']);

// Validate username before updating the database
if (!empty($username)) {
    if(mysqli_num_rows(mysqli_query($conn, "SELECT username FROM users WHERE username = '{$username}'")) > 0){
        echo "$username - This username already exists!";
    } 
    elseif(strlen($username) > 15){
        echo "Username is too long!";
    } 
    elseif(strlen($username) < 6){
        echo "Username is too short!";
    } 
    elseif(!ctype_alnum($username)) {
        echo "Username must contain only letters and numbers!";
    }
    else {
        $query = "UPDATE users SET username = '{$username}' WHERE unique_id = {$user_id}";
        $result = mysqli_query($conn, $query);
    
        if ($result) {
            echo "Username updated successfully!";
        } else {
            echo "Failed to update username: " . mysqli_error($conn);
        }
    }
}

$password = mysqli_real_escape_string($conn, $_POST['password']);
$md5password = md5($password);

if (!empty($password)) {
    // Validate password before updating the database
    if(strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password)){
        echo "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit!";
    } else {
        $query = "UPDATE users SET password = '{$md5password}' WHERE unique_id = {$user_id}";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Password updated successfully!";
        } else {
            echo "Failed to update password: " . mysqli_error($conn);
        }
    }
}


if (!empty($_FILES['image']['name'])) {
    if($_FILES['image']['error'] == 0) { //if file is uploaded
        $img_name = $_FILES['image']['name']; // Getting user uploaded img name
        $img_type = $_FILES['image']['type']; // Getting user uploaded img type
        $tmp_name = $_FILES['image']['tmp_name']; // This temporary name is used to save/move file in our folder
    
        // Let's explode image and get the last extension like jpg png
        $img_explode = explode('.', $img_name);
        $img_ext = end($img_explode); // Here we get the extension of an user uploaded img file
    
        $extensions = ['png', 'jpeg', 'jpg']; // These are some valid img ext and we've store them in array
        if(in_array($img_ext, $extensions) === true){ // If user uploaded img ext is matched with any array extensions
            $time = time(); // This will return us current time
                        // We need this time because when you uploading user img to in our folder we rename user file with current time
                        // So all the img file will have a unique name
            // Let's move the user uploaded img to our particular folder
            $new_img_name = $user_id.$time.$img_name;
                                            
            if(move_uploaded_file($tmp_name, "images/".$new_img_name)){ // If user upload img move to our folder successfully
                $status = "Active now"; // Once user signed up then his status will be active now
                $random_id = rand(time(), 10000000); // Creating random id for user

                // Delete old image file
                $query = "SELECT img FROM users WHERE unique_id = {$user_id}";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $old_img_name = $row['img'];
                    $old_img_path = "images/" . $old_img_name;
                    
                    if (file_exists($old_img_path)) {
                        unlink($old_img_path);
                    }
                }
                
                $query = "UPDATE users SET img = '{$new_img_name}' WHERE unique_id = {$user_id}";
                $result = mysqli_query($conn, $query);
                
                    if($result){
                        echo "Profile picture updated successfully!";
                    }
                }else{
                    echo "Something went wrong!";
                }
            }else{
                echo "Please select an image file - jpeg, jpg, png!";
    
        }
    }
}
 
?>
