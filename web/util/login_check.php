<?php
function is_login($usermail,$token){
    $salt = "okshjq9ajhiau47yai";
    if(hash('ripemd128',$usermail.$salt.$_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'] === $token)){
        return TRUE;
    }
    else{
        return false;
    }
}
?>