<?php
function salted($passwd)
{
    $salt = 'nctu5566';
    return $passwd.$salt;
}
?>
