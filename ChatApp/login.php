<?php
    session_start();
    if(isset($_SESSION['unique_id'])){ // If user is already logged in then redirect to users.php
        header("location: users.php");
    }
?>
<?php include_once "header.php"; ?>
<body>
    <div class="wrapper">
        <section class="form login">
            <header>Realtime Chat App</header>
            <form action="#">
                <div class="error-txt"></div>
                <div class="field input">
                    <label>Email or Username</label>
                    <input type="text" name="emailoruser" placeholder="Enter your email or Username">
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="forgot-password">
                    <a href="forgotpwd.php">Forgot password?</a>
                </div>
                <div class="field button">
                    <input type="submit" value="Continue">
                </div>
            </form>
            <div class="link">Not signed up yet? <a href="index.php">Sign-up now</a></div>
        </section>
    </div>

    <script src="./Javascript/Chat-App-pass-show-hide.js"></script>
    <script src="./Javascript/login.js"></script>
</body>
</html>