<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once('util/login_check.php');
$login = false;
$error_text = "";
if(isset($_SESSION['EMAIL'],$_SESSION['token'])){
    if(is_login($_SESSION['EMAIL'],$_SESSION['token'])){
        $login = true;
    }else{
        $error_text = false;
    }
}else{
    $login = false;
}
$db = new PDO('mysql:host=sql;dbname=User', 'root', $_ENV['PASS']);
$sth = $db->prepare("SELECT * FROM bulletin");
$sth->execute();
$row = $sth -> fetchAll(PDO::FETCH_ASSOC); //if a post was posted before 1 week, delete the post
for($i = 0 ; $i < sizeof($row) ; $i++){
    $date = new DateTimeImmutable($row[$i]['starttime']);
    $hours = $date->modify('+3 hour');
    $now = new DateTimeImmutable();
    $interval = $now->diff($hours);
    $invert = (int)$interval ->invert;
    if ($invert == 1){
        $sth = $db->prepare("DELETE FROM bulletin where id=:id");
        $sth->bindParam(":id",$row[$i]["id"],PDO::PARAM_INT);
        $sth->execute();
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
        <!--start-->
        <div class="uk-container uk-margin-top">
            <p class="uk-text-lead uk-text-center"><?php echo $bulletin; ?></p>
        </div>
        <div class="uk-text-center uk-margin-top">
            <a class="uk-button uk-button-primary" href="post.php"><?php echo $post; ?></a>
        </div>
        <div class="uk-text-center uk-margin-top">
            <form action="bulletin.php" method="get">
                <div class="uk-container uk-container-small">
                    <div class="uk-child-width-1-6@s uk-child-width-1-6@m uk-child-width-1-5@l uk-flex-center" uk-grid>
                        <div class="uk-margin-small-top">
                            <div uk-form-custom="target: > * > span:first-child">
                                <select name="my_lang">
                                    <?php
                                        include_once("./util/lang_list_a.php");
                                    ?>
                                </select>
                                <button class="uk-button uk-button-default" type="button" tabindex="-1">
                                    <span></span>
                                    <span uk-icon="icon: chevron-down"></span>
                                </button>
                            </div>
                        </div>
                        <div class="uk-margin-small-top">
                            <div uk-form-custom="target: > * > span:first-child">
                                <select name="your_lang">
                                    <?php
                                        include_once("./util/lang_list_b.php");
                                    ?>
                                </select>
                                <button class="uk-button uk-button-default" type="button" tabindex="-1">
                                    <span></span>
                                    <span uk-icon="icon: chevron-down"></span>
                                </button>
                            </div>
                        </div>
                        <div class="uk-margin-small-top">
                            <div class="uk-margin">
                                <div class="uk-form-controls">
                                    <label><input class="uk-radio" type="radio" value="Yes" name="video"><?php echo $video_on; ?></label><br>
                                    <label><input class="uk-radio" type="radio" value="No" name="video"><?php echo $video_off; ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="uk-margin-small-top">
                            <input class="uk-button uk-button-primary" type="submit" value="<?php echo $search; ?>">
                        </div>    
                    </div>
                </div>
            </form>
        </div>
        <div class="uk-section">
            <div class="uk-container-small uk-align-center">
                <form action="bulletin.php" method="get" class="uk-search uk-search-default uk-margin-small-bottom">
                    <span uk-search-icon></span>
                    <input class="uk-search-input" type="search" name="finduser" placeholder=" <?php echo $usersearch ;?>">
                </form>
                <div class="uk-child-width-1-3@m uk-child-width-1-3@l" uk-grid="masonry: true">
                <?php
                    include_once("util/get_post.php");
                    include_once("util/post_check.php");
                    for($k = 0 ; $k < sizeof($row) ; $k++){
                        $textrealm = "";
                        $textrealm = make_post($row[$k]); 
                        echo $textrealm;
                    }
                    
                ?> 
                </div> 
            </div>
            <div class="uk-text-center">
                <?php
                    echo $prevlink;
                    echo $nextlink;
                ?>
            </div>
            
        </div>
        <br>
        <br>
    </body>
</html>
