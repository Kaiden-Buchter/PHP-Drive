<?php
    session_start();
    if (!isset($_SESSION['unique_id'])) {
        header("location: login.php");
    }
?>

<?php include_once "header.php"; ?>
<body>
    <div class="wrapper">
        <section class="users">
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
                            
                        <p><?php echo $row['status'] ?></p>
                    </div>
                </div>
            </header>
            <div class="search">
                <span class="text">Select a user to start chatting</span>
                <input type="text" placeholder="Enter a name to search...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">
            </div>
            </section>
    </div>

    <script src="./Javascript/admin.js"></script>

    </body>
</html>