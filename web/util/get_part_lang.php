<?php
function get_part($en,$ja){
    $lan = $_SESSION['lan'];
    if(is_null($lan)){$_SESSION['lan'] = "en";}
    $lan = $_SESSION['lan'];
    if($lan == "ja"){
        return $ja;
    }elseif($_SESSION['lan'] = "en"){
        return $en;
    }
}
?>