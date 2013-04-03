<?php
    $path = '../models/CheckUserList_Id_and_Passwd.php';
    require_once("$path");

    function CheckIp()
    {
        $result = false;                                                           
        if ($_SERVER['REMOTE_ADDR'] === '140.113.200.173')
        {                       
           $result = true;                                                         
        }                                                                          
        return $result;                                                            
    }   

    function CheckId($id)
    {
        $result = false;
        if( !is_null($id) && !empty($id) )
        {
            if(preg_match("/^[0-9]{7}$/", $id) === 1) $result = true;
        }
        return $result;
    }

    function CheckPasswd($passwd)
    {
        $result = false;
        if( !is_null($passwd) && !empty($passwd) )
        {
            $result = true;
        }
        return $result;
    }
?>
