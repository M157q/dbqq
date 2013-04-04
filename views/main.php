<?php
    session_start();
    $path = '../controllers/Session.php';
    require_once("$path");
    if(array_key_exists('id', $_SESSION))
    {
        echo 'user: ' . $_SESSION['id'] . ' has logined!!! <br />' ;
        var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="zh">                                                                   
    <head>                                                                         
        <meta charset="utf-8">                                                     
        <title>Main</title>                                                       
    </head>                                                                        
    <body>                                                                         
        <div>
            <form name="logout" method="post" action="../controllers/Logout.php" >
                <p>
                    <input type="submit" value="登出" /><p>
            </form>
        </div>
    </body>                                                                        
</html>
<?php 
    } 
?>
