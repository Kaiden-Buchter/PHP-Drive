<?php
    session_start();
    if(isset($_SESSION['unique_id'])){ // If user is already logged in then redirect to users.php
        header("location: users.php");
    }
?>
<?php include_once "header.php"; ?>
<body>
<div class="wrapper">
        <section class="resetpwd">
            <header>Reset your password</header>
            <form action="#">
                <div class="error-txt"></div>
                <div class="field input">
                    <label>Email Address</label>
                    <input type="text" name="email" placeholder="Enter your email">
                </div>
                <div class="field button">
                    <input type="submit" value="Continue">
                </div>
                <div class="back">
                   <a href="login.php">Back to login</a>
               </div>
            </form>
        </section>
    </div>
</body>
</html>