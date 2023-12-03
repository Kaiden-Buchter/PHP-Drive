<?php
    session_start();
    if (!isset($_SESSION['unique_id'])) {
        header("location: login.php");
    }
?>

<?php include_once "header.php"; ?>
<body>
    <div class="wrapper">
        <section class="form users">
            <header>
                <?php
                    include_once "php/config.php";
                    $spl = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
                    if(mysqli_num_rows($spl) > 0){
                        $row = mysqli_fetch_assoc($spl);
                    }
                ?>
                <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <div class="content">
                    <img src="php/images/<?php echo $row['img'] ?>" alt="">
                    <div class="details">
                        <span><?php echo $row['username'] ?> </span>
                        <?php
                            if ($row['role'] === 'admin') {
                                echo "<i> Admin </i>";
                            }elseif ($row['role'] === 'owner') {
                                echo "<i> Owner </i>";
                            }
                        ?>
                    </div>
                </div>
            </header>
            <form action="#">
                <div class="error-txt"></div>
                <div class="settings">
                    <div class="field input">
                        <label>Change Username</label>
                        <input type="text" name="user" placeholder="New username">
                    </div>
                    <div class="field input">
                        <label>Change Password</label>
                        <input type="password" name="password" placeholder="New password">
                    </div>
                    <div class="field image">
                        <label>Change Profile Picture</label>
                        <input type="file" name="image">
                    </div>
                    <div class="field button">
                        <input type="submit" value="Save Changes">
                    </div>
                    <div class="field button">
                        <input type="submit" value="Delete Account">
                    </div>
            </form>
        </section>
    </div>

    <script src="./Javascript/settings.js"></script>
</body>
</html>