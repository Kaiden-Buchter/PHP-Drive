<?php
    session_start();
    include_once "config.php";
    $username = mysqli_real_escape_string($conn, $_POST['user']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $md5password = md5($password);

    if(!empty($username) && !empty($email) && !empty($password)){
        // Let's check user email is valid or not
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){ // If email is valid
            // Let's check that email already exists in the database or not
            $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0){ // If email already exists
                echo "$email - This email already exists!";
                }else{
                    // Let's check if confirm password and password are matched or not
                    if($password !== $confirm_password){ // If password not matched
                        echo "Passwords do not match!";
                    }else{
                        $sql = mysqli_query($conn, "SELECT username FROM users WHERE username = '{$username}'");
                        if(mysqli_num_rows($sql) > 0){ // If username already exists
                            echo "$username - This username already exists!";
                        }elseif(strlen($username) > 15){
                            echo "Username is too long!";
                        }elseif(strlen($username) < 6){
                            echo "Username is too short!";
                        }elseif(!ctype_alnum($username)) {
                            echo "Username must contain only letters and numbers!";
                        }else{
                            if(strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password)){
                                echo "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit!";
                            }else {
                                // Let's check user upload file or not
                                if(isset($_FILES['image'])) { //if file is uploaded
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
                                        $new_img_name = $time.$img_name;
                                        
                                        if(move_uploaded_file($tmp_name, "images/".$new_img_name)){ // If user upload img move to our folder successfully
                                            $status = "Active now"; // Once user signed up then his status will be active now
                                            $random_id = rand(time(), 10000000); // Creating random id for user

                                            // Let's insert all user data inside table
                                            $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, username, email, password, img, status, role)
                                                                VALUES ({$random_id}, '{$username}', '{$email}', '{$md5password}', '{$new_img_name}', '{$status}', 'user')");
                                            if($sql2){ // If these data inserted
                                                $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                                if(mysqli_num_rows($sql3) > 0){
                                                    $row = mysqli_fetch_assoc($sql3);
                                                    $_SESSION['unique_id'] = $row['unique_id']; // Using this session we used user unique_id in other php file
                                                    echo "success";
                                                }
                                            }else{
                                                echo "Something went wrong!";
                                            }
                                        }

                                    }else{
                                        echo "Please select an image file - jpeg, jpg, png!";
                                    }
                                }else{
                                    echo "Please select an image file!";
                                }                                
                            }

                    }
                        
                }
            }
        }else{
            echo "$email - This is not a vaild email!";
        }
    }else{
        echo "All input fields are required!";
    }
?>