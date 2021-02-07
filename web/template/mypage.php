<?php
session_start();
include_once('../../util/login_check.php');
include_once('../../util/get_lang.php');
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
    echo "<script> location.replace(\"login.php\"); </script>";
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
        <script src="../../uikit/dist/js/uikit-icons.min.js"></script>
        <script src="../../js/tab-style.js"></script>
        <script type="text/javascript" src="../../js/service.js"></script>
    </head>
    <body>
    <?php include_once("../../util/navi_nonroot.php"); 
    $usermail = $_SESSION["EMAIL"];
    $db = new PDO('mysql:host=sql;dbname=User', 'root', $_ENV['PASS']);
    $sth = $db->prepare('SELECT * FROM userinfo where usermail=:usermail');
    $sth->bindParam(':usermail',$usermail,PDO::PARAM_STR);
    $sth->execute();
    $name = $sth -> fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="uk-container">
        <div class="uk-section uk-padding uk-section-muted uk-text-center">
            <div class="tabs">
                <ul uk-tab>
                    <li class="uk-active"><a href="javascript:void(0)" id="defaultOpen" class="tablink" onclick="openContent(event, 'notify')"><?php echo $notification;?></a></li>
                    <li><a href="javascript:void(0)" id="profile_tab" class="tablink" onclick="openContent(event, 'profile')"><?php echo $profile_tab; ?></a></li>    
                </ul>
                <div id="notify" class="tabcontent">
                    <div class="uk-grid-small uk-text-center uk-margin-top" uk-grid>
                        <div class="uk-text-bolder"><?php echo $requst_list ?></div>
                    </div>
                    <div class="uk-card-small uk-card-body">
                        <div class="uk-text-large"><?php echo $caution_request ?></div>
                        <ul class="uk-list">
                            <li class="uk-text-meta"><?php echo $caution1 ?></li>
                            <li class="uk-text-meta"><?php echo $caution2 ?></li>
                            <li class="uk-text-meta"><?php echo $caution3 ?></li>
                            <li class="uk-text-meta"><?php echo $caution4 ?></li>
                        </ul>
                    </div>
                    <div class="uk-width-2-3 uk-align-center" >
                        <?php
                        include_once('../../util/show_request.php');
                        echo $show_id;
                        $req = show_request($name['username']);
                        echo $req;
                        ?>
                    <div>
                </div>
                </div>
                </div>
                <div id="profile" class="tabcontent">
                    <div class="uk-grid-small uk-text-center uk-margin-top" uk-grid>
                        <div class="uk-width-1-5@m uk-width-1-3@l">
                            <div>
                                <img src="<?php echo $files[0]; ?>" alt="sample" width="90" height="90" border="3">
                            </div>
                            <form action="index.php" method="post" enctype="multipart/form-data">          
                                <div class="js-upload uk-margin-top" uk-form-custom>
                                    <input type="file" name="upfile">
                                    <button class="uk-button uk-button-default" type="button" tabindex="-1"><span uk-icon="icon: cloud-upload"></span>Select</button>
                                </div>

                                <div class="uk-form-controls">
                                    <input type="hidden" name="profile" value="profile">
                                </div>
                                <input class="uk-button uk-button-primary uk-margin-top uk-margin-bottom" type="submit" value="<?php echo $uppicture; ?>" name="yomikomi">
                                </form>
                                <?php echo $msg;?>

                        </div>
                        <div class="uk-width-3-5@m">
                            <div><?php echo $errors;?></div>
                            <form data-persist="garlic" action="<?php print $_SERVER['PHP_SELF']; ?>" method="POST" name="form1">    
                                <div class="uk-margin">
                                    <div uk-grid>
                                            <div class="uk-width-1-2@m">
                                                <?php echo $username_pro ?><span class="uk-text-danger">*</span>
                                            </div>
                                            <div class="uk-width-1-2@m uk-padding-remove">
                                                <input id="username" class="uk-input uk-margin-left" name="username" type="text" value= <?php echo $name["username"] ?> >
                                            </div>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <div uk-grid>
                                        <div class="uk-width-1-2@m">
                                            <?php echo $mailaddress_pro ?><span class="uk-text-danger">*</span>
                                        </div>
                                        <div class="uk-width-1-2@m uk-padding-remove">
                                            <input id="usermail" class="uk-input uk-margin-left" name="usermail" type="text" value= <?php echo $name["usermail"] ?> >
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <div uk-grid>
                                        <div class="uk-width-1-2@m">
                                                <?php echo $current_pass ?>
                                        </div>    
                                        <div class="uk-width-1-2@m uk-padding-remove">
                                            <input id="userpassnow" class="uk-input uk-margin-left" name="userpassnow" type="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <div uk-grid>
                                        <div class="uk-width-1-2@m">
                                            <?php echo $new_pass ?>
                                        </div>
                                        <div class="uk-width-1-2@m uk-padding-remove">  
                                            <input id="userpass" class="uk-input uk-margin-left" name="userpass" type="password">
                                        </div>
                                    </div>    
                                </div>
                                <div class="uk-margin">
                                    <div uk-grid>
                                        <div class="uk-width-1-2@m">
                                            <?php echo $confirm_new_pass ?>
                                        </div>
                                        <div class="uk-width-1-2@m uk-padding-remove">
                                            <input id="userpassconfirm" class="uk-input uk-margin-left" name="userpassconfirm" type="password">
                                        </div>
                                    </div>
                                </div>
                                <?php echo $availableserv ?><span class="uk-text-danger">*</span>
                                <div class="uk-margin">
                                    <div class="uk-form-controls uk-align-center">
                                        <div uk-grid>
                                            <div class="uk-width-1-6@s"><label><div><p class="uk-badge uk-label-skype uk-margin-remove"> Skype</p></div></label><input class="uk-checkbox" id="Skype" type="checkbox" name="phone_option[]" value="Skype"></div>
                                            <div class="uk-width-1-6@s"><label><div><p class="uk-badge uk-label-line uk-margin-remove">Line</p></div></label><input class="uk-checkbox" id="Line" type="checkbox" name="phone_option[]" value="Line"></div>
                                            <div class="uk-width-1-6@s"><label><div><p class="uk-badge uk-label-viber uk-margin-remove">Viber</p></div></label><input class="uk-checkbox" id="Viber" type="checkbox" name="phone_option[]" value="Viber"></div>
                                            <div class="uk-width-1-6@s"><label><div><p class="uk-badge uk-label-kakao uk-margin-remove">KaKaoTalk</p></div></label><input class="uk-checkbox" id="KaKaoTalk" type="checkbox" name="phone_option[]" value="KaKaoTalk"></div>
                                            <div class="uk-width-1-6@s"><label><div><p class="uk-badge uk-label-messenger uk-margin-remove">Messenger</p></div></label><input class="uk-checkbox" id="Messenger" type="checkbox" name="phone_option[]" value="Messenger"></div>
                                            <div class="uk-width-1-6@s"><label><div><p class="uk-badge uk-label-discord uk-margin-remove">Discord</p></div></label><input class="uk-checkbox" id="Discord" type="checkbox" name="phone_option[]" value="Discord"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-form-controls">
                                    <input type="hidden" name="profile" value="profile">
                                </div>
                                <?php echo $ID_serv ?><span class="uk-text-danger">*</span>
                                <div class="uk-margin">
                                    <div class="uk-form-controls uk-form-horizontal">
                                        <div>
                                            <div id="skype_input" class="uk-margin">
                                                <label class="uk-form-label" for="form-horizontal-text"> <p class="uk-badge uk-label-skype"> Skype ID</p> </label>
                                                <div class="uk-form-controls">
                                                    <input class="uk-input uk-width-4-5 uk-align-center " id="skype_id" name="phone_id[]" type="text" placeholder="Skype ID">
                                                </div>
                                            </div>
                                            <div id="line_input" class="uk-margin">
                                                <label class="uk-form-label" for="form-horizontal-text"> <p class="uk-badge uk-label-line">Line ID</p> </label>
                                                <div class="uk-form-controls">
                                                    <input class="uk-input uk-width-4-5 uk-align-center " id="line_id" name="phone_id[]" type="text" placeholder="LINE ID">
                                                </div>
                                            </div>
                                            <div id="viber_input" class="uk-margin">
                                                <label class="uk-form-label" for="form-horizontal-text"> <p class="uk-badge uk-label-viber">Viber ID</p> </label>
                                                <div class="uk-form-controls">
                                                    <input class="uk-input uk-width-4-5 uk-align-center " id="viber_id" name="phone_id[]" type="text" placeholder="Viber ID">
                                                </div>
                                            </div>
                                            <div id="kakao_input" class="uk-margin">
                                                <label class="uk-form-label" for="form-horizontal-text"><p class="uk-badge uk-label-kakao">KaKaoTalk ID</p> </label>
                                                <div class="uk-form-controls">
                                                    <input class="uk-input uk-width-4-5 uk-align-center " id="kakao_id" name="phone_id[]" type="text" placeholder="KakaoTalk ID">
                                                </div>
                                            </div>    
                                            <div id="messenger_input" class="uk-margin">
                                                <label class="uk-form-label" for="form-horizontal-text"> <p class="uk-badge uk-label-messenger">Messenger ID</p> </label>
                                                <div class="uk-form-controls">
                                                    <input class="uk-input uk-width-4-5 uk-align-center " id="messenger_id" name="phone_id[]" type="text" placeholder="Messenger ID">
                                                </div>
                                            </div>
                                            <div id="discord_input" class="uk-margin">
                                                <label class="uk-form-label" for="form-horizontal-text"> <p class="uk-badge uk-label-discord">Discord ID</p> </label>
                                                <div class="uk-form-controls">
                                                    <input class="uk-input uk-width-4-5 uk-align-center " id="discord_id" name="phone_id[]" type="text" placeholder="Discord ID">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php echo $comment_pro ?>
                                <div class="uk-margin">
                                    <div class="uk-form-controls">
                                        <input class="uk-input" id="form-stacked-text" name="comment" type="text" value= <?php echo $name["comment"] ?>>
                                    </div>
                                </div>
                                <input class="uk-button uk-button-primary" type="submit" value="<?php echo $change ?>">
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['profile'])){
                    echo '<script>document.getElementById("profile_tab").click();</script>';
                }else{
                    echo '<script>document.getElementById("defaultOpen").click();</script>';
                }
                $phone = unserialize($name['phone']);
                $phone = array_values($phone);
                if(is_array($phone)){
                    for($i = 0 ; $i< sizeof($phone) ; $i++){
                        echo '<script>document.getElementById("'.$phone[$i].'").click();</script>';
                    }
                }
                $phone_num = unserialize($name['phone_id']);
                for($i = 0 ; $i < sizeof($phone_num) ; $i++){
                    if($phone_num[$i] != ""){
                        echo '<script>document.getElementById("'.$input_id[$i].'").style.display = "block"</script>';
                        echo '<script>document.getElementById("'.$serv_id[$i].'").style.display = "block"</script>';
                        echo '<script>document.getElementById("'.$serv_id[$i].'").value = "'.$phone_num[$i].'"</script>';
                    }else{
                        echo '<script>document.getElementById("'.$input_id[$i].'").style.display = "none"</script>';
                    }
                }
                ?>
            </div>
        </div>
    </div>    
    </body>
</html>
