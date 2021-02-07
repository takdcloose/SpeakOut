<?php
session_start();
session_regenerate_id(true); //session_idを新しく生成し、置き換える
header('Content-Type: text/html; charset=UTF-8');
include_once("util/get_lang.php");
include("util/get_part_lang.php");
$error_mess = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $usermail = $_POST['usermail'];
    $userpass = $_POST['userpass'];
    if($usermail === "" || $userpass === ""){
        $error_mess= get_part("Some fields are not filled","入力していない箇所があります");
    }else{
        try {
            $db = new PDO('mysql:host=sql;dbname=User', 'root', $_ENV['PASS']);
            $stmt = $db->prepare("SELECT * FROM userinfo WHERE usermail= :usermail ");
            $stmt->bindParam(':usermail', $usermail, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        } catch(\Exception $e){
            echo $e->getMessage() .PHP_EOL;
        }
        if (!isset($row[0]['usermail'])) {
            $error_mess = get_part('Your email address is not registered','メールアドレスが登録されていません');
        }else{
            if (hash('sha256',$userpass) === $row[0]['userpass']) {
                $_SESSION['EMAIL'] = $row[0]['usermail'];
                $salt = "okshjq9ajhiau47yai";
                $_SESSION['token'] = hash('ripemd128',$row[0]['usermail'].$salt.$_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);

            } else {
                $error_mess = get_part('E-mail address or password is incorrect.','メールアドレス又はパスワードが間違っています。');
            }
            if($error_mess === ""){
                echo "<script> location.replace(\"top.php\"); </script>";
            }
        }
    }
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
        
        <div class="uk-container">
            <div class="uk-section uk-padding uk-section-muted uk-text-center">
                <?php echo $error_mess ?>
                <p class="uk-text-lead">login</p>
                <form action="login.php" method="POST">
                    mail address
                    <div class="uk-margin">
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: user"></span>
                            <input class="uk-input" type="email" name="usermail">
                        </div>
                    </div>
                    password
                    <div class="uk-margin-bottom">
                        <div class="uk-inline">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                            <input class="uk-input" type="password" name="userpass">
                        </div>
                    </div>
                    <!--<input type="submit" value="ログイン">-->
                    <button class="uk-button uk-button-default uk-margin-bottom" type="submit"><?php echo $login_button; ?></button><br>
                    <?php echo $no_account; ?>
                </form>
            </div>
        </div>
        
        
        <br>
        <br>
    </body>
</html>
