<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once("util/get_lang.php");

$db = new PDO('mysql:host=sql;dbname=User', 'root', $_ENV['PASS'];
$db1 = new PDO('mysql:host=sql;dbname=user_request', 'root', $_ENV['PASS'];
include_once('util/login_check.php');
$email_sess = $_SESSION['EMAIL'];
if(isset($email_sess,$_SESSION['token'])){
    if(is_login($_SESSION['EMAIL'],$_SESSION['token'])){
        $login = true;
    }else{
        echo "<script> location.replace(\"login.php\"); </script>";
    }
}else{
    echo "<script> location.replace(\"login.php\"); </script>";
}
$post_id = $_POST['post'];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($post_id)){
        try{
            $get_name = $db->prepare("SELECT `username`,`starttime` FROM bulletin WHERE id=:id");
            $get_name->bindParam(':id',$post_id);
            $get_name->execute();
            $name = $get_name-> fetch(PDO::FETCH_ASSOC);
            $app = $db->prepare("SELECT username FROM userinfo WHERE usermail=:usermail");
            $app->bindParam(':usermail',$email_sess);
            $app->execute();
            $app_name = $app-> fetch(PDO::FETCH_ASSOC);
            $stmt = $db1->prepare("SELECT username FROM ".$name['username']);
            $stmt->execute();
            $all_name = $stmt-> fetchall(PDO::FETCH_ASSOC);
            $fail = false;
            for($i=0; $i < sizeof($all_name) ;$i++){
                if($all_name[$i]['username'] === $app_name['username']){
                    $fail = true;
                    $re = false;
                    break;
                }
            }
            if(!$fail){
                $sth = $db1->prepare("INSERT INTO `". $name['username'] ."` (`how`,`username`, `usermail`, `starttime`) VALUES (:how,:username,:usermail,:starttime)");
                $sth->bindValue(':how', "req");
                $sth->bindParam(':username', $app_name['username']);
                $sth->bindParam(':usermail', $email_sess);
                $sth->bindParam(':starttime', $name['starttime']);
                $re = $sth->execute();
                #print_r($sth->errorInfo());
            }
        } catch(Exception $e){
            $re = false;
        }
    }
    if($re){
        $mes = $send_request.'
        <div>
            <a href="./bulletin.php" class="uk-button uk-button-primary uk-margin-top">'.$bulletin.'</a>
        </div>
        ';
    }else{
        $mes = $error_send.'
        <div>
            <a href="./bulletin.php" class="uk-button uk-button-primary uk-margin-top">'.$bulletin.'</a>
        </div>
        ';
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Speakout</title>
        <meta name="viewport" content="width=device-width" >
        <script src="js/uikit.min.js"></script>
        <script src="js/uikit-icons.min.js"></script>
        <link rel="stylesheet" href="css/uikit.min.css">
        <script src="uikit/dist/js/uikit-icons.min.js"></script>
    </head>
    <body>
        <?php 
        include_once("util/get_lang.php");
        include_once("util/navi.php"); ?>
        <!--start-->
        <div class="uk-container uk-margin-top">
            <div class="uk-text-center">
                <div><?php echo $mes ?></div>           
            </div>
        </div>
    </body>
</html>
