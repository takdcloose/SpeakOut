<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
$db = new PDO('mysql:host=sql;dbname=User', 'root', $_ENV['PASS']);
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
$post_id = $_POST['post_id'];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
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
        include_once("util/get_lang.php");
        include_once("util/navi.php"); ?>
        <!--start-->
        <?php
            $sth = $db->prepare("SELECT * FROM bulletin WHERE id=:id");
            $sth->bindParam(':id', $post_id);
            $sth->execute();
            $row = $sth -> fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="uk-container uk-margin-top">
            <div class="uk-grid-small uk-text-center uk-margin-top" uk-grid>
                <div class="uk-text-lead uk-margin"><?php echo $confirm_req; ?></div>
            </div>
            <div id="card" class="uk-card uk-card-muted uk-card-body">
                <div>
                    <span><?php echo $start; ?></span>
                    <div class="uk-tile uk-tile-muted uk-padding-small">
                        <p class="uk-"><?php echo str_replace("T"," ", $row['starttime']) ?></p>
                    </div>
                </div>
                <div>
                    <span><?php echo $theme; ?></span>
                    <div class="uk-tile uk-tile-muted uk-padding-small">
                        <p class="uk-"><?php echo htmlspecialchars($row['theme'],ENT_NOQUOTES,'UTF-8') ?></p>
                    </div>
                </div>
                <div>
                    <span><?php echo $video_call; ?></span>
                    <div class="uk-tile uk-tile-muted uk-padding-small">
                        <p class="uk-"><?php echo htmlspecialchars($row['video'],ENT_NOQUOTES,'UTF-8') ?></p>
                    </div>
                </div>
                <div uk-grid>
                    <div class="uk-width-1-2">
                        <div>
                            <span><?php echo $poster_lang; ?></span>
                            <div class="uk-tile uk-tile-muted uk-padding-small">
                                <p class="uk-"><?php echo htmlspecialchars($row['mylang'],ENT_NOQUOTES,'UTF-8')?></p>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-2">
                        <div>
                            <div><?php echo $your_lang; ?></div>
                            <div class="uk-tile uk-tile-muted uk-padding-small">
                                <p class="uk-"><?php echo htmlspecialchars($row['yourlang'],ENT_NOQUOTES,'UTF-8') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <span><?php echo $comment; ?></span>
                    <div class="uk-tile uk-tile-muted uk-padding-small">
                        <p class="uk-"><?php echo htmlspecialchars($row['other'],ENT_NOQUOTES,'UTF-8')?></p>
                    </div>
                </div>
                <div class="uk-text-center uk-margin-top">
                <input class="uk-button uk-button-default uk-margin-bottom" value="<?php echo $back; ?>" onclick="history.back();" type="button">
                    <form action="request.php" method="POST">
                        <input type="hidden" name="post" value="<?php echo $row['id'] ?>">
                        <input class="uk-button uk-button-primary" type="submit" value="<?php echo $REQUEST; ?>">
                    </form> 
                </div>                    
            </div>
        </div>
    </body>
</html>
