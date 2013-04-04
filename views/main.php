<?php
    session_start();
    $path = '../controllers/SessionCheckAfterLogin.php';
    require_once("$path");
    if(array_key_exists('id', $_SESSION))
    {
        echo 'user: ';
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
<?php echo var_export($_SESSION['id']); echo "has logined!!!! (yay)";?>
                    <input type="submit" value="登出" /><p>                             
            </form>
        </div>
    </body>                                                                        
</html>
<?php 
    } 
?>
