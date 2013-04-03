<?php
    session_start();
    $path = '../controllers/SessionCheckAfterLogin.php';
    require_once("$path");
    if(array_key_exists('id', $_SESSION))
    {
        echo 'correct ip & user validation';
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
<?php echo $_SESSION['id'];?>
                    <input type="submit" value="登出" /><p>                             
            </form>
        </div>
    </body>                                                                        
</html>
<?php 
    } 
?>
