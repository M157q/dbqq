<?php
    session_start();
    // check illegal users, and force to logout
    if ($_SESSION['perm'] != 'adm') {
        //header('Location: '."../controllers/Logout.php");
    }
?>
<html>
<body>
<?php echo "course admin"; ?>
<body>
</html>
