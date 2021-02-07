<?php
session_start();
$serv_id = array(0=>"skype_id",1=>"line_id",2=>"viber_id",3=>"kakao_id",4=>"messenger_id",5=>"discord_id");
$input_id = array(0=>"skype_input",1=>"line_input",2=>"viber_input",3=>"kakao_input",4=>"messenger_input",5=>"discord_input");
$list = array(0=>"Skype",1=>"Line",2=>"Viber",3=>"KaKaoTalk",4=>"Messenger",5=>"Discord");
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
$files= glob('./img/*');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Speakout</title>
        <link rel="shortcut icon" href="../../image/icon.png" type="image/png">
        <meta name="viewport" content="width=device-width" >
        <script src="../../js/uikit.min.js"></script>
        <script src="../../js/uikit-icons.min.js"></script>
        <link rel="stylesheet" href="../../css/uikit.min.css">
        <link rel="stylesheet" href="../../css/tab-style.css">
        <script src="../../js/garlic.js"></script>  
        <script src="../../uikit/dist/js/uikit-icons.min.js"></script>
        <script src="../../js/tab-style.js"></script>
        <script type="text/javascript" src="../../js/service.js"></script>
    </head>
    <body>
    <?php include_once("../../util/navi_nonroot.php");
    preg_match('/users\/.*/', getcwd(), $getuser);
    $lookuser = substr($getuser[0],6);
    $db = new PDO('mysql:host=sql;dbname=User', 'root', $_ENV['PASS']);
    $sth = $db->prepare('SELECT username,sex,age,phone,comment FROM userinfo where username=:username');
    $sth->bindParam(':username',$lookuser,PDO::PARAM_STR);
    $sth->execute();
    $name = $sth -> fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="uk-container">
        <div class="uk-card uk-card-default">
            <div class="uk-card-header">
                <?php
                if($name["sex"] == "woman"){
                    echo '<div class="uk-card-badge uk-label-danger">female</div>';
                }elseif($name["sex"] == "man"){
                    echo '<div class="uk-card-badge uk-label">male</div>';
                }else{
                    echo '<div class="uk-card-badge uk-label-success">other</div>';
                }
                ?>
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                    <div class="uk-width-auto">
                        <img class="uk-border-circle" width="90" height="90" src="<?php echo $files[0]; ?>">
                    </div>
                    <div class="uk-width-expand">
                        <h3 class="uk-card-title uk-margin-remove-bottom"><?php echo $name["username"] ?></h3>
                        <p class="uk-text-meta uk-margin-remove-top">age <?php 
                        if($name["age"] !== ""){
                            echo $name["age"];
                        }else{
                            echo get_part('Unspecified','指定なし');
                        }
                        ?></p>
                    </div>
                </div>
            </div>
            <div class="uk-card-body">
                <div class="uk-margin">
                    <?php echo $availableservice; ?>
                    <div class="uk-text-center" uk-grid>
                        <div id="skype_id" class="uk-margin uk-margin-top">
                            <p class="uk-badge uk-label-skype">Skype</p>
                        </div>
                        <div id="line_id" class="uk-margin">
                            <p class="uk-badge uk-label-line">LINE</p>
                        </div>
                        <div id="viber_id" class="uk-margin">
                            <p class="uk-badge uk-label-viber">Viber</p>
                        </div>
                        <div id="kakao_id" class="uk-margin">
                            <p class="uk-badge uk-label-kakao">KakaoTalk</p>
                        </div>    
                        <div id="messenger_id" class="uk-margin">
                            <p class="uk-badge uk-label-messenger">Messenger</p>
                        </div>
                        <div id="discord_id" class="uk-margin">
                            <p class="uk-badge uk-label-discord">Discord</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-card-footer">
                <?php echo $name["comment"] ?>
            </div>
        </div>
            <?php
            $phone = unserialize($name['phone']);
            $phone = array_values($phone);
            $serv = array("Skype"=>"skype_id","Line"=>"line_id","Viber"=>"viber_id","KaKaoTalk"=>"kakao_id","Messenger"=>"messenger_id","Discord"=>"discord_id");
            if(is_array($phone)){
                for($i = 0 ; $i< sizeof($phone) ; $i++){
                    echo '<script>document.getElementById("'.$serv[$phone[$i]].'").style.display="block";</script>';
                }
            }
            ?>
    </div>    
    </body>
</html>
