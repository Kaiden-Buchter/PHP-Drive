<?php
$receiver = "knbuchtyy879@gmail.com";
$subject = "Reset Password";
$body = "Click on the link to reset your password: http://localhost/chatapp/php/resetpwd.php";
$sender = "From: chatapp.resetpwd@gmail.com";

// php mailer function
if(mail($receiver, $subject, $body, $sender)){
    echo "Email successfully sent to $receiver";
}
else{
    echo "Email sending failed...";
}
?>