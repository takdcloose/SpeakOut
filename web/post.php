<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once("util/get_lang.php");
include_once('util/login_check.php');
$login = false;
$error_text = "";
if(isset($_SESSION['EMAIL'],$_SESSION['token'])){
    if(is_login($_SESSION['EMAIL'],$_SESSION['token'])){
        if(empty($_SESSION['csrf'])){
            $csrf = bin2hex(openssl_random_pseudo_bytes(24));
            $_SESSION['csrf'] = $csrf;
        }else{
            $csrf = $_SESSION['csrf'];
        }
        
        $login = true;
    }else{
        $error_text = "不明なエラーによりログアウトされました。再ログインしてくだいさい";
    }
}else{
    $login = false;
}
if($login === false){
    echo "<script> location.replace(\"login.php\"); </script>";
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['lan'])){
    if(empty($_SESSION['csrf']) || $csrf !== $_SESSION['csrf']){
        die('正規の画面から利用ください');
    }
    include_once("util/post_check.php");
    include_once("util/signup_check.php");
    $db = new PDO('mysql:host=sql;dbname=User', 'root', $_ENV['PASS']);
    $usermail = $_SESSION["EMAIL"];
    $get_name = $db->prepare("SELECT username FROM userinfo WHERE usermail=:usermail");
    $get_name->bindParam(':usermail',$usermail);
    $get_name->execute();
    $name = $get_name-> fetch(PDO::FETCH_ASSOC);
    $starttime = $_POST['time'];
    $theme = $_POST['theme'];
    $video = $_POST['video'];
    $my_lang = $_POST['my_lang'];
    $your_lang = $_POST['your_lang'];
    $other = $_POST['other'];
    $form_errors = check_post($starttime,$theme,$video,$my_lang,$your_lang,$other);
    if(!empty($form_errors)){
        $error_mes = show_form($form_errors);
    } else{
        $fine  = post_thread($name['username'],$starttime,$theme,$video,$my_lang,$your_lang,$other);
        if($fine){
            echo "<script>location.replace(\"bulletin.php\"); </script>";
        }else{
            $error_mes = "不明なエラー もう一度投稿してください。";
        }
    }
}
else{
    $error_mes = "";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Speakout</title>
        <link rel="shortcut icon" href="image/icon.png" type="image/png">
	<meta name="viewport" content="width=device-width" >
        <script src="js/uikit.min.js"></script>
        <script src="js/uikit-icons.min.js"></script>
        <link rel="stylesheet" href="css/uikit.min.css">
        <script src="uikit/dist/js/uikit-icons.min.js"></script>
    </head>
    <body>
        <?php 
        include_once("util/navi.php"); ?>
        <!--start-->
        <div class="uk-container uk-margin-top">
            <p class="uk-text-large uk-text-center"><?php echo $bulletin_board; ?></p><br>
        </div>
        <div class="uk-text-center">
            <p><?php echo $post_notice1; ?></p>
            <p><?php echo $post_notice2; ?></p>
            <p><?php echo $post_notice3; ?><p>
        </div>
        <div class="uk-section uk-padding-remove-top">
            <div class="uk-container-small uk-align-center">
                <div class="uk-text-center uk-text-danger">
                    <?php echo $error_mes; ?>
                </div>
                <form action="post.php" method="POST" novalidate>
                    <div>
                        <span><?php echo $starttime_string; ?></span><span class="uk-text-danger">*</span>
                        <div class="uk-tile uk-tile-muted uk-padding-small">
                            <input class="uk-input" type="datetime-local" name="time">
                        </div>
                    </div>
                    <div>
                        <span><?php echo $theme_on; ?></span>
                        <div class="uk-tile uk-tile-muted uk-padding-small">
                            <input class="uk-input" type="text" name="theme">
                        </div>
                    </div>
                    <div>
                        <span><?php echo $video_call; ?></span><span class="uk-text-danger">*</span>
                        <div class="uk-tile uk-tile-muted uk-padding-small">
                            <?php echo $video_choice; ?>
                        </div>
                    </div>
                    <div uk-grid>
                        <div class="uk-width-1-2">
                            <span><?php echo $youspeak; ?></span><span class="uk-text-danger">*</span>
                            <div class="uk-tile uk-tile-muted uk-padding-small">
                                <select class="uk-select uk-form-width-small" name="my_lang" data-placeholder="Choose a Language...">
                                    <?php
                                    include_once("./util/lang_list_a.php")
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="uk-width-1-2">
                            <span><?php echo $partnerspeak; ?></span><span class="uk-text-danger">*</span>
                            <div class="uk-tile uk-tile-muted uk-padding-small">
                                <select class="uk-select uk-form-width-small" name="your_lang" data-placeholder="Choose a Language...">
                                    <?php
                                        include_once("./util/lang_list_b.php")
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div>
                        <span><?php echo $otherthing; ?></span>
                        <div class="uk-tile uk-tile-muted uk-padding-small">
                            <textarea class="uk-textarea" rows="5" name="other"></textarea>
                        </div>
                    </div>
                    <div>
                        <input type="hidden" name="token" value=<?php echo htmlspecialchars($csrf ,ENT_COMPAT,'UTF-8'); ?> >
                    </div>
                    <div class="uk-text-center uk-margin-top">
                        <button class="uk-button uk-button-primary uk-margin-bottom" type="submit"><?php echo $post_it; ?></button>
                    </div>
                </form>
            </div>
            
        </div>
        <br>
        <br>
    </body>
</html>
