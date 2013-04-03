<?php
    $path = '../models/CheckUser_ID_and_Passwd.php';
    require_once("$path");

    function CheckId($id)
    {
        $result = false;
        if( !is_null($id) && !empty($id) )
        {
            if(preg_match("/^[0-9]{1,10}$/", $id) === 1) $result = true;
            if($id == "r00t") $result = true;
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
