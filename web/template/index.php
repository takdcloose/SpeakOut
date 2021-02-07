<?php
session_start();
$finduser = basename(__DIR__);
include_once("../../util/get_lang.php");
include("../../util/get_part_lang.php");
$db = new PDO('mysql:host=sql;dbname=User', 'root', $_ENV['PASS']);
include_once('../../util/login_check.php');
$serv_id = array(0=>"skype_id",1=>"line_id",2=>"viber_id",3=>"kakao_id",4=>"messenger_id",5=>"discord_id");
$input_id = array(0=>"skype_input",1=>"line_input",2=>"viber_input",3=>"kakao_input",4=>"messenger_input",5=>"discord_input");
$list = array(0=>"Skype",1=>"Line",2=>"Viber",3=>"KaKaoTalk",4=>"Messenger",5=>"Discord");
$r_list = array("Skype"=>0,"Line"=>1,"Viber"=>2,"KaKaoTalk"=>3,"Messenger"=>4,"Discord"=>5);
$login = false;
$num = 6;
$error_text = "";
$email_sess = $_SESSION['EMAIL'];
if(isset($email_sess,$_SESSION['token'])){
    if(is_login($_SESSION['EMAIL'],$_SESSION['token'])){
        $login = true;
    }else{
        $error_text = get_part("You are logged out due to an unknown error. Please log in again","不明なエラーによりログアウトされました。再ログインしてくだいさい");
    }
}else{
    $login = false;
}
include_once("../../util/signup_check.php");
include_once("../../util/upload_img.php");
if (isset ($_FILES ['upfile'])){
    $msg = upload_image($finduser);
}
include_once("../../util/update_check.php");
include_once("../../util/ans_request.php");
if($login){
    $sth = $db->prepare('SELECT (username) FROM userinfo WHERE usermail = :usermail');
    $sth->bindParam(':usermail',$_SESSION['EMAIL']);
    $sth->execute();
    $re = $sth->fetch(PDO::FETCH_ASSOC);
    if($re["username"] == $finduser){
        include_once("./../".$finduser."/mypage.php");
    }else{
        //to profile
        include_once("./profile.php");
    }
}else{
    //to profile
    include_once("./profile.php");
}

?>