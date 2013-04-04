<?php
    session_start();
    var_dump($_SESSION);
    require_once("../models/DepartListGen.php");
?>
<!DOCTYPE html>
<html lang="zh">
<title>User Registration</title>
<head>                                                                         
    <meta charset="utf-8">                                                     
<style>
    body {
        width: 35em;
        margin: 0 auto;
        font-family: Tahoma, Verdana, Arial, sans-serif;
    }
</style>
</head>
<body>
<h1>新的開始</h1>
<p>please fill the from below ;-)</p>

<!-- login -->

<form method="post" action="../controllers/RegistController.php">
    <p>
        <label>帳號(學號):</label>
        <input type="text" id="account" name="account" placeholder="0016056" required>
    </p> <br/>
    <p>
        <label>ㄇㄇ:</label>
        <input type="password" id="passwd" name="passwd" required>
    </p> <br/>
    <p>
        <label>姓名:</label>
        <input type="text" id="name" name="name" placeholder="芃蚊子" required>
    </p> <br/>
    <select name="department"><option selected="selected">請選擇職業XD</option>
<?php DepartListGen(); ?></select>
    <p><button type="submit">Create my account!</button></p>
</form>
        <a href="../index.php">Home</a><br/>
        <a href="">Forgot Password</a><br/>
</body>
</html>
