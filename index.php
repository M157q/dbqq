<?php
    session_start();
    var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="zh">
<title>Welcome to dbqq!</title>
<head>                                                                         
    <meta charset="utf-8">                                                     
    <title>Login</title>                                                       
<style>
    body {
        width: 35em;
        margin: 0 auto;
        font-family: Tahoma, Verdana, Arial, sans-serif;
    }
</style>
</head>
<body>
<h1>歡迎使用選課系統</h1>
<p>If you see this page, the our server is successfully installed and working. ^q^</p>

<p>Your IP:<p>
<?php
    echo $_SERVER['REMOTE_ADDR'];
?>

<!-- login -->

<form method="post" action="controllers/LoginController.php">
    <p>
        <label>User account:</label>
        <input type="text" id="account" name="account" placeholder="r00t" required>
    </p>
  <br/>
  <p>
  <label>Pa55wd:</label>
  <input type="password" id="passwd" name="passwd" required>
  </p>
  <p><button type="submit">Sign in now!</button></p>
</form>

<?php 
    if(isset($_SESSION['errmsg']) && !empty($_SESSION['errmsg'])){
            $errormsg = $_SESSION['errmsg'];
            unset($_SESSION['errmsg']);
            echo "$errormsg".'<br/>';
    }
?>
        <a href="">Register</a><br/>
        <a href="">Forgot Password</a><br/>
</body>
</html>
