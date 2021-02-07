<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
$serv_id = array(0=>"skype_id",1=>"line_id",2=>"viber_id",3=>"kakao_id",4=>"messenger_id",5=>"discord_id");
$input_id = array(0=>"skype_input",1=>"line_input",2=>"viber_input",3=>"kakao_input",4=>"messenger_input",5=>"discord_input");
$list = array(0=>"Skype",1=>"Line",2=>"Viber",3=>"KaKaoTalk",4=>"Messenger",5=>"Discord");
$num = 6;
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
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/garlic.js"></script>   
        <link rel="stylesheet" href="css/uikit.min.css">
        <script src="uikit/dist/js/uikit-icons.min.js"></script>
        <script type="text/javascript" src="js/service_create.js"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-160833806-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-160833806-1');
        </script>
    </head>
    <body>
        <?php 
        include_once("util/get_lang.php");
        include_once("util/navi.php"); ?>
        <!--------------------start------------------------>
        <?php
        //require 'MDB.php';
        
        //if(MDB2::isError($db)){ die("Can't connect" . $db-> getMessage());}
        //$db->serErrorHandling(PEAR_ERROR_DIE);
        include_once("util/signup_check.php");
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $username = $_POST['username'];
            $sex = $_POST['sex'];
            $age = $_POST['age'];
            $usermail = $_POST['usermail'];
            $userpass = $_POST['userpass'];
            $userconfirmpass = $_POST['userconfirmpass'];
            $phone_option = $_POST['phone_option'];
            $phone_id = $_POST['phone_id'];
            $comment = $_POST['comment'];
            $db = new PDO('mysql:host=sql;dbname=User', 'root', $_ENV['PASS']);
            //if submited form is correct , proceed to excute. if not, show error.
            $form_errors = validate_form($username,$sex,$usermail,$userpass,$userconfirmpass,$phone_option,$phone_id);
            if(!empty($form_errors)){
                $error_text = show_form($form_errors);
            } else{
                $suc = process_form($username,$sex,$age,$usermail,$userpass,$phone_option,$phone_id,$comment);
                if($suc){
                    mkdir("./users/".$username, true);
                    chmod("./users/".$username, 0777);
                    mkdir("./users/".$username."/img", true);
                    chmod("./users/".$username."/img", 0777);
                    if($sex == "woman"){
                        copy("image/icons8-woman-90.png","users/".$username."/img/default.png");
                    }else{
                        copy("image/icons8-man-90.png","users/".$username."/img/default.png");
                    }
                    copy("template/index.php","users/".$username."/index.php");
                    copy("template/mypage.php","users/".$username."/mypage.php");
                    copy("template/profile.php","users/".$username."/profile.php");
                    #echo "<script> location.replace(\"login.php\"); </script>";
                }else{
                    $error_text = get_part("Unknown error","不明なエラー");
                }
            }
        } else {
            //if form is not submited yet, show form
            $error_text = show_form();
        }
        ?>
        <div class="uk-container">
            <div class="uk-section uk-padding uk-section-muted uk-text-center">
                <?php echo $error_text; ?>    
                <p class="uk-text-lead"><?php echo $createaccount; ?></p>
                <form data-persist="garlic" action="<?php print $_SERVER['PHP_SELF']; ?>" method="POST" name="form1">   
                    <div class="uk-margin">
                    <?php echo $username_in; ?><span class="uk-text-danger">*</span>
                        <div class="uk-inline uk-margin-left">
                            <span class="uk-form-icon" uk-icon="icon: user"></span>
                            <input id="username" class="uk-input" name="username" type="text">
                        </div>
                    </div>
                    <?php echo $sex_age; ?><span class="uk-text-danger">*</span>
                    <div class="uk-margin　uk-grid">
                        <?php echo $sex_label; ?>
                        <select class="uk-select uk-form-width-small uk-margin-left" name="age" data-placeholder="Choose a Language...">
                            <?php echo $age_range; ?>
                        </select>
                    </div>
                    
                    <div class="uk-margin">
                    <?php echo $mailaddress; ?><span class="uk-text-danger">*</span>
                        <div class="uk-inline uk-margin-left">
                            <span class="uk-form-icon" uk-icon="icon: mail"></span>
                            <input id="usermail" class="uk-input" name="usermail" type="email">
                        </div>
                    </div>
                    <div class="uk-margin-bottom">
                    <?php echo $password; ?><span class="uk-text-danger">*</span>
                        <div class="uk-inline uk-margin-left">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                            <input id="userpass" class="uk-input" name="userpass" type="password">
                        </div>
                    </div>
                    
                    <div class="uk-margin-bottom">
                    <?php echo $confirm_password; ?><span class="uk-text-danger">*</span>
                        <div class="uk-inline uk-margin-left">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                            <input id="userconfirmpass" class="uk-input" name="userconfirmpass" type="password">
                        </div>
                    </div>
                    <?php echo $ableservice; ?><span class="uk-text-danger">*</span>
                    <div>
                        <div class="uk-margin">
                            <div class="uk-form-controls">
				<div class="uk-width-1-6@s"><label><div><p class="uk-badge uk-label-skype uk-margin-remove"> Skype</p></div></label><input class="uk-checkbox" id="Skype" type="checkbox" name="phone_option[]" value="Skype"></div>
                                <div class="uk-width-1-6@s"><label><div><p class="uk-badge uk-label-line uk-margin-remove">Line</p></div></label><input class="uk-checkbox" id="Line" type="checkbox" name="phone_option[]" value="Line"></div>
                                <div class="uk-width-1-6@s"><label><div><p class="uk-badge uk-label-viber uk-margin-remove">Viber</p></div></label><input class="uk-checkbox" id="Viber" type="checkbox" name="phone_option[]" value="Viber"></div>
                                <div class="uk-width-1-6@s"><label><div><p class="uk-badge uk-label-kakao uk-margin-remove">KaKaoTalk</p></div></label><input class="uk-checkbox" id="KaKaoTalk" type="checkbox" name="phone_option[]" value="KaKaoTalk"></div>
                                <div class="uk-width-1-6@s"><label><div><p class="uk-badge uk-label-messenger uk-margin-remove">Messenger</p></div></label><input class="uk-checkbox" id="Messenger" type="checkbox" name="phone_option[]" value="Messenger"></div>
                                <div class="uk-width-1-6@s"><label><div><p class="uk-badge uk-label-discord uk-margin-remove">Discord</p></div></label><input class="uk-checkbox" id="Discord" type="checkbox" name="phone_option[]" value="Discord"></div>
                            </div>
                        </div>
                    </div>
                    <?php echo $ID_video; ?><span class="uk-text-danger">*</span>
                    <div>
                        <div class="uk-margin">
                            <div class="uk-form-controls">
                                <div class="uk-inline">
                                    <input id="skype_id" class="uk-input uk-margin-small uk-margin-top" name="phone_id[]" type="text" placeholder="Skype ID">                    
                                    <input id="line_id" class="uk-input uk-margin-small" name="phone_id[]" type="text" placeholder="Line ID">
                                    <input id="viber_id" class="uk-input uk-margin-small" name="phone_id[]" type="text" placeholder="Viber ID">
                                    <input id="kakao_id" class="uk-input uk-margin-small" name="phone_id[]" type="text" placeholder="KaKaoTalk ID">
                                    <input id="messenger_id" class="uk-input uk-margin-small" name="phone_id[]" type="text" placeholder="Messenger ID">
                                    <input id="discord_id" class="uk-input uk-margin-small" name="phone_id[]" type="text" placeholder="Discord ID">
                                </div>    
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="uk-margin">
                        <?php echo $comment_input; ?>
                            <div class="uk-form-controls">
                                <textarea class="uk-input uk-textarea uk-form-width-large" id="form-stacked-text" name="comment" type="text" placeholder="Some text..."></textarea>
                            </div>
                        </div>
                    </div>
                    <input class="uk-button uk-button-primary" type="submit" value="<?php echo $confirm; ?>">
                </form>
            </div>
        </div>
        
        <br>
    </body>
</html>
