<?php
session_start();
include_once('util/login_check.php');
$login = false;
$error_text = "";
if(isset($_SESSION['EMAIL'],$_SESSION['token'])){
    if(is_login($_SESSION['EMAIL'],$_SESSION['token'])){
        $login = true;
        $db = new PDO('mysql:host=sql;dbname=User', 'root', $_ENV['PASS']);
        $sth = $db->prepare('SELECT (username) FROM userinfo WHERE usermail = :usermail');
        $sth->bindParam(':usermail',$_SESSION['EMAIL']);
        $sth->execute();
        $re = $sth->fetch(PDO::FETCH_ASSOC);
    }else{
        $error_text = get_part("You are logged out due to an unknown error. Please log in again","不明なエラーによりログアウトされました。再ログインしてくだいさい");
    }
}else{
    $login = false;
}
?>

<div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; bottom: #transparent-sticky-navbar">
    <nav class="uk-navbar-container" uk-navbar>
        <div class="uk-navbar-left">
            <ul class="uk-subnav  uk-text-center uk-margin-top uk-margin-small-left">
                <li class="uk-padding-remove"><a href="top.php"><button class="uk-button uk-button-text uk-text-meta"><?php echo $top ?></button></a></li>
                <li><a href="bulletin.php"><button class="uk-button uk-button-text uk-text-meta"><?php echo $bulletin ?></button></a></li>
            </ul>
        </div>
        <div class="uk-navbar-right">
            <ul class="uk-subnav uk-text-center uk-margin-top uk-margin-small-right">
                <li><?php
                if($login){
                    if($_SERVER['PHP_SELF'] == '/confirm.php' || $_SERVER['PHP_SELF'] == '/confirm'){
                        $form = "";
                    }else{
                        $form = "
                        <form action='".$_SERVER['PHP_SELF'] ."' method='post'>
                        <input type='hidden' name='lan' value='".$language."'>
                        <button class=\"uk-button uk-button-text uk-text-meta\">". $c_language ."</button></li>
                        </form><li>
                        ";
                    }
                    echo $form . "<a href=\"util/logout.php\"><button class=\"uk-button uk-button-text uk-text-meta\">". $logout ."</button></a></li><li><a href='users/".$re["username"]."/index.php'><button class=\"uk-button uk-button-text uk-text-meta\">".$mypage."</button></a></li>";
                }else{
                    echo "
                    <form action='".$_SERVER['PHP_SELF']."' method='post'>
                        <input type='hidden' name='lan' value='".$language."'>
                        <button class=\"uk-button uk-button-text uk-text-meta\">". $c_language ."</button></li>
                    </form>
                    <li><a href=\"login.php\"><button class=\"uk-button uk-button-text uk-text-meta\">".$login_s."</button></a></li>";
                }
                ?>
            </ul>
        </div>
    </nav>
</div>

<div class="uk-container">
    <div class="uk-card uk-card-body uk-card-primary">
        <h3><a href="top.php"><img src="/image/speakout.png" height="70" width="220" class="uk-link-heading"></a></h3>
    </div>
</div>
